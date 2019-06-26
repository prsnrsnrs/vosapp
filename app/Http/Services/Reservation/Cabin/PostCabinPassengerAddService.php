<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CabinPassengerAddOperation;
use function request;


/**
 * ご乗船者名入力：客室一人追加のサービスです
 * Class PostCabinPassengerAddService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostCabinPassengerAddService extends BaseService
{

    public function execute()
    {
        // 乗船者見出しソケット
        $passenger_heading = new GetPassengerHeadingService();
        $result = $passenger_heading->execute();
        if (!is_array($result)) {
            $this->setSocketErrorMessages($result);
            return;
        };

        // 客室一人追加ソケット
        $operation = new CabinPassengerAddOperation();
        $operation->setTempReservationNumber(VossSessionManager::get('reservation_cabin.temp_reservation_number'));
        $operation->setCabinLineNumber(request('cabin_line_number'));
        $operation->setShowCabinLineNumber(request('show_cabin_line_number'));
        $operation->setPassengerStatus(request('age_type'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }
    }
}