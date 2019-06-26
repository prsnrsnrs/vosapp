<?php

namespace App\Libs;

use Carbon\Carbon;

/**
 * Class DateUtil
 * @package App\Libs
 */
class DateUtil
{

    /**
     * @var array
     */
    private static $weekdaylabel = array('日', '月', '火', '水', '木', '金', '土');

    /**
     * システム日付の年月から５ｹ月先迄取得
     * @return array
     */
    public static function getyymm5()
    {
        $ret = [];
        $years = date("Ym");
        $start = $years;
        $end = $years + 5;
        for ($i = $start; $i <= $end; $i++) {
            $str = substr($i, -2);  // 月を取得
            //月＋１＝１３月なら年＋１
            if ($str == 13) {
                $i = ($i + 100) - 12;
                $end = ($end + 100) - 12;
            }
            array_push($ret, $i);
        }
        return $ret;
    }

    /**
     * システム日付の年月から１２ｹ月前
     * @return array
     */
    public static function getyymm12()
    {
        $ret = [];
        $years = date("Ym");
        $start = $years;
        for ($i = 1; $i < 14; $i++) {
            $str = substr($start, -2);  // 月を取得
            if ($str == 00) {
                $start = ($start - 100) + 12;
            }
            array_push($ret, $start);
            $start = $start - 1;
        }
        return $ret;
    }

    /**
     * システム日付の日付文字列を返します。
     * @param string $format
     * @return false|string
     */
    public static function now($format = 'Ymd')
    {
        return date($format);
    }

    /**
     * システム日付の日付・時間文字列を返します。
     * @param string $format
     * @return false|string
     */
    public static function nowDateTime($format = 'YmdHis')
    {
        return date($format);
    }

    /**
     * システム日付の翌日の日付文字列を返します。
     * @param string $format
     * @return string
     */
    public static function getTomorrow($format = 'Ymd')
    {
        return Carbon::now()->addDay(1)->format($format);
    }

    /**
     * システム日付から1ヶ月前の日付文字列を返します。
     * @param string $format
     * @return string
     */
    public static function getOneMonthBefore($format = 'Ymd')
    {
        return Carbon::now()->subMonth(1)->format($format);
    }

    /**
     * システム日付から2ヶ月前の日付文字列を返します。
     * @param string $format
     * @return string
     */
    public static function getTwoMonthBefore($format = 'Ymd')
    {
        return Carbon::now()->subMonth(2)->format($format);
    }

    /**
     * システム日付から3ヶ月前の日付文字列を返します。
     * @param string $format
     * @return string
     */
    public static function getThreeMonthBefore($format = 'Ymd')
    {
        return Carbon::now()->subMonth(3)->format($format);
    }


    /**
     * 曜日を返します。
     * @param mixed $date
     * @return string
     */
    public static function getYoubi($date)
    {
        if (!$date) {
            return "";
        }
        if (is_string($date)) {
            $date = self::removeFormatString($date);
        }
        $youbi = "";
        try {
            $youbi = self::$weekdaylabel[Carbon::parse($date)->dayOfWeek];
        } catch (\Exception $ex) {
        }
        return $youbi;
    }

    /**
     * 日付書式フォーマットを変換して返します。
     * @param mixed $date
     * @param string $format
     * @return string
     */
    public static function convertFormat($date, $format)
    {
        if (!$date) {
            return "";
        }
        if (is_string($date)) {
            $date = self::removeFormatString($date);
        }
        try {
            $date = Carbon::parse($date)->format($format);
        } catch (\Exception $ex) {
        }
        return $date;
    }

    /**
     * 日付書式文字列を削除します。
     * @param string $str
     * @return string
     */
    public static function removeFormatString($str)
    {
        return str_replace(array('年', '月', '日', '分', '秒'), '', $str);
    }

    /**
     * 現在の時刻から指定の時間 (分) 以内かどうか返します。
     * 1440分 (１日）以上は動作対象外。
     *
     * @param string $date
     * @param int $interval_minutes
     * @return bool
     */
    public static function isWithinIntervalMinutes($date, $interval_minutes = 30)
    {
        $ret = false;
        $now = new \DateTime();
        $datetime = new \DateTime($date);
        $interval = $now->diff($datetime);

        if ($interval->days == 0) {
            $ret = ($interval->h * 60 + $interval->i) < $interval_minutes;
        }
        return $ret;
    }
}