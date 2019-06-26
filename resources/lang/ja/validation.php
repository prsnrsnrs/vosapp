<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "alpha" => config('messages.error.E000-0006'),
    "alpha_num" => config('messages.error.E000-0011'),
    "between" => array(
        "string" => config('messages.error.E000-0012'),
        "array" => config('messages.error.E000-0020'),
    ),
    "date" => config('messages.error.E000-0017'),
    "digits" => config('messages.error.E000-0015'),
    "email" => config('messages.error.E000-0005'),
    "integer" => config('messages.error.E000-0018'),
    "min" => array(
        "numeric" => config('messages.error.E000-0021'),
        "array" => config('messages.error.E000-0021'),
        "file" => config('messages.error.E000-0019'),
    ),
    "mimes" => config('messages.error.E000-0013'),
    "numeric" => config('messages.error.E000-0014'),
    "required" => config('messages.error.E000-0001'),
    "required_if" => config('messages.error.E000-0001'),
    "same" => config('messages.error.E000-0016'),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'password' => 'パスワード',
        'store_id' => '販売店ログインID',
        'user_id' => 'ユーザーID',
    ],




];