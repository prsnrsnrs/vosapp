<?php

namespace App\Http\Requests\Agent;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\AlphaNumber;
use App\Rules\BadChar;
use App\Rules\MaxSoSiByteLength;
use App\Rules\Number;

/**
 * 販売店登録処理のリクエストパラメータを制御します。
 * Class PostEditRequest
 * @package App\Http\Requests\Agent
 */
class PostEditRequest extends BaseRequest
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
        // リクエストの全データをトリム
        $data = ArrayUtil::trim($data);

        //英数
        $data['agent_code'] = StringUtil::alnumFullToHalf($data['agent_code']);
        $data['mail_address1'] = StringUtil::alnumFullToHalf($data['mail_address1']);
        $data['mail_address2'] = StringUtil::alnumFullToHalf($data['mail_address2']);
        $data['mail_address3'] = StringUtil::alnumFullToHalf($data['mail_address3']);
        $data['mail_address4'] = StringUtil::alnumFullToHalf($data['mail_address4']);
        $data['mail_address5'] = StringUtil::alnumFullToHalf($data['mail_address5']);
        $data['mail_address6'] = StringUtil::alnumFullToHalf($data['mail_address6']);
        //数字
        $data['zip_code'] = StringUtil::numberFullToHalf($data['zip_code']);
        $data['tel'] = StringUtil::numberFullToHalf($data['tel']);
        $data['fax_number'] = StringUtil::numberFullToHalf($data['fax_number']);

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
        //数字
        $number = new Number();
        //半角英数
        $alpha_number = new AlphaNumber();

        return [
            'agent_code' => ['required',$alpha_number, new MaxSoSiByteLength(7)],
            'agent_name' => ['required',$bad_char, new MaxSoSiByteLength(72)],
            'zip_code' => ['required',$number, new MaxSoSiByteLength(7)],
            'prefecture_code' => ['required'],
            'address1' => ['required',$bad_char, new MaxSoSiByteLength(102)],
            'address2' => ['required',$bad_char, new MaxSoSiByteLength(102)],
            'address3' => [$bad_char, new MaxSoSiByteLength(102)],
            'tel' => ['required',$number, new MaxSoSiByteLength(16)],
            'fax_number' => ['required',$number, new MaxSoSiByteLength(16)],
            'mail_address1' => ['required','email', new MaxSoSiByteLength(80)],
            'mail_address2' => ['email', new MaxSoSiByteLength(80)],
            'mail_address3' => ['email', new MaxSoSiByteLength(80)],
            'mail_address4' => ['email', new MaxSoSiByteLength(80)],
            'mail_address5' => ['email', new MaxSoSiByteLength(80)],
            'mail_address6' => ['email', new MaxSoSiByteLength(80)],
            'agent_type' => ['required'],
            'login_type' => ['required'],
        ];
    }

    /**
     * attributes
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        $attributes["agent_code"] = "販売店コード";
        $attributes["agent_name"] = "販売店名";
        $attributes["zip_code"] = "郵便番号";
        $attributes["prefecture_code"] = "都道府県";
        $attributes["address1"] = "住所1";
        $attributes["address2"] = "住所2";
        $attributes["address3"] = "住所(建物名)";
        $attributes["tel"] = "電話番号";
        $attributes["fax_number"] = "FAX番号";
        $attributes["mail_address1"] = "メールアドレス1";
        $attributes["mail_address2"] = "メールアドレス2";
        $attributes["mail_address3"] = "メールアドレス3";
        $attributes["mail_address4"] = "メールアドレス4";
        $attributes["mail_address5"] = "メールアドレス5";
        $attributes["mail_address6"] = "メールアドレス6";
        $attributes["agent_type"] = "販売店区分";
        $attributes["login_type"] = "ログイン";
        return $attributes;
    }


}