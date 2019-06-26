<?php

namespace App\Operations;

/**
 * 乗船者見出情報変更ソケットのメッセージクラスです。
 * @package App\Operations
 */
class PassengerHeadingOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('341');
        $this->setTempWorkNumber('');
        $this->setTempReservationNumber('');
        $this->setShowPassengerLineNumber('');
        $this->setPassengerLineNumber('');
        $this->setPrePassengerLineNumber('');
        $this->setBossStatus('');
        $this->setPassengerLastEij('');
        $this->setPassengerFirstEij('');
    }

    /**
     * 要求パラメータ レコード区分をセットします。
     * @param $record_status
     */
    public function setRecordStatus($record_status)
    {
        $this->set(1, 43, $record_status);
    }

    /**
     * 要求パラメータ 一次ワーク管理番号をセットします
     * @param $first_work_number
     */
    public function setTempWorkNumber($temp_work_number)
    {
        $this->set(11, 44, $temp_work_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 一次予約番号をセットします。
     * @param $temp_reservation_number
     */
    public function setTempReservationNumber($temp_reservation_number)
    {
        $this->set(9, 55, $temp_reservation_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 乗船者行Noをセットします。
     * @param $passenger_line_number
     */
    public function setPassengerLineNumber($passenger_line_number)
    {
        $this->set(3, 64, $passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 表示行Noをセットします。
     * @param $show_line_number
     */
    public function setShowPassengerLineNumber($show_passenger_line_number)
    {
        $this->set(3, 67, $show_passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 事前登録者乗船者行Noをセットします。
     * @param $human_type
     */
    public function setPrePassengerLineNumber($pre_passenger_line_number)
    {
        $this->set(3, 70, $pre_passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 代表者区分をセットします。
     * @param $boss_status
     */
    public function setBossStatus($boss_status)
    {
        $this->set(3, 73, $boss_status);
    }

    /**
     * 要求パラメータ 乗船者英字姓をセットします。
     * @param $passenger_first_eij
     */
    public function setPassengerLastEij($passenger_last_eij)
    {
        $this->set(20, 74, $passenger_last_eij);
    }

    /**
     * 要求パラメータ 乗船者英字名をセットします。
     * @param $passenger_last_eij
     */
    public function setPassengerFirstEij($passenger_first_eij)
    {
        $this->set(20, 94, $passenger_first_eij);
    }


    public function parseResponse()
    {
        $response = [
            'temp_work_number' => trim($this->parse(11, 16)),
            'last_update_date_time' => trim($this->parse(17, 27))
        ];
        return $response;
    }
}