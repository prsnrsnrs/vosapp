<?php

namespace App\Operations;

/**
 * 取込フォーマット変更ソケットのメッセージクラスです。
 * Class ImportChangeFormatOperation
 * @package App\Operations
 */
class ImportFormatChangeOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('412');
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
     * 要求パラメータ フォーマット名をセットします。
     * @param string $format_number
     */
    public function setFormatName($format_name)
    {
        $this->set(32, 46, $format_name);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $reservation_mode
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 78, $last_update_date_time);
    }

    /**
     * レスポンスを解析し、結果を連想配列で返します。
     * @return array
     */
    public function parseResponse()
    {
        return [
            'last_update_date_time' => $this->parse(14, 16),
        ];
    }

}