<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Queries\ImportQuery;
use App\Queries\ReservationQuery;

/**
 * 一括取込ファイル指定のサービスです
 *
 * Class GetFileSelectService
 * @package App\Http\Services\Reservation\Import
 */
class GetFileSelectService extends BaseService
{
    /**
     * @var array
     */
    private $auth;
    /**
     * @var ReservationQuery
     */
    private $reservation_query;
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
        $this->reservation_query = new ReservationQuery();
        $this->import_query = new ImportQuery();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // 商品コードの取得
        $item_code = $this->getItemCode();
        // 商品情報の取得
        $item_info = $this->reservation_query->findCruiseByItemCode($item_code);
        $this->response_data['item_info'] = $item_info;
        // 過去取込履歴情報の取得
        $histories = $this->import_query->getManagementsByItemCode($item_code, $this->auth['travel_company_code'], $this->auth['agent_code']);
        $this->response_data['histories'] = $histories;
        // フォーマット情報の取得
        $formats = $this->import_query->getFormatHeaders($this->auth['travel_company_code']);
        $this->response_data['formats'] = $formats;
    }

    /**
     * リクエストパラメータ又は、セッション情報から商品コードを取得します。
     * 取得した商品コードは、セッション情報に保存します。
     * @return string
     */
    private function getItemCode()
    {
        $item_code = request('item_code', VossSessionManager::get('reservation_import.item_code'));
        VossSessionManager::set('reservation_import.item_code', $item_code);
        return $item_code;
    }
}