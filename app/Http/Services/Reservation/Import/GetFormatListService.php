<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Queries\ImportQuery;

/**
 * 取込フォーマット管理のサービスです
 *
 * Class GetFormatListService
 * @package App\Http\Services\Reservation\Import
 */
class GetFormatListService extends BaseService
{
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
        $this->auth = VossAccessManager::getAuth();
        $this->import_query = new ImportQuery();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // フォーマット情報の取得
        $formats = $this->import_query->getFormatHeaders($this->auth['travel_company_code']);
        $this->response_data['formats'] = $formats;
    }
}