<?php

namespace App\Queries;

/**
 * ネット利用者情報のクエリクラスです。
 * Class UserQuery
 * @package App\Queries
 */
class UserQuery extends BaseQuery
{
    /**
     * ネット利用者情報の取得のクエリ
     * @param $net_user_number
     * @return array
     */
    public function find($net_user_number)
    {
        $sql = <<<EOF
SELECT
  NCU.NCU010 AS net_user_number -- ネット利用者No.
 ,NCU.NCU100 AS tel1 -- 電話番号１
 ,NCU.NCU120 AS tel2 -- 電話番号２
FROM 
  {$this->voss_lib}.VOSNCUP NCU -- ネット利用者ファイル
WHERE
  NCU.NCU010 = :net_user_number -- ネット利用者No.
 AND
   NCU.NCU190 <= 0 -- 削除日時
EOF;
        $param = [
            'net_user_number' => $net_user_number
        ];
        return $this->all($sql, $param);
    }
}