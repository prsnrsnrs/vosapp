<?php

namespace App\Http\Requests\Reservation\Import;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Libs\StringUtil;
use App\Rules\MaxSoSiByteLength;

/**
 * フォーマット登録のリクエストパラメータを制御します。
 * Class PostAddFormatRequest
 * @package App\Http\Requests
 */
class PostAddFormatRequest extends BaseRequest
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
        // 数字 半角変換
        $data['header_line_number'] = StringUtil::numberFullToHalf($data['header_line_number']);
        $data['import_start_line_number'] = StringUtil::numberFullToHalf($data['import_start_line_number']);

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
        return [
            'format_name' => ['required', new MaxSoSiByteLength(32)],
            'file_type' => ['required'],
            'header_line_number' => ['required', 'integer', new MaxSoSiByteLength(4)],
            'import_start_line_number' => ['required', 'integer', new MaxSoSiByteLength(4)],
            'import_file' => ['required', 'file'],
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
            $this->importFileExtensionValidation($validator);
        });
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'format_name' => 'フォーマット名',
            'file_type' => 'ファイル形式',
            'header_line_number' => '列見出し行',
            'import_start_line_number' => '取込開始行',
            'import_file' => '取込ファイル',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'import_file.required' => config('messages.error.E000-0002'),
        ];
    }

    /**
     * 取込ファイルの拡張子バリデーション
     * @param  \Illuminate\Validation\Validator $validator
     */
    private function importFileExtensionValidation($validator)
    {
        if ($validator->errors()->isNotEmpty()) {
            return;
        }

        $data = $this->all();
        $upload_extension = strtolower($data['import_file']->getClientOriginalExtension());
        $expected_extension = config('const.file_type.extension.' . $data['file_type']);
        if ($upload_extension !== $expected_extension) {
            $message_code = $expected_extension === 'csv' ? 'E100-0101' : 'E100-0102';
            $validator->errors()->add('import_file', config('messages.error.' . $message_code));
        }
    }
}