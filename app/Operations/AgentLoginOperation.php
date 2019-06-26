<?php

namespace App\Operations;

/**
 * 旅行社ログインのソケットメッセージクラスです。
 * @package App\Operations
 */
class AgentLoginOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('211');
    }

    /**
     * 要求パラメータ パスワードをセットします。
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->set(12, 43, $password);
    }

}