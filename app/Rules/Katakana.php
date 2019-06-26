<?php

namespace App\Rules;

use App\Libs\StringUtil;
use Illuminate\Contracts\Validation\Rule;

/**
 * カタカナチェッククラスです。
 * 全角カタカナに変換してから、カタカナ, ー, スペースのチェックをします。
 *
 * Class Katakana
 * @package App\Rules
 */
class Katakana implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $katakana = StringUtil::convertZenkakuKana($value);
        return !preg_match("/[^ァ-ヶー　]/u", $katakana);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('messages.error.E000-0009');
    }
}
