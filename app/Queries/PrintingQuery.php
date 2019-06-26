<?php

namespace App\Queries;


use App\Libs\Voss\VossAccessManager;

class PrintingQuery extends BaseQuery
{

    /**
     * 乗船券控えと各種確認書の印刷検索一覧情報の取得のクエリ
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

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number                -- 予約番号
  , RHD.RHD020 AS reservation_type                -- 予約区分
  , RHD.RHD440 AS ticketing_flag                  -- 発券可能FLAG
  , RME.RME020 AS passenger_line_number           -- 乗船者行No
  , RME.RME150 AS passenger_last_eij              -- 乗船者英字姓
  , RME.RME160 AS passenger_first_eij             -- 乗船者英字名
  , RME.RME170 AS passenger_last_knj              -- 乗船者漢字姓
  , RME.RME180 AS passenger_first_knj             -- 乗船者漢字名
  , RME.RME210 AS gender                          -- 性別
  , RME.RME220 AS birth_date                      -- 生年月日
  , RME.RME070 AS age_type                        -- 大小幼区分
  , RME.RME230 AS age                             -- 年齢(乗船日時基準)
  , RME.RME120 AS reservation_status              -- ステータス
  , RME.RME620 AS cancel_date_time                -- 取消日時
FROM
  {$this->voss_lib}.VOSRHDP RHD                   -- 予約見出ファイル
  INNER JOIN {$this->voss_lib}.VOSRMEP RME        -- 予約明細ファイル
    ON RHD.RHD010 = RME.RME010                    -- 予約番号
  INNER JOIN {$this->voss_lib}.VOSHINP HIN        -- 商品設定ファイル
    ON RHD.RHD120 = HIN.HIN010                    -- 商品コード
    {$where} 
ORDER BY
  RHD.RHD010 ASC                                  --予約番号
  , RME.RME020 ASC                                -- 乗船者行No

EOF;
        return $this->all($sql, $params);
    }

    /**
     * 乗船券控え情報の取得のクエリ
     * @param $reservation_numbers
     * @return array|string
     */
    public function getETicket($reservation_numbers)
    {
        $array = array_fill(0, count($reservation_numbers), '?');
        $params = implode(",", $array);
        $sql = <<<EOF
SELECT
  MSP.MSP020 AS ship_name_knj                     -- 漢字名称(船名)
  , HIN.HIN060 AS item_name                       -- 商品名
  , HIN.HIN070 AS item_name2                      -- 商品名(２行目)
  , PSC.PSC150 AS voyage_id                       -- 航海ID
  , RME.RME490 AS boarding_date                   -- 乗船日
  , RME.RME530 AS disembark_date                   -- 下船日
  , HIN.HIN480 AS ticketing_date                  -- 乗船券発行可能日
  , MPN1.MPN030 AS departure_port_knj             -- 漢字略称(乗船港)
  , MPN1.MPN020 AS departure_port_eij             -- 英語名称(乗船港）
  , MPN2.MPN030 AS arrival_place_knj              -- 漢字略称(下船港)
  , MPN2.MPN020 AS arrival_place_eij              -- 英語名称(下船港）
  , GRM.GRM040 AS deck_number                     -- デッキNo
  , MHJ.MHJ300 AS ticket_output_name              -- 乗船券出力名称
  , RHD.RHD110 AS cruise_id                       -- クルーズＩＤ
  , RHD.RHD440 AS ticketing_flag                  -- 発券可能FLAG
  , RME.RME210 AS gender                          -- 性別
  , RME.RME150 AS passenger_last_eij              -- 乗船者英字姓
  , RME.RME160 AS passenger_first_eij             -- 乗船者英字名
  , RME.RME170 AS passenger_last_knj              -- 乗船者漢字姓
  , RME.RME180 AS passenger_first_knj             -- 乗船者漢字名
  , RME.RME020 AS passenger_line_number           -- 乗船者行No.
  , RME.RME100 AS cabin_number                    -- 客室番号
  , RME.RME040 AS cabin_type                      -- 客室タイプ
  , RME.RME570 AS fixed_seating                   -- 確定シーティング
  , RME.RME010 AS reservation_number              -- 予約番号
  , RME.RME610 AS pax_id                          -- PAX ID
  , RME.RME611 AS check_digit                     -- チェックデジット  
  , GTY.GTY050 AS cabin_type_knj                  -- 客室タイプ漢字名称
FROM
  {$this->voss_lib}.VOSRMEP RME                   -- 予約明細ファイル
  INNER JOIN {$this->voss_lib}.VOSRHDP RHD        -- 予約見出ファイル
    ON RHD.RHD010 = RME.RME010　　                  -- 予約番号 
    AND RHD.RHD440 <> 0                           -- 発券可能FLAG   
    
  LEFT JOIN {$this->voss_lib}.VOSPSCP PSC         -- スケジュールファイル
    ON PSC.PSC140 = RHD.RHD110                    -- クルーズＩＤ
  LEFT JOIN {$this->voss_lib}.VOSMSPP MSP         -- 船マスタ
    ON MSP.MSP010 = PSC.PSC020                    -- 船コード
  LEFT JOIN {$this->voss_lib}.VOSHINP HIN         -- 商品設定ファイル
    ON RME.RME055 = HIN.HIN010                    -- 商品コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN1        -- 港名マスター
    ON RME.RME480 = MPN1.MPN010                   -- 乗船地港名コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN2        -- 港名マスター
    ON RME.RME520 = MPN2.MPN010                   -- 下船地港名コード
  LEFT JOIN {$this->voss_lib}.VOSGRMP GRM         -- パターン別客室設定ファイル
    ON GRM.GRM010 = PSC.PSC020                    -- 船コード
    AND GRM.GRM020 = PSC.PSC430                   -- 客室パターン
    AND GRM.GRM030 = RME.RME100                   -- 客室番号
  LEFT JOIN {$this->voss_lib}.VOSMHJP MHJ         -- 法人マスタ
    ON MHJ.MHJ010 = RHD.RHD230                    -- 旅行社コード
  LEFT JOIN {$this->voss_lib}.VOSGTYP GTY         -- パターン別客室ファイル
    ON GTY.GTY010 = PSC.PSC020                    -- 船コード
    AND GTY.GTY020 = PSC.PSC430                   -- 客室パターン
    AND GTY.GTY030 = RME.RME040                   -- 客室タイプ
WHERE
  RME.RME010 IN ($params)                         -- 予約番号
  AND RME.RME620 = 0                              -- 取消日時
  AND RHD.RHD440 = 1                              -- 発券可能FLAG
  
ORDER BY
  HIN.HIN510                                      -- 商品出発日
  , HIN.HIN010 ASC                                -- 商品コード
  , RHD.RHD010 ASC                                -- 予約番号
  , RME.RME090 ASC                                -- 客室行No
  , RME.RME020 ASC                                -- 乗船者行No
  

EOF;
        return $this->all($sql, $reservation_numbers);
    }

    /**
     * 乗船券　食事場所取得
     * @param $reservation_number
     * @param $passenger_line_no
     * @return array|string
     */
    public function getMealLocation($reservation_number, $passenger_line_no)
    {
        $sql = <<<EOF
SELECT
    RML.RML010 AS reservation_number              -- 予約番号
   ,RML.RML020 AS passenger_line_number           -- 乗船者行No
   ,RML.RML050 AS meal_location_breakfast         -- 朝食
FROM
  {$this->voss_lib}.VOSRMLP RML                    -- 予約食事ファイル
WHERE
  RML.RML010 = :reservation_number -- 予約番号
AND
  RML.RML020 = :passenger_line_no -- 乗船者行NO
AND
  RML.RML050 IS NOT NULL
AND
  TRIM(RML.RML050) <> ''
ORDER BY 
  RML.RML030 ASC                                   -- 日付
EOF;
        return $this->first($sql,
            ['reservation_number' => $reservation_number, 'passenger_line_no' => $passenger_line_no]);
    }


    /**
     * 文面印刷情報の取得のクエリ
     * @param $cruise_id
     * @param $sentence_type
     * @return array
     */
    public function getPrintInfos($cruise_id, $sentence_type)
    {
        $sql = <<<EOF
SELECT
  PTD.PTD050                                      -- 内容(文面)
FROM
  {$this->voss_lib}.VOSPTDP PTD                   -- 文面設定ファイル
WHERE
  PTD.PTD010 = :cruise_id                         -- クルーズＩＤ
  AND PTD.PTD020 = :type                          -- 文面コード
  AND PTD.PTD030 = '1'                            -- 文面区分
  AND PTD.PTD050 <> ''                            -- 内容
ORDER BY
  PTD.PTD040 ASC                                  -- 行No
EOF;

        $params = [
            'type' => config('const.sentence.value.' . $sentence_type),
            'cruise_id' => $cruise_id
        ];

        return $this->all($sql, $params);
    }

    /**
     * 乗船者印刷情報の取得のクエリ
     * @param array $reservation_numbers
     * @return array|string
     */
    public function getPassengers(array $reservation_numbers, $cancelFlg = false)
    {
        $array = array_fill(0, count($reservation_numbers), "?");
        $params = implode(",", $array);
        if ($cancelFlg) {
            $where = "AND RME.RME620 > 0 -- 取消日時";
        } else {
            $where = "AND RME.RME620 = 0 -- 取消日時";
        }
        $sql = <<<EOF
SELECT
  PSC.PSC160 AS cruise_name                       -- クルーズ名称
  , PSC.PSC140 AS cruise_id                       -- クルーズID
  , HIN.HIN060 AS item_name                       -- 商品名
  , HIN.HIN070 AS item_name2                      -- 商品名(２行目)
  , HIN.HIN080 AS item_port                       -- 商品略称
  , HIN.HIN510 AS item_departure_date             -- 商品出発日
  , HIN.HIN540 AS item_arrival_date               -- 商品到着日
  , MPN1.MPN030 AS departure_place_knj            -- 漢字名称(出発地)
  , MPN2.MPN030 AS arrival_place_knj              -- 漢字名称(到着地)
  , RHD.RHD010 AS reservation_number              --予約番号
  , RHD.RHD120 AS item_code                       -- 商品コード
  , RME.RMEA10 AS new_created_date_time           -- 新規作成日時
  , RME.RME620 AS cancel_date_time                -- 取消日時
  , RME.RME030 AS group_setting_number            -- グループ設定No
  , RME.RME040 AS cabin_type                      -- 客室タイプ
  , RME.RME100 AS cabin_number                    -- 客室番号
  , RME.RME090 AS cabin_line_number               -- 客室行No
  , RME.RME020 AS passenger_line_number           -- 乗船者行No
  , RME.RME120 AS reservation_status              -- ステータス
  , RME.RME080 AS fare_type                       -- 料金タイプ
  , RME.RME130 AS boss_type                       -- 代表者区分
  , RME.RME170 AS passenger_last_knj              -- 乗船者漢字姓
  , RME.RME180 AS passenger_first_knj             -- 乗船者漢字名
  , RME.RME150 AS passenger_last_eij              -- 乗船者英字姓
  , RME.RME160 AS passenger_first_eij             -- 乗船者英字名
  , RME.RME220 AS birth_date                      -- 生年月日
  , RME.RME230 AS age                             -- 年齢(乗船日時基準)
  , RME.RME210 AS gender                          -- 性別
  , RME.RME070 AS age_type                        -- 大小幼区分
  , RME.RME580 AS child_meal_type                 -- 子供食区分
  , RME.RME590 AS infant_meal_type                -- 幼児食区分
  , RME.RME570 AS fixed_seating                   -- 確定シーティング
  , RME.RME420 AS passport_number                 -- パスポート番号
  , RME.RME430 AS passport_issue                  -- パスポート発効日
  , RME.RME280 AS address1                        -- 住所１
  , RME.RME290 AS address2                        -- 住所２
  , RME.RME300 AS address3                        -- 住所３
  , RME.RME310 AS tel1                            -- 電話番号１
  , RME.RME330 AS tel2                            -- 電話番号２
  , RME.RME760 AS remark                          -- 備考
  , KHD.KHD550 AS venus_club_number               -- びいなす倶楽部会員番号
  , MNT.MNT040 AS country_name_port               -- 国名略称
  , MTR.MTR040 AS tariff_short_name               -- タリフ略称
FROM
  {$this->voss_lib}.VOSRMEP RME                   -- 予約明細ファイル
  INNER JOIN {$this->voss_lib}.VOSRHDP RHD        -- 予約見出ファイル
    ON RME.RME010 = RHD.RHD010                    -- 予約番号
   
  LEFT JOIN {$this->voss_lib}.VOSHINP HIN         -- 商品設定ファイル
    ON RME.RME055 = HIN.HIN010                    -- 商品コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN1        -- 港名マスター
    ON MPN1.MPN010 = HIN.HIN500                   -- 商品出発地コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN2        -- 港名マスター
    ON MPN2.MPN010 = HIN.HIN530                   -- 商品到着地コード
  LEFT JOIN {$this->voss_lib}.VOSPSCP PSC         -- スケジュールファイル
    ON PSC.PSC140 = RHD.RHD110                    -- クルーズＩＤ
  LEFT JOIN {$this->voss_lib}.VOSNAGP NAG         -- 旅行社マスタ
    ON NAG.NAG010 = RHD.RHD360                    -- ネット旅行社コード
  LEFT JOIN {$this->voss_lib}.VOSNBRP NBR         -- 販売店マスタ
    ON NBR.NBR010 = RHD.RHD360                    -- ネット旅行社コード
    AND NBR.NBR020 = RHD.RHD370                   -- ネット販売店コード
  LEFT JOIN {$this->voss_lib}.VOSMNTP MNT         -- 国マスタ
    ON MNT.MNT010 = RME.RME400                    -- 国籍コード
  LEFT JOIN {$this->voss_lib}.VOSKHDP KHD         -- 顧客ファイル
    ON KHD.KHD010 = RME.RME140                    -- 顧客番号
  LEFT JOIN {$this->voss_lib}.VOSMTRP MTR        -- タリフマスター
    ON MTR.MTR020 = RME.RME790                    -- タリフコード
    AND MTR.MTR010 = RHD.RHD120                   -- 商品コード
WHERE
  RME.RME010 IN ($params)                         -- 予約番号
 
  {$where}
ORDER BY
  HIN.HIN510 ASC                                  -- 商品出発日
  , HIN.HIN010 ASC                                -- 商品コード
  , RHD.RHD010 ASC                                -- 予約番号
  , RME.RME090 ASC                                -- 客室行No
  , RME.RME020 ASC                                -- 乗船者行No

EOF;
        return $this->all($sql, $reservation_numbers);
    }

    /**
     * 予約内容確認書の乗船者印刷情報の取得のクエリ
     * @param array $reservation_numbers
     * @return array
     */
    public function getPassengersForDetail(array $reservation_numbers)
    {
        $array = array_fill(0, count($reservation_numbers), "?");
        $params = implode(",", $array);
        $sql = <<<EOF
SELECT
  PSC.PSC160 AS cruise_name                       -- クルーズ名称
  , PSC.PSC140 AS cruise_id                       -- クルーズID
  , HIN.HIN060 AS item_name                       -- 商品名
  , HIN.HIN070 AS item_name2                      -- 商品名(２行目)
  , HIN.HIN080 AS item_port                       -- 商品略称
  , HIN.HIN510 AS item_departure_date             -- 商品出発日
  , HIN.HIN540 AS item_arrival_date               -- 商品到着日
  , MPN1.MPN030 AS departure_place_knj            -- 漢字名称(出発地)
  , MPN2.MPN030 AS arrival_place_knj              -- 漢字名称(到着地)
  , RHD.RHD010 AS reservation_number              --予約番号
  , RHD.RHD120 AS item_code                       -- 商品コード
  , RME.RMEA10 AS new_created_date_time           -- 新規作成日時
  , RME.RME030 AS group_setting_number            -- グループ設定No
  , RME.RME040 AS cabin_type                      -- 客室タイプ
  , RME.RME100 AS cabin_number                    -- 客室番号
  , RME.RME020 AS passenger_line_number           -- 乗船者行No
  , RME.RME120 AS reservation_status              -- ステータス
  , RME.RME080 AS fare_type                       -- 料金タイプ
  , RME.RME130 AS boss_type                       -- 代表者区分
  , RME.RME170 AS passenger_last_knj              -- 乗船者漢字姓
  , RME.RME180 AS passenger_first_knj             -- 乗船者漢字名
  , RME.RME150 AS passenger_last_eij              -- 乗船者英字姓
  , RME.RME160 AS passenger_first_eij             -- 乗船者英字名
  , RME.RME220 AS birth_date                      -- 生年月日
  , RME.RME230 AS age                             -- 年齢(乗船日時基準)
  , RME.RME210 AS gender                          -- 性別
  , RME.RME070 AS age_type                        -- 大小幼区分
  , RME.RME580 AS child_meal_type                 -- 子供食区分
  , RME.RME590 AS infant_meal_type                -- 幼児食区分
  , RME.RME570 AS fixed_seating                   -- 確定シーティング
  , RME.RME420 AS passport_number                 -- パスポート番号
  , RME.RME430 AS passport_issue                  -- パスポート発効日
  , RME.RME250 AS zip_code                        -- 郵便番号
  , RME.RME260 AS prefecture_code                 -- 都道府県コード
  , RME.RME280 AS address1                        -- 住所１
  , RME.RME290 AS address2                        -- 住所２
  , RME.RME300 AS address3                        -- 住所３
  , RME.RME310 AS tel1                            -- 電話番号１
  , RME.RME330 AS tel2                            -- 電話番号２
  , RME.RME760 AS remark                          -- 備考
  , MPM.MPM030 AS progress_manage_short_name      -- 進行管理略称
  , RPM.RPM100 AS check_finish_date               -- 確認済日
  , KHD.KHD550 AS venus_club_number               -- びいなす倶楽部会員番号
  , MNT.MNT040 AS country_name_port               -- 国名略称
  , MPR.MPR020 AS prefecture_name                 -- 都道府県名
  , MTR.MTR040 AS tariff_short_name               -- タリフ略称
FROM
  {$this->voss_lib}.VOSRMEP RME                   -- 予約明細ファイル
  INNER JOIN {$this->voss_lib}.VOSRHDP RHD        -- 予約見出ファイル
    ON RME.RME010 = RHD.RHD010                    -- 予約番号
    AND RHD.RHD340 <> '4'                         -- ネット制限FLAG
  LEFT JOIN {$this->voss_lib}.VOSHINP HIN         -- 商品設定ファイル
    ON RME.RME055 = HIN.HIN010                    -- 商品コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN1        -- 港名マスター
    ON MPN1.MPN010 = HIN.HIN500                   -- 商品出発地コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN2        -- 港名マスター
    ON MPN2.MPN010 = HIN.HIN530                   -- 商品到着地コード
  LEFT JOIN {$this->voss_lib}.VOSPSCP PSC         -- スケジュールファイル
    ON PSC.PSC140 = RHD.RHD110                    -- クルーズＩＤ
  LEFT JOIN {$this->voss_lib}.VOSNAGP NAG         -- 旅行社マスタ
    ON NAG.NAG010 = RHD.RHD360                    -- ネット旅行社コード
  LEFT JOIN {$this->voss_lib}.VOSNBRP NBR         -- 販売店マスタ
    ON NBR.NBR010 = RHD.RHD360                    -- ネット旅行社コード
    AND NBR.NBR020 = RHD.RHD370                   -- ネット販売店コード
  LEFT JOIN {$this->voss_lib}.VOSMNTP MNT         -- 国マスタ
    ON MNT.MNT010 = RME.RME400                    -- 国籍コード
  LEFT JOIN {$this->voss_lib}.VOSRPMP RPM         -- 予約進行管理ファイル
    ON RPM.RPM010 = RME.RME010                    -- 予約番号
    AND RPM.RPM020 = RME.RME020                   -- 乗船者行No
  LEFT JOIN {$this->voss_lib}.VOSMPMP MPM         -- 進行管理マスタ
    ON MPM.MPM010 = RPM.RPM040                    -- 進行管理コード
  LEFT JOIN {$this->voss_lib}.VOSKHDP KHD         -- 顧客ファイル
    ON KHD.KHD010 = RME.RME140                    -- 顧客番号
  LEFT JOIN {$this->voss_lib}.VOSMPRP MPR         -- 都道府県マスター
    ON MPR.MPR010 = RME.RME260                    -- 都道府県コード
  LEFT JOIN {$this->voss_lib}.VOSMTRP MTR        -- タリフマスター
    ON MTR.MTR020 = RME.RME790                    -- タリフコード
    AND MTR.MTR010 = RHD.RHD120                   -- 商品コード
WHERE
  RME.RME010 IN ($params)                         -- 予約番号
  AND RME.RME620 = 0                              -- 取消日時
  AND RME.RME120 = 'HK'                           -- ステータス(HK)
ORDER BY
  HIN.HIN510 ASC                                  -- 商品出発日
  , HIN.HIN010 ASC                                -- 商品コード
  , RHD.RHD010 ASC                                -- 予約番号
  , RME.RME090 ASC                                -- 客室行No
  , RME.RME020 ASC                                -- 乗船者行No

EOF;
        return $this->all($sql, $reservation_numbers);
    }

    /**
     * 商品単位で客室の合計と乗船者の合計を取得するクエリ
     * @param $item_code
     * @param $user_info
     * @return array
     */
    public function getItemCabinCount($item_code, $user_info)
    {
        $params = [];
        // WHERE句
        $where = PHP_EOL . <<<EOF
WHERE  
   RME.RME620 = 0 -- 取消日時
 AND
   RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
 AND 
   RHD.RHD120 = :item_code -- 商品コード"
 AND
   RME.RME120 = 'HK' -- ステータス

EOF;
        if ($user_info['for_aps_flag'] == true) {
            $params['travel_code'] = $user_info['travel_code'];
            $where .= PHP_EOL . " AND RHD.RHD230 = :travel_code -- 旅行社コード" . PHP_EOL;
        } else {
            $where .= PHP_EOL . " AND RHD.RHD360 = :travel_company_code -- ネット旅行社コード" . PHP_EOL;
            $params['travel_company_code'] = $user_info['net_travel_company_code'];
            if (!VossAccessManager::isJurisdictionAgent()) {
                $where .= PHP_EOL . " AND RHD.RHD370 = :agent_code -- 販売店コード" . PHP_EOL;
                $params['agent_code'] = $user_info['agent_code'];
            }
        }

        $params['item_code'] = $item_code;

        $sql = <<<EOF
SELECT
    T1.cabin_type
  , COUNT(T1.cabin_type) AS cabin_count
  , SUM(T1.passenger_count) AS passenger_count
FROM (
    SELECT
        RME.RME040 AS cabin_type                      -- 客室タイプ
      , RME.RME010 AS reservation_number              -- 予約番号
      , RME.RME090 AS cabin_line_number               -- 客室行No
      , COUNT(RME.RME020) AS passenger_count          -- 乗船者行No
      , GTY.GTY070 AS cabin_sort_number               -- 順序No.
    FROM
      {$this->voss_lib}.VOSRHDP RHD                   -- 予約見出しファイル
      LEFT JOIN {$this->voss_lib}.VOSRMEP RME         -- 予約明細ファイル
        ON RME.RME010 = RHD.RHD010                    -- 予約番号
      LEFT JOIN {$this->voss_lib}.VOSPSCP PSC         -- スケジュールファイル
        ON PSC.PSC140 = RHD.RHD110                    -- クルーズＩＤ
      LEFT JOIN {$this->voss_lib}.VOSGTYP GTY 
        ON GTY.GTY010 = PSC.PSC020                    -- 船コード
        AND GTY.GTY020 = PSC.PSC430                   -- 客室パターン
        AND GTY.GTY030 = RME.RME040                   -- 客室タイプ
     {$where}
    Group BY 
      RME.RME010
     ,RME.RME040
     ,RME.RME090
     ,GTY.GTY070
) T1
GROUP BY
  T1.cabin_type
  , T1.cabin_sort_number
ORDER BY
  T1.cabin_sort_number ASC                            -- 順序No.
EOF;

        return $this->all($sql, $params);
    }

    /**
     * クルーズ単位で客室の合計と乗船者の合計を取得するクエリ
     * @param $cruise_id
     * @param $user_info
     * @return array
     */
    public function getCruiseCabinCount($cruise_id, $user_info)
    {
        $params = [];
        // WHERE句
        $where = PHP_EOL . <<<EOF
WHERE   
  RME.RME620 = 0 -- 取消日時 
 AND 
  RHD.RHD110 = :cruise_id -- クルーズＩＤ"
 AND
  RHD.RHD020 IN ('1', '4') -- 予約区分 (一般、キャンセル待ち)
 AND
  RME.RME120 = 'HK' -- ステータス

EOF;
        if ($user_info['for_aps_flag'] == true) {
            $params['travel_code'] = $user_info['travel_code'];
            $where .= PHP_EOL . " AND RHD.RHD230 = :travel_code -- 旅行社コード" . PHP_EOL;
        } else {
            $where .= PHP_EOL . " AND RHD.RHD360 = :travel_company_code -- ネット旅行社コード" . PHP_EOL;
            $params['travel_company_code'] = $user_info['net_travel_company_code'];
            if (!VossAccessManager::isJurisdictionAgent()) {
                $where .= PHP_EOL . " AND RHD.RHD370 = :agent_code -- 販売店コード" . PHP_EOL;
                $params['agent_code'] = $user_info['agent_code'];
            }
        }

        $params['cruise_id'] = $cruise_id;


        $sql = <<<EOF
SELECT
    T1.cabin_type
  , COUNT(T1.cabin_type) AS cabin_count
  , SUM(T1.passenger_count) AS passenger_count
FROM (
    SELECT
        RME.RME040 AS cabin_type                      -- 客室タイプ
      , RME.RME010 AS reservation_number              -- 予約番号
      , RME.RME090 AS cabin_line_number               -- 客室行No
      , COUNT(RME.RME020) AS passenger_count          -- 乗船者行No
      , GTY.GTY070 AS cabin_sort_number               -- 順序No.
    FROM
      {$this->voss_lib}.VOSRHDP RHD                   -- 予約見出しファイル
      LEFT JOIN {$this->voss_lib}.VOSRMEP RME         -- 予約明細ファイル
        ON RME.RME010 = RHD.RHD010                    -- 予約番号
      LEFT JOIN {$this->voss_lib}.VOSPSCP PSC         -- スケジュールファイル
        ON PSC.PSC140 = RHD.RHD110                    -- クルーズＩＤ
      LEFT JOIN {$this->voss_lib}.VOSGTYP GTY 
        ON GTY.GTY010 = PSC.PSC020                    -- 船コード
        AND GTY.GTY020 = PSC.PSC430                   -- 客室パターン
        AND GTY.GTY030 = RME.RME040                   -- 客室タイプ
     {$where} 
    Group BY 
      RME.RME010
     ,RME.RME040
     ,RME.RME090
     ,GTY.GTY070
) T1
GROUP BY
    T1.cabin_type
  , T1.cabin_sort_number
ORDER BY
  T1.cabin_sort_number ASC                             -- 順序No.
EOF;
        return $this->all($sql, $params);
    }

    /**
     * 商品ごとのタリフ数を取得するクエリ
     * @param $item_codes
     * @return array
     */
    public function getTariffByItemCodes(array $item_codes)
    {

        $array = array_fill(0, count($item_codes), "?");
        $params = implode(",", $array);

        $sql = <<<EOF
SELECT
  MTR.MTR010 AS item_code -- 商品コード
 ,COUNT(MTR.MTR010) AS tariff_number -- タリフ数
FROM 
  {$this->voss_lib}.VOSMTRP MTR -- タリフマスター
WHERE
  MTR.MTR010 IN ($params)   -- 商品コード
GROUP BY 
  MTR.MTR010
EOF;
        return $this->all($sql, $item_codes);
    }

    /**
     * CSV出力情報の取得
     * @param array $reservation_numbers
     * @return array
     */
    public function getPassengersForCsv(array $reservation_numbers)
    {
        $array = array_fill(0, count($reservation_numbers), "?");
        $params = implode(",", $array);
        $sql = <<<EOF
SELECT
  PSC.PSC160 AS cruise_name                       -- クルーズ名称
  , PSC.PSC140 AS cruise_id                       -- クルーズID
  , HIN.HIN060 AS item_name                       -- 商品名
  , HIN.HIN070 AS item_name2                      -- 商品名(２行目)
  , HIN.HIN080 AS item_port                       -- 商品略称
  , HIN.HIN510 AS item_departure_date             -- 商品出発日
  , HIN.HIN540 AS item_arrival_date               -- 商品到着日
  , MPN1.MPN030 AS departure_place_knj            -- 漢字名称(出発地)
  , MPN2.MPN030 AS arrival_place_knj              -- 漢字名称(到着地)
  , RHD.RHD010 AS reservation_number              -- 予約番号
  , RHD.RHD120 AS item_code                       -- 商品コード
  , RME.RMEA10 AS new_created_date_time           -- 新規作成日時
  , RME.RME030 AS group_setting_number            -- グループ設定No
  , RME.RME040 AS cabin_type                      -- 客室タイプ
  , RME.RME100 AS cabin_number                    -- 客室番号
  , RME.RME020 AS passenger_line_number           -- 乗船者行No
  , RME.RME120 AS reservation_status              -- ステータス
  , RME.RME080 AS fare_type                       -- 料金タイプ
  , RME.RME130 AS boss_type                       -- 代表者区分
  , RME.RME170 AS passenger_last_knj              -- 乗船者漢字姓
  , RME.RME180 AS passenger_first_knj             -- 乗船者漢字名
  , RME.RME150 AS passenger_last_eij              -- 乗船者英字姓
  , RME.RME160 AS passenger_first_eij             -- 乗船者英字名
  , RME.RME220 AS birth_date                      -- 生年月日
  , RME.RME230 AS age                             -- 年齢(乗船日時基準)
  , RME.RME210 AS gender                          -- 性別
  , RME.RME070 AS age_type                        -- 大小幼区分
  , RME.RME580 AS child_meal_type                 -- 子供食区分
  , RME.RME590 AS infant_meal_type                -- 幼児食区分
  , RME.RME570 AS fixed_seating                   -- 確定シーティング
  , RME.RME420 AS passport_number                 -- パスポート番号
  , RME.RME430 AS passport_issue                  -- パスポート発効日
  , RME.RME240 AS wedding_anniversary             -- 結婚記念日
  , RME.RME250 AS zip_code                        -- 郵便番号
  , RME.RME260 AS prefecture_code                 -- 都道府県コード
  , RME.RME280 AS address1                        -- 住所１
  , RME.RME290 AS address2                        -- 住所２
  , RME.RME300 AS address3                        -- 住所３
  , RME.RME310 AS tel1                            -- 電話番号１
  , RME.RME330 AS tel2                            -- 電話番号２
  , RME.RME760 AS remark                          -- 備考
  , MPM.MPM010 AS progress_manage_code            -- 進行管理コード
  , MPM.MPM030 AS progress_manage_short_name      -- 進行管理略称
  , RPM.RPM100 AS check_finish_date               -- 確認済日
  , KHD.KHD550 AS venus_club_number               -- びいなす倶楽部会員番号
  , MNT.MNT040 AS country_name_port               -- 国名略称
  , MPR.MPR020 AS prefecture_name                 -- 都道府県名
  , MTR.MTR040 AS tariff_short_name               -- タリフ略称
  , RDT.RDT030 AS discount_line_number            -- 割引券行No
  , RDT.RDT040 AS discount_number                 -- 割引券番号
FROM
  {$this->voss_lib}.VOSRMEP RME                   -- 予約明細ファイル
  INNER JOIN {$this->voss_lib}.VOSRHDP RHD        -- 予約見出ファイル
    ON RME.RME010 = RHD.RHD010                    -- 予約番号
    AND RHD.RHD340 <> '4'                         -- ネット制限FLAG
  LEFT JOIN {$this->voss_lib}.VOSHINP HIN         -- 商品設定ファイル
    ON RME.RME055 = HIN.HIN010                    -- 商品コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN1        -- 港名マスター
    ON MPN1.MPN010 = HIN.HIN500                   -- 商品出発地コード
  LEFT JOIN {$this->voss_lib}.VOSMPNP MPN2        -- 港名マスター
    ON MPN2.MPN010 = HIN.HIN530                   -- 商品到着地コード
  LEFT JOIN {$this->voss_lib}.VOSPSCP PSC         -- スケジュールファイル
    ON PSC.PSC140 = RHD.RHD110                    -- クルーズＩＤ
  LEFT JOIN {$this->voss_lib}.VOSNAGP NAG         -- 旅行社マスタ
    ON NAG.NAG010 = RHD.RHD360                    -- ネット旅行社コード
  LEFT JOIN {$this->voss_lib}.VOSNBRP NBR         -- 販売店マスタ
    ON NBR.NBR010 = RHD.RHD360                    -- ネット旅行社コード
    AND NBR.NBR020 = RHD.RHD370                   -- ネット販売店コード
  LEFT JOIN {$this->voss_lib}.VOSMNTP MNT         -- 国マスタ
    ON MNT.MNT010 = RME.RME400                    -- 国籍コード
  LEFT JOIN {$this->voss_lib}.VOSRPMP RPM         -- 予約進行管理ファイル
    ON RPM.RPM010 = RME.RME010                    -- 予約番号
    AND RPM.RPM020 = RME.RME020                   -- 乗船者行No
  LEFT JOIN {$this->voss_lib}.VOSMPMP MPM         -- 進行管理マスタ
    ON MPM.MPM010 = RPM.RPM040                    -- 進行管理コード
  LEFT JOIN {$this->voss_lib}.VOSKHDP KHD         -- 顧客ファイル
    ON KHD.KHD010 = RME.RME140                    -- 顧客番号
  LEFT JOIN {$this->voss_lib}.VOSMPRP MPR         -- 都道府県マスター
    ON MPR.MPR010 = RME.RME260                    -- 都道府県コード
  LEFT JOIN {$this->voss_lib}.VOSMTRP MTR         -- タリフマスター
    ON MTR.MTR020 = RME.RME790                    -- タリフコード
    AND MTR.MTR010 = RHD.RHD120                   -- 商品コード
  LEFT JOIN {$this->voss_lib}.VOSRDTP RDT         -- 予約割引券ファイル
    ON RDT.RDT010 = RHD.RHD010                    -- 予約番号
    AND RDT.RDT020 = RME.RME020                   -- 乗船者行No
WHERE
  RME.RME010 IN ($params)                         -- 予約番号
  AND RME.RME620 = 0                              -- 取消日時
ORDER BY
  RHD.RHD010 ASC                                -- 予約番号
  , RME.RME090 ASC                                -- 客室行No
  , RME.RME020 ASC                                -- 乗船者行No
  , RDT.RDT030 ASC                                -- 割引券番号
EOF;
        return $this->all($sql, $reservation_numbers);

    }

    /**
     * 割引券番号の取得のクエリ
     * @param array $reservation_numbers
     * @return array
     */
    public function getTicketNumberByReservationNumbers(array $reservation_numbers)
    {
        $array = array_fill(0, count($reservation_numbers), "?");
        $params = implode(",", $array);
        $sql = <<<EOF
SELECT
  RDT.RDT010 AS reservation_number -- 予約番号
 ,RDT.RDT020 AS passenger_line_number -- 乗船者行No.
 ,RDT.RDT030 AS discount_line_number -- 割引券行No.
 ,RDT.RDT040 AS discount_number -- 割引券番号
FROM 
  {$this->voss_lib}.VOSRDTP RDT -- 割引券番号ファイル
WHERE
  RDT.RDT010 IN ($params)       -- 予約番号
ORDER BY
  RDT.RDT010 ASC -- 予約番号
, RDT.RDT020 ASC -- 乗船者行No.
, RDT.RDT030 ASC -- 割引券行No.
EOF;
        return $this->all($sql, $reservation_numbers);
    }

    /**
     * 検索条件を動的に生成します
     * @param array $search_con
     * @return array
     */
    private function getWhere(array $search_con)
    {
        //WHERE句を検索条件によって動的に作成します
        $params = [];
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

        //商品コードが空ではない
        if (!empty($search_con['item_code'])) {
            $where_str .= PHP_EOL . "AND RHD.RHD120 = :item_code -- 商品コード";
            $params['item_code'] = $search_con['item_code'];
        }

        // 商品出発日fromが空でない
        if (!empty($search_con['departure_date_from'])) {
            $where_str .= PHP_EOL . "AND HIN.HIN510 >= :departure_date_from -- 商品出発日";
            $params['departure_date_from'] = $search_con['departure_date_from'];
        }
        // 商品出発日toが空でない
        if (!empty($search_con['departure_date_to'])) {
            $where_str .= PHP_EOL . "AND HIN.HIN510 <= :departure_date_to -- 商品出発日";
            $params['departure_date_to'] = $search_con['departure_date_to'];
        }
        // クルーズIDが空ではない
        if (!empty($search_con['cruise_name'])) {
            $where_str .= PHP_EOL . "AND RHD.RHD110 = :cruise_name -- クルーズID";
            $params['cruise_name'] = $search_con['cruise_name'];
        }
        // 予約番号が空ではない
        if (!empty($search_con['reservation_number'])) {
            $where_str .= PHP_EOL . "AND RHD.RHD010 = :reservation_number -- 予約番号";
            $params['reservation_number'] = (int)$search_con['reservation_number'];
        }
        // 乗船者名が空でない
        if (!empty($search_con['passenger_name'])) {
            $search_con['passenger_name'] = preg_replace("/( |　)/", "", $search_con['passenger_name']);
            $where_str .= PHP_EOL . "AND CONCAT(CONCAT(rtrim(RME.RME150),rtrim(RME.RME160)), CONCAT(rtrim(RME.RME170),rtrim(RME.RME180))) LIKE :passenger_name -- 乗船者名英字姓、英字名、漢字姓、漢字名";
            $params['passenger_name'] = $this->changeLike($search_con['passenger_name']);
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