<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;


/**
 * 割引情報入力のサービスクラスです。
 * Class GetDiscountService
 * @package App\Http\Services\Reservation\Input
 */
class GetDiscountService extends BaseService
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

        //タリフ情報の取得
        $tariffs = $this->reservation_query->getTariffs($item_info['item_code']);
        $this->response_data['tariffs'] = $tariffs;

        //割引情報入力情報の取得
        $passengers = $this->reservation_query->getTicketNumber($this->reservation_number);
        $format_passengers = $this->formatPassengers($passengers);
        $this->response_data['passengers'] = $format_passengers;
    }

    /**
     * 割引情報入力情報の取得クエリで取得したデータを乗船者行Noでグループ化します。
     * @param $passengers
     */
    private function formatPassengers($passengers)
    {
        $collection = new Collection($passengers);
        $format_passengers = $collection->groupBy('passenger_line_number')->toArray();
        return $format_passengers;
    }
}