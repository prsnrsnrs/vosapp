<?php

namespace App\Queries;


class AgentQuery extends BaseQuery
{
    /**
     * 販売店一覧情報の取得のクエリ
     * @param array $search_con
     * @return array
     */
    public function findAll(array $search_con)
    {
        //WHERE句生成
        $result = $this->getWhere($search_con);
        $where = $result['where'];
        //WHERE句の要素を削除し、パラメータのみの配列を$paramsに格納
        unset($result['where']);
        $params = $result;

        //ページ番号設定
        $params['page_start'] = $search_con['page'] * 10 - 9;
        $params['page_end'] = $search_con['page'] * 10;

        $sql = <<<EOF
       
SELECT
SUB.*
FROM(
SELECT 
  NBR.NBR020 AS agent_code -- 販売店コード
 ,NBR.NBR040 AS agent_name -- 販売店名
 ,NBR.NBR100 AS tel -- 電話番号
 ,NBR.NBR180 AS agent_type -- 販売店区分
 ,NBR.NBR190 AS login_type -- ログイン区分
 ,NBR.NBR030 AS agent_login_id-- 販売店ログインID
 ,NBR.NBRA40 AS last_update_date_time -- 最終更新日時
,(SELECT count(NBU.NBU070) 
 FROM {$this->voss_lib}.VOSNBUP NBU -- 販売店利用者ファイル
 WHERE  NBR.NBR010 = NBU.NBU010 -- 旅行社コード
 AND NBR.NBR020 = NBU.NBU020 -- 販売店コード
 AND NBU.NBU190 <= 0 --削除日時
 )AS number_of_user --ユーザー数
 ,ROW_NUMBER() OVER(ORDER BY NBR.NBR180 DESC, NBR.NBR190 ASC, NBR.NBR200 DESC) AS rn
FROM 
  {$this->voss_lib}.VOSNBRP NBR -- 販売店マスター

{$where}

) AS SUB
WHERE 
SUB.rn BETWEEN :page_start AND :page_end


EOF;
        return $this->all($sql, $params);
    }

    /**
     * 販売店一覧全件取得のクエリ
     * @param array $search_con
     * @return array|string
     */
    public function countAll(array $search_con)
    {
        //WHERE句生成
        $result = $this->getWhere($search_con);
        $where = $result['where'];
        //WHERE句の要素を削除し、パラメータのみの配列を$paramsに格納
        unset($result['where']);
        $params = $result;
        $sql = <<<EOF
SELECT 
  COUNT(NBR.NBR020) AS agent_count-- 販売店コード
FROM 
   {$this->voss_lib}.VOSNBRP NBR -- 販売店マスター

{$where}

AND
  NBR.NBR280 <= 0 --削除日時

EOF;
        return $this->first($sql, $params);
    }

    /**
     * 販売一覧情報取得用のWHERE句生成
     * @param array $search_con
     * @return array
     */
    private function getWhere(array $search_con)
    {
        $and_where = "";
        $params = [];

        //旅行社コードwhere句にセット
        $params['travel_company_code'] = $search_con['net_travel_company_code'];
        $and_where .= "WHERE NBR.NBR010 = :travel_company_code -- 旅行社コード ";
        //削除日時をwhere句にセット
        $and_where .= PHP_EOL . "AND NBR.NBR280 <= 0 --削除日時";

        $and_where .= PHP_EOL . "AND NBR.NBR020 <> '@JCLDRT'";

        //販売店名が空でない
        if ($search_con['agent_name'] !== "") {
            $search_con['agent_name'] = preg_replace("/( |　)/", "", $search_con['agent_name']);
            $and_where .= PHP_EOL . "AND NBR.NBR040 LIKE :agent_name -- 販売店名";
            $params['agent_name'] = $this->changeLike($search_con['agent_name']);
        }

        //販売店区分のチェックボックス
        if ($search_con['agent_jurisdiction'] === '1' && $search_con['agent_general'] == "") {
            //管轄：1　一般：空
            $and_where .= PHP_EOL . " AND NBR.NBR180 = :agent_type -- 販売店区分";
            $params['agent_type'] = $search_con['agent_jurisdiction'];
        } elseif (empty($search_con['agent_jurisdiction']) && $search_con['agent_general'] === '0') {
            //管轄：空　一般：0
            $and_where .= PHP_EOL . " AND NBR.NBR180 = :agent_type -- 販売店区分";
            $params['agent_type'] = $search_con['agent_general'];

        }
        $where = [
            'where' => $and_where
        ];

        //パラメータとWHERE句の配列をマージし、return
        $result = array_merge($params, $where);
        return $result;

    }

