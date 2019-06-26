<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Operations\PassengerRequestChangeOperation;
use App\Operations\SeatingRequestChangeOperation;


/**
 * ご乗船者リクエスト更新のサービスクラスです。
 * 次へ(客室リクエスト)、スキップ(照会へ)クリック時
 * Class PostPassengerRequestChangeService
 * @package App\Http\Services\Reservation\Input
 */
class PostPassengerRequestChangeService extends BaseService
{
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var string
     */
    private $last_update_date_time;
    /**
     * @var string
     */
    private $meal_request;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->last_update_date_time = request('last_update_date_time');
        $this->meal_request = request('meal_request');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        if (!$this->sendPassengerRequestChangeOperation() || !$this->sendSeatingRequestChangeOperation()) {
            return;
        }
        $this->response_data['redirect'] = ext_route(
            'reservation.input.cabin_request', ['reservation_number' => $this->reservation_number]);
    }

    /**
     * 乗船者リクエスト情報変更ソケット送信
     * @return bool
     * @throws \Exception
     */
    private function sendPassengerRequestChangeOperation()
    {
        $operation = new PassengerRequestChangeOperation();

        //開始
        $operation->setRecordType('1');
        $operation->setTempWorkManagementNumber('0');
        $operation->setReservationNumber($this->reservation_number);
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result1['event_number']);
            return false;
        }

        // データ
        foreach (request('passengers') as $display_line_number => $passenger) {
            $operation->reset();
            $operation->setRecordType('2');
            $operation->setTempWorkManagementNumber($operation_result1['temp_work_number']);
            $operation->setReservationNumber($this->reservation_number);
            $operation->setPassengerLineNumber($passenger['passenger_line_number']);
            $operation->setDisplayLineNumber($passenger['display_line_number']);
            $operation->setChildMealType($passenger['child_meal_type']);
            $operation->setInfantMealType($passenger['infant_meal_type']);
            $operation->setAnniversaryType($passenger['anniversary_type']);
            $operation->setRemarks($passenger['net_remark']);
            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                $this->setSocketErrorMessages($operation_result2['event_number']);
                return false;
            }
        }

        // 終了
        $operation->reset();
        $operation->setRecordType('9');
        $operation->setTempWorkManagementNumber($operation_result1['temp_work_number']);
        $operation->setReservationNumber($this->reservation_number);
        $operation->setConfirmUpdateDateTime($this->last_update_date_time);
        $operation_result9 = $operation->execute();
        if ($operation_result9['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result9['event_number']);
            return false;
        }
        return true;
    }

    /**
     * シーティングリクエスト変更ソケット送信
     * @return bool
     * @throws \Exception
     */
    private function sendSeatingRequestChangeOperation()
    {
        $operation = new SeatingRequestChangeOperation();
        $operation->setReservationNumber($this->reservation_number);
        $operation->setSeatingRequest($this->meal_request);
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return false;
        }
        return true;
    }
}