<?php

namespace App\Http\Services\Login;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Operations\AgentLogoutOperation;


/**
 * ログアウトのサービスです
 * Class PostLoginService
 * @package App\Http\Services\Login
 */
class GetAgentLogoutService extends BaseService
{
    public function execute()
    {
        if (VossAccessManager::isLogin()) {
            $socket = new AgentLogoutOperation();
            $socket->execute();
        }
        VossSessionManager::flush();
        VossSessionManager::forget('_token');
    }
}