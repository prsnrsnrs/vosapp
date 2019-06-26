<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Queries\AddressQuery;
use App\Queries\AnniversaryQuery;
use App\Queries\ReservationQuery;

/**
 * ご乗船者詳細入力のサービスです
 *
 * Class GetPassengerService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetPassengerService extends BaseService
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
     * @var AddressQuery
     */
    private $address_query;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->reservation_query = new ReservationQuery();
        $this->anniversary_query = new AnniversaryQuery();
        $this->address_query = new AddressQuery();
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        // 商品情報の取得
        $item_info = $this->reservation_query->getReservationByNumber($this->reservation_number);
        $this->response_data['item_info'] = $item_info;
        $is_overseas_cruise = $item_info['domestic_overseas_cruise_type'] === '2' || $item_info['domestic_overseas_cruise_type'] === '3'? true : false;
        $this->response_data['is_overseas_cruise'] = $is_overseas_cruise;

        // 記念日情報の取得
        $anniversaries = $this->anniversary_query->getAnniversary();
        $this->response_data['anniversaries'] = $anniversaries;

        // 都道府県情報;
        $prefectures = $this->address_query->getPrefectures();
        $this->response_data['prefectures'] = $prefectures;

        // 国情報の取得
        $countries = $this->address_query->getCountries();
        $this->response_data['countries'] = $countries;

        // ご乗船者情報
        $passengers = $this->reservation_query->getPassengers($this->reservation_number);
        $this->response_data['passengers'] = $passengers;

        // インフォメーションメッセージ取得
        $this->response_data['info_message'] = $this->getInformationMessage($item_info['detail_input_flag']);
    }

    /**
     * インフォメーションメッセージを返します。
     * @param $detail_input_flag
     * @return \Illuminate\Config\Repository|mixed|string
     */
    private function getInformationMessage($detail_input_flag){

        $message = '';
        if ($detail_input_flag == 0){
            $message =  config('messages.info.I050-0301');
        }
        return $message;
    }
}