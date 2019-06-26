<?php
namespace App\Operations;

/**
 * 旅行社販売店変更ソケットのメッセージクラスです。
 * Class AgentUpdateOperation
 * @package App\Operations
 */
class AgentUpdateOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('242');
    }

    /**
     * 販売店コードをセットします。
     * @param $code
     * @throws \Exception
     */
    public function agentCode($code)
    {
        $this->set(7, 43, $code);
    }

    /**
     * 販売店名をセットします。
     * @param $name
     * @throws \Exception
     */
    public function agentName($name)
    {
        $this->set(72, 50, $name);
    }

    /**
     * 郵便番号をセットします。
     * @param $zip_code
     * @throws \Exception
     */
    public function zipCode($zip_code)
    {
        $this->set(7, 122, $zip_code);
    }

    /**
     * 都道府県コードをセットします。
     * @param $prefecture_code
     * @throws \Exception
     */
    public function prefectureCode($prefecture_code)
    {
        $this->set(2, 129, $prefecture_code,['padding' => 0, 'right' => false]);
    }

    /**
     * 住所１をセットします。
     * @param $address1
     * @throws \Exception
     */
    public function address1($address1)
    {
        $this->set(102, 131, $address1);
    }

    /**
     * 住所２をセットします。
     * @param $address2
     * @throws \Exception
     */
    public function address2($address2)
    {
        $this->set(102, 233, $address2);
    }

    /**
     * 住所３をセットします。
     * @param $address3
     * @throws \Exception
     */
    public function address3($address3)
    {
        $this->set(102, 335, $address3);
    }

    /**
     * 電話番号をセットします
     * @param $tel
     * @throws \Exception
     */
    public function tel($tel)
    {
        $this->set(16, 437, $tel);
    }

    /**
     * FAX番号をセットします。
     * @param $fax_number
     * @throws \Exception
     */
    public function faxNumber($fax_number)
    {
        $this->set(16, 453, $fax_number);
    }

    /**
     * メールアドレス１をセットします。
     * @param $mail_address1
     * @throws \Exception
     */
    public function mailAddress1($mail_address1)
    {
        $this->set(80, 469, $mail_address1);
    }

    /**
     * メールアドレス２をセットします。
     * @param $mail_address2
     * @throws \Exception
     */
    public function mailAddress2($mail_address2)
    {
        $this->set(80, 549, $mail_address2);
    }

    /**
     * メールアドレス３をセットします。
     * @param $mail_address3
     * @throws \Exception
     */
    public function mailAddress3($mail_address3)
    {
        $this->set(80, 629, $mail_address3);
    }

    /**
     * メールアドレス４をセットします。
     * @param $mail_address4
     * @throws \Exception
     */
    public function mailAddress4($mail_address4)
    {
        $this->set(80, 709, $mail_address4);
    }

    /**
     * メールアドレス５をセットします。
     * @param $mail_address5
     * @throws \Exception
     */
    public function mailAddress5($mail_address5)
    {
        $this->set(80, 789, $mail_address5);
    }

    /**
     * メールアドレス６をセットします。
     * @param $mail_address6
     * @throws \Exception
     */
    public function mailAddress6($mail_address6)
    {
        $this->set(80, 869, $mail_address6);
    }

    /**
     * 販売店区分をセットします。
     * @param $agent_type
     * @throws \Exception
     */
    public function agentType($agent_type)
    {
        $this->set(1, 949, $agent_type);
    }

    /**
     * ログイン区分をセットします。
     * @param $login_type
     * @throws \Exception
     */
    public function loginType($login_type)
    {
        $this->set(1, 950, $login_type);
    }

    /**
     * 確認更新日時をセットします。
     * @param $last_update_date_time
     * @throws \Exception
     */
    public function lastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 951, $last_update_date_time);
    }

}