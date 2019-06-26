<?php

namespace App\Queries;


class DocumentQuery extends BaseQuery
{

    /**
     * 提出書類の取得のクエリ
     * @param $reservation_number
     * @return array
     */
    public function findDocumentByNumber($reservation_number)
    {

        $sql = <<<EOF
SELECT
  RHD.RHD010 AS reservation_number -- 予約番号
 ,RME.RME020 AS passenger_line_number -- 乗船者行No
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,MPM.MPM010 AS progress_manage_code -- 進行管理コード
 ,MPM.MPM020 AS progress_manage_name -- 進行管理名称
 ,MPM.MPM040 AS net_input_type -- ネット入力区分
 ,MPM.MPM050 AS document_get_type -- 書類入手区分
 ,MPM.MPM060 AS answer_format -- 返信区分
 ,MPM.MPM070 AS upload_possible -- アップロード可
 ,MPM.MPM080 AS document_check_type -- 書類確認区分
 ,RPM.RPM070 AS net_input_date -- ネット入力日
 ,RPM.RPM080 AS document_post_later_date -- 書類後日郵送日
 ,RPM.RPM090 AS upload_date -- アップロード日
 ,RPM.RPM100 AS check_finish_date -- 確認済日
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出し
INNER JOIN
  {$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
  ON
     RME.RME010 = RHD.RHD010 -- 予約番号
  AND
     RME.RME740 = 1 -- 表示区分
LEFT JOIN
  {$this->voss_lib}.VOSRPMP RPM-- 予約進行管理ファイル
  ON
     RPM.RPM010 = RME.RME010 -- 予約番号
  AND
     RPM.RPM020 = RME.RME020 -- 乗船者行No
  AND
     RPM.RPM120 <= 0 -- 削除日時
LEFT JOIN
  {$this->voss_lib}.VOSMPMP MPM -- 進行管理マスタ
  ON
     MPM.MPM130 = 'Y' -- ネット提出書類区分
  AND
     MPM.MPM010 = RPM.RPM040-- 進行管理コード
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
AND
   RHD.RHD340 <> '4' -- ネット制限 FLAG
ORDER BY
  RME.RME090 ASC -- 客室行No.
, RME.RME020 ASC -- 乗船者行No.
, RPM.RPM030 ASC -- 進行管理行No.
EOF;
        $param = [
            'reservation_number' => $reservation_number
        ];
        return $this->all($sql, $param);
    }

    /**
     * 進行管理マスタの取得のクエリ
     * @param $progress_manage_code
     * @return array
     */
    public function findByProgressCode($progress_manage_code)
    {

        $sql = <<<EOF
SELECT
  MPM.MPM010 AS progress_manage_code -- 進行管理コード
 ,MPM.MPM030 AS progress_manage_short_name -- 進行管理略称
 ,MPM.MPM140 AS net_header_print -- ネットヘッダー印字
FROM 
  {$this->voss_lib}.VOSMPMP MPM -- 進行管理マスタ
WHERE
  MPM.MPM010 = :progress_manage_code -- 進行管理コード
EOF;
        $param = [
            'progress_manage_code' => $progress_manage_code
        ];
        return $this->first($sql, $param);
    }

    /**
     * 提出書類ヘッダー印字情報の取得のクエリ
     * @param $reservation_number
     * @param $passenger_line_number
     * @return array
     */
    public function getPrintData($reservation_number, $passenger_line_number)
    {

        $sql = <<<EOF
SELECT
  RHD.RHD160 AS departure_date -- 乗船日
 ,RHD.RHD210 AS arrival_date -- 下船日
 ,HIN.HIN060 AS item_name --商品名
 ,HIN.HIN070 AS item_name2 -- 商品名（2行目）
 ,RME.RME150 AS passenger_last_eij -- 乗船者英字姓
 ,RME.RME160 AS passenger_first_eij -- 乗船者英字名
 ,RME.RME170 AS passenger_last_knj -- 乗船者漢字姓
 ,RME.RME180 AS passenger_first_knj -- 乗船者漢字名
 ,RME.RME210 AS gender -- 性別
 ,RME.RME220 AS birth_date -- 生年月日
 ,RME.RME230 AS age -- 年齢（乗船日基準）
 ,NAG.NAG020 AS travel_company_name--  旅行社名
FROM 
  {$this->voss_lib}.VOSRHDP RHD -- 予約見出しファイル
LEFT JOIN
{$this->voss_lib}.VOSRMEP RME -- 予約明細ファイル
 ON
     RHD.RHD010 = RME.RME010 -- 予約番号
 AND
     RME.RME020 = :passenger_line_number -- 乗船者行No.
LEFT JOIN
{$this->voss_lib}.VOSHINP HIN -- 商品設定ファイル
 ON
     RHD.RHD120 = HIN.HIN010 -- 商品コード
LEFT JOIN
{$this->voss_lib}.VOSNAGP NAG -- 旅行社マスター
 ON
     RHD.RHD230 = NAG.NAG010 -- 旅行社コード
WHERE
  RHD.RHD010 = :reservation_number -- 予約番号
EOF;

        $params = [
            'reservation_number' => $reservation_number,
            'passenger_line_number' => $passenger_line_number
        ];
        return $this->first($sql, $params);
    }
}