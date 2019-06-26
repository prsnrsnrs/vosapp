<?php

namespace App\Http\Requests\Agent\Import;

use App\Http\Requests\BaseRequest;


/**
 * 販売店一括登録用の入力チェック
 * Class GetFileSelectRequest
 * @package App\Http\Requests\Agent\Import
 */
class PostFileSelectRequest extends BaseRequest
{
    /**
     *販売店一括登録用の入力チェック
     * @return mixed
     */
    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance();
    }

    /**
     * バリデーションルール
     * @return array
     */
    public function rules()
    {
        //取込ファイルチェック
        return [
            'import_csv_file' => ['required', 'file'],
        ];
    }

    /**
     * バリデーションインスタンスの設定
     * @param \Illuminate\Validation\Validator $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->importFileExtensionValidation($validator);
        });
    }


    /**
     * attributes
     * @return array
     */
    public function attributes()
    {
        return [
            'import_csv_file' => 'CSVファイル',
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

        //インポートファイルの拡張子取得
        $upload_extension = strtolower($data['import_csv_file']->getClientOriginalExtension());
        //constから"CSV"取得
        $expected_extension = config('const.file_type.extension.C');
        //拡張子が一致しているのか。
        if ($upload_extension !== $expected_extension) {
            //一致していない場合はエラーメッセージ
            $message_code = 'E100-0101';
            $validator->errors()->add('import_file', config('messages.error.' . $message_code));
        }
    }

}