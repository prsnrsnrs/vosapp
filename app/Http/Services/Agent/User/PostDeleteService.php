<?php

namespace App\Http\Services\Agent\User;
use App\Http\Services\BaseService;
use App\Operations\AgentUserDeleteOperation;

/**
 * 旅行社ユーザーを削除するサービスです。
 * Class PostDeleteService
 * @package App\Http\Services\Agent
 */
class PostDeleteService extends BaseService
{
    /**
     * 削除処理
     */
    public function execute()
    {
        // 旅行社販売店ユーザー削除ソケット
        $operation = new AgentUserDeleteOperation();
        $operation->setAgentUserNumber(request('agent_user_number'));
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        $operation->setAgentCode(request('agent_code'));
        $result = $operation->execute();

        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
        }
        $this->response_data['redirect'] = ext_route('detail',['agent_code' => request('agent_code')]);
    }
}