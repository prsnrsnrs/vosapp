<?php

namespace App\Http\Requests\Reservation\Input;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Rules\BadChar;
use App\Rules\MaxSoSiByteLength;

/**
 * 客室リクエスト入力の更新リクエストパラメータを制御します。
 * Class PostCabinRequestChangeRequest
 * @package App\Http\Requests
 */
class PostCabinRequestChangeRequest extends BaseRequest
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
        $bad_char = new BadChar();

        $data = $this->all();
        $rule = [];
        foreach ($data['passengers'] as $key => $value) {
            $rule["passengers.{$key}.cabin_request_free"] = [$bad_char, new MaxSoSiByteLength(52)];
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
            $attributes["passengers.{$i}.cabin_request_free"] = "客室No." . $i . "のキャビンリクエスト";
        }
        return $attributes;
    }
}