    /**
     * 一次インポート結果の取得のクエリ
     * @param $import_management_number
     * @return array
     */
    public function getImportResults($import_management_number)
    {

        $sql = <<<EOF
SELECT
  NBW.NBW010 AS import_management_number -- 一次 ｲﾝﾎﾟｰﾄ 管理№
 ,NBW.NBW020 AS first_import_line_number -- 一次インポート行No.
 ,NBW.NBW030 AS agent_code -- 販売店コード
 ,NBW.NBW040 AS agent_name -- 販売店名
 ,NBW.NBW050 AS zip_code -- 郵便番号
 ,NBW.NBW060 AS prefecture_code-- 都道府県コード
 ,NBW.NBW070 AS address1-- 住所１
 ,NBW.NBW080 AS address2 -- 住所２
 ,NBW.NBW090 AS address3 -- 住所３
 ,NBW.NBW100 AS tel -- 電話番号
 ,NBW.NBW110 AS fax_number -- FAX番号
 ,NBW.NBW120 AS mail_address1 -- メールアドレス１
 ,NBW.NBW130 AS mail_address2 -- メールアドレス２
 ,NBW.NBW140 AS mail_address3 -- メールアドレス３
 ,NBW.NBW150 AS mail_address4 -- メールアドレス４
 ,NBW.NBW160 AS mail_address5 -- メールアドレス５
 ,NBW.NBW170 AS mail_address6 -- メールアドレス６
 ,NBW.NBW180 AS agent_code -- 販売店区分
 ,NBW.NBW190 AS login_type -- ログイン区分
 ,NBW.NBW200 AS user_id -- ユーザーID
 ,NBW.NBW240 AS password -- パスワード
 ,NBW.NBW250 AS error_message -- エラーメッセージ
 
FROM 
  {$this->voss_lib}.VOSNBWP NBW -- 販売店一次インポートファイル
WHERE
  NBW.NBW010 = :import_management_number -- 一次 ｲﾝﾎﾟｰﾄ 管理№
ORDER BY
  NBW.NBW020 ASC -- 一次インポート行No.
EOF;
        $param = [
            'import_management_number' => $import_management_number
        ];
        return $this->all($sql, $param);
    }

