<?php

namespace App\Queries;


use App\Libs\Voss\VossCacheManager;

class AnniversaryQuery extends BaseQuery
{

    /**
     * 記念日情報の取得のクエリ (24時間キャッシュ)
     * @return array
     */
    public function getAnniversary()
    {
        $cache_key = __METHOD__;
        if (VossCacheManager::has($cache_key)) {
            return VossCacheManager::get($cache_key);
        }

        $sql = <<<EOF
SELECT
  MAV.MAV010 AS anniversary_type -- 記念日区分
 ,MAV.MAV020 AS anniversary -- 記念日
FROM 
  {$this->voss_lib}.VOSMAVP MAV -- 記念日マスター
ORDER BY
  MAV.MAV040 ASC -- 表示順
EOF;
        $results = $this->all($sql);
        VossCacheManager::set($cache_key, $results);
        return VossCacheManager::get($cache_key);
    }

}