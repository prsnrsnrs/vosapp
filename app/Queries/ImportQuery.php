<?php

namespace App\Queries;


class ImportQuery extends BaseQuery
{

    /**
     * 取込管理一覧情報の取得クエリ
     * @param $item_code
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function getManagementsByItemCode($item_code, $travel_company_code, $agent_code)
    {

        $sql = <<<EOF
SELECT
  NIC.NICA10 AS new_created_date_time -- 新規作成日時
 ,NIC.NIC010 AS import_management_number -- 取込管理№
 ,NIC.NIC060 AS import_count -- 取込件数
 ,NIC.NIC070 AS new_import_count -- 取込新規件数
 ,NIC.NIC080 AS new_success_import_count -- 取込新規成功数
 ,NIC.NIC090 AS new_import_error_count -- 取込新規エラー数
 ,NIC.NIC100 AS change_import_count -- 取込変更件数
 ,NIC.NIC110 AS change_success_import_count -- 取込変更成功数
 ,NIC.NIC120 AS change_error_import_count -- 取込変更エラー数
 ,NFH.NFH030 AS format_name -- フォーマット名
FROM 
  {$this->voss_lib}.VOSNICP NIC -- 取込管理ファイル
LEFT JOIN
  {$this->voss_lib}.VOSNFHP NFH -- 取込フォーマット見出ファイル
  ON
    NFH.NFH010 = NIC.NIC020 -- 旅行社コード
  AND
    NFH.NFH020 = NIC.NIC050 -- 取込フォーマット番号
WHERE
  NIC.NIC040 = :item_code -- 商品コード
 AND
   NIC.NIC020 = :travel_company_code -- 旅行社コード
 AND
   NIC.NIC030 = :agent_code -- 販売店コード
ORDER BY
  NIC.NICA40 DESC -- 最終更新日時
EOF;
        $params = [
            'item_code' => $item_code,
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code
        ];
        return $this->all($sql, $params);
    }

    /**
     * 取込フォーマット管理見出し一覧情報の取得クエリ
     * @param $travel_company_code
     * @return array
     */
    public function getFormatHeaders($travel_company_code)
    {
        $sql = <<<EOF
SELECT
  NFH.NFHA10 AS new_register_date_time -- 新規作成日時
 ,NFH.NFHA40 AS last_update_date_time -- 最終更新日時
 ,NFH.NFH020 AS format_number -- フォーマット番号
 ,NFH.NFH030 AS format_name -- フォーマット名
 ,NFH.NFH050 AS default_type -- 既定区分
 ,NFH.NFH055 AS edit_flag -- 編集フラグ
 ,NFH.NFH060 AS file_type -- ファイル形式
 ,NFH.NFH070 AS import_type -- 取込区分
 ,NFH.NFH080 AS header_line_number -- 列見出行番号
 ,NFH.NFH090 AS import_start_line_number -- 取込開始行番号
 ,NBU.NBU060 AS user_name -- ユーザー名称
FROM 
   {$this->voss_lib}.VOSNFHP NFH -- 取込フォーマット見出しファイル
LEFT JOIN
{$this->voss_lib}.VOSNBUP NBU -- 販売店利用者ファイル
 ON
     NFH.NFH160 = NBU.NBU010 -- 旅行社コード
 AND
     NFH.NFH170 = NBU.NBU020 -- 販売店コード
 AND
     NFH.NFH180 = NBU.NBU030 -- 販売店利用者No.
WHERE
  NFH.NFH010 = :travel_company_code -- 旅行社コード
AND
  NFH.NFH190 <= 0
ORDER BY
  NFH.NFH020 ASC -- フォーマット番号
EOF;
        $param = ['travel_company_code' => $travel_company_code];
        return $this->all($sql, $param);
    }

