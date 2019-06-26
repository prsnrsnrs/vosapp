<?php

namespace App\Queries;


use App\Libs\DateUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossCacheManager;

class ReservationQuery extends BaseQuery
{

    /**
     * クルーズプラン検索対象の出発地情報を取得します。
     * @param $cruises
     * @return array
     */
    public function getDeparturesByCruiseIDs($cruises)
    {
//        $cache_key = __METHOD__;
//        if (VossCacheManager::has($cache_key)) {
//            return VossCacheManager::get($cache_key);
//        }

        $array = array_fill(0, count($cruises), '?');
        $params = implode(",", $array);
        $sql = <<<EOF
SELECT
  MPN.MPN010 AS port_code -- 港名コード
 ,MPN.MPN030 AS port_knj -- 漢字名称
FROM 
  {$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
INNER JOIN
  {$this->voss_lib}.VOSMPNP MPN -- 港名マスター
  ON
     MPN.MPN010 = HIN.HIN500 -- 商品出発地コード
WHERE
  HIN.HIN020 IN ($params)
GROUP BY
  MPN.MPN010 -- 港名コード
 ,MPN.MPN030 -- 漢字名称  
ORDER BY
  COUNT(MPN.MPN010) DESC -- 港名コード
EOF;
        return $this->all($sql, $cruises);
//        VossCacheManager::set($cache_key, $results);
//        return VossCacheManager::get($cache_key);
    }

    /**
     * クルーズ検索情報を取得します。
     * @param $cruises
     * @return array
     */
    public function findByCruiseIDs(array $cruises)
    {
//        $cache_key = __METHOD__;
//        if (VossCacheManager::has($cache_key)) {
//            return VossCacheManager::get($cache_key);
//        }

        $array = array_fill(0, count($cruises), "?");
        $params = implode(",", $array);
        $sql = <<<EOF
SELECT
  PSC.PSC140 AS curise_id -- クルーズID
 ,PSC.PSC160 AS cruise_name -- クルーズ名称
 ,PSC.PSC370 AS start_date -- 日程開始日
 ,PSC.PSC380 AS finish_date -- 日程終了日
FROM 
  {$this->voss_lib}.VOSPSCP PSC -- スケジュールファイル
WHERE
  PSC.PSC140 IN ($params)
ORDER BY
  PSC.PSC370 ASC -- 日程開始日
EOF;
        return $this->all($sql, $cruises);
//        VossCacheManager::set($cache_key, $results);
//        return VossCacheManager::get($cache_key);
    }

    /**
     * 複数商品情報を取得
     * @param array $cruises
     * @return array
     */
    public function findItemByCruiseIDs(array $cruises)
    {
//        $cache_key = __METHOD__;
//        if (VossCacheManager::has($cache_key)) {
//            return VossCacheManager::get($cache_key);
//        }

        $array = array_fill(0, count($cruises), "?");
        $params = implode(",", $array);
        $current_date = DateUtil::nowDateTime();
        $sql = <<<EOF
SELECT
  HIN.HIN010 AS item_code -- 商品コード
 ,HIN.HIN020 AS cruise_id -- クルーズID
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名（２行目）
 ,HIN.HIN500 AS item_departure_place_code -- 商品出発地コード
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,HIN.HIN520 AS item_departure_time -- 商品出発時間
 ,HIN.HIN530 AS item_arrival_place_code -- 商品到着地コード
 ,HIN.HIN540 AS item_arrival_date -- 商品到着日
 ,HIN.HIN550 AS item_arrival_time -- 商品到着時間
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
  HIN.HIN020 IN ($params)
 AND
   HIN.HIN300 = 'Y' -- 承認区分
 AND
   HIN.HIN440 < $current_date -- ネット予約開始日時
 AND
   HIN.HIN450 IN ('Y','1','2','3') -- ネット受付
ORDER BY
  HIN.HIN510 ASC -- 商品出発日
, HIN.HIN520 ASC -- 商品出発時間
EOF;
        return $this->all($sql, $cruises);
//        VossCacheManager::set($cache_key, $results);
//        return VossCacheManager::get($cache_key);
    }


    /**
     * 客室情報の取得のクエリ
     * @param $cruise_id
     * @return array|string
     */
    public function getCabins($cruise_id)
    {

        $sql = <<<EOF
SELECT
  GTY.GTY030 AS cabin_type -- 客室タイプ
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
 ,MITM.MITM040 AS cabin_description -- 説明
 ,MITM.MITM090 AS cabin_image1 -- 客室イメージパス1
FROM 
  {$this->voss_lib}.VOSPSCP PSC-- スケジュールファイル
LEFT JOIN
  {$this->voss_lib}.VOSGTYP GTY-- パターン別客室タイプファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
LEFT JOIN
  {$this->voss_lib}.VOSMITMU MITM-- 商品詳細マスタ
  ON
     MITM.MITM010 = GTY.GTY010 -- 船コード
  AND
     MITM.MITM030 = GTY.GTY030 -- 客室タイプ
WHERE
  PSC.PSC140 = :cruise_id -- クルーズＩＤ
ORDER BY
  GTY.GTY070 ASC -- 順序No.
EOF;
        $params = ['cruise_id' => $cruise_id];
        return $this->all($sql, $params);
    }

    /**
     * 客室詳細情報の取得のクエリ
     * @param $cruise_id
     * @param $cabin_type
     * @return array
     */
    public function getCabin($cruise_id, $cabin_type)
    {

        $sql = <<<EOF
SELECT
  GTY.GTY030 AS cabin_type -- 客室タイプ
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
 ,MITM.MITM040 AS cabin_description -- 説明
 ,MITM.MITM050 AS floar -- フロア
 ,MITM.MITM060 AS area -- 広さ
 ,MITM.MITM070 AS facility -- 設備
 ,MITM.MITM080 AS fixture -- 備品
 ,MITM.MITM090 AS cabin_image1 -- 客室イメージパス1
 ,MITM.MITM100 AS cabin_image2 -- 客室イメージパス2
 ,MITM.MITM110 AS cabin_image3 -- 客室イメージパス3
 ,MITM.MITM120 AS sketch_image1 -- 見取り図イメージパス1
 ,MITM.MITM130 AS sketch_image2 -- 見取り図イメージパス2
FROM 
  {$this->voss_lib}.VOSPSCP PSC-- スケジュールファイル
INNER JOIN
  {$this->voss_lib}.VOSGTYP GTY-- パターン別客室タイプファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
  AND
     GTY.GTY030 = :cabin_type -- 客室タイプ
LEFT JOIN
  {$this->voss_lib}.VOSMITMU MITM-- 商品詳細マスタ
  ON
     MITM.MITM010 = GTY.GTY010 -- 船コード
  AND
     MITM.MITM030 = GTY.GTY030 -- 客室タイプ
WHERE
  PSC.PSC140 = :cruise_id -- クルーズＩＤ
EOF;
        $params = [
            'cruise_id' => $cruise_id,
            'cabin_type' => $cabin_type
        ];
        return $this->first($sql, $params);
    }

    /**
     * 予約見出し情報の取得のクエリ
     * @param $reservation_numbers
     * @return array
     */
    public function getReservationByNumber($reservation_number)
    {
        $sql = <<<EOF
SELECT
  RHD.RHDA40 AS last_update_date_time -- 最終更新日時
 ,RHD.RHD010 AS reservation_number -- 予約番号
 ,RHD.RHD020 AS reservation_type -- 予約区分
 ,RHD.RHD110 AS cruise_id -- クルーズID
 ,RHD.RHD120 AS item_code -- 商品コード
 ,RHD.RHD270 AS seating_request -- シーティングリクエスト
 ,RHD.RHD310 AS state_flag -- 状況FLAG
 ,RHD.RHD410 AS detail_input_flag -- 詳細入力FLAG
 ,RHD.RHD420 AS pay_state_flag -- 精算状況 FLAG
 ,RHD.RHD430 AS submit_document_flag -- 提出書類FLAG
 ,RHD.RHD440 AS ticketing_flag -- 発券可能 FLAG
 ,RHD.RHD450 AS ticket_state_flag -- 発券状況 FLAG
 ,RHD.RHD460 AS contact_mail_count -- 連絡メール数
 ,RHD.RHDA10 AS new_created_date_time -- 新規作成日時
 ,RHD.RHDA70 AS original_reservation_number -- 一次予約元予約番号
 ,RHD.RHD510 AS cancel_date_time -- 取消日時
 ,HIN.HIN040 AS domestic_overseas_cruise_type -- 内外航区分
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名（２行目）
 ,HIN.HIN510 AS item_departure_date -- 商品出発日
 ,HIN.HIN540 AS item_arrival_date -- 商品到着日
 ,HIN.HIN560 AS stays -- 泊数
 ,HIN.HIN570 AS days -- 日数
 ,MPN1.MPN030 AS departure_place_knj -- 漢字名称(出発地)
 ,MPN2.MPN030 AS arrival_place_knj -- 漢字名称(到着地)
 ,RME.RME020 AS passenger_line_number -- 乗船者行No
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,RME.RME310 AS tel1 -- 電話番号１
 ,RME.RME120 AS reservation_status -- ステータス
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
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
LEFT JOIN
  {$this->voss_lib}.VOSMPNP MPN2 -- 港名マスター
  ON
     MPN2.MPN010 = HIN.HIN530 -- 商品到着地コード
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->first($sql, $param);
    }

    /**
     * 商品情報の取得
     * @param string $item_code
     * @return array
     */
    public function findCruiseByItemCode($item_code)
    {
        $sql = <<<EOF
SELECT
  HIN.HIN010 AS item_code -- 商品コード
 ,HIN.HIN020 AS cruise_id -- クルーズID
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名(2行目)
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
        $params = [
            'item_code' => $item_code
        ];
        return $this->first($sql, $params);
    }

    /**
     * クルーズプラン商品情報の取得
     * @param array $item_codes
     * @return array
     */
    public function findCruiseByItemCodes(array $item_codes)
    {
        $array = array_fill(0, count($item_codes), '?');
        $item_codes_holder = implode(",", $array);
        $sql = <<<EOF
SELECT
  HIN.HIN010 AS item_code -- 商品コード
 ,HIN.HIN020 AS cruise_id -- クルーズID
 ,HIN.HIN060 AS item_name -- 商品名
 ,HIN.HIN070 AS item_name2 -- 商品名(2行目)
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
  HIN.HIN010 IN ({$item_codes_holder}) -- 商品コード
EOF;
        return $this->all($sql, $item_codes);
    }

    /**
     * 予約詳細情報の取得のクエリ
     * @param string $reservation_numbers
     * @param bool $needs_cancel_data
     * @return array
     */
    public function findReservationDetailsByNumber($reservation_number, $needs_cancel_data = false)
    {
        // 表示区分の取得条件
        $disp_where = $needs_cancel_data ? 'RME.RME740 <> 0' : 'RME.RME740 = 1';

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RHD.RHD020 AS reservation_type -- 予約区分
 ,RHD.RHD310 AS state_flag -- 状況FLAG
 
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
 ,CASE
    WHEN HTR.HTR060 > 0 THEN '定員2～3名'
    ELSE '定員2名' END AS cabin_capacity -- 定員数
 ,RME.RME090 AS cabin_line_number -- 客室行No.
 ,RME.RME040 AS cabin_type -- 客室タイプ
 ,RME.RME100 AS cabin_number -- 客室番号
 ,RME.RME020 AS passenger_line_number -- 乗船者行No.
 ,RME.RME130 AS boss_type -- 代表者区分
 ,RME.RME060 AS person_type -- 人数区分
 ,RME.RME070 AS age_type -- 大小幼区分
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME210 AS gender -- 性別
 ,RME.RME230 AS age -- 年齢(乗船日時基準)
 ,RME.RME220 AS birth_date -- 生年月日
 ,RME.RME120 AS reservation_status -- ステータス
 ,RME.RME080 AS fare_type -- 料金タイプ
 ,RME.RME700 AS total_travel_charge -- 旅行代金合計
 ,RME.RME710 AS total_discount_charge -- 割引額合計
 ,RME.RME720 AS total_cancel_charge -- 取消料等合計
 ,RME.RME730 AS total_other_charge -- その他代金合計
 ,RME.RME740 AS display_type -- 表示区分
 ,RME.RME750 AS pre_register_passenger_row_number -- 事前登録乗船者行No.
 ,RME.RME790 AS tariff_code -- タリフコード
 ,MTR.MTR030 AS tariff_name -- タリフ名称
 ,MTR.MTR040 AS tariff_short_name  -- タリフ略称
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
  ON
     RME.RME010 = RHD.RHD010 -- 予約番号
  AND
     {$disp_where} -- 表示区分
INNER JOIN
  {$this->voss_lib}.VOSPSCP PSC -- スケジュールファイル
  ON
     PSC.PSC140 = RHD.RHD110 -- クルーズＩＤ
INNER JOIN
  {$this->voss_lib}.VOSGTYP GTY -- パターン別客室タイプファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
  AND
     GTY.GTY030 = RME.RME040 -- 客室タイプ
LEFT JOIN
  {$this->voss_lib}.VOSHTRP HTR -- 商品タリフ設定ファイル
  ON
     RHD.RHD120 = HTR.HTR010 -- 商品コード
  AND
     HTR.HTR040 = 'A' -- 大小幼区分
  AND
     HTR.HTR050 = 'TP' -- 料金タイプ
  AND
     HTR.HTR030 = RME.RME040 -- 客室タイプ
  AND
     HTR.HTR080 = RME.RME790 -- タリフコード
LEFT JOIN
  {$this->voss_lib}.VOSMTRP MTR -- タリフマスタ
  ON
    MTR.MTR010 = RHD.RHD120 -- 商品コード
  AND
    MTR.MTR020 = RME.RME790 -- タリフコード
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
ORDER BY
  RME.RME090 ASC -- 客室行No.
 ,RME.RME020 ASC -- 乗船者行No.
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * 客室数取得のクエリ
     * @param $reservation_number
     * @param bool $needs_cancel_data
     * @return array|string
     */
    public function countCabinsByNumber($reservation_number, $needs_cancel_data = false)
    {
        // 表示区分の取得条件
        $disp_where = $needs_cancel_data ? 'RME.RME740 <> 0' : 'RME.RME740 = 1';

        $sql = <<<EOF
SELECT
  COUNT(RME.RME090) AS cabins_count -- 客室数
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
  ON
     RME.RME010 = RHD.RHD010 -- 予約番号
  AND
     {$disp_where} -- 表示区分
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG

EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->first($sql, $param);
    }

    /**
     * ご乗船者詳細情報の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function getPassengers($reservation_number)
    {

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RME.RME130 AS boss_type -- 代表者区分
 ,RME.RME070 AS age_type -- 大小幼区分
 ,RME.RME020 AS passenger_line_number -- 乗船者行No
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,RME.RME190 AS passenger_last_kana -- 乗船者カナ姓
 ,RME.RME200 AS passenger_first_kana -- 乗船者カナ名
 ,RME.RME210 AS gender -- 性別
 ,RME.RME220 AS birth_date -- 生年月日
 ,RME.RME230 AS age -- 年齢（乗船日時基準）
 ,RME.RME240 AS wedding_anniversary -- 結婚記念日
 ,RME.RME250 AS zip_code -- 郵便番号
 ,RME.RME260 AS prefecture_code -- 都道府県コード
 ,RME.RME280 AS address1 -- 住所１
 ,RME.RME290 AS address2 -- 住所２
 ,RME.RME300 AS address3 -- 住所３
 ,RME.RME310 AS tel1 -- 電話番号１
 ,RME.RME320 AS tel1_type -- 電話番号1区分
 ,RME.RME330 AS tel2 -- 電話番号２
 ,RME.RME340 AS tel2_type -- 電話番号２区分
 ,RME.RME350 AS emergency_contact_name  -- 緊急連絡先氏名
 ,RME.RME360 AS emergency_contact_kana -- 緊急連絡先フリガナ
 ,RME.RME370 AS emergency_contact_tel -- 緊急連絡先電話番号
 ,RME.RME380 AS emergency_contact_tel_type -- 緊急連絡先電話番号区分
 ,RME.RME390 AS emergency_contact_relationship -- 緊急連絡先続柄
 ,RME.RME400 AS country_code -- 国籍コード
 ,RME.RME410 AS residence_code -- 居住国コード
 ,RME.RME420 AS passport_number -- パスポート番号
 ,RME.RME430 AS passport_issued_date -- パスポート発給日
 ,RME.RME440 AS passport_issued_place -- パスポート発給地
 ,RME.RME450 AS passport_lose_date -- パスポート失効日
 ,RME.RME460 AS link_id -- リンクID
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出しファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
    ON
     RHD.RHD010 = RME.RME010 -- 予約番号
    AND
     RME.RME740 = 1 -- 表示区分
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
ORDER BY
  RME.RME090 ASC -- 客室行No.
 , RME.RME020 ASC -- 乗船者行No.
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * 客室タイプリクエストの取得のクエリ
     * @param $cruise_id
     * @return array
     */
    public function getCabinTypeRequests($cruise_id)
    {

        $sql = <<<EOF
SELECT
  GTY.GTY030 AS cabin_type -- 客室タイプ
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
FROM 
  {$this->voss_lib}.VOSPSCP PSC-- スケジュールファイル
INNER JOIN
  {$this->voss_lib}.VOSGTYP GTY-- パターン別客室設定ファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
WHERE
  PSC.PSC140 = :cruise_id -- クルーズＩＤ
  AND
     GTY.GTY170 = 'Y' -- ネット表示FLAG 
ORDER BY
  GTY.GTY070 ASC -- 順序No.
EOF;
        $param = [
            'cruise_id' => $cruise_id
        ];
        return $this->all($sql, $param);
    }

    /**
     * 予約客室リクエスト入力情報の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function getCabinRequests($reservation_number)
    {

        $sql = <<<EOF
SELECT DISTINCT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RME.RME090 AS cabin_line_number -- 客室行No.
 ,GTY.GTY050 AS cabin_type_knj -- 客室タイプ漢字名称
 ,RTR.RTR040 AS cabin_type_request -- 客室タイプＲＱ
 ,RRQ.RRQ040 AS cabin_request_free -- 客室RQフリー欄
FROM 
  {$this->voss_lib}.VOSRHDP RHD-- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSPSCP PSC-- スケジュールファイル
  ON
     PSC.PSC140 = RHD.RHD110 -- クルーズID
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
  ON
     RME.RME010 = RHD.RHD010 -- 予約番号
  AND
     RME.RME740 = 1 -- 表示区分
INNER JOIN
  {$this->voss_lib}.VOSGTYP GTY-- パターン別客室タイプファイル
  ON
     GTY.GTY010 = PSC.PSC020 -- 船コード
  AND
     GTY.GTY020 = PSC.PSC440 -- 客室パターンコード
  AND
     GTY.GTY030 = RME.RME040 -- 客室タイプ
LEFT JOIN
  {$this->voss_lib}.VOSRTRP RTR-- 予約客室タイプリクエスト
  ON
     RHD.RHD010 = RTR.RTR010 -- 予約番号
  AND
     RTR.RTR020 = RME.RME090 -- 客室行No
  AND
     RTR.RTR090 <= 0 -- 処理済日時
  AND
     RTR.RTR035 = '1' -- RQ希望順位
LEFT JOIN
  {$this->voss_lib}.VOSRRQP RRQ-- 予約客室リクエスト
  ON
     RHD.RHD010 = RRQ.RRQ010 -- 予約番号
  AND
     RRQ.RRQ020 = RME.RME090 -- 客室行No
  AND
     RRQ.RRQ110 <= 0 -- 処理済日時
  AND
     RRQ.RRQ035 = '1' -- 希望順位
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
ORDER BY
  RME.RME090 ASC -- 客室行No.
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * 割引情報入力情報の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function getTicketNumber($reservation_number)
    {

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RME.RME090 AS cabin_line_number -- 客室行No.
 ,RME.RME020 AS passenger_line_number -- 乗船者行No.
 ,RME.RME070 AS age_type -- 大小幼区分
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME210 AS gender -- 性別
 ,RME.RME230 AS age -- 年齢(乗船日時基準)
 ,RME.RME220 AS birth_date -- 生年月日
 ,RME.RME710 AS total_discount_charge -- 割引額合計
 ,RME.RME790 AS tariff_code -- タリフコード
 ,RDT.RDT030 AS discount_line_number -- 割引券行No.
 ,RDT.RDT040 AS discount_number -- 割引券番号
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
    ON
     RHD.RHD010 = RME.RME010 -- 予約番号
    AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSRDTP RDT -- 割引券番号ファイル
    ON
     RME.RME010 = RDT.RDT010 -- 予約番号
    AND
     RME.RME020 = RDT.RDT020 -- 乗船者行No.
    AND
     RDT.RDT050 <= 0 -- 削除日時
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)   
ORDER BY
  RME.RME090 ASC -- 客室行No.
, RME.RME020 ASC -- 乗船者行No.
, RDT.RDT030 ASC -- 割引券行No.
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * タリフ情報取得のクエリ
     */
    public function getTariffs($item_code)
    {
        $sql = <<<EOF
SELECT
  MTR.MTR010 AS item_code -- 商品コード
 ,MTR.MTR020 AS tariff_code -- タリフコード
 ,MTR.MTR030 AS tariff_name -- タリフ名称
 ,MTR.MTR040 AS tariff_short_name -- タリフ略称
 ,MTR.MTR050 AS tariff_start_date -- 申込開始日
 ,MTR.MTR060 AS tariff_finish_date -- 申込終了日
 ,MTR.MTR070 AS member_only -- メンバー限定
 ,MTR.MTR080 AS first_shipping_only -- 紹介乗船限定
FROM 
  {$this->voss_lib}.VOSMTRP MTR -- タリフマスター
WHERE
  MTR.MTR010 = :item_code -- 商品コード
ORDER BY
  MTR.MTR020 ASC -- タリフコード
EOF;
        $param = [
            'item_code' => $item_code
        ];
        return $this->all($sql, $param);

    }

    /**
     * 質問項目の取得のクエリ (24時間キャッシュ)(旅行者用)
     * @return array
     */
    public function getQuestions()
    {
        $cache_key = __METHOD__;
        if (VossCacheManager::has($cache_key)) {
            return VossCacheManager::get($cache_key);
        }

        $sql = <<<EOF
SELECT
  MQA.MQA010 AS question_code -- 質問コード
 ,MQA.MQA030 AS question_sentence -- 質問文章
 ,MQA.MQA050 AS delited_flag -- 削除フラグ
 ,MQA.MQA060 AS answer_format -- 回答形式
 ,MQA.MQA080 AS infants_auto_flag -- 乳幼児自動設定フラグ
 ,MQA.MQA090 AS female_answer_flag -- 女性回答フラグ
FROM 
  {$this->voss_lib}.VOSMQAP MQA -- 質問マスター
WHERE
  MQA.MQA070 <> 'Y' -- 削除フラグ
ORDER BY
  MQA.MQA010 ASC -- 質問コード
EOF;
        $results = $this->all($sql);
        VossCacheManager::set($cache_key, $results);
        return VossCacheManager::get($cache_key);
    }

    /**
     * 質問入力情報の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function getQuestionAnswer($reservation_number)
    {

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RME.RME090 AS cabin_line_number -- 客室行No.
 ,RME.RME020 AS passenger_line_number -- 乗船者行No.
 ,RME.RME070 AS age_type -- 大小幼区分
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME210 AS gender -- 性別
 ,RME.RME220 AS birth_date -- 生年月日 
 ,RME.RME230 AS age -- 年齢(乗船日時基準)
 ,RQT.RQT030 AS question_code -- 質問コード
 ,RQT.RQT040 AS answer -- 回答
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME-- 予約明細ファイル
    ON
     RHD.RHD010 = RME.RME010 -- 予約番号
    AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSRQTP RQT -- 予約質問ファイル
    ON
     RME.RME010 = RQT.RQT010 -- 予約番号
    AND
     RME.RME020 = RQT.RQT020 -- 乗船者行No.
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)   
ORDER BY
  RME.RME090 ASC -- 客室行No.
, RME.RME020 ASC -- 乗船者行No.
, RQT.RQT030 ASC -- 質問コード
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * ご乗船者リクエスト入力情報の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function getPassengerRequest($reservation_number)
    {
        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RME.RME020 AS passenger_line_number -- 乗船者行No.
 ,RME.RME090 AS cabin_line_number -- 客室行No.
 ,RHD.RHD270 AS seating_request -- シーティングリクエスト
 ,RME.RME070 AS age_type -- 大小幼区分
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME210 AS gender -- 性別
 ,RME.RME230 AS age -- 年齢(乗船日時基準)
 ,RME.RME220 AS birth_date -- 生年月日
 ,RME.RME580 AS child_meal_type -- 子供食区分
 ,RME.RME590 AS infant_meal_type -- 幼児食区分
 ,RME.RME600 AS anniversary -- 記念日
 ,RME.RME770 AS net_remark -- ネット備考
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
    ON
     RHD.RHD010 = RME.RME010 -- 予約番号
    AND
     RME.RME740 = 1 -- 表示区分
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
ORDER BY
  RME.RME090 ASC -- 客室行No.
, RME.RME020 ASC -- 乗船者行No.
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * アクセス可能な予約番号を返します。
     * @param string $reservation_number
     * @param bool $is_temp_reservation
     * @return array
     */
    public function getAccessibleReservationNumber($reservation_number)
    {
        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number --予約番号
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出ファイル
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)"
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
EOF;
        $params = ['reservation_number' => $reservation_number];

        // 認証情報単位でパラメータセット
        $auth = VossAccessManager::getAuth();
        if (VossAccessManager::isUserSite()) {
            $sql .= "\nAND\n   RHD.RHD350 = :user_number -- ネット利用者№";
            $params['user_number'] = $auth['user_number'];
        } elseif (VossAccessManager::isAgentSite() || VossAccessManager::isAgentTestSite()) {
            $sql .= "\nAND\n   TRIM(RHD.RHD360) = :travel_company_code -- ネット旅行社コード";
            $params['travel_company_code'] = $auth['travel_company_code'];
            if (!VossAccessManager::isJurisdictionAgent()) {
                $sql .= "\nAND\n   TRIM(RHD.RHD370) = :agent_code -- ネット販売店コード";
                $params['agent_code'] = $auth['agent_code'];
            }
        }
        $ret = $this->first($sql, $params);
        return array_get($ret, 'reservation_number', '');
    }

}