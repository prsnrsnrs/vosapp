<?php

namespace App\Operations;

/**
 * パスワード再設定用のOperationです。
 * Class AgentUserResettingPasswordOperation
 * @package App\Operations
 */
class AgentUserPasswordResetOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('264');
    }

    /**
     * メールアドレスをセットします。
     * @param $mail_address
     * @throws \Exception
     */

    public function setMailAddress($mail_address)
    {
        $this->set(80, 43, $mail_address);
    }

    /**
     * 認証キーをセットします。
     * @param $mail_auth_key
     * @throws \Exception
     */
    public function setMailAuthKey($mail_auth_key)
    {
        $this->set(16, 123, $mail_auth_key);
    }

    /**
     * 販売店コード を設定します。
     *
     * @param string $agent_code
     */
    public function setAgentCode($agent_code)
    {
        $this->set(7, 139, $agent_code);
    }

    /**
     * 販売店利用者No を設定します。
     *
     * @param string $agent_user_number
     */
    public function setAgentUserNumber($agent_user_number)
    {
        $this->set(5, 146, $agent_user_number, ['right' => false, 'padding' => '0']);
    }

}