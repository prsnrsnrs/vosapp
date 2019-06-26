<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\ReservationCancelPreparationOperation;

/**
 * (予約取消クリック時)
 * 予約取消に進む前の事前処理サービスです。
 * Class PostBeforeCabinEditService
 * @package App\Http\Services\Reservation
 */
class PostBeforeCabinCancelService extends BaseService
{

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        $reservation_number = request('reservation_number');
        $last_update_date_time = request('last_update_date_time');
        $in_charge = 'before';

        // 予約取消準備ソケット
        $operation = new ReservationCancelPreparationOperation();
        $operation->setReservationNumber($reservation_number);
        $operation->setLastUpdateDateTime($last_update_date_time);
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        } elseif ($operation_result['status'] === config('const.answer_status.value.request')) {
            // 回答ソケットのステータスが"R"（要求あり）の場合
            $in_charge = 'after';
        }

        // 予約取消情報をセッションにセット
        VossSessionManager::set('reservation_cancel', [
            'reservation_number' => (int)request('reservation_number'),
            'temp_reservation_number' => (int)$operation_result['temp_reservation_number'],
            'in_charge' => $in_charge,
        ]);

        $this->response_data['redirect'] = ext_route('reservation.cancel');
    }
}