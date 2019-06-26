<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Queries\AnniversaryQuery;
use App\Queries\ReservationQuery;


/**
 * ご乗船者リクエスト入力のサービスクラスです。
 * Class GetPassengerRequestService
 * @package App\Http\Services\Reservation\Input
 */
class GetPassengerRequestService extends BaseService
{
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var ReservationQuery
     */
    private $reservation_query;
    /**
     * @var AnniversaryQuery
     */
    private $anniversary_query;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->reservation_query = new ReservationQuery();
        $this->anniversary_query = new AnniversaryQuery();
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //予約見出し情報の取得
        $item_info = $this->reservation_query->getReservationByNumber($this->reservation_number);
        $this->response_data['item_info'] = $item_info;

        //シーティング情報の取得
        $seating = $this->reservation_query->findCruiseByItemCode($item_info['item_code']);
        $this->response_data['seating'] = $seating['seating'];

        //記念日情報の取得
        $anniversaries = $this->anniversary_query->getAnniversary();
        $this->response_data['anniversaries'] = $anniversaries;

        //ご乗船者リクエスト入力情報の取得
        $passengers = $this->reservation_query->getPassengerRequest($this->reservation_number);
        $this->response_data['passengers'] = $passengers;
    }
}