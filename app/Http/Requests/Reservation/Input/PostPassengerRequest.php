<?php

namespace App\Http\Requests\Reservation\Input;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\Alpha;
use App\Rules\AlphaNumber;
use App\Rules\BadChar;
use App\Rules\Katakana;
use App\Rules\MaxSoSiByteLength;
use App\Rules\Number;
use App\Rules\SizeSoSiByteLength;

/**
 * ご乗船者詳細入力の更新リクエストパラメータを制御します。
 * Class PostPassengerRequest
 * @package App\Http\Requests
 */
class PostPassengerRequest extends BaseRequest
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
            // 英字半角大文字変換
            $passenger['passenger_last_eij'] = strtoupper(StringUtil::alnumFullToHalf($passenger['passenger_last_eij']));
            $passenger['passenger_first_eij'] = strtoupper(StringUtil::alnumFullToHalf($passenger['passenger_first_eij']));
            // カナ変換
            $passenger['passenger_last_kana'] = StringUtil::convertHankakuKana($passenger['passenger_last_kana']);
            $passenger['passenger_first_kana'] = StringUtil::convertHankakuKana($passenger['passenger_first_kana']);
            $passenger['emergency_contact_kana'] = StringUtil::convertHankakuKana($passenger['emergency_contact_kana']);
            // 数字 半角変換
            $passenger['zip_code'] = StringUtil::numberFullToHalf($passenger['zip_code']);
            $passenger['tel1'] = StringUtil::numberFullToHalf($passenger['tel1']);
            $passenger['tel2'] = StringUtil::numberFullToHalf($passenger['tel2']);
            $passenger['emergency_contact_tel'] = StringUtil::numberFullToHalf($passenger['emergency_contact_tel']);
            // 英数字 半角変換
            $passenger['passport_number'] = StringUtil::alnumFullToHalf($passenger['passport_number']);
            // 日付データ作成
            $passenger['birth_date'] = $passenger['birth_year'] . $passenger['birth_month'] . $passenger['birth_day'];
            $passenger['wedding_anniversary'] = $passenger['wedding_year'] . $passenger['wedding_month'] . $passenger['wedding_day'];
            $passenger['passport_issued_date'] = $passenger['passport_issued_year'] . $passenger['passport_issued_month'] . $passenger['passport_issued_day'];
            $passenger['passport_lose_date'] = $passenger['passport_lose_year'] . $passenger['passport_lose_month'] . $passenger['passport_lose_day'];
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
        $katakana = new Katakana();
        $number = new Number();
        $alpha = new Alpha();
        $alpha_number = new AlphaNumber();

        $data = $this->all();
        $rule = [];
        foreach ($data['passengers'] as $key => $value) {
            $rule["passengers.{$key}.passenger_last_eij"] = [$alpha, new MaxSoSiByteLength(20)];
            $rule["passengers.{$key}.passenger_first_eij"] = [$alpha, new MaxSoSiByteLength(20)];
            $rule["passengers.{$key}.passenger_last_knj"] = [$bad_char, new MaxSoSiByteLength(22)];
            $rule["passengers.{$key}.passenger_first_knj"] = [$bad_char, new MaxSoSiByteLength(22)];
            $rule["passengers.{$key}.passenger_last_kana"] = [$katakana, new MaxSoSiByteLength(20)];
            $rule["passengers.{$key}.passenger_first_kana"] = [$katakana, new MaxSoSiByteLength(20)];
            $rule["passengers.{$key}.gender"] = [];
            $rule["passengers.{$key}.birth_date"] = ['date'];
            $rule["passengers.{$key}.wedding_anniversary"] = ['date'];
            $rule["passengers.{$key}.zip_code"] = [$number, new SizeSoSiByteLength(7)];
            $rule["passengers.{$key}.prefecture_code"] = [];
            $rule["passengers.{$key}.address1"] = [$bad_char, new MaxSoSiByteLength(102)];
            $rule["passengers.{$key}.address2"] = [$bad_char, new MaxSoSiByteLength(102)];
            $rule["passengers.{$key}.address3"] = [$bad_char, new MaxSoSiByteLength(102)];
            $rule["passengers.{$key}.tel1"] = [$number, new MaxSoSiByteLength(16)];
            $rule["passengers.{$key}.tel2"] = [$number, new MaxSoSiByteLength(16)];
            $rule["passengers.{$key}.emergency_contact_name"] = [$bad_char, new MaxSoSiByteLength(42)];
            $rule["passengers.{$key}.emergency_contact_kana"] = [$katakana, new MaxSoSiByteLength(42)];
            $rule["passengers.{$key}.emergency_contact_relationship"] = [$bad_char, new MaxSoSiByteLength(12)];
            $rule["passengers.{$key}.emergency_contact_tel"] = [$number, new MaxSoSiByteLength(16)];
            $rule["passengers.{$key}.country_code"] = [];
            $rule["passengers.{$key}.passport_number"] = [$alpha_number, new MaxSoSiByteLength(12)];
            $rule["passengers.{$key}.passport_issued_place"] = [];
            $rule["passengers.{$key}.residence_code"] = [];
            $rule["passengers.{$key}.passport_issued_date"] = ['date'];
            $rule["passengers.{$key}.passport_lose_date"] = ['date'];
        }
        return $rule;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        $data = $this->all();
        foreach ($data['passengers'] as $key => $value) {
            $attributes["passengers.{$key}.passenger_last_eij"] = "ご乗船者様 No.{$key} お名前英字 (姓)";
            $attributes["passengers.{$key}.passenger_first_eij"] = "ご乗船者様 No.{$key} お名前英字 (名)";
            $attributes["passengers.{$key}.passenger_last_knj"] = "ご乗船者様 No.{$key} お名前漢字 (姓)";
            $attributes["passengers.{$key}.passenger_first_knj"] = "ご乗船者様 No.{$key} お名前漢字 (名)";
            $attributes["passengers.{$key}.passenger_last_kana"] = "ご乗船者様 No.{$key} お名前カナ (姓)";
            $attributes["passengers.{$key}.passenger_first_kana"] = "ご乗船者様 No.{$key} お名前カナ (名)";
            $attributes["passengers.{$key}.gender"] = "ご乗船者様 No.{$key} 性別";
            $attributes["passengers.{$key}.birth_date"] = "ご乗船者様 No.{$key} 生年月日";
            $attributes["passengers.{$key}.wedding_anniversary"] = "ご乗船者様 No.{$key} 結婚記念日";
            $attributes["passengers.{$key}.zip_code"] = "ご乗船者様 No.{$key} 郵便番号";
            $attributes["passengers.{$key}.prefecture_code"] = "ご乗船者様 No.{$key} 都道府県";
            $attributes["passengers.{$key}.address1"] = "ご乗船者様 No.{$key} 住所 市区町村まで";
            $attributes["passengers.{$key}.address2"] = "ご乗船者様 No.{$key} 住所 番地以降";
            $attributes["passengers.{$key}.address3"] = "ご乗船者様 No.{$key} 住所 建物名";
            $attributes["passengers.{$key}.tel1"] = "ご乗船者様 No.{$key} 電話番号 携帯";
            $attributes["passengers.{$key}.tel2"] = "ご乗船者様 No.{$key} 電話番号 自宅";
            $attributes["passengers.{$key}.emergency_contact_name"] = "ご乗船者様 No.{$key} 緊急連絡先 お名前";
            $attributes["passengers.{$key}.emergency_contact_kana"] = "ご乗船者様 No.{$key} 緊急連絡先 お名前カナ";
            $attributes["passengers.{$key}.emergency_contact_relationship"] = "ご乗船者様 No.{$key} 緊急連絡先 続柄";
            $attributes["passengers.{$key}.emergency_contact_tel"] = "ご乗船者様 No.{$key} 緊急連絡先 電話番号";
            $attributes["passengers.{$key}.country_code"] = "ご乗船者様 No.{$key} 国籍";
            $attributes["passengers.{$key}.passport_number"] = "ご乗船者様 No.{$key} 旅券番号";
            $attributes["passengers.{$key}.passport_issued_place"] = "ご乗船者様 No.{$key} 旅券発給地";
            $attributes["passengers.{$key}.residence_code"] = "ご乗船者様 No.{$key} 居住国";
            $attributes["passengers.{$key}.passport_issued_date"] = "ご乗船者様 No.{$key} 旅券発給日";
            $attributes["passengers.{$key}.passport_lose_date"] = "ご乗船者様 No.{$key} 旅券失効日";
        }
        return $attributes;
    }
}