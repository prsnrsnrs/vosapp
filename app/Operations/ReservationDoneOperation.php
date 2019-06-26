<?php

namespace App\Operations;

/**
 * 予約確定ソケットのメッセージクラスです。
 * @package App\Operations
 */
class ReservationDoneOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('351');
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
     * 要求パラメータ 予約番号をセットします。
     * @param $reservation_number
     */
    public function setReservationNumber($reservation_number)
    {
        $this->set(9, 52, $reservation_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 登録モードをセットします。
     * @param $insert_mode
     */
    public function setInsertMode($insert_mode)
    {
        $this->set(1, 61, $insert_mode);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $reservation_mode
     */
    public function setUpdateConfirm($update_confirm)
    {
        $this->set(17, 62, $update_confirm, ['padding' => 0]);
    }

    public function parseResponse()
    {
        $response = [
            'reservation_number_hk' => abs(trim($this->parse(9, 16))),
            'reservation_number_wt' => abs(trim($this->parse(9, 25))),
        ];

        // WT客室行No. 3桁×100
        for ($i = 0; $i < 100; $i++) {
            $line_wt = trim($this->parse(3, $i * 3 + 34));
            if ($line_wt) {
                $response['cabin_line_wt'][] = $line_wt;
            }
        }
        return $response;
    }
}