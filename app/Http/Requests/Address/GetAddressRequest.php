<?php

namespace App\Http\Requests\Address;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;


/**
 * 住所取得のパラメータを制御します
 * Class GetAddressRequest
 * @package App\Http\Requests\Address
 */
class GetAddressRequest extends BaseRequest
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
        //半角数字かチェック
        $data['zip_code'] = StringUtil::numberFullToHalf($data['zip_code']);
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