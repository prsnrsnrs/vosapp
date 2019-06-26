<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;


/**
 * 客室人数選択：客室タイプ追加のサービスです
 * Class PostCabinAddService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostCabinAddService extends BaseService
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

        $this->response_data['redirect'] = ext_route('reservation.cabin.type_select');
    }
}