<?php

namespace App\Libs\Voss;


/**
 * VOSS専用 アクセス管理クラスです。
 * Class VossAccessManager
 * @package App\Libs\Voss
 */
class VossAccessManager
{

    /**
     * アクセスサイト名
     * @var string
     */
    private static $access_site;

    /**
     * routeのプレフィックス
     * @var
     */
    private static $route_prefix;

    /**
     * ログイン中かどうか返します。
     * @param array|null $auth 認証情報
     * @return bool
     */
    public static function isLogin($auth = null)
    {
        $auth = is_null($auth) ? self::getAuth() : $auth;
        return (bool)$auth;
    }

    /**
     * 販売店の管理者ユーザーか返します。
     * @param array|null $auth 認証情報
     * @return bool
     */
    public static function isAgentAdmin($auth = null)
    {
        $auth = is_null($auth) ? self::getAuth() : $auth;
        return array_get($auth, 'user_type') == config('const.user_type.value.admin');
    }

    /**
     * 管轄店かどうか返します。
     * @param array|null $auth 認証情報
     * @return bool
     */
    public static function isJurisdictionAgent($auth = null)
    {
        $auth = is_null($auth) ? self::getAuth() : $auth;
        return array_get($auth, 'agent_type') == config('const.agent_type.value.jurisdiction_agent');
    }

    /**
     * JTBの販売店かどうか返します。
     * @return bool
     */
    public static function isJTBAgent($auth = null)
    {
        $auth = is_null($auth) ? self::getAuth() : $auth;
        $travel_company_code = array_get($auth, 'travel_company_code');
        return in_array($travel_company_code, config('const.travel_company.jtb.code'));
    }

    /**
     * 販売店のアクセスかどうか返します。
     * @return bool
     */
    public static function isAgent()
    {
        return self::isAgentSite() || self::isAgentTestSite();
    }

    /**
     * 認証情報を返します。
     * @return mixed
     */
    public static function getAuth()
    {
        return VossSessionManager::get('auth');
    }

    /**
     * アクセス中のサイトが代理店向けかどうか返します。
     * @return bool
     */
    public static function isAgentSite()
    {
        return self::getAccessSite() === 'AGENT';
    }

    /**
     * アクセス中のサイトが代理店向けテストかどうか返します。
     * @return bool
     */
    public static function isAgentTestSite()
    {
        return self::getAccessSite() === 'AGENT_TEST';
    }

    /**
     * アクセス中のサイトがびぃなす倶楽部会員向けかどうか返します。
     * @return bool
     */
    public static function isVenusClubSite()
    {
        return self::getAccessSite() === 'VENUS_CLUB';
    }

    /**
     * アクセス中のサイトが商品メンテナンスかどうか返します。
     * @return bool
     */
    public static function isMaintenanceSite()
    {
        return self::getAccessSite() === 'MAINTENANCE';
    }

    /**
     * アクセス中のサイトがユーザー向けかどうか返します。
     * @return bool
     */
    public static function isUserSite()
    {
        return self::getAccessSite() === 'USER';
    }

    /**
     * アクセス中のサイトがモバイル向けかどうか返します。
     * @return bool
     */
    public static function isMobile()
    {
        // TODO:フェーズ2
        return true;
    }

    /**
     * アクセス中のサイトの文字列データを返します。
     * @return string
     */
    private static function getAccessSite()
    {
        if (!is_null(self::$access_site)) {
            return self::$access_site;
        }

        if (strpos(request()->path(), 'agent_test') === 0) {
            self::$access_site = 'AGENT_TEST';
        } elseif (strpos(request()->path(), 'agent') === 0) {
            self::$access_site = 'AGENT';
        } elseif (strpos(request()->path(), 'venus_club') === 0) {
            self::$access_site = 'VENUS_CLUB';
        } elseif (strpos(request()->path(), 'maintenance') === 0) {
            self::$access_site = 'MAINTENANCE';
        } else {
            self::$access_site = 'USER';
        }
        return self::$access_site;
    }

    /**
     * ルートのプレフィックスを返します。
     * @return string
     */
    public static function getRoutePrefix()
    {
        if (!is_null(self::$route_prefix)) {
            return self::$route_prefix;
        }

        $access_site = self::getAccessSite();
        if ($access_site === 'AGENT') {
            self::$route_prefix = 'agent.';
        } else if ($access_site === 'AGENT_TEST') {
            self::$route_prefix = 'agent_test.';
        } else if ($access_site === 'VENUS_CLUB') {
            self::$route_prefix = 'venus_club.';
        } else if ($access_site === 'MAINTENANCE') {
            self::$route_prefix = 'maintenance.';
        } else {
            self::$route_prefix = '';
        }
        return self::$route_prefix;
    }
}