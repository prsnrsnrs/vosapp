<?php

namespace App\Libs;

class StringUtil
{
    const SO = "\x0E"; // シフトアウト文字
    const SI = "\x0F"; // シフトイン文字
    const DELIMITER_HALF_SPACE_DB_CHAR = "HSP"; // 半角スペース区切り文字のDB用の特殊変換文字

    /**
     * 電話番号、金額など数字系の文字列を全角から半角に変換します。
     *
     * @param  string $str
     * @return string
     */
    public static function numberFullToHalf($str)
    {
        $str = str_replace("‐", "-", $str);
        $str = str_replace("−", "-", $str);
        $str = str_replace("ー", "-", $str);
        $str = str_replace("—", "-", $str);
        $str = str_replace("．", ".", $str);
        return mb_convert_kana($str, "n", "utf-8");
    }

    /**
     * 英数字を全角から半角に変換します。
     *
     * @param  string $str
     * @return string
     */
    public static function alnumFullToHalf($str)
    {
        return mb_convert_kana($str, "a", "utf-8");
    }

    /**
     * 空と判断できる値をNullに変換します。
     * 空以外はそのまま返します。
     *
     * @param string $str
     * @return null|string
     */
    public static function emptyToNull($str)
    {
        if ($str == '' or $str == null) {
            $str = null;
        }
        return $str;
    }

    /**
     * 空と判断できる文字列を0に変換します。
     * 空以外はそのまま返します。
     *
     * @param string $str
     * @return int|string
     */
    public static function emptyToZero($str)
    {
        if ($str == '' or $str == null) {
            $str = 0;
        }
        return $str;
    }

    /**
     * 空と判断できる文字列を指定の値に変換します。
     * 空以外はそのまま返します。
     *
     * @param string $str
     * @param mixed $value
     * @return mixed
     */
    public static function emptyToVal($str, $value)
    {
        if ($str == '' or $str == null) {
            $str = $value;
        }
        return $str;
    }

    /**
     * 0を空文字にして返します。
     * 0以外はそのまま返します。
     *
     * @param string $str
     * @return string
     */
    public static function zeroToEmpty($str)
    {
        if ($str == '0') {
            $str = '';
        }
        return $str;
    }

    /**
     * 数値を３桁カンマ区切り＋”円”に変換します。
     *
     * @param string|int @param
     * @return string
     */
    public static function numToYen($str)
    {
        return number_format($str) . "円";
    }

    /**
     * 全角カナ、ひらがなを半角カナに変換します。
     *
     * @param string $str
     * @return string
     */
    public static function convertHankakuKana($str)
    {
        return mb_convert_kana($str, 'hksa', 'utf-8');
    }

    /**
     * 半角カナを全角カナに変換します。
     *
     * @param string $str
     * @return string
     */
    public static function convertZenkakuKana($str)
    {
        return mb_convert_kana($str, 'KVCS', 'utf-8');
    }

    /**
     * 半角カナを全角カナに変換します。
     *
     * @param string $str
     * @return string
     */
    public static function convertOnlyZenkakuKana($str)
    {
        return mb_convert_kana($str, 'KVS', 'utf-8');
    }


    /**
     * 全角,半角カタカナをひらがなに変換します。
     *
     * @param string $str
     * @return string
     */
    public static function convertHiragana($str)
    {
        return mb_convert_kana($str, 'HcVS', 'utf-8');
    }

    /**
     * UTF8からSJISに変換します。
     *
     * @param string|array $param
     * @return string|array
     */
    public static function utf8ToSjis($param)
    {
        if (is_array($param)) {
            $ret = [];
            foreach ($param as $key => $value) {
                $ret[$key] = self::utf8ToSjis($value);
            }
        } else {
            $ret = mb_convert_encoding($param, "sjis-win", "utf-8");
        }
        return $ret;
    }

    /**
     * SJISからUTF8に変換します。
     *
     * @param string|array $param
     * @return string|array
     */
    public static function sjisToUtf8($param)
    {
        if (is_array($param) || is_object($param)) {
            $ret = [];
            foreach ($param as $key => $value) {
                $ret[strtolower($key)] = self::sjisToUtf8($value);
            }
        } else {
            $ret = mb_convert_encoding($param, "utf-8", "sjis-win");
        }
        return $ret;
    }

    /**
     * SO/SIを含むSJIS文字列を返します。
     *
     * @param string $str
     * @return string
     */
    public static function utf8ToSosi($str)
    {
        return self::sjisToSosi(self::utf8ToSjis($str));
    }

    /**
     * SO/SIを含むSJIS文字列を返します。
     *
     * @param string $sjis
     * @return string
     */
    public static function sjisToSosi($sjis)
    {
        $result = '';
        $sosi_flag = false;
        for ($i = 0, $len = mb_strlen($sjis, 'sjis-win'); $i < $len; $i++) {
            $char = mb_substr($sjis, $i, 1, 'sjis-win');
            if (strlen($char) > 1) {
                if (!$sosi_flag) {
                    $sosi_flag = true;
                    $result .= self::SO;
                }
            } else {
                if ($sosi_flag) {
                    $sosi_flag = false;
                    $result .= self::SI;
                }
            }
            $result .= $char;
        }
        if ($sosi_flag) {
            $result .= self::SI;
        }
        return $result;
    }

