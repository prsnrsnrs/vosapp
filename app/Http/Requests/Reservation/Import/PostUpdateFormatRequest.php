<?php

namespace App\Http\Requests\Reservation\Import;

use App\Http\Requests\BaseRequest;
use App\Libs\StringUtil;
use App\Rules\MaxSoSiByteLength;

/**
 * フォーマット更新のリクエストパラメータを制御します。
 * Class PostUpdateFormatRequest
 * @package App\Http\Requests
 */
class PostUpdateFormatRequest extends BaseRequest
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

        $data['format_details'] = $this->convertFormatDetails($data['format_details']);

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
        $rule = [
            'format_name' => ['required', new MaxSoSiByteLength(32)],
        ];
        $data = $this->all();
        foreach ($data['format_details'] as $key => $value) {
            $rule["format_details.{$key}.delimiter_char"] = ['sometimes', new MaxSoSiByteLength(4)];
            $rule["format_details.{$key}.travel_company_col_index"] = ["required_if:format_details.{$key}.format_require_type,Y"];
        }
        return $rule;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [
            'format_name' => 'フォーマット名',
        ];
        $data = $this->all();
        foreach ($data['format_details'] as $key => $format_detail) {
            $attributes["format_details.{$key}.delimiter_char"] = "取込フォーマット No.{$format_detail['display_row_number']} 区切り文字";
            $attributes["format_details.{$key}.travel_company_col_index"] = "取込フォーマット No.{$format_detail['display_row_number']} 取込情報";
        }
        return $attributes;
    }

    /**
     * 取込フォーマット明細の入力データを加工します。
     * ・ 区切り文字をi5DBの文字に変換します。
     * ・ 区切り文字が設定されているが、取込設定が未設定のデータに対して 前 or 後ろ のデータで補完
     * @param array $format_details
     * @return array
     */
    private function convertFormatDetails(array $format_details)
    {
        $prev_key = null;
        foreach ($format_details as $key => $format_detail) {

            // 区切り文字をWebからDBに変換
            if (isset($format_detail['delimiter_char'])) {
                $format_details[$key]['delimiter_char'] = StringUtil::convertWebDelimiterToI5DBChar($format_detail['delimiter_char']);
            }

            if (is_null($prev_key) || !isset($format_detail['delimiter_char']) || !$format_detail['delimiter_char']) {
                $prev_key = $key;
                continue;
            }

            $prev_format_detail = $format_details[$prev_key];
            // 前後をチェックし、取込設定の値を補完する。
            if ($prev_format_detail['display_row_number'] === $format_detail['display_row_number']) {
                if (!$format_detail['travel_company_col_index']) {
                    $format_details[$key]['travel_company_col_index'] = $prev_format_detail['travel_company_col_index'];
                }
                if (!$prev_format_detail['travel_company_col_index']) {
                    $format_details[$prev_key]['travel_company_col_index'] = $format_detail['travel_company_col_index'];
                }
            }
            $prev_key = $key;
        }
        return $format_details;
    }
}