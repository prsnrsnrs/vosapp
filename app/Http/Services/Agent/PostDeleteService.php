<?php

namespace App\Http\Services\Agent;


use App\Http\Services\BaseService;
use App\Operations\AgentListDeleteOperation;

/**
 * 旅行社販売店を削除するサービスです。
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
        // 旅行社販売店削除ソケット
        $operation = new AgentListDeleteOperation();
        $operation->setCode(request('agent_code'));
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
        }
        $this->response_data['redirect'] = ext_route('list');
    }

}