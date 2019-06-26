<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Queries\ImportQuery;

/**
 * 取込結果一覧のサービスです
 *
 * Class GetResultService
 * @package App\Http\Services\Reservation\Import
 */
class GetResultService extends BaseService
{
    /**
     * @var string
     */
    private $import_management_number;
    /**
     * @var array
     */
    private $auth;
    /**
     * @var ImportQuery
     */
    private $import_query;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->import_management_number = request('import_management_number');
        $this->auth = VossAccessManager::getAuth();
        $this->import_query = new ImportQuery();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // 取込管理情報の取得
        $import_management = $this->import_query->getManagement($this->import_management_number, $this->auth['travel_company_code'], $this->auth['agent_code']);
        $this->response_data['import_management'] = $import_management;
        // 取込見出一覧情報の取得
        $import_headers = $this->import_query->getHeaders($this->import_management_number, $this->auth['travel_company_code'], $this->auth['agent_code']);
        $this->response_data['import_headers'] = $import_headers;
    }
}