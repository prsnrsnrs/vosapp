<?php

namespace App\Operations;

/**
 * 販売店一括登録用ソケットクラスです。
 * Class AgentImportOperation
 * @package App\Operations
 */
class AgentImportOperation extends BaseOperation
{
    /**
     * 初期化します。
     * 初期値を設定します。
     */
    public function init()
    {
        $this->setCommonOperationCode('251');
        $this->setRecordType("");
        $this->setImportManagementNumber("");
        $this->setImportRowNo("");
        $this->setData0("");
        $this->setData1("");
        $this->setData2("");
        $this->setData3("");
        $this->setData4("");
        $this->setData5("");
        $this->setData6("");
        $this->setData7("");
        $this->setData8("");
        $this->setData9("");
        $this->setData10("");
        $this->setData11("");
        $this->setData12("");
        $this->setData13("");
        $this->setData14("");
        $this->setData15("");
        $this->setData16("");
        $this->setData17("");
        $this->setData18("");
        $this->setUserName("");
        $this->setUserType("");
    }

    /**
     * 要求パラメータ インポート区分をセットします
     * @param $record_status 1:開始、2:データ、9:終了
     * @throws \Exception
     */
    public function setRecordType($record_status)
    {
        $this->set(1, 43, $record_status);
    }

    /**
     * 要求パラメータ 一時インポート管理番号をセットします
     * @param $import_management_number
     * @throws \Exception
     */
    public function setImportManagementNumber($import_management_number)
    {
        $this->set(11, 44, $import_management_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ：一次インポート行No
     * @param $row_no
     * @throws \Exception
     */
    public function setImportRowNo($row_no)
    {
        $this->set(4, 55, $row_no, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ:販売店コードをセットします。
     * @param $agent_code
     * @throws \Exception
     */

    public function setData0($agent_code)
    {
        $this->set(7, 59, $agent_code, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：販売店名をセットします。
     * @param $agent_name
     * @throws \Exception
     */

    public function setData1($agent_name)
    {
        $this->set(72, 66, $agent_name, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：郵便番号をセットします。
     * @param $zip_code
     * @throws \Exception
     */
    public function setData2($zip_code)
    {
        $this->set(7, 138, $zip_code, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：都道府県をセットします。
     * @param $prefecture_code
     * @throws \Exception
     */
    public function setData3($prefecture_code)
    {
        $this->set(2, 145, $prefecture_code, ['padding' => 0, 'right' => false], ['overflow' => true]);
    }

    /**
     * 要求パラメータ：住所１をセットします。
     * @param $address1
     * @throws \Exception
     */
    public function setData4($address1)
    {
        $this->set(102, 147, $address1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：住所２をセットします。
     * @param $address2
     * @throws \Exception
     */
    public function setData5($address2)
    {
        $this->set(102, 249, $address2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：住所３をセットします。
     * @param $address3
     * @throws \Exception
     */
    public function setData6($address3)
    {
        $this->set(102, 351, $address3, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：電話番号をセットします。
     * @param $tel
     * @throws \Exception
     */
    public function setData7($tel)
    {
        $this->set(16, 453, $tel, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：FAX番号をセットします。
     * @param $fax_number
     * @throws \Exception
     */
    public function setData8($fax_number)
    {
        $this->set(16, 469, $fax_number, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：メールアドレスをセットします。
     * @param $mail_address1
     * @throws \Exception
     */
    public function setData9($mail_address1)
    {
        $this->set(80, 485, $mail_address1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：メールアドレス２をセットします。
     * @param $mail_address2
     * @throws \Exception
     */
    public function setData10($mail_address2)
    {
        $this->set(80, 565, $mail_address2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：メールアドレス３をセットします。
     * @param $mail_address3
     * @throws \Exception
     */
    public function setData11($mail_address3)
    {
        $this->set(80, 645, $mail_address3, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：メールアドレス４をセットします。
     * @param $mail_address4
     * @throws \Exception
     */
    public function setData12($mail_address4)
    {
        $this->set(80, 725, $mail_address4, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：メールアドレス５をセットします。
     * @param $mail_address5
     * @throws \Exception
     */
    public function setData13($mail_address5)
    {
        $this->set(80, 805, $mail_address5, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：メールアドレス６をセットします。
     * @param $mail_address6
     * @throws \Exception
     */
    public function setData14($mail_address6)
    {
        $this->set(80, 885, $mail_address6, ['overflow' => true]);
    }

    /**
     *要求パラメータ：販売店区分をセットします。
     * @param $agent_type
     * @throws \Exception
     */
    public function setData15($agent_type)
    {
        $this->set(1, 965, $agent_type, ['overflow' => true]);
    }

    /**
     *要求パラメータ：ログイン区分をセットします。
     * @param $login_type
     * @throws \Exception
     */
    public function setData16($login_type)
    {
        $this->set(1, 966, $login_type, ['overflow' => true]);

    }

    /**
     * 要求パラメータ：ユーザーIDをセットします。
     * @param $user_id
     * @throws \Exception
     */
    public function setData17($user_id)
    {
        $this->set(12, 967, $user_id, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：ユーザー名称をセットします。
     * @param $user_name
     * @throws \Exception
     */
    public function setUserName($user_name)
    {
        $this->set(42, 979, $user_name, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：ユーザー区分をセットします。
     * @param $user_type
     * @throws \Exception
     */

    public function setUserType($user_type)
    {
        $this->set(1, 1021, $user_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：ログイン区分をセットします。：2項目目
     * @param $login_type
     * @throws \Exception
     */
    public function setLoginType($login_type)
    {
        $this->set(1, 1022, $login_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ：パスワードをセットします。
     * @param $password
     * @throws \Exception
     */
    public function setData18($password)
    {
        $this->set(12, 1023, $password, ['overflow' => true]);
    }

    /**
     * 回答ソケットを定義します。
     * @return array
     */
    public function parseResponse()
    {
        $response = [
            'import_management_number' => trim($this->parse(11, 16)),
            'import_date_time' => $this->parse(17, 27)
        ];
        return $response;
    }
}