<?php

namespace App\Http\Requests\Reservation\Input;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\AlphaNumber;
use App\Rules\MaxSoSiByteLength;

/**
 * 割引情報入力の更新リクエストパラメータを制御します。
 * Class PostDiscountChangeRequest
 * @package App\Http\Requests
 */
class PostDiscountChangeRequest extends BaseRequest
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

        foreach ($data['passengers'] as &$passenger) {
            // データの加工
            $passenger = ArrayUtil::trim($passenger);
            $count = 1;
            foreach ($passenger['discount_number'] as $discount_number){
                $passenger['discount_number'][$count] = StringUtil::alnumFullToHalf($discount_number);
                $count++;
            }
        }

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
        $alpha_number = new AlphaNumber();
        $data = $this->all();
        $rule = [];
        foreach ($data['passengers'] as $key => $value) {
            $rule["passengers.{$key}.discount_number.1"] = [$alpha_number,new MaxSoSiByteLength(11)];
            $rule["passengers.{$key}.discount_number.2"] = [$alpha_number,new MaxSoSiByteLength(11)];
            $rule["passengers.{$key}.discount_number.3"] = [$alpha_number,new MaxSoSiByteLength(11)];
            $rule["passengers.{$key}.discount_number.4"] = [$alpha_number,new MaxSoSiByteLength(11)];
            $rule["passengers.{$key}.discount_number.5"] = [$alpha_number,new MaxSoSiByteLength(11)];
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
        for ($i = 1; $i <= $length; $i++) {
            $attributes["passengers.{$i}.discount_number.1"] = "乗船者No.".$i."の割引券番号1";
            $attributes["passengers.{$i}.discount_number.2"] = "乗船者No.".$i."の割引券番号2";
            $attributes["passengers.{$i}.discount_number.3"] = "乗船者No.".$i."の割引券番号3";
            $attributes["passengers.{$i}.discount_number.4"] = "乗船者No.".$i."の割引券番号4";
            $attributes["passengers.{$i}.discount_number.5"] = "乗船者No.".$i."の割引券番号5";
        }
        return $attributes;
    }
}