<?php

namespace App\Queries;


use App\Libs\Voss\VossCacheManager;

class HolidayQuery extends BaseQuery
{
    /**
     * 祝日を取得します (24時間キャッシュ)
     * @return array
     */
    public function getAll()
    {
        $cache_key = __METHOD__;
        if (VossCacheManager::has($cache_key)) {
            return VossCacheManager::get($cache_key);
        }

        $sql = <<<EOF
SELECT
  HD.HOL001 AS holiday_date -- 日付
 ,HD.HOL002 AS holiday_name -- 名称
FROM 
  CASE400.HOLIDAY HD -- 祝日マスター
ORDER BY
  HD.HOL001 ASC -- 日付
EOF;
        $results = $this->all($sql);
        VossCacheManager::set($cache_key, $results);
        return VossCacheManager::get($cache_key);
    }
}