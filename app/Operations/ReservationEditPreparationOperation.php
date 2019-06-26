<?php

namespace App\Operations;

/**
 * 予約変更追加準備ソケットのメッセージクラスです。
 * Class ReservationEditPreparationOperation
 * @package App\Operations
 */
class ReservationEditPreparationOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('361');
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
     * 要求パラメータ 確認更新日時をセットします。
     * @param $reservation_mode
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(17, 52, $last_update_date_time, ['padding' => 0]);
    }

    /**
     * 回答ソケットのデータを成型します。
     * @return array
     */
    public function parseResponse()
    {
        return [
            'temp_reservation_number' => trim($this->parse(9, 16)),
        ];
    }
}