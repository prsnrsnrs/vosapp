<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\ReservationEditPreparationOperation;

/**
 * (客室追加・変更クリック時)
 * 客室追加・変更に進む前の事前処理サービスです。
 * Class PostBeforeCabinEditService
 * @package App\Http\Services\Reservation
 */
class PostBeforeCabinEditService extends BaseService
{

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        $operation = new ReservationEditPreparationOperation();
        $operation->setReservationNumber(request('reservation_number'));
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        $operation_result = $operation->execute();

        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }

        // セッション情報の削除
        VossSessionManager::forget("reservation_cabin");
        VossSessionManager::set('reservation_cabin', [
            'reservation_number' => (int)request('reservation_number'),
            'temp_reservation_number' => (int)$operation_result['temp_reservation_number'],
        ]);
        $this->response_data['redirect'] = ext_route('reservation.cabin.passenger_entry');
    }
}