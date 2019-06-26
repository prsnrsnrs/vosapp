<?php

namespace App\Http\Services\Login;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\AgentLoginOperation;
use App\Queries\AuthQuery;
use function request;


/**
 * ログインの認証サービスです
 * Class PostLoginService
 * @package App\Http\Services\Login
 */
class PostAgentLoginService extends BaseService
{

    public function execute()
    {
        // 販売店認証情報の取得
        $auth = $this->getAuthQuery();
        if (!$auth) {
            $this->setErrorMessage(config('messages.error.E010-0101'));
            return;
        }

        // 旅行者ログインソケット
        $operation = new AgentLoginOperation();
        $operation->setCommonTravelCompanyCode($auth['travel_company_code']);
        $operation->setCommonAgentCode($auth['agent_code']);
        $operation->setCommonAgentUserNumber($auth['agent_user_number']);
        $operation->setPassword(request('password'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }

        // ログイン時のみセッションIDを再発行する
        \Request::session()->regenerate();
        VossSessionManager::set('auth', $auth);
        $this->response_data['redirect'] = ext_route('mypage');

    }

    /**
     * 認証情報を取得します
     * @return array|string
     */
    public function getAuthQuery()
    {
        $query = new AuthQuery();
        $result = $query->getAgentLoginData(request('store_id'), request('user_id'), request('password'));
        return $result;
    }
}