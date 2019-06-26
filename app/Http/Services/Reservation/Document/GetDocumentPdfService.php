<?php

namespace App\Http\Services\Reservation\Document;

use App\Http\Services\BaseService;
use App\Queries\DocumentQuery;
use Request;
use SebastianBergmann\Environment\Console;


/**
 * 提出書類のPDFファイルを出力するサービスクラスです。
 * Class GetDocumentPdfService
 * @package App\Http\Services\Reservation\Document
 */
class GetDocumentPdfService extends BaseService
{
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var string
     */
    private $passenger_line_number;
    /**
     * @var string
     */
    private $progress_manage_code;
    /**
     * @var DocumentQuery
     */
    private $document_query;

    /**
     *サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->passenger_line_number = request('passenger_line_number');
        $this->progress_manage_code = request('progress_manage_code');
        $this->document_query = new DocumentQuery();
    }

    /**
     * サービスを実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //ファイル名のために乗船者行Noをレスポンスデータに格納
        $this->response_data['passenger_line_number'] = $this->passenger_line_number;
        //クリックされたPDFがあるディレクトリ内のファイル数(ページ数)を取得
        $dir = resource_path('views/reservation/document/' . $this->progress_manage_code);
        $files = \File::allFiles($dir);
        $this->response_data['files'] = $files;

        //進行管理マスタ情報の取得
        $progress_manage_info = $this->document_query->findByProgressCode($this->progress_manage_code);
        $this->response_data['progress_manage_info'] = $progress_manage_info;

        //提出書類に印字が必要な場合のみヘッダー情報を取得
        if (!$progress_manage_info['net_header_print'] == "0") {
            //提出書類ヘッダー部情報の取得
            $header_info = $this->document_query->getPrintData($this->reservation_number, $this->passenger_line_number);
            $this->response_data['header_info'] = $header_info;
        }
    }
}