    /**
     * 取込フォーマット管理見出情報の取得クエリ
     * @param $travel_company_code
     * @param $format_number
     * @return array
     */
    public function getFormatHeader($travel_company_code, $format_number)
    {

        $sql = <<<EOF
SELECT
  NFH.NFHA40 AS last_update_date_time -- 最終更新日時
 ,NFH.NFH020 AS format_number -- フォーマット番号
 ,NFH.NFH030 AS format_name -- フォーマット名
 ,NFH.NFH040 AS upload_file_name -- アップロードファイル名
 ,NFH.NFH060 AS file_type -- ファイル形式
 ,NFH.NFH070 AS import_type -- 取込区分
 ,NFH.NFH080 AS header_line_number -- 列見出行番号
 ,NFH.NFH090 AS import_start_line_number -- 取込開始行番号
FROM 
   {$this->voss_lib}.VOSNFHP NFH -- 取込フォーマット見出しファイル
WHERE
  NFH.NFH010 = :travel_company_code -- 旅行社コード
 AND
   NFH.NFH020 = :format_number -- フォーマット番号
 AND
   NFH.NFH190 <= 0
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'format_number' => $format_number
        ];
        return $this->first($sql, $params);
    }

    /**
     * 取込フォーマット管理明細情報の取得クエリ
     * @param $travel_company_code
     * @param $format_number
     * @return array
     */
    public function getFormatDetails($travel_company_code, $format_number)
    {
        $sql = <<<EOF
SELECT
  NFM.NFMA40 AS last_update_date_time -- 最終更新日時
 ,NFM.NFM040 AS travel_company_col_index-- 旅行社列番号
 ,NFM.NFM050 AS delimiter_char -- 区切り文字
 ,NFF.NFF010 AS format_point_manage_number -- 項目管理番号
 ,NFF.NFF020 AS format_point_name -- 項目名
 ,NFF.NFF030 AS attribute_type -- 属性区分
 ,NFF.NFF040 AS format_require_type -- 必須項目区分
 ,NFF.NFF050 AS description -- 説明文
 ,NFF.NFF060 AS group_point_name -- グループ項目名
 ,NFF.NFF080 AS display_approval_flag -- 表示許可フラグ
 ,NFF.NFF090 AS delimit_type -- 区切区分
 ,NFF.NFF100 AS socket_data_number -- ソケットデータ番号
FROM
  {$this->voss_lib}.VOSNFFP NFF -- 取込フォーマット項目マスター
LEFT JOIN
  {$this->voss_lib}.VOSNFMP NFM -- 取込フォーマット明細ファイル
  ON
     NFM.NFM010 = :travel_company_code -- 旅行社コード
  AND
     NFM.NFM020 = :format_number -- フォーマット番号
  AND
     NFM.NFM030 = NFF.NFF010 -- 項目管理番号
WHERE
  NFF.NFF080 = 'Y'
ORDER BY
  NFF.NFF070 ASC --  表示順
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'format_number' => $format_number
        ];
        return $this->all($sql, $params);
    }

