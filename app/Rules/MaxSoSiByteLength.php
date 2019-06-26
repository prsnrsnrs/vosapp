<?php

namespace App\Rules;

use App\Libs\StringUtil;
use Illuminate\Contracts\Validation\Rule;

/**
 * 最大桁数のチェッククラスです。
 * シフトイン、シフトアウトを考慮したバイト数のチェックをします。
 *
 * Class MaxLength
 * @package App\Rules
 */
class MaxSoSiByteLength implements Rule
{
    /**
     * @var int
     */
    protected $max_length;

    /**
     * Create a new rule instance.
     *
     * @param int $max_length
     * @return void
     */
    public function __construct(int $max_length)
    {
        $this->max_length = $max_length;
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
        $byte_length = strlen(StringUtil::utf8ToSosi($value));
        return $byte_length <= $this->max_length;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('messages.error.E000-0007');
    }
}
