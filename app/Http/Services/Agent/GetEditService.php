<?php

namespace App\Http\Services\Agent;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Queries\AddressQuery;
use App\Queries\AgentQuery;


/**
 * 販売店編集・新規登録のビジネスロジックです。
 * Class GetEditService
 * @package App\Http\Services\Agent
 */
class GetEditService extends BaseService
{
    /**
     * 実行メソッド
     */
    public function execute()
    {
        // 都道府県情報の取得
        $query = new AddressQuery();

        // 販売店情報の取得(編集時のみ)
        if (request()->has('agent_code')) {
            $this->getAgentData();
            $this->response_data['prefectures'] = $query->getPrefectures(request('agent_code'));
            $this->response_data['agent_title'] = "販売店編集";
        }else{
            //新規作成
            $this->response_data['prefectures'] = $query->getPrefectures();
            $this->response_data['agent_title'] = "販売店追加";
        }
    }

    /**
     * 販売店情報の取得
     */
    private function getAgentData()
    {
        $query = new AgentQuery();
        $travel_company_code = VossSessionManager::get('auth.travel_company_code');
        $this->response_data['agent_data'] = $query->getAgentData($travel_company_code, request('agent_code'));
    }
}