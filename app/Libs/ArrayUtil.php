<?php

namespace App\Libs;

/**
 * Class ArrayUtil
 * @package App\Libs
 */
class ArrayUtil
{

    /**
     * 配列の value を文字列データに結合し、一致する部分のみを抽出した文字列を返します。
     * @param array
     * @return string
     */
    public static function matchingValue(array $arr) {
        $collection = collect($arr);
        return $collection->reduce(function ($prev, $item) {
            $new = StringUtil::deleteSpace(implode($item));
            if (is_null($prev)) {
                return $new;
            }
            $length = min(mb_strlen($prev), mb_strlen($new));
            //マルチバイト文字列を配列に変換
            $arr_prev = preg_split("//u", $prev, -1, PREG_SPLIT_NO_EMPTY);
            $arr_new = preg_split("//u", $new, -1, PREG_SPLIT_NO_EMPTY);

            $matching = "";
            for ($i = 0; $i < $length; $i++) {
                if ($arr_prev[$i] === $arr_new[$i]) {
                    $matching .= $arr_prev[$i];
                } else {
                    break;
                }
            }
            return $matching;
        });
    }

    /**
     * 配列内の全データをトリムします。
     * @param array $arr
     * @return mixed
     */
    public static function trim(array $arr)
    {
        return self::mapRecursive('\App\Libs\StringUtil::trim', $arr);
    }

    /**
     * 配列の要素を再帰的に呼び出して関数を実行します。
     * @param string $function
     * @param array $data
     * @return mixed
     */
    public static function mapRecursive($function, array $arr)
    {
        $ret = [];
        foreach ($arr as $i => $item) {
            $ret[$i] = is_array($item) ? self::mapRecursive($function, $item) : $function($item);
        }
        return $ret;
    }
}

