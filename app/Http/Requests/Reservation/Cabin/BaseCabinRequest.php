<?php

namespace App\Http\Requests\Reservation\Cabin;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\Alpha;
use App\Rules\MaxSoSiByteLength;

/**
 * 予約登録関連のパラメータを制御します。
 * Class BaseCabinRequest
 * @package App\Http\Requests
 */
class BaseCabinRequest extends BaseRequest
{
    /**
     * 入力チェック前の事前処理
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {

        // TODO；個人向けの場合、代表者はログインユーザーであるかチェック

        $data = $this->all();
        if (!$data) {
            return parent::getValidatorInstance();
        }

        $boss_status = [];
        foreach ($data['passengers'] as &$passenger) {
            // データの加工
            $passenger = ArrayUtil::trim($passenger);
            // 英字 半角変換
            $passenger['passenger_last_eij'] = strtoupper(StringUtil::alnumFullToHalf($passenger['passenger_last_eij']));
            $passenger['passenger_first_eij'] = strtoupper(StringUtil::alnumFullToHalf($passenger['passenger_first_eij']));
            // 代表者区分
            $boss_status[] = $passenger['boss_status'];
        }

        // 代表者区分の加工
        $result = in_array('Y', $boss_status);
        if (!$result) {
            $result = '';
        }
        $data['custom']['boss_status'] = $result;

        // リクエストデータ強制書き換え
        $this->merge($data);
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
        $alpha = new Alpha();

        $data = $this->all();
        $rule = [];
        foreach ($data['passengers'] as $key => $value){
            $rule['custom.boss_status'] = ['required'];
            $rule["passengers.{$key}.passenger_last_eij"] = [$alpha, new MaxSoSiByteLength(20)];
            $rule["passengers.{$key}.passenger_first_eij"] = [$alpha, new MaxSoSiByteLength(20)];
        }

        return $rule;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        $length = count(request('passengers'));
        for ($key = 1; $key <= $length; $key++) {
            $attributes["passengers.{$key}.passenger_last_eij"] = "ご乗船者様 No.{$key} お名前英字（姓）";
            $attributes["passengers.{$key}.passenger_first_eij"] = "ご乗船者様 No.{$key} お名前英字（名）";
        }
        $attributes["custom.boss_status"] = "代表者";

        return $attributes;
    }
}