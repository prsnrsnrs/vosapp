<?php

namespace App\Operations;

/**
 * 乗船者リクエスト情報変更ソケットのメッセージクラスです
 * Class PassengerRequestChangeOperation
 * @package App\Operations
 */
class PassengerRequestChangeOperation extends BaseOperation
{

    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('346');
        $this->setRecordType("");
        $this->setTempWorkManagementNumber("");
        $this->setReservationNumber("");
        $this->setPassengerLineNumber("");
        $this->setDisplayLineNumber("");
        $this->setChildMealType("");
        $this->setInfantMealType("");
        $this->setAnniversaryType("");
        $this->setRemarks("");
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
     * 要求パラメータ 子供食区分をセットします。
     * @param $child_meal_type
     */
    public function setChildMealType($child_meal_type)
    {
        $this->set(1, 70, $child_meal_type);
    }

    /**
     * 要求パラメータ 幼児食区分をセットします。
     * @param $infant_meal_type
     */
    public function setInfantMealType($infant_meal_type)
    {
        $this->set(1, 71, $infant_meal_type);
    }

    /**
     * 要求パラメータ 記念日区分をセットします。
     * @param $anniversary_type
     */
    public function setAnniversaryType($anniversary_type)
    {
        $this->set(1, 72, $anniversary_type);
    }

    /**
     * 要求パラメータ 備考をセットします。
     * @param $remarks
     */
    public function setRemarks($remarks)
    {
        $this->set(302, 73, $remarks);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $confirm_update_date_time
     */
    public function setConfirmUpdateDateTime($last_update_date_time)
    {
        $this->set(17, 375, $last_update_date_time);
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