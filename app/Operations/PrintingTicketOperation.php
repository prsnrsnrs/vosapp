<?php

namespace App\Operations;

/**
 * 乗船券控え発行ソケットのメッセージクラスです。
 * @package App\Operations
 */
class PrintingTicketOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('811');
        $this->setReservationNumber('');
        $this->setPassengerLineNumber('');
    }

    /**
     * 要求パラメータ 一次予約番号をセットします。
     * @param $reservation_number
     */
    public function setReservationNumber($reservation_number)
    {
        $this->set(9, 43, $reservation_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 乗船者行Noをセットします。
     * @param $passenger_line_number
     */
    public function setPassengerLineNumber($passenger_line_number)
    {
        $this->set(3, 52, $passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    public function parseResponse()
    {
        return [];
    }
}