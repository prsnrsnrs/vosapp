<?php

namespace App\Operations;

/**
 * 客室ルーミング変更ソケットのメッセージクラスです。
 * @package App\Operations
 */
class RoomingChangeOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('347');
        $this->setRecordStatus('');
        $this->setTempWorkNumber('');
        $this->setReservationNumber('');
        $this->setPassengerLineNumber('');
        $this->setShowPassengerLineNumber('');
        $this->setCabinLineNumber('');
        $this->setUpdateDateTime('');
        $this->setTempReservationNumber('');
    }

    /**
     * 要求パラメータ レコード区分をセットします。
     * @param $record_type
     */
    public function setRecordStatus($record_status)
    {
        $this->set(1, 43, $record_status);
    }

    /**
     * 要求パラメータ 一次ワーク管理番号をセットします。
     * @param $temp_work_number
     */
    public function setTempWorkNumber($temp_work_number)
    {
        $this->set(11, 44, $temp_work_number, ['padding' => 0, 'right' => false]);
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
     * 要求パラメータ 乗船者行No.をセットします。
     * @param $passenger_line_number
     */
    public function setPassengerLineNumber($passenger_line_number)
    {
        $this->set(3, 64, $passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 表示行No.をセットします。
     * @param $show_cabin_line_number
     */
    public function setShowPassengerLineNumber($show_cabin_line_number)
    {
        $this->set(3, 67, $show_cabin_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 客室行No.をセットします。
     * @param $cabin_line_number
     */
    public function setCabinLineNumber($cabin_line_number)
    {
        $this->set(3, 70, $cabin_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $update_date_time
     */
    public function setUpdateDateTime($update_date_time)
    {
        $this->set(17, 73, $update_date_time, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 一次予約番号をセットします。
     * @param $temp_resrvation_number
     */
    public function setTempReservationNumber($temp_reservation_number)
    {
        $this->set(9, 90, $temp_reservation_number, ['padding' => 0, 'right' => false]);
    }

    public function parseResponse()
    {
        $response = [
            'temp_work_number' => trim($this->parse(11, 16)),
            'temp_reservation_number' => trim($this->parse(9, 27))
        ];

        return $response;
    }
}