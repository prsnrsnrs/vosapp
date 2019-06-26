<?php


namespace App\Http\Services\Reservation\Printing;

use App\Queries\PrintingQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 乗船券控えのサービスです (for APS)
 * Class GetTicketServiceForAPS
 * @package App\Http\Services\Reservation\Printing
 */
class GetTicketServiceForAPS extends PostTicketService
{
    /**
     * @var
     */
    private $json_data;


    /**
     * 初期化処理を実行します。
     */
    protected function init()
    {
        $this->printing_query = new PrintingQuery();
        // json読み込み処理
        $file = 'ticket' . DIRECTORY_SEPARATOR . request('file');
        $json = $this->readJson($file);
        $this->reservations = $json['reservations'];
    }

    /**
     * サービス処理を実行します。
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
    }

}