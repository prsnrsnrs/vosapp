<?php

namespace App\Operations;

/**
 * 客室リクエスト情報変更ソケットのメッセージクラスです
 * Class PassengerRequestChangeOperation
 * @package App\Operations
 */
class CabinRequestChangeOperation extends BaseOperation
{
    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('343');
        $this->setRecordType("");
        $this->setTempWorkManagementNumber("");
        $this->setReservationNumber("");
        $this->setCabinLineNumber("");
        $this->setDisplayLineNumber("");
        $this->setCabinTypeRequest("");
        $this->setCabinRequestFree("");
        $this->setConfirmUpdateDateTime("");
    }

    /**
     * 要求パラメータ レコード区分をセットします
     * @param $record_type
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
     * 要求パラメータ 予約番号をセットします。
     * @param $reservation_number
     */
    public function setReservationNumber($reservation_number)
    {
        $this->set(9, 55, $reservation_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 客室行Noをセットします。
     * @param $cabin_line_number
     */
    public function setCabinLineNumber($cabin_line_number)
    {
        $this->set(3, 64, $cabin_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 客室表示行No.をセットします。
     * @param $display_line_number
     */
    public function setDisplayLineNumber($display_line_number)
    {
        $this->set(3, 67, $display_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 客室タイプリクエストをセットします。
     * @param $cabin_type_request
     */
    public function setCabinTypeRequest($cabin_type_request)
    {
        $this->set(2, 70, $cabin_type_request);
    }

    /**
     * 要求パラメータ キャビンリクエスト備考をセットします。
     * @param $cabin_request_free
     */
    public function setCabinRequestFree($cabin_request_free)
    {
        $this->set(52, 72, $cabin_request_free);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $confirm_update_date_time
     */
    public function setConfirmUpdateDateTime($last_update_date_time)
    {
        $this->set(17, 124, $last_update_date_time);
    }

    /**
     * 回答ソケットを定義します。
     * @return array
     */
    public function parseResponse()
    {
        $response = [
            'temp_work_number' => trim($this->parse(11, 16))
        ];
        return $response;
    }
}