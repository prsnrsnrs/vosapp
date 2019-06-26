<?php

namespace App\Operations;

/**
 * ご乗船者詳細情報変更ソケットのメッセージクラスです
 * Class PassengerRequestChangeOperation
 * @package App\Operations
 */
class PassengerDetailChangeOperation extends BaseOperation
{

    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('342');
        $this->setAddress1("");
        $this->setAddress2("");
        $this->setAddress3("");
        $this->setBirthDate("");
        $this->setLastUpdateDateTime("");
        $this->setCountryCode("");
        $this->setDisplayLineNumber("");
        $this->setEmergencyContactKana("");
        $this->setEmergencyContactName("");
        $this->setEmergencyContactRelationship("");
        $this->setEmergencyContactTel("");
        $this->setEmergencyContactTelType("");
        $this->setGender("");
        $this->setLinkId("");
        $this->setPassengerFirstKana("");
        $this->setPassengerFirstKnj("");
        $this->setPassengerLastKana("");
        $this->setPassengerLastKnj("");
        $this->setPassengerLineNumber("");
        $this->setPassportIssuedDate("");
        $this->setPassportIssuedPlace("");
        $this->setPassportLoseDate("");
        $this->setPassportNumber("");
        $this->setPrefectureCode("");
        $this->setRecordType("");
        $this->setReservationNumber("");
        $this->setResidenceCode("");
        $this->setTel1("");
        $this->setTel1Type("");
        $this->setTel2("");
        $this->setTel2Type("");
        $this->setTempWorkManagementNumber("");
        $this->setWeddingAnniversary("");
        $this->setZipCode("");
    }

    /**
     * 要求パラメータ レコード区分をセットします
     * @param $record_type 1:開始、2:データ、9:終了
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
     * 要求パラメータ 乗船者漢字姓をセットします。
     * @param $child_meal_type
     */
    public function setPassengerLastKnj($passenger_last_knj)
    {
        $this->set(22, 70, $passenger_last_knj);
    }

    /**
     * 要求パラメータ 乗船者漢字名をセットします。
     * @param $passenger_first_knj
     */
    public function setPassengerFirstKnj($passenger_first_knj)
    {
        $this->set(22, 92, $passenger_first_knj);
    }

    /**
     * 要求パラメータ 乗船者カナ姓をセットします。
     * @param $passenger_last_kana
     */
    public function setPassengerLastKana($passenger_last_kana)
    {
        $this->set(20, 114, $passenger_last_kana);
    }

    /**
     * 要求パラメータ 乗船者カナ名をセットします。
     * @param $passenger_first_kana
     */
    public function setPassengerFirstKana($passenger_first_kana)
    {
        $this->set(20, 134, $passenger_first_kana);
    }

    /**
     * 要求パラメータ 性別をセットします。
     * @param $gender
     */
    public function setGender($gender)
    {
        $this->set(1, 154, $gender);
    }

    /**
     * 要求パラメータ 生年月日をセットします。
     * @param $birth_date
     */
    public function setBirthDate($birth_date)
    {
        $this->set(8, 155, $birth_date, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 結婚記念日をセットします。
     * @param $wedding_anniversary
     */
    public function setWeddingAnniversary($wedding_anniversary)
    {
        $this->set(8, 163, $wedding_anniversary, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 郵便番号をセットします。
     * @param $zip_code
     */
    public function setZipCode($zip_code)
    {
        $this->set(7, 171, $zip_code);
    }

    /**
     * 要求パラメータ 都道府県コードをセットします。
     * @param $prefecture_code
     */
    public function setPrefectureCode($prefecture_code)
    {
        $this->set(2, 178, $prefecture_code, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 住所１をセットします。
     * @param $address1
     */
    public function setAddress1($address1)
    {
        $this->set(102, 180, $address1);
    }

    /**
     * 要求パラメータ 住所２をセットします。
     * @param $address2
     */
    public function setAddress2($address2)
    {
        $this->set(102, 282, $address2);
    }

    /**
     * 要求パラメータ 住所３をセットします。
     * @param $address3
     */
    public function setAddress3($address3)
    {
        $this->set(102, 384, $address3);
    }

    /**
     * 要求パラメータ 電話番号１をセットします。
     * @param $tel1
     */
    public function setTel1($tel1)
    {
        $this->set(16, 486, $tel1);
    }

    /**
     * 要求パラメータ 電話番号１区分をセットします。
     * @param $tel1_type
     */
    public function setTel1Type($tel1_type)
    {
        $this->set(1, 502, $tel1_type);
    }

    /**
     * 要求パラメータ 電話番号２をセットします。
     * @param $tel2
     */
    public function setTel2($tel2)
    {
        $this->set(16, 503, $tel2);
    }

    /**
     * 要求パラメータ 電話番号２区分をセットします。
     * @param $tel2_type
     */
    public function setTel2Type($tel2_type)
    {
        $this->set(1, 519, $tel2_type);
    }

    /**
     * 要求パラメータ 緊急連絡先氏名をセットします。
     * @param $emergency_contact_name
     */
    public function setEmergencyContactName($emergency_contact_name)
    {
        $this->set(42, 520, $emergency_contact_name);
    }

    /**
     * 要求パラメータ 緊急連絡先氏名フリガナをセットします。
     * @param $emergency_contact_kana
     */
    public function setEmergencyContactKana($emergency_contact_kana)
    {
        $this->set(42, 562, $emergency_contact_kana);
    }

    /**
     * 要求パラメータ 緊急連絡先電話番号をセットします。
     * @param $emergency_contact_tel
     */
    public function setEmergencyContactTel($emergency_contact_tel)
    {
        $this->set(16, 604, $emergency_contact_tel);
    }

    /**
     * 要求パラメータ 緊急連絡先電話番号区分をセットします。
     * @param $emergency_contact_tel_type
     */
    public function setEmergencyContactTelType($emergency_contact_tel_type)
    {
        $this->set(1, 620, $emergency_contact_tel_type);
    }

    /**
     * 要求パラメータ 緊急連絡先続柄をセットします。
     * @param $emergency_contact_relationship
     */
    public function setEmergencyContactRelationship($emergency_contact_relationship)
    {
        $this->set(12, 621, $emergency_contact_relationship);
    }

    /**
     * 要求パラメータ 国籍をセットします。
     * @param $country_code
     */
    public function setCountryCode($country_code)
    {
        $this->set(3, 633, $country_code);
    }

    /**
     * 要求パラメータ 居住国コードをセットします。
     * @param $residence_code
     */
    public function setResidenceCode($residence_code)
    {
        $this->set(3, 636, $residence_code);
    }

    /**
     * 要求パラメータ パスポート番号をセットします。
     * @param $passport_number
     */
    public function setPassportNumber($passport_number)
    {
        $this->set(12, 639, $passport_number);
    }

    /**
     * 要求パラメータ パスポート発給日をセットします。
     * @param $passport_issued_date
     */
    public function setPassportIssuedDate($passport_issued_date)
    {
        $this->set(8, 651, $passport_issued_date, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ パスポート発給地をセットします。
     * @param $passport_issued_place
     */
    public function setPassportIssuedPlace($passport_issued_place)
    {
        $this->set(3, 659, $passport_issued_place);
    }

    /**
     * 要求パラメータ パスポート失効日をセットします。
     * @param $passport_lose_date
     */
    public function setPassportLoseDate($passport_lose_date)
    {
        $this->set(8, 662, $passport_lose_date, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ リンクＩＤをセットします。
     * @param $link_id
     */
    public function setLinkId($link_id)
    {
        $this->set(10, 670, $link_id);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $last_update_date_time
     */
    public function setLastUpdateDateTime($last_update_date_time)
    {
        $this->set(17, 680, $last_update_date_time, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 乗船者英字姓をセットします。
     * @param $passenger_last_eij
     */
    public function setPassengerLastEij($passenger_last_eig)
    {
        $this->set(20, 697, $passenger_last_eig);
    }

    /**
     * 要求パラメータ 乗船者英字名をセットします。
     * @param $passenger_first_eij
     */
    public function setPassengerFirstEij($passenger_first_eij)
    {
        $this->set(20, 717, $passenger_first_eij);
    }

    /**
     * 回答ソケットを定義します。
     * @return array
     */
    public function parseResponse()
    {
        $response = [
            'temp_work_management_number' => trim($this->parse(11, 16))
        ];
        return $response;
    }
}