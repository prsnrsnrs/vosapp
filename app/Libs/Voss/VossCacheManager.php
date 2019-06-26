<?php

namespace App\Libs\Voss;


/**
 * VOSS キャッシュ管理クラスです。
 * Class VossCacheManager
 * @package App\Libs\Voss
 */
class VossCacheManager
{
    /**
     * キャッシュに保存します。
     *
     * @param string $key
     * @param mixed $value
     * @param string|int|null $savetime
     * @return bool
     */
    public static function set($key, $value, $savetime = null)
    {
        $savetime = is_null($savetime) ? config('cache.savetime') : $savetime;
        if ($savetime === 'forever') {
            \Cache::forever($key, $value);
        } else {
            \Cache::put($key, $value, $savetime);
        }
    }

    /**
     * キャッシュを取得します。
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return \Cache::get($key, $default);
    }

    /**
     * 指定されたキーのキャッシュ情報が存在するかチェックします。
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return \Cache::has($key);
    }

    /**
     * キャッシュを削除します。
     *
     * @param string|array $keys
     */
    public static function forget($keys)
    {
        $keys = is_array($keys) ? $keys : [$keys];
        foreach ($keys as $key) {
            \Cache::forget($key);
        }
    }

    /**
     * キャッシュ全体を削除します。
     */
    public static function flush()
    {
        \Cache::flush();
    }
}