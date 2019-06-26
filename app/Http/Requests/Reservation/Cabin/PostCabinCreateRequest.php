<?php

namespace App\Http\Requests\Login;

use App\Http\Requests\BaseRequest;

/**
 * 客室人数選択：客室追加処理のリクエストパラメータを制御します。
 * Class LoginRequest
 * @package App\Http\Requests
 */
class PostCabinCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [];
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
            if (!$this->passngersValidation()) {
                $validator->errors()->add('cabin', config('messages.error.E050-0101'));
            }
        });
    }

    /**
     * 人数チェック
     * @return bool
     */
    private function passngersValidation()
    {
        $data = $this->all();
        for ($i = 0; $i < count($data['passengers']); $i++) {
            $adult = (int)$data['passengers'][$i]['adult'];
            $children = (int)$data['passengers'][$i]['children'];
            $infant = (int)$data['passengers'][$i]['child'];
            $total = $adult + $children + $infant;
            if ($total === 0) {
                return false;
            }
        }
        return true;
    }

}