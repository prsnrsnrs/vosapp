<?php

namespace App\Queries;


class MailQuery extends BaseQuery
{

    /**
     * 送信対象メール情報の取得のクエリ
     * @return array
     */
    public function getSendMails()
    {

        $sql = <<<EOF
SELECT
      NME.NME010 AS send_instruction_number -- 送信指示No.
     ,NME.NME040 AS net_user_number -- ネット利用者No.
     ,NME.NME050 AS travel_company_code -- 旅行社コード
     ,NME.NME060 AS agent_code -- 販売店コード
     ,NME.NME070 AS agent_user_number -- 販売店利用者No.
     ,NME.NME080 AS mail_address1 -- メールアドレス1
     ,NME.NME081 AS mail_address2 -- メールアドレス2
     ,NME.NME082 AS mail_address3 -- メールアドレス3
     ,NME.NME083 AS mail_address4 -- メールアドレス4
     ,NME.NME084 AS mail_address5 -- メールアドレス5
     ,NME.NME085 AS mail_address6 -- メールアドレス6
     ,NME.NME130 AS send_instruction_code -- 送信指示コード
     ,NME.NME200 AS retry_count -- 再試行回数
     ,NME.NME210 AS mail_category -- メール分類
     ,NME.NME220 AS mail_format -- メール形式
     ,NME.NME230 AS reply_date -- 回答期限
     ,NME.NME240 AS item_code -- 商品コード
     ,NME.NME250 AS reservation_number -- 予約番号 
     ,NME.NME260 AS cabin_line_number -- 客室行No
     ,NME.NME270 AS after_cabin_type -- 変更後客室タイプ
     ,NME.NME280 AS after_cabin_number -- 変更後客室番号
     ,NME.NME290 AS request_priority_order -- RQ希望順位
     ,NME.NME295 AS hk_cabin_line_numbers -- ＨＫ客室行No
     ,NME.NME300 AS close_cabin_types -- 手仕舞客室タイプ (複数)
     ,NME.NME330 AS attachment_file_path -- 添付ファイルパス
     ,NME.NME340 AS mail_text_manage_number -- メール本文管理番号
     ,NME.NME410 AS mail_auth_key -- メール認証キー     
     ,NME.NME520 AS support_request_date_time -- サポート要求日時
     ,NMR.NMR030 AS mail_title -- メールタイトル
FROM 
  {$this->voss_lib}.VOSNMEP NME -- メール送信ファイル
LEFT JOIN
  {$this->voss_lib}.VOSNMRP NMR -- メール送信件名マスター
  ON
     NMR.NMR010 = NME130 -- 送信指示区分
WHERE
  NME.NME130 <> '' -- 送信指示区分
AND
   (NME.NME170 = '' OR NME.NME170 = 'R') -- 送信状況
ORDER BY
  NME.NME120 ASC -- 送信指示日時
EOF;
        return $this->all($sql);
    }

    /**
     * 旅行社向けメールヘッダー情報の取得のクエリ
     * @param $travel_company_code
     * @param $agent_code
     * @param $agent_user_number
     * @return array
     */
    public function getAgentMailHeader($travel_company_code, $agent_code, $agent_user_number)
    {

        $sql = <<<EOF
SELECT
  NBU.NBU060 AS user_name -- ユーザー名称
 ,NBR.NBR040 AS agent_name -- 販売店名
 ,NAG.NAG020 AS travel_company_name -- 旅行社名
FROM 
  {$this->voss_lib}.VOSNBUP NBU -- 販売店利用者ファイル
INNER JOIN
  {$this->voss_lib}.VOSNBRP NBR--販売店マスタ
  ON
     NBR.NBR020 = NBU.NBU020 -- 販売店コード
INNER JOIN
  {$this->voss_lib}.VOSNAGP NAG -- 旅行社マスタ
  ON
     NAG.NAG010 = NBU.NBU010 -- 旅行社コード
WHERE
  NBU.NBU010 = :travel_company_code -- 旅行社コード
AND
   NBU.NBU020 = :agent_code -- 販売店コード
AND
   NBU.NBU030 = :agent_user_number -- 販売店利用者No
EOF;
        $params = [
            'travel_company_code' => $travel_company_code,
            'agent_code' => $agent_code,
            'agent_user_number' => $agent_user_number
        ];
        return $this->first($sql, $params);

    }

