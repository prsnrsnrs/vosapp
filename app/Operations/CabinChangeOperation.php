<?php

namespace App\Operations;

/**
 * 客室タイプ変更ソケットのメッセージクラスです。
 * @package App\Operations
 */
class CabinChangeOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('323');
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
     * 要求パラメータ 変更客室行No.をセットします。
     * @param $cabin_line_number
     */
    public function setCabinLineNumber($cabin_line_number)
    {
        $this->set(3, 52, $cabin_line_number, ['padding' => 0, 'right' => false]);
    }


    /**
     * 要求パラメータ 変更客室タイプコードをセットします。
     * @param $cabin_type
     */
    public function setCabinType($cabin_type)
    {
        $this->set(2, 55, $cabin_type);
    }

    /**
     * 要求パラメータ 登録モードをセットします。
     * @param $insert_mode
     */
    public function setInsertMode($insert_mode)
    {
        $this->set(1, 57, $insert_mode);
    }


    public function parseResponse()
    {
        return $response = [];
    }
}