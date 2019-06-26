<?php

namespace App\Operations;

/**
 * 客室タイプ追加ソケットのメッセージクラスです。
 * @package App\Operations
 */
class CabinAddOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('325');
    }


    /**
     * 要求パラメータ 一次予約番号をセットします。
     * @param string $temp_reservation_number
     */
    public function setTempReservationNumber($temp_reservation_number)
    {
        $this->set(9, 43, $temp_reservation_number,  ['padding' => 0, 'right' => false]);
    }


    /**
     * 要求パラメータ 客室タイプコードをセットします。
     * @param $cabin_type
     */
    public function setCabinTypeCode($cabin_type_code)
    {
        $this->set(2, 52, $cabin_type_code);
    }

    /**
     * 要求パラメータ 大人の人数をセットします。
     * @param $human_type
     */
    public function setHumanTypeAdult($human_type, $count)
    {
        $this->set(3, $count * 9 + 54, $human_type, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 小人の人数をセットします。
     * @param $human_type
     */
    public function setHumanTypeChildren($human_type, $count)
    {
        $this->set(3, $count * 9 + 57, $human_type, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 幼児の人数をセットします。
     * @param $human_type
     */
    public function setHumanTypeChild($human_type, $count)
    {
        $this->set(3, $count * 9 + 60, $human_type, ['padding' => 0, 'right' => false]);
    }

    public function parseResponse()
    {
        return [];
    }
}