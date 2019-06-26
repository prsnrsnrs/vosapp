<?php

namespace App\Queries;


use App\Libs\ArrayUtil;
use App\Libs\Voss\VossAccessManager;

class ReceptionQuery extends BaseQuery
{

    /**
     * 個人受付一覧情報の取得のクエリ
     */
    public function getAll($net_user_number)
    {
        /*TODO paramにページ番号は？*/
        $sql = <<<EOF
SELECT
  RHD.RHDA10 AS new_created_date_time -- 新規作成日時
 ,RHD.RHD010 AS reservation_number --予約番号
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名(２行目)
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,RME.RME120 AS reservation_status -- ステータス
 ,RHD.RHD410 AS detail_input_flag -- 詳細入力FLAG
 ,RHD.RHD430 AS submit_document_flag -- 提出書類FLAG
 ,RHD.RHD460 AS contact_mail_count -- 連絡メール数
 ,RHD.RHD250 AS travelwith_number -- TravelWith予約番号
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,HIN.HIN540 AS item_arrival_date -- 商品到着日
 ,HIN.HIN560 AS stays -- 泊数
 ,HIN.HIN570 AS days -- 日数
 ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
 ,MPN2.MPN030 AS arrival_place_knj -- 漢字名称(到着地)
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
{$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
 ON
     RHD.RHD120 = HIN.HIN010 -- 商品コード
INNER JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME130 = 'Y' -- 代表者区分
 AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
  ON
     MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN2 -- 港名マスター
  ON
     MPN2.MPN010 = HIN.HIN530 -- 商品到着地コード
WHERE
  RHD.RHD350 = :net_user_number -- ネット利用者No,
 AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
 AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
ORDER BY
  RHD.RHDA10 DESC -- 新規作成日時
EOF;
        $param = [
            'net_user_number' => $net_user_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * 受付一覧情報の取得
     * @param array $search_con
     * @return array
     */
    public function findAll(array $search_con)
    {
        $result = $this->getWhere($search_con);
        $where = $result['where'];
        //WHERE句の要素を削除し、パラメータのみの配列を$paramsに格納
        unset($result['where']);
        $params = $result;
        $params['page_start'] = $search_con['page'] * 10 - 9;
        $params['page_end'] = $search_con['page'] * 10;
        $sql = <<<EOF
SELECT
  SUB.*
FROM (
    SELECT
      RHD.RHDA10 AS new_created_date_time  -- 新規作成日時
     ,RHD.RHD010 AS reservation_number --予約番号
     ,RHD.RHD110 AS cruise_id -- クルーズid
     ,RHD.RHD120 AS item_code -- 商品コード
     ,RHD.RHD410 AS detail_input_flag -- 詳細入力FLAG
     ,RHD.RHD430 AS submit_document_flag -- 提出書類FLAG
     ,RHD.RHD460 AS contact_mail_count -- 連絡メール数
     ,RHD.RHD250 AS travelwith_number -- TravelWith予約番号
     ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
     ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
     ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
     ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
     ,RME.RME120 AS reservation_status -- ステータス
     ,HIN.HIN060 AS item_name -- 商品名
     ,HIN.HIN070 AS item_name2 -- 商品名(２行目)
     ,HIN.HIN510 AS item_departure_date -- 商品出発日
     ,HIN.HIN540 AS item_arrival_date -- 商品到着日
     ,HIN.HIN560 AS stays -- 泊数
     ,HIN.HIN570 AS days -- 日数
     ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
     ,MPN2.MPN030 AS arrival_place_knj -- 漢字名称(到着地)
     ,ROW_NUMBER() OVER (ORDER BY RHD.RHDA10 DESC) AS rn
    FROM 
      {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
    INNER JOIN
    {$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
     ON
         RHD.RHD120 = HIN.HIN010 -- 商品コード
    INNER JOIN
    {$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
     ON
         RHD.RHD010 = RME.RME010 -- 予約番号
     AND
         RME.RME130 = 'Y' -- 代表者区分
     AND
         RME.RME740 = 1 -- 表示区分
    LEFT JOIN
      {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
      ON
         MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
    LEFT JOIN
      {$this->voss_lib}.VOSMPNP MPN2 -- 港名マスター
      ON
         MPN2.MPN010 = HIN.HIN530 -- 商品到着地コード
    {$where}
) AS SUB
WHERE
  SUB.rn BETWEEN :page_start AND :page_end
EOF;
        return $this->all($sql, $params);
    }

    /**
     * 受付一覧全件取得のクエリ
     * @param $net_travel_company_code
     * @param $net_agent_code
     * @param $net_user_number
     * @return array
     */
    public function countAll(array $search_con)
    {
        $result = $this->getWhere($search_con);
        $where = $result['where'];
        //WHERE句の要素を削除し、パラメータのみの配列を$paramsに格納
        unset($result['where']);
        $params = $result;
        $sql = <<<EOF
SELECT COUNT(RHD.RHD010) AS reservation_count
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
{$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
 ON
     RHD.RHD120 = HIN.HIN010 -- 商品コード
INNER JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME130 = 'Y' -- 代表者区分
 AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
  ON
     MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN2 -- 港名マスター
  ON
     MPN2.MPN010 = HIN.HIN530 -- 商品到着地コード
    {$where}
EOF;
        return $this->first($sql, $params);
    }

    /**
     * グループ情報の取得のクエリ
     * @param string $cruise_id
     * @param string $travel_company_code
     * @param string $agent_code
     * @return array
     */
    public function getReservationGroups($cruise_id, $travel_company_code, $agent_code)
    {
        $params = [];

        // SELECT, FROM, JOIN句
        $sql = <<<EOF
SELECT
  RHD.RHDA10 AS new_created_date_time -- 新規作成日時
 ,RHD.RHD010 AS reservation_number --予約番号
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名(２行目)
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,RME.RME310 AS tel1 -- 電話番号１
 ,RME.RME120 AS reservation_status -- ステータス
 ,RHD.RHD250 AS travelwith_number -- TravelWith予約番号
 ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
{$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
 ON
     RHD.RHD120 = HIN.HIN010 -- 商品コード
INNER JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME130 = 'Y' -- 代表者区分
 AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
  ON
     MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
EOF;

        // WHERE句
        $where = PHP_EOL . <<<EOF
WHERE
   RHD.RHD110 = :cruise_id -- クルーズID
 AND
   (RME.RME120 = 'HK' OR RME.RME120 = 'WT') -- ステータス
 AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
 AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
 AND
   RHD.RHD360 = :travel_company_code -- ネット旅行社コード
EOF;
        $params['cruise_id'] = $cruise_id;
        $params['travel_company_code'] = $travel_company_code;
        if (!VossAccessManager::isJurisdictionAgent()) {
            $where .= PHP_EOL . " AND RHD.RHD370 = :agent_code -- 販売店コード" . PHP_EOL;
            $params['agent_code'] = $agent_code;
        }

        // ORDER BY句
        $order = PHP_EOL . <<<EOF
ORDER BY
   RME.RME250 ASC -- TravelWith予約番号
 , RHD.RHDA10 ASC -- 新規作成日時
EOF;

        return $this->all($sql . $where . $order, $params);
    }

    /**
     * TravelWith予約番号が同じ予約情報を取得します。
     *
     * @param $net_travel_company_code
     * @param $travelwith_number
     */
    public function getReservationsByTravelwith($net_travel_company_code, $travelwith_number)
    {
        $sql = <<<EOF
SELECT
  RHD.RHDA10 AS new_created_date_time -- 新規作成日時
 ,RHD.RHD010 AS reservation_number --予約番号
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名(２行目)
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,RME.RME310 AS tel1 -- 電話番号１
 ,RME.RME120 AS reservation_status -- ステータス
 ,RHD.RHD250 AS travelwith_number -- TravelWith予約番号
 ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
{$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
 ON
     RHD.RHD120 = HIN.HIN010 -- 商品コード
INNER JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME130 = 'Y' -- 代表者区分
 AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
  ON
     MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
WHERE
  RHD.RHD360 = :net_travel_company_code -- ネット旅行社コード
 AND
  RHD.RHD250 = :travelwith_number
 AND
   (RME.RME120 = 'HK' OR RME.RME120 = 'WT') -- ステータス
 AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
 AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
ORDER BY
   RME.RME250 ASC -- TravelWith予約番号
 , RHD.RHDA10 ASC -- 新規作成日時
EOF;
        $params = [
            'net_travel_company_code' => $net_travel_company_code,
            'travelwith_number' => $travelwith_number
        ];
        return $this->all($sql, $params);
    }

    /**
     * トラベルウイズ番号を取得します。
     *
     * @param $net_travel_company_code
     * @param $reservation_numbers
     */
    public function getTravelwithNumber($net_travel_company_code, $reservation_number)
    {
        $sql = <<<EOF
SELECT
  RHD.RHD250 AS travelwith_number -- TravelWith予約番号
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
WHERE
  RHD.RHD360 = :net_travel_company_code -- ネット旅行社コード
 AND
  RHD.RHD010 = :reservation_number -- 予約番号
 AND
  RHD.RHD340 <> '4' -- ネット制限 FLAG
 AND
  RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
EOF;
        $params = [
            'net_travel_company_code' => $net_travel_company_code,
            'reservation_number' => $reservation_number,
        ];

        $result = $this->first($sql, $params);
        return array_get($result, 'travelwith_number');
    }


    /**
     * 検索条件によってWHERE句を動的に作ってパラメータと共に配列で返す関数です
     * @param array $search_con
     * @return array
     */
    private function getWhere(array $search_con)
    {

        //WHERE句を検索条件によって動的に作成します
        $params = [];
        $status_all_flag = false;
        $detail_input_all_flag = false;
        $submit_document_all_flag = false;

        //WHERE句を$whereに格納
        $where_str = "WHERE RHD.RHD340 <> '4' -- ネット制限 FLAG";
        $where_str .= PHP_EOL . "AND RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち) ";
        //ネット旅行社コードが空ではない
        if ($search_con['net_travel_company_code'] !== "") {
            $where_str .= PHP_EOL . "AND RHD.RHD360 = :net_travel_company_code -- ネット旅行社コード";
            $params['net_travel_company_code'] = $search_con['net_travel_company_code'];
        }
        //管轄店ではない、かつ販売店コードが空ではない
        if (!(VossAccessManager::isJurisdictionAgent()) && $search_con['agent_code'] !== "") {
            $where_str .= PHP_EOL . "AND RHD.RHD370 = :agent_code -- 販売店コード";
            $params['agent_code'] = $search_con['agent_code'];
        }
        //クルーズIDが空ではない
        if (!empty($search_con['cruise_name'])) {
            $where_str .= PHP_EOL . "AND RHD.RHD110 = :cruise_name -- クルーズID";
            $params['cruise_name'] = $search_con['cruise_name'];
        }
        //商品コードが空ではない
        if ($search_con['item_code'] !== "") {
            $where_str .= PHP_EOL . "AND RHD.RHD120 = :item_code -- 商品コード";
            $params['item_code'] = $search_con['item_code'];
        }
        //商品出発日がNULLではない
        if (!empty($search_con['departure_date_from'])) {
            $where_str .= PHP_EOL . "AND HIN.HIN510 >= :departure_date_from -- 商品出発日";
            $params['departure_date_from'] = $search_con['departure_date_from'];
        }
        //商品到着日がNULLではない
        if (!empty($search_con['departure_date_to'])) {
            $where_str .= PHP_EOL . "AND HIN.HIN510 <= :departure_date_to -- 商品出発日";
            $params['departure_date_to'] = $search_con['departure_date_to'];
        }
        //予約番号が空ではない
        if ($search_con['reservation_number'] !== "") {
            $where_str .= PHP_EOL . "AND RHD.RHD010 = :reservation_number -- 予約番号";
            $params['reservation_number'] = $search_con['reservation_number'];
        }
        //代表者が空ではない
        if ($search_con['boss_name'] !== "") {
            $search_con['boss_name'] = preg_replace("/( |　)/", "", $search_con['boss_name']);
            $where_str .= PHP_EOL . "AND CONCAT(CONCAT(rtrim(RME.RME150),rtrim(RME.RME160)), CONCAT(rtrim(RME.RME170),rtrim(RME.RME180))) LIKE :boss_name -- 代表者名英字姓、英字名、漢字姓、漢字名";
            $params['boss_name'] = $this->changeLike($search_con['boss_name']);
        }
        //ステータスの全チェックあり,または、全チェックなしの判別
        if (($search_con['status_hk'] === 'HK' && $search_con['status_wt'] === 'WT' && $search_con['status_cx'] === 'CX')
            || (empty($search_con['status_hk']) && empty($search_con['status_wt']) && empty($search_con['status_cx']))) {
            $status_all_flag = true;
        }
        //上記以外の場合はWHERE句に追加
        if (!$status_all_flag) {
            //HKのみチェック
            if ($search_con['status_hk'] === 'HK' && empty($search_con['status_wt']) && empty($search_con['status_cx'])) {
                $where_str .= PHP_EOL . "AND RME.RME120 = :status_hk -- ステータス_HK";
                $params['status_hk'] = $search_con['status_hk'];
            }
            //WTのみチェック
            if (empty($search_con['status_hk']) && $search_con['status_wt'] === 'WT' && empty($search_con['status_cx'])) {
                $where_str .= PHP_EOL . "AND RME.RME120 = :status_wt -- ステータス_WT";
                $params['status_wt'] = $search_con['status_wt'];
            }
            //CXのみチェック
            if (empty($search_con['status_hk']) && empty($search_con['status_wt']) && $search_con['status_cx'] === 'CX') {
                $where_str .= PHP_EOL . "AND RME.RME120 = :status_cx -- ステータス_CX";
                $params['status_cx'] = $search_con['status_cx'];
            }
            //HK,WTにチェック
            if ($search_con['status_hk'] === 'HK' && $search_con['status_wt'] === 'WT' && empty($search_con['status_cx'])) {
                $where_str .= PHP_EOL . "AND (RME.RME120 = :status_hk -- ステータス_HK" . PHP_EOL . "OR RME.RME120 = :status_wt) -- ステータス_WT";
                $params['status_hk'] = $search_con['status_hk'];
                $params['status_wt'] = $search_con['status_wt'];
            }
            //HK,CXにチェック
            if ($search_con['status_hk'] === 'HK' && empty($search_con['status_wt']) && $search_con['status_cx'] === 'CX') {
                $where_str .= PHP_EOL . "AND (RME.RME120 = :status_hk -- ステータス_HK" . PHP_EOL . "OR RME.RME120 = :status_cx) -- ステータス_CX";
                $params['status_hk'] = $search_con['status_hk'];
                $params['status_cx'] = $search_con['status_cx'];
            }
            //WT,CXにチェック
            if (empty($search_con['status_hk']) && $search_con['status_wt'] === 'WT' && $search_con['status_cx'] === 'CX') {
                $where_str .= PHP_EOL . "AND (RME.RME120 = :status_wt -- ステータス_WT" . PHP_EOL . "OR RME.RME120 = :status_cx) -- ステータス_CX";
                $params['status_wt'] = $search_con['status_wt'];
                $params['status_cx'] = $search_con['status_cx'];
            }
        }
        //詳細入力両方チェックあり、両方チェックなしの判別
        if ((($search_con['detail_input_flag_yet']) === "0" && $search_con['detail_input_flag_fin'] === "1") ||
            ($search_con['detail_input_flag_yet'] === "" && $search_con['detail_input_flag_fin'] === "")) {
            $detail_input_all_flag = true;
        }
        //上記以外の場合はWHERE句に追加
        if (!$detail_input_all_flag) {
            //"未のみチェック"
            if ($search_con['detail_input_flag_yet'] === "0" && $search_con['detail_input_flag_fin'] === "") {
                $where_str .= PHP_EOL . "AND RHD.RHD410 = :detail_input_flag_yet -- 詳細入力FLAG_未";
                $params['detail_input_flag_yet'] = $search_con['detail_input_flag_yet'];
            }
            //"済"のみチェック
            if ($search_con['detail_input_flag_yet'] === "" && $search_con['detail_input_flag_fin'] === "1") {
                $where_str .= PHP_EOL . "AND RHD.RHD410 = :detail_input_flag_fin -- 詳細入力FLAG_済";
                $params['detail_input_flag_fin'] = $search_con['detail_input_flag_fin'];
            }
        }
        //提出書類両方チェックあり、両方チェックなしの判別
        if (($search_con['submit_document_flag_yet'] === "1" && $search_con['submit_document_flag_fin'] === "3") ||
            ($search_con['submit_document_flag_yet'] === "" && $search_con['submit_document_flag_fin'] === "")) {
            $submit_document_all_flag = true;
        }
        //上記以外の場合はWHERE句に追加
        if (!$submit_document_all_flag) {
            //"未のみチェック"
            if ($search_con['submit_document_flag_yet'] === "1" && $search_con['submit_document_flag_fin'] === "") {
                $where_str .= PHP_EOL . "AND RHD.RHD430 = :submit_document_flag_yet -- 提出書類FLAG_未";
                $params['submit_document_flag_yet'] = $search_con['submit_document_flag_yet'];
            }
            //"済"のみチェック
            if ($search_con['submit_document_flag_yet'] === "" && $search_con['submit_document_flag_fin'] === "3") {
                $where_str .= PHP_EOL . "AND RHD.RHD430 = :submit_document_flag_fin -- 提出書類FLAG_済";
                $params['submit_document_flag_fin'] = $search_con['submit_document_flag_fin'];
            }
        }
        //WHERE句の文字列である$where_strを配列に格納
        $where = [
            'where' => $where_str
        ];
        //パラメータとWHERE句の配列をマージし、return
        $result = array_merge($params, $where);
        return $result;
    }
}