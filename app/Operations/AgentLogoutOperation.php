<?php

namespace App\Operations;

/**
 * 旅行社ログアウトのソケットメッセージクラスです。
 * @package App\Operations
 */
class AgentLogoutOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('212');
    }
}