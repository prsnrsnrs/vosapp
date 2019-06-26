<?php

namespace App\Operations;

/**
 * 取込フォーマット変更ソケットのメッセージクラスです。
 * Class ImportFormatDetailUpdateOperation
 * @package App\Operations
 */
class ImportFormatDetailUpdateOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('414');
        $this->setLastUpdateDateTime("");
        $this->setFormatNumber("");
        $this->setTempWorkManagementNumber("");
        $this->setRecordType("");
        $this->setDelimiterChar("");
        $this->setFormatPointManageNumber("");
        $this->setTravelCompanyColIndex("");
    }

    /**
     * 要求パラメータ レコード区分をセットします
     * @param $record_type 1:開始、2:データ、9:終了
     */
    public function setRecordType($record_status)
    {
        $this->set(1, 43, $record_status);
    }

    /**
     * 要求パラメータ 一次ワーク管理番号をセットします
     * @param $temp_work_management_number
     */
    public function setTempWorkManagementNumber($temp_work_management_number)
    {
        $this->set(11, 44, $temp_work_management_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ フォーマット番号をセットします。
     * @param string $format_number
     */
    public function setFormatNumber($format_number)
    {
        $this->set(3, 55, $format_number, ['padding' => '0', 'right' => false]);
    }

    /**
     * 要求パラメータ 項目管理番号をセットします。
     * @param string $format_point_manage_number
     */
    public function setFormatPointManageNumber($format_point_manage_number)
    {
        $this->set(3, 58, $format_point_manage_number, ['padding' => '0', 'right' => false]);
    }

    /**
     * 要求パラメータ 旅行社列番号をセットします。
     * @param string $travel_company_col_index
     */
    public function setTravelCompanyColIndex($travel_company_col_index)
    {
        $this->set(3, 61, $travel_company_col_index, ['padding' => '0', 'right' => false]);
    }

    /**
     * 要求パラメータ 区切文字をセットします。
     * @param string $format_number
     */
    public function setDelimiterChar($delimiter_char)
    {
        $this->set(4, 64, $delimiter_char);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $reservation_mode
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(14, 68, $last_update_date_time);
    }

    /**
     * レスポンスを解析し、結果を連想配列で返します。
     * @return array
     */
    public function parseResponse()
    {
        return [
            'temp_work_management_number' => $this->parse(11, 16),
        ];
    }

}