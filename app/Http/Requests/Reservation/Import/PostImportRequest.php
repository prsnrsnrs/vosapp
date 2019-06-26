<?php

namespace App\Http\Requests\Reservation\Import;

use App\Http\Requests\BaseRequest;
use App\Libs\Voss\VossAccessManager;
use App\Queries\ImportQuery;

/**
 * 予約取込のリクエストパラメータを制御します。
 * Class PostImportRequest
 * @package App\Http\Requests
 */
class PostImportRequest extends BaseRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'format_number' => ['required'],
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

        $query = new ImportQuery();
        $auth = VossAccessManager::getAuth();
        $format_header = $query->getFormatHeader($auth['travel_company_code'], $data['format_number']);

        $upload_extension = strtolower($data['import_file']->getClientOriginalExtension());
        $expected_extension = config('const.file_type.extension.' . $format_header['file_type']);
        if ($upload_extension !== $expected_extension) {
            $message_code = $expected_extension === 'csv' ? 'E100-0101' : 'E100-0102';
            $validator->errors()->add('import_file', config('messages.error.' . $message_code));
        }
    }
}