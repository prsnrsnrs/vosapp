<?php

namespace App\Operations;

/**
 * 客室一人追加ソケットのメッセージクラスです。
 * @package App\Operations
 */
class CabinPassengerAddOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('326');
    }

    /**
     * 要求パラメータ 一次予約番号をセットします。
     * @param $temp_reservation_number
     */
    public function setTempReservationNumber($temp_reservation_number)
    {
        $this->set(9, 43, $temp_reservation_number, ['padding' => 0, 'right' => false]);
    }


    /**
     * 要求パラメータ 客室行Noをセットします。
     * @param $cabin_line_number
     */
    public function setCabinLineNumber($cabin_line_number)
    {
        $this->set(3, 52, $cabin_line_number, ['padding' => 0, 'right' => false]);
    }


    /**
     * 要求パラメータ 客室表示行Noをセットします。
     * @param $show_line_number
     */
    public function setShowCabinLineNumber($show_cabin_line_number)
    {
        $this->set(3, 55, $show_cabin_line_number, ['padding' => 0, 'right' => false]);
    }


    /**
     * 要求パラメータ 人数区分をセットします。
     * @param $passenger_count_status
     */
    public function setPassengerStatus($passenger_status)
    {
        $this->set(1, 58, $passenger_status);
    }


    public function parseResponse()
    {
        return [];
    }
}