<?php

namespace App\Http\Requests\Reservation\Input;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Rules\BadChar;
use App\Rules\MaxSoSiByteLength;
use App\Rules\SelectRequire;

/**
 * ご乗船者リクエスト入力の更新リクエストパラメータを制御します。
 * Class PostPassengerRequestChangeRequest
 * @package App\Http\Requests
 */
class PostPassengerRequestChangeRequest extends BaseRequest
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
        $select_require = new SelectRequire();
        $bad_char = new BadChar();

        $data = $this->all();
        $rule = [];
        foreach ($data['passengers'] as $key => $value) {
            $rule["passengers.{$key}.child_meal_type"] = [$select_require];
            $rule["passengers.{$key}.net_remark"] = [$bad_char, new MaxSoSiByteLength(302)];
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
            $attributes["passengers.{$i}.child_meal_type"] = "乗船者No." . $i . "の子供食区分";
            $attributes["passengers.{$i}.net_remark"] = "乗船者No." . $i . "の備考";
        }
        return $attributes;
    }
}