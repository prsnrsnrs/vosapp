<?php

namespace App\Operations;
/**
 * 旅行社販売店ユーザーパスワード再設定完了ソケットのメッセージクラスです
 * Class AgentUserPasswordResetCompleteOperation
 * @package App\Operations
 */
class AgentUserPasswordResetCompleteOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('265');
    }

    /**
     * メール送信指示Noをセットします。
     * @param $mail_send_instruction_number
     */
    public function setMailSendInstructionNumber($mail_send_instruction_number)
    {
        $this->set(11, 43, $mail_send_instruction_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * パスワードをセットします。
     * @param $password
     */
    public function setPassword($password)
    {
        $this->set(12, 54, $password);
    }
}