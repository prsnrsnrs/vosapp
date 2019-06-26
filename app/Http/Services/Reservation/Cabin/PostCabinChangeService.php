<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;


/**
 *  ご乗船者名入力：客室タイプ変更のサービスです
 *
 * Class PostCabinCreateService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostCabinChangeService extends BaseService
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