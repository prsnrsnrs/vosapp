<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\ReservationDoneOperation;
use function request;


/**
 *
 * 予約確定のサービスです
 *
 * Class PostReservationDoneService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostReservationDoneService extends BaseService
{
    /**
     * @var string
     */
    private $insert_mode;
    /**
     * @var string
     */
    private $last_update_date_time;
    /**
     * @var string
     */
    private $cabins_count;
    /**
     * @var string
     */
    private $reservation_number;

    /**
     * サービスを初期化します
     */
    public function init()
    {
        // パラメーターの初期化
        $this->insert_mode = request('insert_mode');
        $this->last_update_date_time = '';
        $this->cabins_count = request('cabins_count');
        $this->reservation_number = VossSessionManager::get('reservation_cabin.reservation_number');

    }

    /**
     * サービスの処理を実行します
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // 現在の画面モードを取得
        $mode = $this->getMode();
        // 確認更新日時をセット
        if (!$this->setLastUpdateDateTime()) {
            return;
        }
        // 予約確定ソケット送信
        $operation = new ReservationDoneOperation();
        $operation->setTempReservationNumber(VossSessionManager::get('reservation_cabin.temp_reservation_number'));
        $operation->setReservationNumber($this->reservation_number);
        $operation->setInsertMode(config('const.insert_mode.value.' . $this->insert_mode));
        $operation->setUpdateConfirm($this->last_update_date_time);
        $reservation = $operation->execute();
        if ($reservation['status'] === 'E') {
            $this->setSocketErrorMessages($reservation['event_number']);
            return;
        }

        // 回答ソケットのステータスが"要求あり"かつ、客室行にHKとキャンセル待ちが混在していた場合
        if ($reservation['status'] === config('const.answer_status.value.request') && $this->hasCabinWaitStatus($reservation, $this->cabins_count) == 'both') {
            $this->response_data['both'] = [
                'message' => config('messages.alert.A050-0201'),
                'last_update_date_time' => $this->last_update_date_time
            ];
            return;
        }
        // 回答ソケットのステータスが"要求あり"かつ、客室行がキャンセル待ちのみである場合
        if ($reservation['status'] === config('const.answer_status.value.request') && $this->hasCabinWaitStatus($reservation, $this->cabins_count) == 'wait_only') {
            $this->response_data['wait_only'] = [
                'message' => config('messages.alert.A050-0206'),
                'last_update_date_time' => $this->last_update_date_time
            ];
            return;
        }

        // セッション破棄
        VossSessionManager::forget('reservation_cabin');

        if ($mode === 'new') {
            // 新規は確認ダイアログが必要
            $prop = $this->getConfirmProp($reservation);
            $this->response_data['new'] = [
                'message' => $prop['message'],
                'done' => ext_route('reservation.input.passenger', ['reservation_number' => $prop['reservation_number']]),
                'cancel' => ext_route('reservation.detail', ['reservation_number' => $prop['reservation_number']])
            ];
        } else if ($mode === 'edit') {
            $this->response_data['edit'] = [
                'redirect' => ext_route('reservation.detail', ['reservation_number' => $this->reservation_number])
            ];
        }
    }


    /**
     * 遷移先URLとメッセージを返します
     * @param $reservation
     * @return array
     */
    private function getConfirmProp($reservation)
    {
        $message = '';
        $reservation_number = [];

        if ((int)$reservation['reservation_number_hk'] && !(int)$reservation['reservation_number_wt']) {
            // 全室HK予約
            $reservation_number = $reservation['reservation_number_hk'];
            $message = str_replace([':attribute'], [$reservation_number], config('messages.alert.A050-0202'));
        } else if (!(int)$reservation['reservation_number_hk'] && (int)$reservation['reservation_number_wt']) {
            // 全室WT予約
            $reservation_number = $reservation['reservation_number_wt'];
            $message = str_replace([':attribute'], [$reservation_number], config('messages.alert.A050-0203'));
        } else {
            // HK/WT予約
            $reservation_number = $reservation['reservation_number_hk'];
            $message = str_replace([':{0}', ':{1}'], [$reservation_number, $reservation['reservation_number_wt']],
                config('messages.alert.A050-0204'));
        }
        return ['message' => $message, 'reservation_number' => $reservation_number];
    }

    /**
     * 確定更新日時を取得します
     * @return bool
     */
    private function setLastUpdateDateTime()
    {
        if ($this->insert_mode === 'check') {
            // 乗船者見出しソケット
            $passenger_heading = new GetPassengerHeadingService();
            $result = $passenger_heading->execute();
            if (!is_array($result)) {
                $this->setSocketErrorMessages($result);
                return false;
            }
            $this->last_update_date_time = $result['last_update_date_time'];

        } elseif ($this->insert_mode === 'force') {
            $this->last_update_date_time = request('last_update_date_time');
        }
        return true;
    }

    /**
     * 客室行にキャンセル待ちが含まれているかどうかを返します
     * @param $reservation
     * @return bool $has_wait
     */
    private function hasCabinWaitStatus($reservation, $cabins_count)
    {
        $count_wait = 0;
        $has_wait = 'hk_only';
        foreach ($reservation['cabin_line_wt'] as $key => $value) {
            if (!(int)$value) {
                $has_wait = 'both';
                break;
            }
            $count_wait++;
        }
        if ($count_wait === (int)$cabins_count) {
            $has_wait = 'wait_only';
        }
        return $has_wait;
    }

    /**
     * 画面モードを返します
     * @return string $mode
     */
    private function getMode()
    {
        $mode = 'new';
        if ($this->reservation_number) {
            $mode = 'edit';
        }
        return $mode;
    }
}