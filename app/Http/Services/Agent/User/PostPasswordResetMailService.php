<?php

namespace App\Http\Services\Agent\User;
use App\Http\Services\BaseService;
use App\Libs\StringUtil;
use App\Operations\AgentUserPasswordResetOperation;

/**
 * パスワード再設定メール送信サービスです。
 * Class PostPasswordResetMailService
 * @package App\Http\Services\Agent
 */
class PostPasswordResetMailService extends BaseService
{
    /**
     * 実行メソッド
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->setResetSocket($this->getMailKey())) {
            return;
        }
        $this->setRedirectSuccessMessage(str_replace('{0}', request('mail_address'),
            config('messages.info.I220-0101')));
        $this->response_data['redirect'] = ext_route('detail', ['agent_code' => request('agent_code')]);
    }

    /**
     * 認証キー取得
     * @return array
     */
    private function getMailKey()
    {
        while (empty($key)){
            $key = $this->createMailAuthKey(StringUtil::generateKey());
        }
        $key = $key['mail_auth_key'];
        return  $key;
    }

    /**
     * 旅行社販売店ユーザーパスワード再設定メール送信ソケット通信
     * @param $mailAuthKey
     * @return bool
     * @throws \Exception
     */
    private function setResetSocket($mailAuthKey)
    {
        $ret = true;
        $operation = new AgentUserPasswordResetOperation();
        $operation->setMailAddress(request('mail_address'));
        $operation->setMailAuthKey($mailAuthKey);
        $operation->setAgentCode(request('agent_code'));
        $operation->setAgentUserNumber(request('agent_user_number'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            $ret = false;
        }
        return $ret;
    }
}