<?php

namespace App\Http\Requests\Agent\User;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Rules\BetweenSoSiByteLength;
use App\Rules\Password;

/**
 * パスワード再設定のリクエストパラメータを制御します。
 * Class PostPasswordResetRequest
 * @package App\Http\Requests\Agent\User
 */
class PostPasswordResetRequest extends BaseRequest
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

        $data = ArrayUtil::trim($data);

        // リクエストデータ強制書き換え
        $this->merge($data);
        request()->merge($data);
        return parent::getValidatorInstance();
    }

    /**
     * バリデーションルール
     * @return array
     */
    public function rules()
    {
        $password = new Password();
        return [
            'password' => ['required', new BetweenSoSiByteLength(8, 12), $password],
            'password_confirm' => ['required', 'same:password'],
        ];
    }

    /**
     * attributes
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => '新しいパスワード',
            'password_confirm' => '新しいパスワード再入力',
        ];
    }
}