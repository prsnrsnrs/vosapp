<?php

namespace App\Http\Services\Reservation\Reception;


use App\Exceptions\VossException;
use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Operations\GroupSettingOperation;
use App\Queries\ReceptionQuery;

/**
 * グループ設定処理のサービスです。
 * Class PostGroupService
 * @package App\Http\Services\Reservation\Reception
 */
class PostGroupService extends BaseService
{
    /**
     * @var array
     */
    private $auth;
    /**
     * @var string 'update' or 'leave'
     */
    private $mode;
    /**
     * 受付一覧で選択された予約番号
     * @var string
     */
    private $selected_reservation_number;
    /**
     * @var ReceptionQuery
     */
    private $reception_query;
    /**
     * @var GroupSettingOperation
     */
    private $group_setting_operation;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->mode = request('mode', 'update');
        $this->auth = VossAccessManager::getAuth();
        $this->selected_reservation_number = request('group_reservation_numbers.0');
        $this->reception_query = new ReceptionQuery();
        $this->group_setting_operation = new GroupSettingOperation();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        try {
            if ($this->mode === 'leave') {
                $this->modeLeaveExecute();

            } else {
                $this->modeUpdateExecute();
            }
        } catch (VossException $e) {
            // 複数回ソケット通信する仕様から、
            // ソケットでエラーが発生したときは例外をスローして処理を抜ける構成。
        }

        $this->response_data['redirect'] = ext_route('reservation.reception.list');
        if ($this->isSuccess()) {
            $this->setRedirectSuccessMessage(config('messages.alert.I080-0101'));
        }
    }

    /**
     * グループから抜ける処理を実行します。
     */
    private function modeLeaveExecute()
    {
        $leave_reservation_number = array_get(request('group_reservation_numbers'), 0);
        $prev_travelwith_number = $this->reception_query->getTravelwithNumber($this->auth['travel_company_code'], $leave_reservation_number);
        $this->changeTravelwithNumber($leave_reservation_number, $prev_travelwith_number, '');
    }

    /**
     * グループ設定を更新する処理を実行します。
     * グループ対象の予約が1件のみの場合は、グループを解散します。
     * @return bool
     */
    private function modeUpdateExecute()
    {
        $travelwith_number = request('travelwith_number');
        $group_reservation_numbers = request('group_reservation_numbers');

        $this->leaveForUnselected($travelwith_number, $group_reservation_numbers);
        if (count($group_reservation_numbers) === 1) {
            // 解散
            return $this->sendGroupSettingOperation($group_reservation_numbers[0], '');
        }

        foreach ($group_reservation_numbers as $reservation_number) {
            $prev_travelwith_number = $this->reception_query->getTravelwithNumber($this->auth['travel_company_code'], $reservation_number);
            if ($prev_travelwith_number === $travelwith_number) {
                continue;
            }
            $this->changeTravelwithNumber($reservation_number, $prev_travelwith_number, $travelwith_number);
        }
    }

    /**
     * グループから除外 (画面で未選択に) された予約は、グループから抜ける。
     * @param $travelwith_number
     * @param $select_reservation_numbers
     */
    private function leaveForUnselected($travelwith_number, $select_reservation_numbers)
    {
        $travelwith_reservations = $this->reception_query->getReservationsByTravelwith($this->auth['travel_company_code'], $travelwith_number);
        foreach ($travelwith_reservations as $row) {
            if (in_array($row['reservation_number'], $select_reservation_numbers)) {
                continue;
            }
            // 未選択の予約は、グループから抜ける
            $this->sendGroupSettingOperation($row['reservation_number'], '');
        }
    }

    /**
     * TravelWith予約番号を変更します。
     * 移動元のグループが存在した場合は、解散 or 親交代の処理が実行されます。
     * @param $reservation_number
     * @param $prev_travelwith_number
     * @param $after_travelwith_number
     */
    private function changeTravelwithNumber($reservation_number, $prev_travelwith_number, $after_travelwith_number)
    {
        $this->sendGroupSettingOperation($reservation_number, $after_travelwith_number);
        if (!$prev_travelwith_number) {
            return;
        }

        $reservations = $this->reception_query->getReservationsByTravelwith($this->auth['travel_company_code'], $prev_travelwith_number);
        if (!$reservations) {
            return;
        }
        if (count($reservations) === 1) {
            // 解散
            $this->sendGroupSettingOperation($reservations[0]['reservation_number'], '');
        } elseif ($reservation_number === $prev_travelwith_number) {
            // 親交代
            $new_travelwith_number = $reservations[0]['reservation_number'];
            foreach ($reservations as $row) {
                $this->sendGroupSettingOperation($row['reservation_number'], $new_travelwith_number);
            }
        }
    }

    /**
     * グループ設定ソケットを送信します。
     * @param $reservation_number
     * @param $travelwith_number
     * @throws VossException
     */
    private function sendGroupSettingOperation($reservation_number, $travelwith_number)
    {
        $this->group_setting_operation->reset();
        $this->group_setting_operation->setReservationNumber($reservation_number);
        $this->group_setting_operation->setTravelWithNumber($travelwith_number);
        $result = $this->group_setting_operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            throw new VossException();
        }
    }
}