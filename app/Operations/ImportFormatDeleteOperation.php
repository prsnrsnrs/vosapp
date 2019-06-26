<?php

namespace App\Operations;

/**
 * 取込フォーマット削除ソケットのメッセージクラスです。
 * Class ImportFormatDeleteOperation
 * @package App\Operations
 */
class ImportFormatDeleteOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('413');
    }

    /**
     * 要求パラメータ フォーマット番号をセットします。
     * @param string $format_number
     */
    public function setFormatNumber($format_number)
    {
        $this->set(3, 43, $format_number, ['padding' => '0', 'right' => false]);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param string $last_update_date_time
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 46, $last_update_date_time);
    }
}