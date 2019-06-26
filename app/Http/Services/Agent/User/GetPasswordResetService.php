<?php

namespace App\Http\Services\Agent\User;

use App\Http\Services\BaseService;

/**
 * 販売代理店のパスワードリセット画面のサービスクラスです。
 * Class GetPasswordResetService
 * @package App\Http\Services\Agent\User
 */
class GetPasswordResetService extends BaseService
{
    /**
     * サービスクラスの処理を実行します。
     */
    public function execute()
    {
        $mail_auth = $this->getAccessibleMailAuth(request('auth_key'), config('const.mail_operation_code.value.agent_password_reset'));
        $this->response_data['mail_auth'] = $mail_auth;
    }
}