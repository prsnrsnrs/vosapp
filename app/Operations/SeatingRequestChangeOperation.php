<?php

namespace App\Operations;

class SeatingRequestChangeOperation extends BaseOperation{

    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('349');
        $this->setReservationNumber("");
        $this->setSeatingRequest("");
    }

    /**
     * 要求パラメータ 予約番号をセットします。
     * @param $reservation_number
     */
    public function setReservationNumber($reservation_number)
    {
        $this->set(9, 43, $reservation_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 予約番号をセットします。
     * @param $seating_request
     */
    public function setSeatingRequest($seating_request)
    {
        $this->set(1, 52, $seating_request, ['padding' => 0, 'right' => false]);
    }
}