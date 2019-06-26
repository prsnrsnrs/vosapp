<?php

namespace App\Operations;

/**
 * グループ設定ソケットのメッセージクラスです。
 * @package App\Operations
 */
class GroupSettingOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('348');
        $this->setReservationNumber('');
        $this->setTravelWithNumber('');
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
     * 要求パラメータ TravelWith予約番号をセットします。
     * @param $travelwith_number
     */
    public function setTravelWithNumber($travelwith_number)
    {
        $this->set(9, 52, $travelwith_number, ['padding' => 0, 'right' => false]);
    }
}