<?php

namespace App\Queries;


use App\Libs\Voss\VossAccessManager;

class ContactQuery extends BaseQuery
{
    /**
     * ご連絡一覧情報の取得のクエリ
     * @param array $search_con
     * @return array
     */
    public function findAll(array $search_con)
    {
        $result = $this->getListWhere($search_con);
        $order_by = $this->getOrderBy($search_con);
        $where = $result['where'];
        $params = $result['params'];
        $params['page_start'] = $search_con['page'] * 10 - 9;
        $params['page_end'] = $search_con['page'] * 10;
        $sql = <<<EOF
SELECT
  SUB.*
FROM (
    SELECT
      NMIL.NMIL010 AS mail_send_instruction_number -- メール送信指示No.
     ,NMIL.NMIL020 AS reservation_number -- 予約番号
     ,NMIL.NMIL030 AS mail_category -- メール分類
     ,NMIL.NMIL040 AS mail_subject -- 件名
     ,NMIL.NMIL060 AS mail_send_date_time-- 送信日時
     ,HIN.HIN060 AS item_name -- 商品名
     ,HIN.HIN070 AS item_name2 -- 商品名（2行目）
     ,HIN.HIN510 AS item_departure_date -- 商品出発日
     ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
     ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
     ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
     ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
     ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
     ,ROW_NUMBER() OVER ({$order_by}) AS rn
    FROM 
      {$this->voss_lib}.VOSNMILU NMIL -- メール送信記録ファイル
    LEFT JOIN
      {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
     ON
         NMIL.NMIL020 = RHD.RHD010 -- 予約番号
    LEFT JOIN
    {$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
     ON
         RHD.RHD120 = HIN.HIN010 -- 商品コード
    LEFT JOIN
    {$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
     ON
         RHD.RHD010 = RME.RME010 -- 予約番号
     AND
         RME.RME130 = 'Y' -- 代表者区分
    LEFT JOIN
    {$this->voss_lib}.VOSNBRP NBR -- 販売店マスター
     ON
         RHD.RHD360 = NBR.NBR010 -- 旅行社コード
     AND
         RHD.RHD370 = NBR.NBR020 -- 販売店コード
    LEFT JOIN
      {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
      ON
         MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
    {$where}
) AS SUB
WHERE
  SUB.rn BETWEEN :page_start AND :page_end
EOF;
        return $this->all($sql, $params);
    }

    /**
     * ご連絡一覧全件取得のクエリ
     * @param $travel_company_code
     * @param $agent_code
     * @param $user_no
     * @return array
     */
    public function countAll(array $search_con)
    {
        $result = $this->getListWhere($search_con);
        $where = $result['where'];
        $params = $result['params'];
        $sql = <<<EOF
SELECT
  COUNT(NMIL.NMIL020) AS contact_count -- ご連絡数
    FROM 
      {$this->voss_lib}.VOSNMILU NMIL -- メール送信記録ファイル
    LEFT JOIN
      {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
     ON
         NMIL.NMIL020 = RHD.RHD010 -- 予約番号
    LEFT JOIN
    {$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
     ON
         RHD.RHD120 = HIN.HIN010 -- 商品コード
    LEFT JOIN
    {$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
     ON
         RHD.RHD010 = RME.RME010 -- 予約番号
     AND
         RME.RME130 = 'Y' -- 代表者区分
    {$where}
EOF;
        return $this->first($sql, $params);
    }

    /**
     * ご連絡閲覧情報の取得
     * @param $mail_instruction
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function getMailDetail($user_info)
    {
        $result = $this->getDetailWhere($user_info);
        $where = $result['where'];
        $params = $result['params'];
        $sql = <<<EOF
SELECT
  RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名 (2行目)
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
 ,NMIL.NMIL010 AS mail_send_instruction_number -- メール送信指示No.
 ,NMIL.NMIL020 AS reservation_number -- 予約番号
 ,NMIL.NMIL040 AS mail_subject -- 件名
 ,NMIL.NMIL050 AS mail_text -- 本文
 ,NMIL.NMIL060 AS mail_send_date_time -- 送信日時
 ,NMIL.NMIL070 AS send_mail_address1 -- 送信先(メールアドレス1)
 ,NMIL.NMIL071 AS send_mail_address2 -- 送信先(メールアドレス2)
 ,NMIL.NMIL072 AS send_mail_address3 -- 送信先(メールアドレス3)
 ,NMIL.NMIL073 AS send_mail_address4 -- 送信先(メールアドレス4)
 ,NMIL.NMIL074 AS send_mail_address5 -- 送信先(メールアドレス5)
 ,NMIL.NMIL075 AS send_mail_address6 -- 送信先(メールアドレス6) 
 ,NMIL.NMIL080 AS mail_format -- メール形式
FROM 
  {$this->voss_lib}.VOSNMILU NMIL -- メール送信記録ファイル
LEFT JOIN
{$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
 ON
     NMIL.NMIL020 = RHD.RHD010 -- 予約番号
LEFT JOIN
{$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
 ON
     RHD.RHD120 = HIN.HIN010 -- 商品コード
LEFT JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME130 = 'Y' -- 代表者区分
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
  ON
     MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
  {$where}
EOF;
        return $this->first($sql, $params);
    }

    /**
     * 検索条件によってWHERE句を動的に作ってパラメータと共に配列で返す関数です
     * @param array $search_con
     * @return array
     */
    private function getListWhere(array $search_con)
    {
        //WHERE句を検索条件によって動的に作成します
        $params = [];
        $status_all_flag = false;

        //WHERE句を$whereに格納
        $where_str = "WHERE NMIL.NMIL140 <= 0 -- 削除日時";
        $where_str .= PHP_EOL . "AND NMIL.NMIL030 <> '9' -- メール分類 ";
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
        //ステータスの全チェックあり,または、全チェックなしの判別
        if (($search_con['status_need_answer'] === '1' && $search_con['status_not_need_answer'] === '2' && $search_con['status_information'] === '3')
            || (empty($search_con['status_need_answer']) && empty($search_con['status_not_need_answer']) && empty($search_con['status_information']))) {
            $status_all_flag = true;
        }
        //上記以外の場合はWHERE句に追加
        if (!$status_all_flag) {
            //回答要のみチェック
            if ($search_con['status_need_answer'] === '1' && empty($search_con['status_not_need_answer']) && empty($search_con['status_information'])) {
                $where_str .= PHP_EOL . "AND NMIL.NMIL030 = :status_need_answer -- 分類_回答要";
                $params['status_need_answer'] = $search_con['status_need_answer'];
            }
            //回答不要のみチェック
            if (empty($search_con['status_need_answer']) && $search_con['status_not_need_answer'] === '2' && empty($search_con['status_information'])) {
                $where_str .= PHP_EOL . "AND NMIL.NMIL030 = :status_not_need_answer -- 分類_回答不要";
                $params['status_not_need_answer'] = $search_con['status_not_need_answer'];
            }
            //ご案内のみチェック
            if (empty($search_con['status_need_answer']) && empty($search_con['status_not_need_answer']) && $search_con['status_information'] === '3') {
                $where_str .= PHP_EOL . "AND NMIL.NMIL030 = :status_information -- 分類_ご案内";
                $params['status_information'] = $search_con['status_information'];
            }
            //回答要,回答不要にチェック
            if ($search_con['status_need_answer'] === '1' && $search_con['status_not_need_answer'] === '2' && empty($search_con['status_information'])) {
                $where_str .= PHP_EOL . "AND (NMIL.NMIL030 = :status_need_answer -- 分類_回答要" . PHP_EOL . "OR NMIL.NMIL030 = :status_not_need_answer) -- 分類_回答不要";
                $params['status_need_answer'] = $search_con['status_need_answer'];
                $params['status_not_need_answer'] = $search_con['status_not_need_answer'];
            }
            //回答要,ご案内にチェック
            if ($search_con['status_need_answer'] === '1' && empty($search_con['status_not_need_answer']) && $search_con['status_information'] === '3') {
                $where_str .= PHP_EOL . "AND (NMIL.NMIL030 = :status_need_answer -- 分類_回答要" . PHP_EOL . "OR NMIL.NMIL030 = :status_not_need_answer) -- 分類_ご案内";
                $params['status_need_answer'] = $search_con['status_need_answer'];
                $params['status_not_need_answer'] = $search_con['status_not_need_answer'];
            }
            //回答不要,ご案内にチェック
            if (empty($search_con['status_need_answer']) && $search_con['status_not_need_answer'] === '2' && $search_con['status_information'] === '3') {
                $where_str .= PHP_EOL . "AND (NMIL.NMIL030 = :status_not_need_answer -- 分類_回答不要" . PHP_EOL . "OR NMIL.NMIL030 = :status_information) -- 分類_ご案内";
                $params['status_not_need_answer'] = $search_con['status_not_need_answer'];
                $params['status_information'] = $search_con['status_information'];
            }
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
        //商品コードが空ではない
        if (!($search_con['item_code'] === "")) {
            $where_str .= PHP_EOL . "AND HIN.HIN010 = :item_code -- 商品コード";
            $params['item_code'] = $search_con['item_code'];
        }
        //予約番号がNULLではない
        if (!($search_con['reservation_number'] === "")) {
            $where_str .= PHP_EOL . "AND NMIL.NMIL020 = :reservation_number -- 予約番号";
            $params['reservation_number'] = $search_con['reservation_number'];
        }
        //代表者が空ではない
        if ($search_con['boss_name'] !== "") {
            $search_con['boss_name'] = preg_replace("/( |　)/", "", $search_con['boss_name']);
            $where_str .= PHP_EOL . "AND CONCAT(CONCAT(rtrim(RME.RME150),rtrim(RME.RME160)), CONCAT(rtrim(RME.RME170),rtrim(RME.RME180))) LIKE :boss_name -- 代表者名英字姓、英字名、漢字姓、漢字名";
            $params['boss_name'] = $this->changeLike($search_con['boss_name']);
        }
        //販売店区分：自販売店のみにチェック
        if (VossAccessManager::isJurisdictionAgent() && $search_con['agent_type'] === "own") {
            $where_str .= PHP_EOL . "AND NMIL.NMIL110 = :agent_code -- 販売店コード";
            $params['agent_code'] = $search_con['agent_code'];
        }

        //WHERE句の文字列である$where_strを配列に格納
        $result = [
            'where' => $where_str,
            'params' => $params
        ];
        return $result;
    }

    /**ご連絡内容取得クエリのWHERE句とパラメータを動的に生成します。
     * @param $user_info
     * @return array
     */
    private function getDetailWhere($user_info)
    {
        //WHERE句を検索条件によって動的に作成します
        $params['mail_send_instruction_number'] = $user_info['mail_send_instruction_number'];
        $where_str = "WHERE NMIL.NMIL010 = :mail_send_instruction_number -- メール送信指示No";
        //旅行社コードが定義されていること、かつ旅行社コードが空ではない
        if (isset($user_info['travel_company_code']) && $user_info['travel_company_code'] !== "") {
            $where_str .= PHP_EOL . "AND NMIL.NMIL100 = :travel_company_code -- 旅行社コード";
            $params['travel_company_code'] = $user_info['travel_company_code'];
        }

        //管轄店ではない、かつ販売店コードが定義されていること、かつ販売店コードが空ではない場合は販売店コードの条件を追加
        if (!(VossAccessManager::isJurisdictionAgent()) && isset($user_info['agent_code']) && $user_info['agent_code'] !== "") {
            $where_str .= PHP_EOL . "AND NMIL.NMIL110 = :agent_code -- 販売店コード";
            $params['agent_code'] = $user_info['agent_code'];
        }
        //WHERE句の文字列である$where_strを配列に格納
        $result = [
            'where' => $where_str,
            'params' => $params
        ];
        return $result;
    }

    /**
     * ORDERBY句を検索条件によって動的に作成します
     * @param array $search_con
     * @return string
     */
    private function getOrderBy(array $search_con)
    {
        //ORDERBY句を$order_byに格納
        //ご連絡日時昇順
        if ($search_con['contact_sort'] === "contact_date_asc") {
            $order_by = "ORDER BY NMIL.NMIL060 ASC";
        }
        //ご連絡日時降順
        if ($search_con['contact_sort'] === "contact_date_desc") {
            $order_by = "ORDER BY NMIL.NMIL060 DESC";
        }
        //出発日昇順
        if ($search_con['departure_sort'] === "departure_date_asc") {
            $order_by = "ORDER BY HIN.HIN510 ASC";
        }
        //出発日降順
        if ($search_con['departure_sort'] === "departure_date_desc") {
            $order_by = "ORDER BY HIN.HIN510 DESC";
        }
        return $order_by;
    }
}