<?php

namespace App\Queries;


use App\Libs\Voss\VossCacheManager;

class AddressQuery extends BaseQuery
{
    /**
     * 郵便番号から住所を取得します。
     * @param $zip
     * @return array
     */
    public function findByZipCode($zip)
    {

        $sql = <<<EOF
SELECT
  PST.PST030 AS prefecture_name -- 都道府県名
 ,PST.PST040 AS city_name -- 市区町村名
 ,PST.PST060 AS town_name -- 町名
 ,MPR.MPR010 AS prefecture_code -- 都道府県コード
FROM 
  {$this->common_lib}.POSTALP PST -- 郵便番号辞書ファイル
LEFT JOIN
 {$this->voss_lib}.VOSMPRP MPR -- 都道府県マスター
    ON
     MPR.MPR020 = PST.PST030 -- 都道府県名
WHERE
  PST.PST020 = :zip -- 郵便番号
ORDER BY
  PST.PST010 ASC -- SEQNO
EOF;
        $param = ['zip' => $zip];
        return $this->all($sql, $param);
    }

    /**
     * 都道府県名から市区町村を取得します。
     * @param $prefecture
     * @return array
     */
    public function getCitysByPrefecture($prefecture)
    {

        $sql = <<<EOF
SELECT DISTINCT 
  PST.PST040 AS city_name -- 市区郡町村名
 ,PST.PST050 AS city_name_kana -- 市区郡町村名カナ
FROM 
  {$this->common_lib}.POSTALP PST -- 郵便番号辞書ファイル
WHERE
  PST.PST030 = :prefecture -- 都道府県名
ORDER BY
  PST.PST050 ASC -- 市区郡町村名カナ
EOF;
        $param = ['prefecture' => $prefecture];
        return $this->all($sql, $param);
    }

    /**
     * 市区町村名から町名を取得します。
     * @param $prefecture
     * @param $city
     * @return array
     */
    public function getTownsByCity($prefecture, $city)
    {

        $sql = <<<EOF
SELECT
  PST.PST060 AS town_name -- 町名
 ,PST.PST070 AS town_name_kana -- 町名カナ
 ,PST.PST020 AS zip_code -- 郵便番号
FROM 
  {$this->common_lib}.POSTALP PST -- 郵便番号辞書ファイル
WHERE
  PST.PST030 = :prefecture -- 都道府県名
AND
   PST.PST040 = :city -- 市区郡町村名
ORDER BY
  PST.PST070 ASC -- 町名カナ
EOF;
        $params = [
            'prefecture' => $prefecture,
            'city' => $city
        ];
        return $this->all($sql, $params);
    }

    /**
     * 国情報の取得のクエリ (24時間キャッシュ)
     * @return array
     */
    public function getCountries()
    {
        $cache_key = __METHOD__;
        if (VossCacheManager::has($cache_key)) {
            return VossCacheManager::get($cache_key);
        }

        $sql = <<<EOF
SELECT
  MNT.MNT010 AS country_code -- 国コード
 ,MNT.MNT020 AS country_name_knj -- 国名漢字
FROM 
  {$this->voss_lib}.VOSMNTP MNT -- 国マスター
ORDER BY
  MNT.MNT050 ASC -- 順序No.
EOF;
        $results = $this->all($sql);
        VossCacheManager::set($cache_key, $results);
        return VossCacheManager::get($cache_key);
    }

    /**
     * 都道府県情報の取得のクエリ (24時間キャッシュ)
     * @return array
     */
    public function getPrefectures()
    {
        $cache_key = __METHOD__;
        if (VossCacheManager::has($cache_key)) {
            return VossCacheManager::get($cache_key);
        }

        $sql = <<<EOF
SELECT
  MPR.MPR010 AS prefecture_code -- 都道府県コード
 ,MPR.MPR020 AS prefecture_name -- 都道府県名
FROM 
  {$this->voss_lib}.VOSMPRP MPR -- 都道府県マスター
ORDER BY
  MPR.MPR010 ASC -- 都道府県コード
EOF;
        $results = $this->all($sql);
        VossCacheManager::set($cache_key, $results);
        return VossCacheManager::get($cache_key);
    }

}