<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Operations\CabinRequestChangeOperation;


/**
 * 客室リクエスト入力更新のサービスクラスです。
 * Class PostCabinRequestChangeService
 * @package App\Http\Services\Reservation\Input
 */
class PostCabinRequestChangeService extends BaseService
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
     * サービスクラスを初期化します。
     */
    public function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->last_update_date_time = request('last_update_date_time');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        if (!$this->sendCabinRequestChangeOperation()) {
            return;
        }
        $this->response_data['redirect'] = ext_route(
            'reservation.input.discount', ['reservation_number' => $this->reservation_number]);
    }

    /**
     * リクエスト情報変更ソケットを送信します。
     * @return bool
     * @throws \Exception
     */
    private function sendCabinRequestChangeOperation()
    {
        $operation = new CabinRequestChangeOperation();

        //開始
        $operation->setRecordType('1');
        $operation->setTempWorkManagementNumber('0');
        $operation->setReservationNumber($this->reservation_number);
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result1['event_number']);
            return false;
        }

        //データ
        foreach (request('passengers') as $display_number => $passenger) {
            $operation->reset();
            $operation->setRecordType('2');
            $operation->setTempWorkManagementNumber($operation_result1['temp_work_number']);
            $operation->setReservationNumber($this->reservation_number);
            $operation->setCabinLineNumber($passenger['cabin_line_number']);
            $operation->setDisplayLineNumber($passenger['display_line_number']);
            $operation->setCabinTypeRequest($passenger['cabin_type_request']);
            $operation->setCabinRequestFree($passenger['cabin_request_free']);
            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                $this->setSocketErrorMessages($operation_result2['event_number']);
                return false;
            }
        }

        //終了
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
}