//    /**
//     * 取込フォーマット情報の取得クエリ
//     * @param $travel_company_code
//     * @param $format_number
//     * @return array
//     */
//    public function getFormat($travel_company_code, $format_number)
//    {
//
//        $sql = <<<EOF
//SELECT
// ,NFH.NFH070 AS import_type -- 取込区分
// ,NFH.NFH080 AS header_start_line -- 列見出開始行
// ,NFH.NFH090 AS import_start_line_number -- 取込開始行番号
// ,NFH.NFH100 AS setting_point_count -- 設定項目数
// ,NFM.NFM040 AS travel_company_col_index -- 旅行社列番号
// ,NFM.NFM050 AS delimiter_char -- 区切り文字
// ,NFF.NFF020 AS format_point_name -- 項目名
// ,NFF.NFF090 AS delimit_type -- 区切区分
// ,NFF.NFF100 AS length -- 桁数
//FROM
//  {$this->voss_lib}.VOSNFHP NFH -- 取込フォーマット見出ファイル
//LEFT JOIN
//{$this->voss_lib}.VOSNFMP NFM -- 取込フォーマット明細
// ON
//     NFM.NFM010 = NFH.NFH010 -- 旅行社コード
// AND
//     NFM.NFM020 = NFH.NFH020 -- フォーマット番号
//LEFT JOIN
//{$this->voss_lib}.VOSNFFP NFF -- 取込フォーマット項目マスター
// ON
//     NFM.NFM030 = NFF.NFF010 -- 項目管理番号
//WHERE
//  NFH.NFH010 = :travel_company_code -- 旅行社コード
// AND
//   NFH.NFH020 = :format_number -- フォーマット番号
// AND
//   NFH.NFH190 <= 0 -- 削除日時
//ORDER BY
//  NFF.NFF070 ASC -- 表示順
//EOF;
//        $params = [
//            'travel_company_code' => $travel_company_code,
//            'format_number' => $format_number
//        ];
//        return $this->first($sql, $params);
//    }

    /**
     * 取込見出一覧情報の取得クエリ
     * @param $import_management_number
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function getHeaders($import_management_number, $travel_company_code, $agent_code)
    {

        $sql = <<<EOF
SELECT
  NIH.NIH050 AS travel_company_manage_number -- 旅行社管理番号
 ,NIH.NIH060 AS process_type -- 処理区分
 ,NIH.NIH070 AS reservation_import_status -- ステータス
 ,NIH.NIH080 AS boss_name -- 代表者名
 ,NIH.NIH090 AS boss_tel -- 代表者名電話番号
 ,NIH.NIH100 AS adult_count -- 大人人数
 ,NIH.NIH110 AS child_count -- 小人人数
 ,NIH.NIH120 AS infant_count -- 幼児人数
 ,NIH.NIH150 AS reservation_number -- 予約番号
 ,NIH.NIH160 AS import_error_content -- 取込エラー内容
FROM 
  {$this->voss_lib}.VOSNIHP NIH -- 取込見出ファイル
WHERE
  NIH.NIH020 = :travel_company_code -- 旅行社コード
 AND
   NIH.NIH030 = :agent_code -- 販売店コード
 AND
   NIH.NIH010 = :import_management_number -- 取込管理No.
ORDER BY
  NIH.NIH050 ASC -- 旅行社管理番号
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code,
            'import_management_number' => $import_management_number
        ];
        return $this->all($sql, $params);
    }

    /**
     * 取込管理情報の取得クエリ
     * @param $import_management_number
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function getManagement($import_management_number, $travel_company_code, $agent_code)
    {

        $sql = <<<EOF
SELECT
  NIC.NIC060 AS import_count -- 取込件数
 ,NIC.NIC070 AS new_import_count -- 取込新規件数
 ,NIC.NIC090 AS new_import_error_count -- 取込新規エラー数
 ,NIC.NIC100 AS change_import_count -- 取込変更件数
 ,NIC.NIC120 AS change_error_import_count -- 取込変更エラー数
FROM 
  {$this->voss_lib}.VOSNICP NIC -- 取込管理ファイル
WHERE
  NIC.NIC010 = :import_management_number -- 取込管理No.
 AND
   NIC.NIC020 = :travel_company_code -- 旅行社コード
 AND
   NIC.NIC030 = :agent_code -- 販売店コード
EOF;
        $params = [
            'import_management_number' => $import_management_number,
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code
        ];
        return $this->first($sql, $params);
    }

//    /**
//     * フォーマット項目マスタ取得のクエリ (24時間キャッシュ)
//     * @return array
//     */
//    public function getFormatItemMaster()
//    {
//        $cache_key = __METHOD__;
//        if (VossCacheManager::has($cache_key)) {
//            return VossCacheManager::get($cache_key);
//        }
//
//        $sql = <<<EOF
//SELECT
//  NFF.NFF010 AS format_point_manage_number -- 項目管理番号
// ,NFF.NFF020 AS format_point_name -- 項目名
// ,NFF.NFF030 AS attribute_type -- 属性区分
// ,NFF.NFF040 AS format_require_type -- 必須項目区分
// ,NFF.NFF050 AS description -- 説明文
// ,NFF.NFF060 AS group_point_name -- グループ項目名
// ,NFF.NFF080 AS display_approval_flag -- 表示許可フラグ
// ,NFF.NFF090 AS delimit_type -- 区切区分
// ,NFF.NFF100 AS socket_data_number -- ソケットデータ番号
//FROM
//  VOSDTL.VOSNFFP NFF
//WHERE
//  NFF.NFF080 = 'Y'
//ORDER BY
//  NFF.NFF070
//EOF;
//        $results = $this->all($sql);
//        VossCacheManager::set($cache_key, $results);
//        return VossCacheManager::get($cache_key);
//    }
}