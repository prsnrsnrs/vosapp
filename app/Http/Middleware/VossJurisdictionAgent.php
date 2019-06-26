<?php
/**
 * Created by PhpStorm.
 * User: ando-himiko
 * Date: 2017/12/11
 * Time: 10:18
 */

namespace App\Http\Middleware;


use App\Libs\Voss\VossAccessManager;
use Closure;
use Illuminate\Http\Request;

/**
 * 旅行社向け - 管轄店のアクセスチェック
 * Class VossJurisdictionAgent
 * @package App\Http\Middleware
 */
class VossJurisdictionAgent
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
        if (!VossAccessManager::isJurisdictionAgent()) {
            return abort(403);
        }
        return $next($request);
    }
}