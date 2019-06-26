<?php
namespace App\Operations;
/**
 * 旅行社販売店ユーザー変更ソケット用Operation
 * Class AgentUserUpdateOperation
 * @package App\Operations
 */
class AgentUserUpdateOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('262');
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
     * ユーザー名称をセットします。
     * @param $user_name
     * @throws \Exception
     */

    public function setUserName($user_name)
    {
        $this->set(42, 48, $user_name);
    }

    /**
     * ユーザー区分をセットします。
     * @param $user_type
     * @throws \Exception
     */

    public function setUserType($user_type)
    {
        $this->set(1, 90, $user_type);
    }

    /**
     * ログイン区分をセットします。
     * @param $login_type
     * @throws \Exception
     */

    public function setLoginType($login_type)
    {
        $this->set(1, 91, $login_type);
    }

    /**
     * 最終更新日時をセットします。
     * @param $last_update_date_time
     * @throws \Exception
     */

    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 92, $last_update_date_time);
    }

    /**販売店コードをセットします
     * @param $agent_code
     * @throws \Exception
     */
    public function setAgentCode($agent_code)
    {
        $this->set(7, 106, $agent_code);
    }
}