<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\ReservationDoneOperation;
use function request;


/**
 *
 * 予約取消のサービスです
 *
 * Class PostReservationCancelService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostReservationCancelService extends BaseService
{

    public function execute()
    {
        $tmp_reservation_number = VossSessionManager::get('reservation_cancel.temp_reservation_number');
        $reservation_number = VossSessionManager::get('reservation_cancel.reservation_number');
        // 予約確定ソケット送信
        $operation = new ReservationDoneOperation();
        $operation->setTempReservationNumber($tmp_reservation_number);
        $operation->setReservationNumber($reservation_number);
        $operation->setInsertMode(config('const.insert_mode.value.force'));
        $operation->setUpdateConfirm(request('last_update_date_time'));
        $done_reservation = $operation->execute();
        if ($done_reservation['status'] === 'E') {
            $this->setSocketErrorMessages($done_reservation['event_number']);
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.detail', ['reservation_number' => $reservation_number]);

        // セッション破棄
        VossSessionManager::forget('reservation_cancel');
    }

}