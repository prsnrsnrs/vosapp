<?php

namespace App\Http\Services\Agent;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Queries\AgentQuery;

/**
 * 販売店情報、販売店ユーザー情報を表示します。
 * Class GetDetailService
 * @package App\Http\Services\Agent
 */
class GetDetailService extends BaseService
{
    /**
     * 販売店情報、ユーザー情報を取得するサービスです。
     * @return mixed|void
     */
    public function execute()
    {
        $query = new AgentQuery();
        $travel_company_code = VossSessionManager::get('auth.travel_company_code');
        $agent_code = VossSessionManager::get('auth.agent_code');

        if (request()->has('agent_code')) {
            //販売店一覧からの画面遷移時
            $this->getRequestAgentCode($query,$travel_company_code);
            //ユーザー数
            $countAgent = $query->countUserType($travel_company_code, request('agent_code'));
        }
        else{
            //マイページの<販売店情報とユーザーの管理>からの画面遷移時
            $this->getAuthAgentCode($query,$travel_company_code,$agent_code);
            //ユーザー数
            $countAgent = $query->countUserType($travel_company_code, $agent_code);
        }

        //ユーザー数:一般
        if(isset($countAgent['1']['record_count'])){
            $this->response_data['count_user'] = $countAgent['1']['record_count'];
        }else{
            $this->response_data['count_user'] =0;
        }
        //ユーザー数:管理者
        if(isset($countAgent['0']['record_count'])){
            $this->response_data['count_admin'] = $countAgent['0']['record_count'];
        }else{
            $this->response_data['count_admin'] = 0;
        }
    }

    /**
     * クエリを実行:販売店一覧からの画面遷移時
     * @param $query
     * @param $travel_company_code
     */
    private function getRequestAgentCode($query,$travel_company_code){
        //販売店情報
        $this->response_data['agent_data'] = $query->getAgentData($travel_company_code, request('agent_code'));
        //ユーザー情報
        $this->response_data['agent_user_data'] = $query->getUsers($travel_company_code, request('agent_code'));
    }

    /**
     * クエリを実行:マイページの<販売店情報とユーザーの管理>からの画面遷移時
     * @param $query
     * @param $travel_company_code
     * @param $agent_code
     */
    private function getAuthAgentCode($query,$travel_company_code,$agent_code){
        //販売店情報
        $this->response_data['agent_data'] = $query->getAgentData($travel_company_code, $agent_code);
        //ユーザー情報
        $this->response_data['agent_user_data'] = $query->getUsers($travel_company_code, $agent_code);
    }

}