    /**
     *販売店ユーザー数の取得のクエリ
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function countUserType($travel_company_code, $agent_code)
    {
        $sql = <<<EOF
SELECT
  count(NBU.NBU070) AS record_count --レコード数
 ,NBU.NBU070 AS user_type -- ユーザー区分
FROM 
  {$this->voss_lib}.VOSNBUP NBU -- ネット販売店利用者ファイル
WHERE
  NBU.NBU010 = :travel_company_code -- 旅行社コード
 AND
   NBU.NBU020 = :agent_code -- 販売店コード
 AND
   NBU.NBU190 <= 0 -- 削除日時
GROUP BY
 NBU.NBU070 -- ユーザー区分
ORDER BY
  NBU.NBU070 DESC -- ユーザー区分
EOF;
        $param = [
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code
        ];
        return $this->all($sql, $param);
    }

    /**
     *販売店ユーザー情報の取得のクエリ
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function getUsers($travel_company_code, $agent_code)
    {

        $sql = <<<EOF
SELECT
  NBU.NBU010 AS travel_company_code -- 旅行社コード
 ,NBU.NBU020 AS agent_code -- 販売店コード
 ,NBU.NBU030 AS agent_user_number -- 販売店利用者No.
 ,NBU.NBU050 AS user_id -- ユーザーID
 ,NBU.NBU060 AS user_name -- ユーザー名称
 ,NBU.NBU070 AS user_type -- ユーザー区分
 ,NBU.NBU080 AS login_type -- ログイン区分
 ,NBU.NBU100 AS last_login_date_time -- 最終ログイン日時
 ,NBU.NBUA10 AS new_register_date_time -- 新規作成日時
 ,NBU.NBUA40 AS last_update_date_time -- 最終更新日時
FROM 
  {$this->voss_lib}.VOSNBUP NBU -- ネット販売店利用者ファイル
WHERE
  NBU.NBU010 = :travel_company_code -- 旅行社コード
 AND
   NBU.NBU020 = :agent_code -- 販売店コード
 AND
   NBU.NBU190 <= 0 -- 削除日時
ORDER BY
  NBU.NBU070 DESC -- ユーザー区分
 , NBU.NBU060 ASC -- ユーザー名称
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code
        ];
        return $this->all($sql, $params);
    }

    /**
     * 販売店ユーザー情報の取得のクエリ
     * @param $travel_company_code
     * @param $agent_code
     * @param $store_user_number
     * @return array
     */
    public function getUser($travel_company_code, $agent_code, $store_user_number)
    {

        $sql = <<<EOF
SELECT
  NBU.NBU050 AS user_id -- ユーザーID
 ,NBU.NBU060 AS user_name -- ユーザー名称
 ,NBU.NBU070 AS user_type -- ユーザー区分
 ,NBU.NBU080 AS login_type -- ログイン区分
 ,NBU.NBU100 AS last_login_date_time -- 最終ログイン日時
 ,NBU.NBUA10 AS new_register_date_time -- 新規登録日時
 ,NBU.NBUA40 AS last_update_date_time-- 最終更新日時
FROM 
  {$this->voss_lib}.VOSNBUP NBU -- ネット販売店利用者ファイル
WHERE
  NBU.NBU010 = :travel_company_code -- 旅行社コード
 AND
   NBU.NBU020 = :agent_code -- 販売店コード
 AND
   NBU.NBU030 = :store_user_number -- 販売店利用者No.
 AND
   NBU.NBU190 <= 0 -- 削除日時
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code,
            'store_user_number' => $store_user_number
        ];
        return $this->all($sql, $params);
    }

    /**
     * 販売店情報の取得のクエリ
     * @param $travel_company_code
     * @param $agent_code
     * @return array
     */
    public function getAgentData($travel_company_code, $agent_code)
    {
        $sql = <<<EOF
SELECT
  NBR.NBR020 AS agent_code -- 販売店コード
 ,NBR.NBR040 AS agent_name -- 販売店名
 ,NBR.NBR050 AS zip_code -- 郵便番号
 ,NBR.NBR060 AS prefecture_code -- 都道府県コード
 ,NBR.NBR070 AS address1 -- 住所1
 ,NBR.NBR080 AS address2 -- 住所2
 ,NBR.NBR090 AS address3 -- 住所3
 ,NBR.NBR100 AS tel-- 電話番号
 ,NBR.NBR110 AS fax_number -- FAX番号
 ,NBR.NBR120 AS mail_address1 -- メールアドレス1
 ,NBR.NBR130 AS mail_address2 -- メールアドレス2
 ,NBR.NBR140 AS mail_address3 -- メールアドレス3
 ,NBR.NBR150 AS mail_address4 -- メールアドレス4
 ,NBR.NBR160 AS mail_address5 -- メールアドレス5
 ,NBR.NBR170 AS mail_address6 -- メールアドレス6
 ,NBR.NBR180 AS agent_type -- 販売店区分
 ,NBR.NBR190 AS login_type -- ログイン区分
 ,NBR.NBR030 AS agent_login_id -- 販売店ログインID
 ,NBR.NBRA40 AS last_update_date_time -- 最終更新日時
 ,MPR.MPR020 AS prefecture_name -- 都道府県名
FROM 
  {$this->voss_lib}.VOSNBRP NBR -- 販売店マスター
INNER JOIN
 {$this->voss_lib}.VOSMPRP MPR -- 都道府県マスター
    ON
     MPR.MPR010 = NBR.NBR060 -- 都道府県コード
WHERE
  NBR.NBR010 = :travel_company_code -- 旅行社コード
 AND
   NBR.NBR020 = :agent_code -- 販売店コード
 AND
   NBR.NBR280 <= 0 -- 削除日時
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code
        ];
        return $this->first($sql, $params);
    }
}