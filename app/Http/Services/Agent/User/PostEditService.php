<?php
namespace App\Http\Services\Agent\User;
use App\Http\Services\BaseService;
use App\Operations\AgentUserInsertOperation;
use App\Operations\AgentUserUpdateOperation;

/**
 * ユーザー作成・編集用のサービスです。
 * Class PostEditService
 * @package App\Http\Services\Agent\User
 */
class PostEditService extends BaseService
{

    /**
     *ユーザー作成・編集
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        if(request()->has('is_edit')){
            // 変更ソケット
            $this->setUpdateSocket();
        }else{
            // 登録ソケット
            $this->setInsertSocket();
            }
        $this->response_data['redirect'] = ext_route('detail', ['agent_code' => request('agent_code')]);
    }

    /**
     * 登録用ソケット
     * @return bool
     * @throws \Exception
     */
    private function setInsertSocket()
    {
        $ret = true;
        $operation = new AgentUserInsertOperation();
        $operation->setUserId(request('user_id'));
        $operation->setUserName(request('user_name'));
        $operation->setUserType(request('user_type'));
        $operation->setLoginType(request('login_type'));
        $operation->setPassword(request('password'));
        $operation->setAgentCode(request('agent_code'));

        $result = $operation->execute();
        //エラー
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            $ret = false;
        }
        return $ret;
    }

    /**
     * 変更用ソケット
     * @return bool
     * @throws \Exception
     */
    private function setUpdateSocket()
    {
        $ret = true;
        $operation = new AgentUserUpdateOperation();
        $operation->setAgentUserNumber(request('agent_user_number'));
        $operation->setUserName(request('user_name'));
        $operation->setUserType(request('user_type'));
        $operation->setLoginType(request('login_type'));
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        $operation->setAgentCode(request('agent_code'));
        $result = $operation->execute();
        //エラー
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            $ret = false;
        }
        return $ret;
    }
}