<?php

namespace App\Http\Requests\Agent\Import;

use App\Http\Requests\BaseRequest;

/**
 * 販売店一括登録 確認ボタン押下時の入力チェック
 * Class PostImportRequest
 * @package App\Http\Requests\Agent\Import
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
     * 入力チェック内容:すべて必須チェック
     * @return array
     */

    public function rules()
    {
        return [
            'agent_code' => ['required'],
            'agent_name' => ['required'],
            'zip_code' => ['required'],
            'prefecture_code' => ['required'],
            'address1' => ['required'],
            'address2' => ['required'],
            'tel' => ['required'],
            'fax_number' => ['required'],
            'mail_address1' => ['required'],
            'agent_type' => ['required'],
            'login_type' => ['required'],
            'user_id' => ['required'],
            'password' => ['required'],
        ];
    }

    /**
     * メッセージ項目名
     * @return array
     */
    public function attributes()
    {
        return [
            'agent_code' => '販売店コード',
            'agent_name' => '販売店名',
            'zip_code' => '郵便番号',
            'prefecture_code' => '都道府県',
            'address1' => '住所1',
            'address2' => '住所2',
            'address3' => '住所3',
            'tel' => '電話番号',
            'fax_number' => 'FAX番号',
            'mail_address1' => 'メールアドレス1',
            'mail_address2' => 'メールアドレス2',
            'mail_address3' => 'メールアドレス3',
            'mail_address4' => 'メールアドレス4',
            'mail_address5' => 'メールアドレス5',
            'mail_address6' => 'メールアドレス6',
            'agent_type' => '販売店区分',
            'login_type' => 'ログイン区分',
            'user_id' => 'ユーザーID',
            'password' => 'パスワード',
        ];
    }


    /**
     * インスタンス設定
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->importColumnValidation($validator);
        });
    }

    /**
     * 列名セレクトボックスで選択された列名の重複チェック
     * @param $validator
     */
    public function importColumnValidation($validator)
    {
        //列名セレクトボックスのvalue値のみ取得
        $data = $this->all();
        $attributes = $this->attributes();
        $import_item_no = [];
        foreach ($data as $item_key => $item_value) {
            if ($item_key === "import_csv_file" || trim($item_value) === "") {
                continue;
            }

            if (in_array($item_value, $import_item_no)) {
                //エラーメッセージ表示
                $message_code = 'E210-0001';
                $validator->errors()->add($item_key, str_replace(':attribute', $attributes[$item_key], config('messages.error.' . $message_code)));
            }
            $import_item_no[] = $item_value;
        }
//        //列名重複チェック
//        if ($import_item_no !== array_unique($import_item_no)) {
//            //エラーメッセージ表示
//            $message_code = 'E210-0001';
//            $validator->errors()->add('select_column', config('messages.error.' . $message_code));
//        }


    }

}