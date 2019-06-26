<?php

namespace App\Operations;

/**
 * 取込フォーマット登録ソケットのメッセージクラスです。
 * Class ImportFormatAddOperation
 * @package App\Operations
 */
class ImportFormatAddOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('411');
    }

    /**
     * 要求パラメータ フォーマット名をセットします。
     * @param string $format_number
     */
    public function setFormatName($format_name)
    {
        $this->set(32, 43, $format_name);
    }

    /**
     * 要求パラメータ ファイル形式をセットします。
     * @param string $file_type
     */
    public function setFileType($file_type)
    {
        $this->set(1, 75, $file_type);
    }

    /**
     * 要求パラメータ 列見出行番号をセットします。
     * @param string $format_number
     */
    public function setHeaderLineNumber($header_line_number)
    {
        $this->set(4, 76, $header_line_number, ['padding' => '0', 'right' => false]);
    }

    /**
     * 要求パラメータ 取込開始行番号をセットします。
     * @param string $import_start_line_number
     */
    public function setImportStartLineNumber($import_start_line_number)
    {
        $this->set(4, 80, $import_start_line_number, ['padding' => '0', 'right' => false]);
    }

    /**
     * レスポンスを解析し、結果を連想配列で返します。
     * @return array
     */
    public function parseResponse()
    {
        return [
            'format_number' => $this->parse(3, 16),
            'last_update_date_time' => $this->parse(14, 19),
        ];
    }

}