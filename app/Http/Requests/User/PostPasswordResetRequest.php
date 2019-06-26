<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Queries\MailQuery;
use App\Queries\UserQuery;
use App\Rules\BetweenSoSiByteLength;
use App\Rules\Number;
use App\Rules\Password;

/**
 * パスワード再設定のリクエストパラメータを制御します。
 * Class PostPasswordResetRequest
 * @package App\Http\Requests\User
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
        $data['tel'] = StringUtil::numberFullToHalf($data['tel']);

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
        $number = new Number();
        return [
            'password' => ['required', new BetweenSoSiByteLength(8, 12), $password],
            'password_confirm' => ['required', 'same:password'],
            'tel' => ['required', $number],
        ];
    }

    /**
     * バリデータインスタンスの設定
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->telMatchValidation($validator);
        });
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
            'tel' => '登録された電話番号',
        ];
    }

    /**
     * 電話番号を判定します。
     * @param $validator
     */
    public function telMatchValidation($validator)
    {
        if ($validator->errors()->isNotEmpty()) {
            return;
        }
        $data = $this->all();

        $mail_query = new MailQuery();
        $mail_auth = $mail_query->findByMailAuthKey(request('auth_key'));
        $net_user_number = array_get($mail_auth, 'net_user_number');

        $user_query = new UserQuery();
        $user = $user_query->find($net_user_number);
        $user_tel1 = array_get($user, 'tel1');
        $user_tel2 = array_get($user, 'tel2');
        if ($user_tel1 !== $data['tel'] && $user_tel2 !== $data['tel2']) {
            $validator->errors()->add('tel', config('messages.error.E320-0101'));
        }
    }
}