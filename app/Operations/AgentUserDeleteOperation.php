<?php
namespace App\Operations;

/**
 * 旅行社販売店ユーザー削除ソケット用Operation
 * Class AgentUserDeleteOperation
 * @package App\Operations
 */
class AgentUserDeleteOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('263');
    }

    /**
     * 販売店利用者Noをセットします。
     * @param $agent_user_number
     * @throws \Exception
     */

    public function setAgentUserNumber($agent_user_number)
    {
        $this->set(5, 43, $agent_user_number,['padding' => 0, 'right' => false]);
    }

    /**
     * 　確認更新日時をセットします。
     * @param $last_update_date_time
     * @throws \Exception
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 48, $last_update_date_time);
    }

    /**販売店コードをセットします
     * @param $agent_code
     * @throws \Exception
     */
    public function setAgentCode($agent_code)
    {
        $this->set(7, 62, $agent_code);
    }
}