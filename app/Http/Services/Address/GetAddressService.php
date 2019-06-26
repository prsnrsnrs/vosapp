<?php

namespace App\Http\Services\Address;

use App\Http\Services\BaseService;
use App\Libs\ArrayUtil;
use App\Queries\AddressQuery;


/**
 * 郵便番号から住所を取得するサービスです。
 * Class GetAddressService
 * @package App\Http\Services\Address
 */
class GetAddressService extends BaseService
{
    /**
     * サービスクラスを初期化します。
     */
    public function init()
    {
        $this->response_data['prefecture_code'] = '';
        $this->response_data['address1'] = '';
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        try {
            $query = new AddressQuery();
            $address_list = $query->findByZipCode(request('zip_code'));
            if (!$address_list) {
                return;
            }
            if (count($address_list) === 1) {
                $address = $address_list[0];
                $this->response_data['prefecture_code'] = $address['prefecture_code'];

                $address1 = $address['city_name'];
                if ($address['town_name'] !== config('const.address.name.not_posting')) {
                    // "以下に掲載がない場合"を選択していない場合のみ、文字列を結合する
                    $address1 .= $address['town_name'];
                }
                $this->response_data['address1'] = $address1;

            } else {
                // 複数件住所が取得できた場合は、前方からマッチする部分のみを抽出する
                $matching = ArrayUtil::matchingValue(array_except($address_list, 'prefecture_code'));
                foreach ($address_list as $address) {
                    $pos = mb_strpos($matching, $address['prefecture_name']);
                    if ($pos === 0) {
                        $this->response_data['prefecture_code'] = $address['prefecture_code'];
                        $this->response_data['address1'] = mb_substr($matching, 0, count($address['prefecture_name']));
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            // エラーは無視する。
        }
    }
}