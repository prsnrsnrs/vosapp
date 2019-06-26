<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * パスワードのチェッククラスです。
 *
 * Class Password
 * @package App\Rules
 */
class Password implements Rule
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
        return !preg_match('/[^#\$%\&\(\)=\{\}\*:\+_\?\.<\-\/@;>!\|\[\]a-zA-Z0-9]/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('messages.error.E000-0022');
    }
}
