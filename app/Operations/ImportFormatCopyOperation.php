<?php

namespace App\Operations;

/**
 * 取込フォーマットコピーソケットのメッセージクラスです。
 * Class ImportFormatCopyOperation
 * @package App\Operations
 */
class ImportFormatCopyOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('416');
    }

    /**
     * 要求パラメータ コピー元フォーマット番号をセットします。
     * @param string $format_number
     */
    public function setOriginalFormatNumber($original_format_number)
    {
        $this->set(3, 43, $original_format_number, ['padding' => '0', 'right' => false]);
    }

    /**
     * レスポンスを解析し、結果を連想配列で返します。
     * @return array
     */
    public function parseResponse()
    {
        return [
            'copy_to_format_number' => $this->parse(3, 16),
        ];
    }

}