<?php

namespace App\Http\Services\Reservation\Printing;

use App\Queries\CorporateQuery;
use App\Queries\PrintingQuery;


/**
 * 予約内容確認書のサービスです。( forAPS )
 * Class GetDetailServiceForAPS
 * @package App\Http\Services\Reservation\Printing
 */
class GetDetailServiceForAPS extends PostDetailService
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
     * 初期化処理します
     */
    protected function init()
    {
        $this->printing_query = new PrintingQuery();
        $this->corporate_query = new CorporateQuery();

        $file = 'detail' . DIRECTORY_SEPARATOR . request('file');
        // json読み込み処理
        $json = $this->readJson($file);
        $this->travel_code = $json['travel_code'];
        $this->reservations = $json['reservations'];
        $this->is_agent = (bool)$this->travel_code;
    }

    /**
     * サービスの処理を実行します
     * @return mixed|void
     */
    public function execute()
    {
        parent::execute();

        $this->response_data['file_name'] = '予約内容確認書_' . date('Ymd') . '.pdf';
        $this->response_data['is_agent'] = $this->is_agent;
        if ($this->is_agent) {
            //販売店名の取得
            $corporate_info = $this->corporate_query->getName($this->travel_code);
            $this->response_data['travel_company_name'] = $corporate_info['company_name'];
            $this->response_data['agent_name'] = $corporate_info['office_name'];
        }
    }

}