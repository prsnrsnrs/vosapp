<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossUplClient;
use App\Queries\ImportQuery;

/**
 * フォーマットファイルのダウンロード処理サービスです。
 * Class GetFormatDownloadService
 * @package App\Http\Services\Reservation\Import
 */
class GetFormatDownloadService extends BaseService
{
    /**
     * @var string
     */
    private $format_number;
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
        $this->format_number = request('format_number');
        $this->auth = VossAccessManager::getAuth();
        $this->import_query = new ImportQuery();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // 取込フォーマット設定情報の取得
        $format_header = $this->import_query->getFormatHeader($this->auth['travel_company_code'], $this->format_number);
        $dl_response = VossUplClient::download('reservation_import_format', $format_header['upload_file_name']);
        $this->response_data['headers'] = [
            'Content-Type' => $dl_response->getHeader('Content-Type'),
            'Content-Disposition' => $dl_response->getHeader('Content-Disposition'),
        ];
        $this->response_data['contents'] = $dl_response->getBody()->getContents();
    }
}