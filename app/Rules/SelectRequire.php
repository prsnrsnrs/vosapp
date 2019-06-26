<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 選択必須のチェッククラスです。
 *
 * Class ArrayRequire
 * @package App\Rules
 */
class SelectRequire implements Rule
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
        return !($value ==="none");
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('messages.error.E000-0002');
    }
}
