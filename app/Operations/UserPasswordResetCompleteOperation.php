<?php

namespace App\Operations;
/**
 * 個人パスワード忘れ再設定 (リセット) の変更ソケットのメッセージクラスです
 * Class UserPasswordResetCompleteOperation
 * @package App\Operations
 */
class UserPasswordResetCompleteOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('122');
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