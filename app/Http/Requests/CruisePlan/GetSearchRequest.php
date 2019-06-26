<?php

namespace App\Http\Requests\CruisePlan;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\DateUtil;

/**
 * クルーズプラン検索のリクエストパラメータを制御します。
 * Class GetSearchRequest
 * @package App\Http\Requests
 */
class GetSearchRequest extends BaseRequest
{
    /**
     * 入力チェック前の事前処理
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $data = $this->all();
        if (!$data) {
            return parent::getValidatorInstance();
        }

        \Log::debug('変換前のリクエストデータ', $data);

        // リクエストの全データをトリム
        $data = ArrayUtil::trim($data);

        $convert_date = ['search_con.departure_date_from', 'search_con.departure_date_to'];
        foreach ($convert_date as $key) {
            $date = array_get($data, $key);

            // Fromが空なら翌日を日付を書換
            if ($key === 'search_con.departure_date_from' && !$date) {
                $date = date('Ymd', strtotime('+1 day'));
            }

            // 日付書式変換
            $convert = DateUtil::convertFormat($date, 'Ymd');
            array_set($data, $key, $convert);
        }

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