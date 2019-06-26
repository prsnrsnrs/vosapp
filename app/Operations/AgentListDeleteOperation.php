<?php
/**
 * Created by PhpStorm.
 * User: ando-himiko
 * Date: 2017/12/13
 * Time: 11:14
 */

namespace App\Operations;


class AgentListDeleteOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('243');
    }

    /**
     * 要求パラメータ 販売店コードをセットします。
     * @param $code
     * @throws \Exception
     */
    public function setCode($code)
    {
        $this->set(7, 43, $code);
    }

    /**
     * 要求パラメータ　確認更新日時をセットします。
     * @param $last_update_date_time
     * @throws \Exception
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 50, $last_update_date_time);
    }
}