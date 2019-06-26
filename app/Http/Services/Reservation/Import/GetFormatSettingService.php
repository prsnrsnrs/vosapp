<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\ImportUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossUplClient;
use App\Queries\ImportQuery;

/**
 * 取込フォーマット設定のサービスです
 *
 * Class GetFormatSettingService
 * @package App\Http\Services\Reservation\Import
 */
class GetFormatSettingService extends BaseService
{
    /**
     * @var string
     */
    private $format_number;
    /**
     * @var bool
     */
    private $is_edit;
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
        $this->is_edit = (bool)$this->format_number;
        $this->auth = VossAccessManager::getAuth();
        $this->import_query = new ImportQuery();

        $this->response_data['is_edit'] = $this->is_edit;
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        if ($this->is_edit) {
            // 取込フォーマット設定情報の取得
            $format_header = $this->import_query->getFormatHeader($this->auth['travel_company_code'], $this->format_number);
            $this->response_data['format_header'] = $format_header;
            // 取込フォーマット情報の取得
            $format_details = $this->import_query->getFormatDetails($this->auth['travel_company_code'], $this->format_number);
            $this->response_data['format_details'] = $this->convertFormatDetail($format_details);
            // 取込情報の取得

            $dl_response = VossUplClient::download('reservation_import_format', $format_header['upload_file_name']);
            $this->response_data['file_header'] = ImportUtil::readHeadingForFileContents($dl_response->getBody()->getContents(),
                $format_header['header_line_number']);
        }
    }

    /**
     * フォーマット明細データを画面表示用に加工します。
     * @param array $format_details
     * @return array
     */
    private function convertFormatDetail($format_details)
    {
        $ret = [];
        $len = count($format_details);
        for ($i = 0; $i < $len; $i++) {
            $format_detail = $format_details[$i];
            $format_detail['group_point_name'] = $format_detail['group_point_name'] ? $format_detail['group_point_name'] : $format_detail['format_point_name'];
            $format_detail['group'] = [];
            while (true) {
                if (!isset($format_details[$i + 1]) || $format_detail['group_point_name'] != $format_details[$i + 1]['group_point_name']) {
                    break;
                }
                $format_detail['group'][] = $format_details[$i + 1];
                $i++;
            }
            $ret[] = $format_detail;
        }
        return $ret;
    }
}