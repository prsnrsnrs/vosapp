<?php

namespace App\Http\Services\Agent;

use App\Http\Services\BaseService;
use App\Operations\AgentUpdateOperation;
use App\Operations\AgentInsertOperation;

/**
 * 販売店登録処理のビジネスロジックです。
 * Class PostEditService
 * @package App\Http\Services\Agent
 */
class PostEditService extends BaseService
{
    /**
     * 販売店情報登録処理
     */
    public function execute()
    {
        if (request()->has('is_edit')) {
            // 販売店変更ソケット
            if ($this->setUpdateSocket()) {
                $this->response_data['redirect'] = ext_route('list');
            }
        } else {
            // 販売店登録ソケット
            if ($this->setInsertSocket()) {
                $this->response_data['redirect'] = ext_route('user.edit', ['agent_code' => request('agent_code')]);
            }
        }
    }

    /**
     * 販売店登録ソケット
     * @return bool
     * @throws \Exception
     */

    private function setInsertSocket()
    {
        $ret = true;
        $operation = new AgentInsertOperation();
        $operation->agentCode(request('agent_code'));
        $operation->agentName(request('agent_name'));
        $operation->zipCode(request('zip_code'));
        $operation->prefectureCode(request('prefecture_code'));
        $operation->address1(request('address1'));
        $operation->address2(request('address2'));
        $operation->address3(request('address3'));
        $operation->tel(request('tel'));
        $operation->faxNumber(request('fax_number'));
        $operation->mailAddress1(request('mail_address1'));
        $operation->mailAddress2(request('mail_address2'));
        $operation->mailAddress3(request('mail_address3'));
        $operation->mailAddress4(request('mail_address4'));
        $operation->mailAddress5(request('mail_address5'));
        $operation->mailAddress6(request('mail_address6'));
        $operation->agent_type(request('agent_type'));
        $operation->loginType(request('login_type'));
        $result = $operation->execute();

        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            $ret = false;
        }
        return $ret;
    }

    /**
     * 販売店変更ソケット
     * @return bool
     * @throws \Exception
     */
    private function setUpdateSocket()
    {
        $ret = true;
        $operation = new AgentUpdateOperation();
        $operation->agentCode(request('agent_code'));
        $operation->agentName(request('agent_name'));
        $operation->zipCode(request('zip_code'));
        $operation->prefectureCode(request('prefecture_code'));
        $operation->address1(request('address1'));
        $operation->address2(request('address2'));
        $operation->address3(request('address3'));
        $operation->tel(request('tel'));
        $operation->faxNumber(request('fax_number'));
        $operation->mailAddress1(request('mail_address1'));
        $operation->mailAddress2(request('mail_address2'));
        $operation->mailAddress3(request('mail_address3'));
        $operation->mailAddress4(request('mail_address4'));
        $operation->mailAddress5(request('mail_address5'));
        $operation->mailAddress6(request('mail_address6'));
        $operation->agentType(request('agent_type'));
        $operation->loginType(request('login_type'));
        $operation->lastUpdateDateTime(request('last_update_date_time'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            $ret = false;
        }
        return $ret;
    }

}