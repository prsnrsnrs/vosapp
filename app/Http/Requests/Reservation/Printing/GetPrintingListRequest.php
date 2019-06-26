<?php

namespace App\Http\Requests\Reservation\Printing;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\DateUtil;
use App\Libs\StringUtil;

/**
 * 乗船券控え・確認書の印刷リクエストパラメータを制御します。
 * Class GetPrintingListRequest
 * @package App\Http\Requests
 */
class GetPrintingListRequest extends BaseRequest
{
    /**
     * 入力チェック前の事前処理
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $data = $this->all();
        if (!$data || !array_key_exists('search_con', $data)) {
            return parent::getValidatorInstance();
        }

        \Log::debug('変換前のリクエストデータ', $data);

        // リクエストの全データをトリム
        $data = ArrayUtil::trim($data);

        // 日付書式変換
        $convert_date = ['search_con.departure_date_from', 'search_con.departure_date_to'];
        foreach ($convert_date as $key) {
            $convert = DateUtil::convertFormat(array_get($data, $key), 'Ymd');
            array_set($data, $key, $convert);
        }


        //英字大文字変換、半角変換
        $data['search_con']['passenger_name'] = strtoupper(StringUtil::alnumFullToHalf($data['search_con']['passenger_name']));
        //英字以外、全角変換
        $data['search_con']['passenger_name'] = strtoupper(StringUtil::convertOnlyZenkakuKana($data['search_con']['passenger_name']));

        //予約番号を半角数字に変換
        $data['search_con']['reservation_number'] = strtoupper(StringUtil::numberFullToHalf($data['search_con']['reservation_number']));


        \Log::debug('変換後のリクエストデータ', $data);

        // リクエストデータ強制書き換え
        request()->merge($data);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}