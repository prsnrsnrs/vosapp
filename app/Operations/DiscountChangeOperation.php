<?php

namespace App\Operations;

/**
 * 割引券情報変更ソケットのメッセージクラスです
 * Class DiscountChangeOperation
 * @package App\Operations
 */
class DiscountChangeOperation extends BaseOperation
{

    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('344');
        $this->setRecordType("");
        $this->setTempWorkManagementNumber("");
        $this->setReservationNumber("");
        $this->setPassengerLineNumber("");
        $this->setDisplayLineNumber("");
        $this->setDiscountNumber1("");
        $this->setDiscountNumber2("");
        $this->setDiscountNumber3("");
        $this->setDiscountNumber4("");
        $this->setDiscountNumber5("");
        $this->setTariffCode("");
        $this->setConfirmUpdateDateTime("");
    }

    /**
     * 要求パラメータ レコード区分をセットします
     * @param $record_type
     */
    public function setRecordType($record_status)
    {
        $this->set(1, 43, $record_status);
    }

    /**
     * 要求パラメータ 一次ワーク管理番号をセットします
     * @param $temp_work_management_number
     */
    public function setTempWorkManagementNumber($temp_work_management_number)
    {
        $this->set(11, 44, $temp_work_management_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 予約番号をセットします。
     * @param $reservation_number
     */
    public function setReservationNumber($reservation_number)
    {
        $this->set(9, 55, $reservation_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 乗船者行No.をセットします。
     * @param $passenger_line_number
     */
    public function setPassengerLineNumber($passenger_line_number)
    {
        $this->set(3, 64, $passenger_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 表示行No.をセットします。
     * @param $display_line_number
     */
    public function setDisplayLineNumber($display_line_number)
    {
        $this->set(3, 67, $display_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 割引券番号1をセットします。
     * @param $discount_number1
     */
        public function setDiscountNumber1($discount_number1)
    {
        $this->set(11, 70, $discount_number1);
    }

    /**
     * 要求パラメータ 割引券番号2をセットします。
     * @param $discount_number2
     */
    public function setDiscountNumber2($discount_number2)
    {
        $this->set(11, 81, $discount_number2);
    }

    /**
     * 要求パラメータ 割引券番号3をセットします。
     * @param $discount_number3
     */
    public function setDiscountNumber3($discount_number3)
    {
        $this->set(11, 92, $discount_number3);
    }

    /**
     * 要求パラメータ 割引券番号4をセットします。
     * @param $discount_number4
     */
    public function setDiscountNumber4($discount_number4)
    {
        $this->set(11, 103, $discount_number4);
    }

    /**
     * 要求パラメータ 割引券番号5をセットします。
     * @param $discount_number5
     */
    public function setDiscountNumber5($discount_number5)
    {
        $this->set(11, 114, $discount_number5);
    }

    /**
     * 要求パラメータ タリフコードをセットします。
     * @param $tariff_code
     */
    public function setTariffCode($tariff_code)
    {
        $this->set(3, 125, $tariff_code);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $confirm_update_date_time
     */
    public function setConfirmUpdateDateTime($last_update_date_time)
    {
        $this->set(17, 128, $last_update_date_time);
    }

    /**
     * 回答ソケットを定義します。
     * @return array
     */
    public function parseResponse()
    {
        $response = [
            'temp_work_number' => trim($this->parse(11, 16))
        ];
        return $response;
    }
}