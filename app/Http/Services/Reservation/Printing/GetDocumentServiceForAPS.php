<?php

namespace App\Http\Services\Reservation\Printing;

use App\Queries\CorporateQuery;
use App\Queries\PrintingQuery;


/**
 * 予約確認書のサービスです。( forAPS )
 * Class PostDocumentServiceForAPS
 * @package App\Http\Services\Reservation\Printing
 */
class GetDocumentServiceForAPS extends PostDocumentService
{
    /**
     * @var $travel_code ;
     * 旅行社コード
     */
    private $travel_code;
    /**
     * @var CorporateQuery
     */
    private $corporate_query;

    /**
     * 初期化します。
     */
    protected function init()
    {
        $this->printing_query = new PrintingQuery();
        $this->corporate_query = new CorporateQuery();

        // json読み込み処理
        $file = 'document' . DIRECTORY_SEPARATOR . request('file');
        $json = $this->readJson($file);
        $this->travel_code = $json['travel_code'];
        $this->reservations = $json['reservations'];

        $this->is_agent = (bool)$this->travel_code;
        if ($this->is_agent) {
            $this->query_param = $this->getQueryParam();
        }
    }



    /**
     * サービスの処理を実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // 乗船者情報の取得
        $passengers_detail = $this->printing_query->getPassengers(array_keys($this->reservations));
        $group_by_cruise_id = collect($passengers_detail)->groupBy('cruise_id')->toArray();
        $this->response_data['cruises'] = $this->formatCruises($group_by_cruise_id);
        $group_by_item_code = collect($passengers_detail)->groupBy('item_code')->toArray();
        $this->response_data['tariff_by_item_code'] = $this->getTariffByItemCodes($group_by_item_code);

        $this->response_data['file_name'] = '予約確認書_' . date('Ymd') . '.pdf';
        $this->response_data['is_agent'] = $this->is_agent;

        if ($this->is_agent) {
            // 販売店名の取得
            $corporate_info = $this->corporate_query->getName($this->travel_code);
            $this->response_data['travel_company_name'] = $corporate_info['company_name'];
            $this->response_data['agent_name'] = $corporate_info['office_name'];
        }
    }

    /**
     * 動的にパラメーターをセットします。
     * @return array
     */
    protected function getQueryParam()
    {
        $param = array(
            "travel_code" => $this->travel_code,
            "for_aps_flag" => true
        );
        return $param;
    }
}

