<?php
/**
 * Created by PhpStorm.
 * User: kita-kouichi
 * Date: 2017/12/14
 * Time: 17:55
 */

namespace App\Http\Middleware;


use App\Libs\Voss\VossAccessManager;
use Closure;
use Illuminate\Http\Request;

/**
 * 旅行社向け - 管理者のアクセスチェック
 * Class VossAdminAgent
 * @package App\Http\Middleware
 */
class VossAdminAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!VossAccessManager::isAgentAdmin()) {
            return abort(403);
        }
        return $next($request);
    }
}