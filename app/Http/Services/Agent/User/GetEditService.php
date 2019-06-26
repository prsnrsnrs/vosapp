<?php

namespace App\Http\Services\Agent\User;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Queries\AgentQuery;

class GetEditService extends BaseService
{
    /**
     * 実行メソッド
     */
    public function execute()
    {
        // 販売店情報の取得(編集時のみ)
        if (request()->has('agent_user_number')) {
            $this->getAgentData();
            $this->response_data['agent_user_title'] = "ユーザー編集";
        } else {
            $this->response_data['agent_user_title'] = "ユーザー作成";
        }
    }

    /**
     * 販売店情報の取得
     */
    private function getAgentData()
    {
        $query = new AgentQuery();
        $travel_company_code = VossSessionManager::get('auth.travel_company_code');
        $this->response_data['agent_user_data'] = $query->getUser($travel_company_code, request('agent_code'), request('agent_user_number'));
    }

}