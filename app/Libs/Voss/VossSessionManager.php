<?php

namespace App\Libs\Voss;


/**
 * VOSS専用 セッション管理クラスです。
 * アクセスするサイトごとにセッションを管理する仕組みを提供します。
 * 原則、このクラスを経由してセッション情報にアクセスします。
 *
 * Class AccessManagement
 * @package App\Libs\Voss
 */
class VossSessionManager
{

    /**
     * @var string
     */
    private static $prefix = '';

    /**
     * セッションに保存します。
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        \Session::put(self::getKey($key), $value);
    }

    /**
     * 指定されたキーのセッション情報を返します。
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return \Session::get(self::getKey($key), $default);
    }

    /**
     * 指定されたキーのセッション情報が存在するかチェックします。
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return \Session::has(self::getKey($key));
    }

    /**
     * 指定されたキーのセッション情報を削除します。
     * @param $key
     */
    public static function forget($key)
    {
        \Session::forget(self::getKey($key));
    }

    /**
     * 全セッション情報を削除します。
     * ※ 別サイトのセッション情報は削除しません。
     */
    public static function flush()
    {
        \Session::forget(self::getPrefix());
    }

    /**
     * VOSSに関係する全サイトのセッション情報を削除します。
     */
    public static function flushForAllSites()
    {
        \Session::flush();
    }

    /**
     * プレフィックス付きのキー情報を取得します。
     * @param $key
     * @return string
     */
    private static function getKey($key)
    {
        return self::getPrefix() . '.' . $key;
    }

    /**
     * プレフィックス文字列を返します。
     * @return string
     */
    private static function getPrefix()
    {
        if (self::$prefix) {
            return self::$prefix;
        }

        if (VossAccessManager::isAgentSite()) {
            self::$prefix = 'agent';
        } elseif (VossAccessManager::isAgentTestSite()) {
            self::$prefix = 'agent_test';
        } elseif (VossAccessManager::isVenusClubSite()) {
            self::$prefix = 'venus_club';
        } elseif (VossAccessManager::isMaintenanceSite()) {
            self::$prefix = 'maintenance';
        } else {
            self::$prefix = 'user';
        }
        return self::$prefix;
    }
}