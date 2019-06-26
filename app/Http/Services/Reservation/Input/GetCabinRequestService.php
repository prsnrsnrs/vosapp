<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Queries\ReservationQuery;


/**
 * 客室リクエスト入力のサービスクラスです。
 * Class GetCabinRequestService
 * @package App\Http\Services\Reservation\Input
 */
class GetCabinRequestService extends BaseService
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
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->reservation_query = new ReservationQuery();
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

        //客室リクエストドロップダウンの項目取得
        $cabins = $this->reservation_query->getCabinTypeRequests($item_info['cruise_id']);
        $this->response_data['cabins'] = $cabins;

        //客室リクエスト入力情報の取得
        $passengers = $this->reservation_query->getCabinRequests($this->reservation_number);
        $this->response_data['passengers'] = $passengers;
    }
}