<?php

namespace App\Http\Services\Reservation\Printing;

use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Queries\PrintingQuery;

/**
 * 予約内容確認書のサービスです
 *
 * Class PostDetailService
 * @package App\Http\Services\Reservation\Printing
 */
class PostDetailService extends BaseService
{
    /**
     * @var PrintingQuery
     */
    protected $printing_query;
    /**
     * @var $reservations
     */
    protected $reservations;
    /**
     * @var bool
     */
    protected $is_agent;

    /**
     * 初期化します
     */
    protected function init()
    {
        $this->printing_query = new PrintingQuery();
        $this->reservations = request('reservations');
        $this->is_agent = VossAccessManager::isAgent();
    }

    /**
     * 処理を開始します
     * @return mixed|void
     */
    public function execute()
    {

        // 乗船者情報の取得
        $passengers_detail = $this->printing_query->getPassengersForDetail(array_keys($this->reservations));
        $group_by_cruise_id = collect($passengers_detail)->groupBy('cruise_id')->toArray();
        $this->response_data['cruises'] = $this->formatCruises($group_by_cruise_id);
        $group_by_item_code = collect($passengers_detail)->groupBy('item_code')->toArray();
        $this->response_data['tariff_by_item_code'] = $this->getTariffByItemCodes($group_by_item_code);
        //ヘッダータイトルに表示するログイン情報の取得
        $session_login = VossSessionManager::get('auth');
        $this->response_data['travel_company_name'] = $session_login['travel_company_name'];;
        $this->response_data['agent_name'] = $session_login['agent_name'];
        $this->response_data['file_name'] = '予約内容確認書_' . date('Ymd') . '.pdf';
        $this->response_data['is_agent'] = $this->is_agent;

    }

    /**
     * 出力用にクルーズ情報整形をします。
     * @param $group_by_cruise_id
     * @return array
     */
    protected function  formatCruises($group_by_cruise_id){
        // データ整形
        $format_cruises = [];
        foreach ($group_by_cruise_id as $cruise_id => $cruises) {
            $group_by_item_code = collect($cruises)->groupBy('item_code')->toArray();
            foreach ($group_by_item_code as $item_code => &$item) {
                // 予約番号ごとに乗船者を格納
                $group_by_reservations = collect($item)->groupBy('reservation_number')->toArray();
                $item['passengers'] = $this->getFormatPassengers($group_by_reservations);
            }
            // クルーズ情報
            $cruise = collect($cruises)->first();
            // クルーズの各商品の乗船者情報
            $cruise['items'] = $group_by_item_code;
            $format_cruises[$cruise_id] = $cruise;
        }

        return $format_cruises;
    }

    /**
     * 提出物ごとに存在する乗船者情報を整形します
     * @param $group_by_reservations
     * @return mixed
     */
    protected function getFormatPassengers($group_by_reservations)
    {
        // 選択した乗船者のみを取得
        $reservations = $this->getSelectedPassenger($group_by_reservations);

        foreach ($reservations as $reservation_number => &$reservation) {
            $group_by_passenger_line_number = collect($reservation)->groupBy('passenger_line_number')->toArray();

            foreach ($group_by_passenger_line_number as $line_number => &$documents){
                $original = $documents;
                $documents = collect($documents)->first();
                $documents['document'] = $original;
            }

            $reservation = $group_by_passenger_line_number;
        }

        return $reservations;
    }

    /**
     * 商品ごとのタリフの数を配列に格納する
     * @param $group_by_item_code
     */
    protected function getTariffByItemCodes($group_by_item_code){
        $tariff_by_item_code = $this->printing_query->getTariffByItemCodes(array_keys($group_by_item_code));
        $tariff_by_item_code = array_column($tariff_by_item_code, 'tariff_number', 'item_code');
        return $tariff_by_item_code;
    }

    /**
     * 選択した乗船者のみを返します
     * @param $group_by_reservation
     * @return array
     */
    protected function getSelectedPassenger($group_by_reservation)
    {
        $selected = [];
        foreach ($group_by_reservation as $reservation_number => $passengers) {
            foreach ($passengers as $passenger) {
                // 選択した乗船者の行No.と一致する乗船者を格納
                if (in_array($passenger['passenger_line_number'], $this->reservations[$reservation_number])) {
                    $selected[$reservation_number][] = $passenger;
                }
            }
        }
        return $selected;
    }
}


