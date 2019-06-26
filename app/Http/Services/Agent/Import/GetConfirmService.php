<?php

namespace App\Http\Services\Agent\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Queries\AddressQuery;
use App\Queries\AgentQuery;

/**
 * 販売店一括登録結果画面のサービスです。
 * Class GetConfirmService
 * @package App\Http\Services\Agent\Import
 */
class GetConfirmService extends BaseService
{
    /**
     * 一次インポートクエリ
     * @var AgentQuery
     */
    protected $agent_query;

    /**
     * 都道府県取得クエリ
     * @var AddressQuery
     */
    protected $address_query;

    /**
     * 都道府県情報
     * @var array
     */
    protected $prefectures;


    /**
     * 都道府県取得インデックス：都道府県
     */
    const CONVERT_PREFECTURE_CODE_INDEXES = 3;


    /**
     * 初期化処理を実行します。
     */
    protected function init()
    {
        $this->agent_query = new AgentQuery();
        $this->address_query = new  AddressQuery();
        //都道府県クエリ
        $this->prefectures = $this->address_query->getPrefectures();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        //セッションに保存しているデータを取得する
        $session_import_data = VossSessionManager::get('import_data');
        //一次インポート管理No
        $import_management_number = request('import_management_number');

        //一次インポートクエリから一次インポート情報を取得する
        $import_management_data = $this->agent_query->getImportResults($import_management_number);

        // キーを取込行番号に変更する
        $confirm_data = [];
        $query_data = [];
        $error_count = [];
        foreach ($session_import_data as $index => $mgr_data) {

            //都道府県コードを都道府県名に変換
            foreach ($mgr_data as $col_index => $col_data) {
                if ($col_index === self::CONVERT_PREFECTURE_CODE_INDEXES) {
                    $pre_name = $this->convertAddress($col_data);
                    $mgr_data[$col_index] = $pre_name;
                    break;
                }
            }

            $confirm_data[$index] = $mgr_data;
            //エラー行を配列に追加する
            if (!empty($session_import_data[$index]['error_message'])) {
                $error_count[] = $mgr_data;
            }
        }

        //一次インポート情報を再編成する
        foreach ($import_management_data as $index => $mgr_data) {
            $query_data[$mgr_data['first_import_line_number']] = $mgr_data;
        }

        //エラーメッセージを取得する
        foreach ($query_data as $line_number => &$data) {
            if (!isset($confirm_data[$line_number])) {
                continue;
            }
            $confirm_data[$line_number]['error_message'] = $data['error_message'];
            //エラー行配列に追加
            if (!empty($data['error_message'])) {
                $error_count[] = $data;
            }
        }

        //CSVファイル情報
        $this->response_data['import_data'] = $confirm_data;
        //一次インポート管理No
        $this->response_data['import_management_number'] = $import_management_number;
        //インポート成功件数
        $this->response_data['import_count'] = count($query_data);
        //インポートエラー件数
        $this->response_data['import_error_count'] = count($error_count);

    }

    /**
     * 都道府県取得処理
     * @param $import_data
     * @return string
     */
    private function convertAddress($import_data)
    {
        //都道府県番号との一致
        foreach ($this->prefectures as $prefecture) {
            $prefecture_code = $prefecture['prefecture_code'];
            if ($prefecture_code !== $import_data) {
                continue;
            }
            $import_data = $prefecture['prefecture_name'];
            break;
        }
        //一致した都道府県名を返す
        return $import_data;
    }


}