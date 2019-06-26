<?php

namespace App\Rules;

use App\Libs\StringUtil;
use Illuminate\Contracts\Validation\Rule;

/**
 * 桁数範囲のチェッククラスです。
 * シフトイン、シフトアウトを考慮したバイト数のチェックをします。
 *
 * Class BetweenSoSiByteLength
 * @package App\Rules
 */
class BetweenSoSiByteLength implements Rule
{
    /**
     * @var int
     */
    protected $min_length;

    /**
     * @var int
     */
    protected $max_length;

    /**
     * Create a new rule instance.
     *
     * @param int $length1
     * $param int $length2
     * @return void
     */
    public function __construct(int $length1, int $length2)
    {
        $this->min_length = min($length1, $length2);
        $this->max_length = max($length1, $length2);
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
        return $this->min_length <= $byte_length && $byte_length <= $this->max_length;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return str_replace([':min', ':max'], [$this->min_length, $this->max_length], config('messages.error.E000-0012'));
    }
}
