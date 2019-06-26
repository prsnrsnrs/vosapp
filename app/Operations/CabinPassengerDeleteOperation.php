<?php

namespace App\Operations;

/**
 * 客室一人削除ソケットのメッセージクラスです。
 * @package App\Operations
 */
class CabinPassengerDeleteOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('327');
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
     * 要求パラメータ 乗船者行Noをセットします。
     * @param $passenger_line_number
     */
    public function setPassengerLineNumber($passenger_line_number)
    {
        $this->set(3, 52, $passenger_line_number, ['padding' => 0, 'right' => false]);
    }


    /**
     * 要求パラメータ 表示行Noをセットします。
     * @param $cabin_show_line_number
     */
    public function setShowPassengerLineNumber($show_passenger_line_number)
    {
        $this->set(3, 55, $show_passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 登録モードをセットします。
     * @param $insert_mode
     */
    public function setInsertMode($insert_mode)
    {
        $this->set(1, 58, $insert_mode);
    }


    public function parseResponse()
    {
        return $response = [];
    }
}