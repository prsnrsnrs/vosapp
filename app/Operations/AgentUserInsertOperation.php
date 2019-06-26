<?php
namespace App\Operations;

/**
 * 旅行社販売店ユーザー登録ソケット用Operation
 * Class AgentUserInsertOperation
 * @package App\Operations
 */
class AgentUserInsertOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('261');
    }

    /**
     *  ユーザーIDをセットします
     * @param $user_id
     * @throws \Exception
     */

    public function setUserId($user_id)
    {
        $this->set(12, 43, $user_id);
    }

    /**
     * ユーザー名称をセットします。
     * @param $user_name
     * @throws \Exception
     */

    public function setUserName($user_name)
    {
        $this->set(42, 55, $user_name);
    }

    /**
     * ユーザー区分をセットします。
     * @param $user_type
     * @throws \Exception
     */

    public function setUserType($user_type)
    {
        $this->set(1, 97, $user_type);
    }

    /**
     * ログイン区分をセットします。
     * @param $login_type
     * @throws \Exception
     */

    public function setLoginType($login_type)
    {
        $this->set(1, 98, $login_type);
    }

    /**
     * パスワードをセットします。
     * @param $password
     * @throws \Exception
     */

    public function setPassword($password)
    {
        $this->set(12, 99, $password);
    }

    /**
     * 販売店コードをセットします
     * @param $agent_code
     * @throws \Exception
     */
    public function setAgentCode($agent_code)
    {
        $this->set(7, 111, $agent_code);
    }
}