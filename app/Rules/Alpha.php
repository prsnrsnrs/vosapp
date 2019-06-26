<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 半角英字チェッククラスです。
 *
 * Class AlphaNumber
 * @package App\Rules
 */
class Alpha implements Rule
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
        return !preg_match('/[^a-zA-Z]/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('messages.error.E000-0006');
    }
}
