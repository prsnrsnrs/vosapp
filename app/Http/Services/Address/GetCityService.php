<?php

namespace App\Http\Services\Address;

use App\Http\Services\BaseService;
use App\Queries\AddressQuery;


/**
 * 市区町村選択画面のサービスクラスです。
 * Class GetCityService
 * @package App\Http\Services\Address
 */
class GetCityService extends BaseService
{
    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        $city = $this->getAddressQuery();
        if (!$city) {
            $this->setQueryErrorMessages(config('messages.error.E010-0101'));
            return;
        }
        $this->response_data['select_prefecture'] = request('select_prefecture');
        $this->response_data['city'] = $city;
        $this->response_data['target'] = request('target');
    }

    /**
     * 選択された都道府県を基に取得した市区町村を、行ごとに格納した配列を返します
     * @return array
     */
    public function getAddressQuery()
    {
        $query = new AddressQuery();
        $city = $query->getCitysByPrefecture(request('select_prefecture'));

        //行ごとに市区町村を分けた配列の初期化
        $city_a = array();
        $city_k = array();
        $city_s = array();
        $city_t = array();
        $city_n = array();
        $city_h = array();
        $city_m = array();
        $city_y = array();
        $city_r = array();
        $city_w = array();

        //全件取得した市区町村を一件ずつ行ごとの配列に格納
        foreach ($city as $value) {
            $city_name = $value['city_name'];
            $city_kana = mb_convert_kana($value['city_name_kana'], "KV");

            //keyを市区町村名漢字、valueを市区町村カナにした配列を作成
            $city_knj_kana = [
                $city_name => $city_kana
            ];

            //市区町村の一文字目を取得し、それを基に判定し、行ごとの配列に格納
            $city_kana_first = mb_substr($city_kana, 0, 1);
            if (preg_match('/' . $city_kana_first . '/', "アイウエオ")) {
                $city_a = array_merge($city_a, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "カキクケコガギグゲゴ")) {
                $city_k = array_merge($city_k, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "サシスセソザジズゼゾ")) {
                $city_s = array_merge($city_s, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "タチツテトダヂヅデド")) {
                $city_t = array_merge($city_t, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "ナニヌネノ")) {
                $city_n = array_merge($city_n, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "ハヒフヘホバビブベボ")) {
                $city_h = array_merge($city_h, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "マミムメモ")) {
                $city_m = array_merge($city_m, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "ヤユヨ")) {
                $city_y = array_merge($city_y, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "ラリルレロ")) {
                $city_r = array_merge($city_r, $city_knj_kana);
            } elseif (preg_match('/' . $city_kana_first . '/', "ワヲン")) {
                $city_w = array_merge($city_w, $city_knj_kana);
            }
        }

        //行ごとに分けた配列をkeyが行名、valueが市区町村名漢字、市区町村名カナの多次元配列に変換
        $all_citys    = [
            'ア行' => $city_a,
            'カ行' => $city_k,
            'サ行' => $city_s,
            'タ行' => $city_t,
            'ナ行' => $city_n,
            'ハ行' => $city_h,
            'マ行' => $city_m,
            'ヤ行' => $city_y,
            'ラ行' => $city_r,
            'ワ行' => $city_w,
        ];
        return $all_citys;
    }
}