    /**
     * 認証キーを作成します。
     *
     * @return string
     */
    public static function generateKey()
    {
        return substr(md5(microtime()), 0, 16);
    }

    /**
     * 「"」をtrimします。
     *
     * @param string $str
     * @return string
     */
    public static function doubleQuoteTrim($str)
    {
        $buf = trim($str);
        $buf = trim($buf, '"');
        return $buf;
    }

    /**
     * 多バイト文字判定をします。
     *
     * @param string $str 対象文字列
     * @param string $encoding エンコーディング(デフォルト)
     * @return bool
     */
    public static function isIncludeMb($str, $encoding = "UTF-8")
    {
        // バイト数と文字数を比較
        return strlen($str) != mb_strlen($str, $encoding);
    }

    /**
     * 指定文字列に禁止文字が含まれていた場合 "^^" に置き換える
     * 含まれていない場合、引数をそのまま返す
     *
     * @param string $str
     * @return string
     */
    public static function replaceBadChar($str, $encoding = "UTF-8")
    {
        $badChar = mb_convert_encoding(",^\'\\~\"①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳纃㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟㏍㊤㊥㊦㊧㊨㈲㈹㍾㍽㍼∮∑∟⊿〝〟><", $encoding, "UTF-8");

        // 対象文字列を走査
        for ($i = 0; $i < mb_strlen($str); $i++) {

            // チェック対象文字
            $c = mb_substr($str, $i, 1);

            // badCharチェック
            for ($j = 0; $j < mb_strlen($badChar); $j++) {
                if ($c == mb_substr($badChar, $j, 1)) {
                    return "^^";
                }
            }
        }

        return $str;
    }

    /**
     * DB2用に文字列をエスケープします。
     *
     * @param string $str 対象文字列
     * @return string エスケープ後の文字列
     */
    public static function escapeDb2String($str)
    {
        return preg_replace("/\\\\'/", "''", addslashes($str));
    }

    /**
     * 半角カタカナ小文字を大文字に変換します。
     *
     * @param string $str
     * @return string
     */
    public static function hankakuKanaToUpper($str)
    {
        $pattern = array('ｧ', 'ｨ', 'ｩ', 'ｪ', 'ｫ', 'ｯ', 'ｬ', 'ｭ', 'ｮ');
        $replacement = array('ｱ', 'ｲ', 'ｳ', 'ｴ', 'ｵ', 'ﾂ', 'ﾔ', 'ﾕ', 'ﾖ');
        return str_replace($pattern, $replacement, $str);
    }

    /**
     * 長音および類似する記号を半角ハイフンに変換します。
     *
     * @param string $str
     * @return string
     */
    public static function convertHankakuHyphen($str)
    {
        return preg_replace('/[\\-ｰー‐－―]/u', '-', $str);
    }

    /**
     * 文字列の空白文字を除外します。
     *
     * @param string $str
     * @return string
     */
    public static function deleteSpace($str)
    {
        return str_replace(array('　', ' '), '', $str);
    }

    /**
     * 全角半角スペースをトリムします。
     *
     * @param string $str
     * @return string
     */
    public static function trim($str)
    {
        $str = preg_replace('/^[ 　]+/u', '', $str);
        $str = preg_replace('/[ 　]+$/u', '', $str);
        return $str;
    }

    /**
     * Web側の区切り文字をi5DBの文字に変換します。
     *
     * @param string $delimiter
     * @return string
     */
    public static function convertWebDelimiterToI5DBChar($delimiter)
    {
        if ($delimiter === ' ') {
            return self::DELIMITER_HALF_SPACE_DB_CHAR;
        }
        return $delimiter;
    }

    /**
     * i5DB側の区切り文字をWeb用の文字に変換します。
     *
     * @param string $delimiter
     * @return string
     */
    public static function convertI5DBDelimiterToWeb($delimiter)
    {
        if ($delimiter === self::DELIMITER_HALF_SPACE_DB_CHAR) {
            return ' ';
        }
        return $delimiter;
    }

    /**
     * 文字数で分割した配列を返します。
     * @param string $str
     * @param int $len
     * @return array
     */
    public static function explodeByLength($str, $len)
    {
        $ret = [];
        $str_len = mb_strlen($str);
        for ($start = 0; $start < $str_len; $start += $len) {
            $ret[] = mb_substr($str, $start, $len);
        }
        return $ret;
    }

    /**
     * ダウンロードファイル名を生成して返します。
     * IE & Edgeでファイル名が日本語が文字化けする問題が解決できます。
     * @param $file_name
     * @return string
     */
    public static function downloadFileName($file_name)
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (strstr($ua, 'Trident') || strstr($ua, 'MSIE') || strstr($ua, 'Edge')) {
            $file_name = rawurlencode($file_name);
        }
        return $file_name;
    }
}
