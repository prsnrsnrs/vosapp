<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\Voss\VossAccessManager;

/**
 * 販売店管理用のmiddlewareです。
 * 管轄店管理者ユーザーは販売店管理関連ページが閲覧可能
 * Class VossRequestOtherAgent
 * @package App\Http\Middleware
 */
class VossRequestOtherAgent
{
    public function handle($request,Closure $next)
    {
        $has_request = $request->has('agent_code');
        if ($has_request) {
            $agent_code = $request->get('agent_code');
            $auth = VossAccessManager::getAuth();
            $is_jurisdiction_admin = VossAccessManager::isJurisdictionAgent() &&
                VossAccessManager::isAgentAdmin();

            // 管轄店管理者以外は自販売店しか閲覧不可
            if (!$is_jurisdiction_admin &&
                $agent_code != array_get($auth, 'agent_code')
            ) {
                //エラーページ
                return abort(403);
            }
        }
        return $next($request);
    }
}