<?php

namespace App\Http\Services\User;

use App\Http\Services\BaseService;
use App\Operations\UserPasswordResetCompleteOperation;

/**
 * パスワード再設定サービスです。
 * Class PostPasswordResetService
 * @package App\Http\Services\Agent
 */
class PostPasswordResetService extends BaseService
{
    /**
     * 処理を実行します。
     * @return void
     */
    public function execute()
    {
        $mail_auth = $this->getAccessibleMailAuth(request('auth_key'), config('const.mail_operation_code.value.password_reset'));
        $operation = new UserPasswordResetCompleteOperation();
        $operation->setMailSendInstructionNumber($mail_auth['mail_send_instruction_number']);
        $operation->setPassword(request('password'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
        }
        $this->response_data['message'] = config('messages.alert.A320-0101');
        $this->response_data['redirect'] = ext_route('login');
    }
}