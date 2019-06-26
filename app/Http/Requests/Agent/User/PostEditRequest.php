<?php
namespace App\Http\Requests\Agent\User;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\AlphaNumber;
use App\Rules\BadChar;
use App\Rules\BetweenSoSiByteLength;
use App\Rules\MaxSoSiByteLength;
use App\Rules\Password;

/**
 * ユーザー情報登録事前入力チェック
 * Class PostEditRequest
 * @package App\Http\Requests\Agent\User
 */
class PostEditRequest extends BaseRequest
{

    protected function getValidatorInstance()
    {
        $data = $this->all();
        if (!$data) {
            return parent::getValidatorInstance();
        }
        // リクエストの全データをトリム
        $data = ArrayUtil::trim($data);

        if(!isset($data['is_edit'])){
            //英数
            $data['user_id'] = StringUtil::alnumFullToHalf($data['user_id']);
        }

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
        //禁止文字
        $bad_char = new BadChar();
        //半角英数
        $alpha_number = new AlphaNumber();
        if(request()->has('is_edit')){
            return [
                'user_name' => ['required', new MaxSoSiByteLength(42),$bad_char],
                'user_type' => ['required'],
                'login_type' => ['required']
                    ];
        }else{
            return [
                'user_id' => ['required', new BetweenSoSiByteLength(6,12),$alpha_number],
                'user_name' => ['required', new MaxSoSiByteLength(42),$bad_char],
                'user_type' => ['required'],
                'login_type' => ['required'],
                'password' => ['required',new BetweenSoSiByteLength(8,12),new Password()]
            ];
        }
    }

    /**
     * メッセージ
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        $attributes["user_id"] = "ユーザーID";
        $attributes["user_name"] = "ユーザー名称";
        $attributes["user_type"] = "ユーザー区分";
        $attributes["login_type"] = "ログイン";
        $attributes["password"] = "パスワード";
        return $attributes;
    }

}