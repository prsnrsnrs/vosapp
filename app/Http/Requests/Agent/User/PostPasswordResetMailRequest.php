<?php
namespace App\Http\Requests\Agent\User;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\MaxSoSiByteLength;

/**
 * パスワード再設定モーダル用リクエストパラメータを制御します。
 * Class PostPasswordResetMailRequest
 * @package App\Http\Requests\Agent\User
 */
class PostPasswordResetMailRequest extends BaseRequest
{
    /**
     *パスワード用の入力チェック
     * @return mixed
     */
    protected function getValidatorInstance()
    {
        $data = $this->all();
        if (!$data) {
            return parent::getValidatorInstance();
        }
        // リクエストをトリム
        $data = ArrayUtil::trim($data);

        //英数
        $data['mail_address'] = StringUtil::alnumFullToHalf($data['mail_address']);

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
        return [
            'mail_address' => ['required','email', new MaxSoSiByteLength(80)]
        ];
    }

    /**
     * attributes
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        $attributes["mail_address"] = "メールアドレス";
        return $attributes;
    }

}