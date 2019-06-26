<?php

namespace App\Http\Middleware;

use Closure;

/**
 * APSサーバーで動作するアプリケーションの制御
 * Class VossAps
 * @package App\Http\Middleware
 */
class VossAps
{
    /**
     * envファイルの設定を確認
     * @param $request
     * @param Closure $next
     * @return mixed|void
     */
    public function handle($request, closure $next)
    {
        //.env情報取得
        $app_env = getenv('APP_ENV');

        if ($app_env === "web" || $app_env === "upl") {
            //404エラーを返す
            return abort(404);
        }
        return $next($request);
    }
}