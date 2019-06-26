<?php

namespace App\Queries;

/**
 * 事前名簿登録関係のクエリクラスです。
 * Class RosterQuery
 * @package App\Queries
 */
class RosterQuery extends BaseQuery
{

    /**
     * 事前登録乗船者情報の取得のクエリ
     * @param $net_user_number
     * @return array
     */
    public function findAll($net_user_number)
    {
        $sql = <<<EOF
SELECT
  NJB.NJB020 AS pre_register_passenger_row_number -- 事前登録乗船者行No.
 ,NJB.NJB030 AS passenger_last_eij -- 英字姓
 ,NJB.NJB040 AS passenger_first_eij -- 英字名
 ,NJB.NJB070 AS passenger_last_kana -- カナ性
 ,NJB.NJB080 AS passenger_first_kana -- カナ名
 ,NJB.NJB090 AS gender -- 性別
 ,NJB.NJB100 AS birth_date -- 生年月日
 ,NJB.NJB180 AS tel1 -- 電話番号１
 ,NJB.NJB330 AS link_id -- リンクID
FROM 
  {$this->voss_lib}.VOSNBJP NBJ -- 事前登録乗船者ファイル
WHERE
  NBJ.NBJ010 = :net_user_number -- ネット利用者No.
ORDER BY
  NBJ.NBJ020 ASC -- 事前登録乗船者行No.
EOF;
        $param = [
            'net_user_number' => $net_user_number
        ];
        return $this->all($sql, $param);
    }
}