    /**
     * 商品情報取得のクエリ
     * @param $item_code
     */
    public function getItem($item_code)
    {
        $sql = <<<EOF
SELECT
  HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名（２行目）
 ,HIN.HIN280 AS seating -- シーティング
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,HIN.HIN540 AS item_arrival_date -- 商品到着日
 ,HIN.HIN560 AS stays -- 泊数
 ,HIN.HIN570 AS days -- 日数
 ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
 ,MPN2.MPN030 AS arrival_place_knj -- 漢字名称(到着地)
FROM
  {$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN1 -- 港名マスター
  ON
     MPN1.MPN010 = HIN.HIN500 -- 商品出発地コード
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN2 -- 港名マスター
  ON
     MPN2.MPN010 = HIN.HIN530 -- 商品到着地コード
WHERE
  HIN.HIN010 = :item_code -- 商品コード
EOF;
        $param = [
            'item_code' => $item_code
        ];
        return $this->first($sql, $param);
    }

    /**
     * 予約見出し情報の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function getReservation($reservation_number)
    {

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RHD.RHD110 AS cruise_id -- クルーズID
 ,RHD.RHD120 AS item_code -- 商品コード
 ,RME.RME020 AS passenger_line_number -- 乗船者(代表者)行No
 ,RME.RME150 AS passenger_last_eij -- 乗船者(代表者)英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者(代表者)英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者(代表者)漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者(代表者)漢字名
 ,RME.RME190 AS passenger_last_kana -- 乗船者(代表者)カナ姓
 ,RME.RME200 AS passenger_first_kana -- 乗船者(代表者)カナ名
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
LEFT JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME130 = 'Y' -- 代表者区分 
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->first($sql, $param);
    }


    /**
     * 予約の客室行Noが一致する客室情報を取得するクエリ
     * @param $reservation_number
     * @param $cabin_line_number
     * @return array|string
     */
    public function getReservationCabinByLineNumber($reservation_number, $cabin_line_number)
    {
        $sql = <<<EOF
SELECT
  RME.RME040 AS cabin_type -- 客室タイプ
 ,RME.RME080 AS fare_type -- 料金タイプ
 ,RME.RME100 AS cabin_number -- 客室番号
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
FROM
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
  ON
     RME.RME010 = RHD.RHD010 -- 予約番号
  AND
     RME.RME740 = '1' -- 表示区分
  AND
     RME.RME090 = :cabin_line_number -- 客室行No.
INNER JOIN
  {$this->voss_lib}.VOSPSCP PSC -- スケジュールファイル
  ON
     PSC.PSC140 = RHD.RHD110 -- クルーズＩＤ
LEFT JOIN
  {$this->voss_lib}.VOSGTYP GTY -- パターン別客室タイプファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
  AND
     GTY.GTY030 = RME.RME040 -- 客室タイプ
WHERE
  RME.RME010 = :reservation_number -- 予約番号
EOF;

        $param = [
            'reservation_number' => $reservation_number,
            'cabin_line_number' => $cabin_line_number,
        ];
        // 乗船者行ごとに複数件取得できるが、客室情報を取得するため最初の１件だけ返す
        return $this->first($sql, $param);
    }

    /**
     * 指定されたキャビンタイプのキャビン情報を取得するクエリ
     * @param string $item_code
     * @param array $cabin_types
     * @return array
     */
    public function getCabinsByTypes($item_code, $cabin_types)
    {
        $array = array_fill(0, count($cabin_types), '?');
        $cabin_types_holder = implode(",", $array);

        $sql = <<<EOF
SELECT
  GTY.GTY030 AS cabin_type -- 客室タイプ
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
FROM 
  {$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
INNER JOIN
  {$this->voss_lib}.VOSPSCP PSC -- スケジュールファイル
  ON
     PSC.PSC140 = HIN.HIN020 -- 商品設定ファイル
LEFT JOIN
  {$this->voss_lib}.VOSGTYP GTY-- パターン別客室タイプファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
WHERE
  HIN.HIN010 = ? -- 商品コード
AND 
  GTY.GTY030 IN ({$cabin_types_holder}) -- 客室タイプ
ORDER BY
  GTY.GTY070 ASC -- 順序No.
EOF;
        $params = array_merge([
            $item_code,
        ], $cabin_types);
        return $this->all($sql, $params);
    }

    /**
     * メール認証情報の取得のクエリ
     * @param $mail_auth_key
     * @return array
     */
    public function findByMailAuthKey($mail_auth_key)
    {
        $sql = <<<EOF
SELECT
  NME.NME010 AS mail_send_instruction_number -- 送信指示No.
 ,NME.NME030 AS operation_code -- 操作コード
 ,NME.NME040 AS net_user_number -- ネット利用者No.
 ,NME.NME070 AS agent_user_number -- 販売店利用者No.
 ,NME.NME050 AS travel_company_code -- 旅行社コード
 ,NME.NME060 AS agent_code -- 販売店コード
 ,NME.NME410 AS mail_auth_key -- メール認証キー   
 ,NME.NME420 AS auth_term_date_time -- 認証期限日時
 ,NME.NME430 AS auth_finish_date_time -- 認証完了日時
FROM 
  {$this->voss_lib}.VOSNMEP NME -- メール送信ファイル
WHERE
  NME.NME410 = :mail_auth_key -- メール認証キー
EOF;
        $param = [
            'mail_auth_key' => $mail_auth_key
        ];
        return $this->first($sql, $param);
    }

    /**
     * フリーフォーマットテキスト情報取得のクエリ
     * @return array
     */
    public function getFreeText($mail_text_manage_number)
    {
        $sql = <<<EOF
SELECT
  NMB.NMB010 AS mail_text_manage_number -- メール本文管理番号
 ,NMB.NMB020 AS mail_title -- メールタイトル
 ,NMD.NMD020 AS mail_detail_number -- 明細行No.
 ,NMD.NMD030 AS mail_detail -- 内容
FROM 
  {$this->voss_lib}.VOSNMBP NMB -- メール本文見出ファイル
LEFT JOIN
  {$this->voss_lib}.VOSNMDP NMD -- メール本文明細ファイル
  ON
    NMD.NMD010 = NMB.NMB010
WHERE
  NMB.NMB010 = :mail_text_manage_number -- メール本文管理番号
EOF;
        $param = [
            'mail_text_manage_number' => $mail_text_manage_number
        ];
        return $this->all($sql,$param);
    }
}