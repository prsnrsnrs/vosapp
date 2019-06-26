<?php

namespace App\Http\Middleware;

use Closure;

/**
 * UPLサーバーで動作するアプリケーションの制御
 * Class VossUpl
 * @package App\Http\Middleware
 */
class VossUpl
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

        if ($app_env === "web" || $app_env === "aps") {
            //404エラーを返す
            return abort(404);
        }
        return $next($request);
    }
}