<?php

namespace App\Http\Services\Address;

use App\Http\Services\BaseService;
use App\Queries\AddressQuery;


/**
 * 町名選択画面のサービスクラスです。
 * Class GetTownService
 * @package App\Http\Services\Address
 */
class GetTownService extends BaseService
{

    /**
     * 掲載がない場合の郵便番号
     * @var array
     */
    private $not_posting;


    /**
     * 初期化します
     */
    public function init()
    {
        $this->not_posting = [];
    }


    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        $town = $this->getAddressQuery();
        if (!$town) {
            $this->setQueryErrorMessages(config('messages.error.E010-0101'));
            return;
        }
        $this->response_data['select_prefecture'] = request('select_prefecture');
        $this->response_data['select_city'] = request('select_city');
        $this->response_data['town'] = $town;
        $this->response_data['not_posting'] = $this->not_posting;
        $this->response_data['target'] = request('target');
    }

    /**
     * 町名を行ごとの配列で取得します。
     * @return array
     */
    private function getAddressQuery()
    {
        $query = new AddressQuery();
        $town = $query->getTownsByCity(request('select_prefecture'), request('select_city'));

        //町名を行ごとに分けた配列の初期化$not_posting = array();
        $town_a = array();
        $town_k = array();
        $town_s = array();
        $town_t = array();
        $town_n = array();
        $town_h = array();
        $town_m = array();
        $town_y = array();
        $town_r = array();
        $town_w = array();

        //全件取得した町名を一件ずつ行ごとの配列に格納
        foreach ($town as $value) {
            $town_name = $value['town_name'];
            $zip_code = $value['zip_code'];
            $town_kana = mb_convert_kana($value['town_name_kana'], "KV");

            // 掲載がない場合の郵便番号を格納
            if (!$town_kana) {
                $this->not_posting = array('name' => $town_name, 'zip_code' => $zip_code);
                continue;
            }

            //keyを町名漢字、valueを町名カナにした配列を作成
            $town_knj_kana = [
                $town_name => $zip_code
            ];

            //町名の一文字目を取得し、それを基に判定し、行ごとの配列に格納
            $town_kana_first = mb_substr($town_kana, 0, 1);

            if (preg_match('/' . $town_kana_first . '/', "アイウエオ")) {
                $town_a = array_merge($town_a, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "カキクケコガギグゲゴ")) {
                $town_k = array_merge($town_k, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "サシスセソザジズゼゾ")) {
                $town_s = array_merge($town_s, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "タチツテトダヂヅデド")) {
                $town_t = array_merge($town_t, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "ナニヌネノ")) {
                $town_n = array_merge($town_n, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "ハヒフヘホバビブベボ")) {
                $town_h = array_merge($town_h, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "マミムメモ")) {
                $town_m = array_merge($town_m, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "ヤユヨ")) {
                $town_y = array_merge($town_y, $town_knj_kana);
            } elseif (preg_match('/' . $town_kana_first . '/', "ラリルレロ")) {
                $town_r = array_merge($town_r, $town_knj_kana);
            } else if (preg_match('/' . $town_kana_first . '/', "ワヲン")) {
                $town_w = array_merge($town_w, $town_knj_kana);
            }
        }

        //行ごとに分けた配列をkeyが行名、valueが町名漢字、町名カナの多次元配列に変換
        $all_towns = [
            'ア行' => $town_a,
            'カ行' => $town_k,
            'サ行' => $town_s,
            'タ行' => $town_t,
            'ナ行' => $town_n,
            'ハ行' => $town_h,
            'マ行' => $town_m,
            'ヤ行' => $town_y,
            'ラ行' => $town_r,
            'ワ行' => $town_w,
        ];
        return $all_towns;
    }

//    /**
//     * 以下に掲載がない場合の郵便番号を取得します
//     * @return mixed
//     */
//    private function getNoTownZipCode()
//    {
//        $query = new AddressQuery();
//        $town = $query->getTownsByCity(request('select_prefecture'), request('select_city'));
//        $no_town_zip_code = $town[0]['zip_code'];
//        return $no_town_zip_code;
//    }
}