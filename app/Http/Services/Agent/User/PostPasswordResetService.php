<?php

namespace App\Http\Services\Agent\User;

use App\Http\Services\BaseService;
use App\Operations\AgentUserPasswordResetCompleteOperation;

/**
 * パスワード再設定サービスです。
 * Class PostPasswordResetService
 * @package App\Http\Services\Agent
 */
class PostPasswordResetService extends BaseService
{
    /**
     * 実行メソッド
     * @return mixed|void
     */
    public function execute()
    {
        $mail_auth = $this->getAccessibleMailAuth(request('auth_key'), config('const.mail_operation_code.value.agent_password_reset'));
        $operation = new AgentUserPasswordResetCompleteOperation();
        $operation->setMailSendInstructionNumber($mail_auth['mail_send_instruction_number']);
        $operation->setPassword(request('password'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }
        $this->response_data['message'] = config('messages.alert.A320-0101');
        $this->response_data['redirect'] = ext_route('login');
    }
}