<?php

namespace App\Rules;

use App\Libs\StringUtil;
use Illuminate\Contracts\Validation\Rule;

/**
 * 桁数一致のチェッククラスです。
 * シフトイン、シフトアウトを考慮したバイト数のチェックをします。
 *
 * Class SizeSoSiByteLength
 * @package App\Rules
 */
class SizeSoSiByteLength implements Rule
{
    /**
     * @var int
     */
    protected $size;

    /**
     * Create a new rule instance.
     *
     * @param int $max_length
     * @return void
     */
    public function __construct(int $size)
    {
        $this->size = $size;
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
        if ((string)$value === "") {
            return true;
        }
        $byte_length = strlen(StringUtil::utf8ToSosi($value));
        return $byte_length === $this->size;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return str_replace(':size', $this->size, config('messages.error.E000-0015'));
    }
}
