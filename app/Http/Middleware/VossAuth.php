<?php

namespace App\Http\Middleware;

use App\Libs\Voss\VossAccessManager;
use Closure;
use Illuminate\Http\Request;
use function redirect;
use function response;

/**
 * 旅行社向け、個人向け - ログイン認証チェック
 * Class VossAuth
 * @package App\Http\Middleware
 */
class VossAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!VossAccessManager::isLogin()) {
            if ($request->ajax()) {
                return response()->json(['forced_redirect' => ext_route('login')], 401);
            } else {
                return redirect()->to(ext_route('login'));
            }
        }
        return $next($request);
    }
}
