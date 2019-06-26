<?php

namespace App\Queries;


class CorporateQuery extends BaseQuery
{

    /**
     * 販売店名取得のクエリ
     * @param $travel_code
     * @return array
     */
    public function getName($travel_code)
    {
        $sql = <<<EOF
SELECT
  MHJ.MHJ040 AS  company_name                                     -- 法人名日本語
 ,MHJ.MHJ070 AS office_name                                       -- 営業所名日本語
  
FROM
  {$this->voss_lib}.VOSMHJP MHJ                                   -- 法人マスタ
WHERE
 MHJ.MHJ010 = :travel_code                                       -- 販売店コード

EOF;
        $param = [
            'travel_code' => $travel_code
        ];
        return $this->first($sql, $param);
    }
}