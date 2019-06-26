<?php

namespace App\Http\Requests\Login;

use App\Http\Requests\BaseRequest;

/**
 * ログイン処理のリクエストパラメータを制御します。
 * Class LoginRequest
 * @package App\Http\Requests
 */
class PostAgentLoginRequest extends BaseRequest
{

    /**
     * 入力チェック前の事前処理
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance();
    }



    /**
     * ログイン処理
     * @return array
     */
    public function rules()
    {

        return [
            'store_id' => 'required',
            'user_id' => 'required',
            'password' => 'required'
        ];
    }


}