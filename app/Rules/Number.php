<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 半角数字チェッククラスです。
 *
 * Class Number
 * @package App\Rules
 */
class Number implements Rule
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
        return !preg_match('/[^0-9]/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('messages.error.E000-0010');
    }
}
