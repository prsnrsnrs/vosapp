<?php

namespace App\Http\Services\Reservation\Document;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Queries\DocumentQuery;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;


/**
 * 提出書類一覧のサービスクラスです。
 * Class GetListService
 * @package App\Http\Services\Reservation\Document
 */
class GetListService extends BaseService
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
     * @var DocumentQuery
     */
    private $document_query;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->reservation_query = new ReservationQuery();
        $this->document_query = new DocumentQuery();
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //旅行者向けサイトの場合のフラグをレスポンスデータに格納
        $this->response_data['is_agent_site'] = VossAccessManager::isAgentSite();
        //旅行者向けテストサイトの場合のフラグをレスポンスデータに格納
        $this->response_data['is_agent_test_site'] = VossAccessManager::isAgentTestSite();
        //個人向け向けサイトの場合のフラグをレスポンスデータに格納
        $this->response_data['is_user_site'] = VossAccessManager::isUserSite();

        //予約見出し情報の取得
        $item_info = $this->reservation_query->getReservationByNumber($this->reservation_number);
        $this->response_data['item_info'] = $item_info;

        //提出書類情報の取得
        $passengers = $this->document_query->findDocumentByNumber($this->reservation_number);
        $format_passengers = $this->formatPassengers($passengers);
        $this->response_data['passengers'] = $format_passengers;
    }

    /**
     * 提出書類情報を成形します。
     * @param $passengers
     * @return array
     */
    private function formatPassengers($passengers)
    {
        //乗船者行Noでグループ化
        $collection = new Collection($passengers);
        $passengers = $collection->groupBy('passenger_line_number')->toArray();
        //キーを1からの連番に変換
        $key = [];
        for ($i = 1; $i <= count($passengers); $i++) {
            $key[$i] = $i;
        }
        $format_passengers = array_combine($key, $passengers);
        $passenger_count = count($format_passengers);

        //乗船者ごとの提出書類数を取得
        for ($i = 1; $i <= $passenger_count; $i++) {
            if (count($format_passengers[$i]) === 1 && $format_passengers[$i][0]['progress_manage_code'] === "") {
                unset($format_passengers[$i]);
                continue;
            } else {
                $document_count[$i] = count($format_passengers[$i]);
            }
            //乗船者の項目に乗船者ごとの提出書類数を追加
            $format_passengers[$i]['document_count'] = $document_count[$i];

            $passenger_line_count = 0;
            //提出書類情報のネット入力区分、書類入手区分の値に合ったviewの行数($line_count)を取得
            for ($j = 0; $j < $document_count[$i]; $j++) {
                if (empty($format_passengers[$i][$j]['net_input_type']) || empty($format_passengers[$i][$j]['document_check_type'])) {
                    $line_count = 1;
                } else {
                    $line_count = 2;
                }
                //行数($line_count)を提出書類ごとの項目に追加
                $format_passengers[$i][$j]['line_count'] = $line_count;
                //行数($line_count)に応じたviewでの乗船者の行数($passenger_line_count)を取得
                $passenger_line_count = $passenger_line_count + $line_count;
            }
            //乗船者の画面のrowspanの値($passenger_line_count)を乗船者の項目に追加
            $format_passengers[$i]['passenger_line_count'] = $passenger_line_count;
        }

        return array_values($format_passengers);
    }
}