<?php

namespace App\Http\Requests\Reservation\Input;

use App\Http\Requests\BaseRequest;
use App\Libs\ArrayUtil;
use App\Rules\SelectRequire;

/**
 * 質問事項のチェックの更新リクエストパラメータを制御します。
 * Class PostQuestionChangeRequest
 * @package App\Http\Requests
 */
class PostQuestionChangeRequest extends BaseRequest
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
        $select_require = new SelectRequire();

        $data = $this->all();
        $rule = [];
        foreach ($data['passengers'] as $key1 => $passenger) {
            foreach ($passenger['answers'] as $key2 => $value2) {
                $rule["passengers.{$key1}.answers.{$key2}"] = [$select_require];
            }
        }
        return $rule;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        $length = count(request('passengers'));
        //乗船者行No分for分を回す
        for ($i = 1; $i <= $length; $i++) {
            $length_question = request('questions');
            //質問数分for分を回す
            for ($j = 1; $j <= $length_question; $j++) {
                $attributes["passengers.{$i}.answers.{$j}"] = "乗船者様No." . $i . "の質問" . $j;
            }
        }
        return $attributes;
    }

}