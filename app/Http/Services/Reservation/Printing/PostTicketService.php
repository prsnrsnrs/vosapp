<?php

namespace App\Http\Services\Reservation\Printing;

use App\Operations\PrintingTicketOperation;
use App\Queries\PrintingQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * 乗船券控えのサービスです
 *
 * Class PostTicketService
 * @package App\Http\Services\Reservation\Printing
 */
class PostTicketService extends BaseService
{

    /**
     * @var $reservations
     *
     */
    protected $reservations;

    /**
     * @var PrintingQuery
     */
    protected $printing_query;

    /**
     * 初期化します
     */
    protected function init()
    {
        $this->reservations = request('reservations');
        $this->printing_query = new PrintingQuery();
    }

    /**
     * サービスの処理を実行します
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {

        // 乗船券控え情報の取得
        $ticket_info = $this->printing_query->getETicket(array_keys($this->reservations));
        if (!$ticket_info) {
            throw new NotFoundHttpException();
        }
        $reservations_info = $this->getSelectedPassenger($ticket_info);

        $this->response_data['reservations'] = $reservations_info;
        $this->response_data['file_name'] = '乗船券控え_' . date('Ymd') . '.pdf';
        $this->response_data['images'] = [
            'logo' => base64_encode(\File::get(public_path('images/VenusCruise.png'))),
            'ship_name' => base64_encode(\File::get(public_path('images/VenusName.jpg'))),
            'company_name' => base64_encode(\File::get(public_path('images/company_name.png'))),
        ];

        // 乗船券控え発行ソケット
        $operation = new PrintingTicketOperation();
        foreach ($reservations_info as $reservation_number => $passengers) {
            foreach ($passengers as $passenger) {
                $operation->setReservationNumber($reservation_number);
                $operation->setPassengerLineNumber($passenger['passenger_line_number']);
                $operation_result = $operation->execute();
                if ($operation_result['status'] === 'E') {
                    $this->setSocketErrorMessages($operation_result['event_number']);
                    return;
                }
            }
        }


    }

    /**
     * 選択した乗船者のみを返します
     * @param $ticket_info
     * @return array
     */
    protected function getSelectedPassenger($ticket_info)
    {
        $selected = [];
        foreach ($ticket_info as $key => $passenger) {
            // 選択した乗船者の行No.と一致する乗船者を格納
            if (in_array($passenger['passenger_line_number'], $this->reservations[$passenger['reservation_number']])) {
                $meal_info = $this->printing_query->getMealLocation($passenger['reservation_number'], $passenger['passenger_line_number']);
                $passenger['meal_location'] = $meal_info['meal_location_breakfast'];
                $selected[$passenger['reservation_number']][] = $passenger;
            }
        }
        return $selected;
    }



}


