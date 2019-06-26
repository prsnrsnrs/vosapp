<?php

namespace App\Operations;

/**
 * 一括取込ソケットのメッセージクラスです
 * Class ReservationImportOperation
 * @package App\Operations
 */
class ReservationImportOperation extends BaseOperation
{

    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('451');
        $this->setQueueInPath(config('stomp.mq.import_in'));
        $this->setQueueOutPath(config('stomp.mq.import_out'));
        $this->setFormatNumber("");
        $this->setImportkManagementNumber("");
        $this->setRecordType("");
        $this->setItemCode("");
        $this->setImportLineNumber("");
        $this->setData1("");
        $this->setData2("");
        $this->setData3("");
        $this->setData4("");
        $this->setData5("");
        $this->setData6("");
        $this->setData7("");
        $this->setData8("");
        $this->setData9("");
        $this->setData10("");
        $this->setData11("");
        $this->setData12("");
        $this->setData13("");
        $this->setData14("");
        $this->setData15("");
        $this->setData16("");
        $this->setData17("");
        $this->setData18("");
        $this->setData19("");
        $this->setData20("");
        $this->setData21("");
        $this->setData22("");
        $this->setData23("");
        $this->setData24("");
        $this->setData25("");
        $this->setData26("");
        $this->setData27("");
        $this->setData28("");
        $this->setData29("");
        $this->setData30("");
        $this->setData31("");
        $this->setData32("");
        $this->setData33("");
        $this->setData34("");
        $this->setData35("");
        $this->setData36("");
        $this->setData37("");
        $this->setData38("");
        $this->setData39("");
        $this->setData40("");
        $this->setData41("");
        $this->setData42("");
        $this->setData43("");
        $this->setData44("");
        $this->setData45("");
        $this->setData46("");
        $this->setData47("");
        $this->setData48("");
        $this->setData49("");
        $this->setData50("");
        $this->setData51("");
        $this->setData52("");
        $this->setData53("");
        $this->setData54("");
        $this->setData55("");

    }

    /**
     * 要求パラメータ レコード区分をセットします
     * @param string $record_type 1:開始、2:データ、9:終了
     */
    public function setRecordType($record_status)
    {
        $this->set(1, 43, $record_status);
    }

    /**
     * 要求パラメータ フォーマット番号をセットします
     * @param string $format_number
     */
    public function setFormatNumber($format_number)
    {
        $this->set(3, 44, $format_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 取込管理番号をセットします
     * @param $import_management_number
     */
    public function setImportkManagementNumber($import_management_number)
    {
        $this->set(11, 47, $import_management_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 取込行Noをセットします
     * @param string $import_line_number
     */
    public function setImportLineNumber($import_line_number)
    {
        $this->set(3, 58, $import_line_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 商品コードをセットします。
     * @param $item_code
     */
    public function setItemCode($item_code)
    {
        $this->set(11, 61, $item_code);
    }

    /**
     * 要求パラメータ 旅行社管理番号をセットします。
     * @param $travel_company_manage_number
     */
    public function setData1($travel_company_manage_number)
    {
        $this->set(20, 72, $travel_company_manage_number, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 管理枝番号をセットします。
     * @param $manage_branch_number
     */
    public function setData2($manage_branch_number)
    {
        $this->set(40, 92, $manage_branch_number, ['overflow' => true]);
    }

    /**
     * 要求パラメータ グループ番号をセットします。
     * @param $group_number
     */
    public function setData3($group_number)
    {
        $this->set(10, 132, $group_number, ['padding' => 0, 'right' => false, 'overflow' => true]);
    }

    /**
     * 要求パラメータ 客室タイプをセットします。
     * @param $cabin_type
     */
    public function setData4($cabin_type)
    {
        $this->set(42, 142, $cabin_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 部屋割番号をセットします。
     * @param $cabin_allocation_number
     */
    public function setData5($cabin_allocation_number)
    {
        $this->set(10, 184, $cabin_allocation_number, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 大小幼区分をセットします。
     * @param $age_type
     */
    public function setData6($age_type)
    {
        $this->set(12, 194, $age_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 代表者区分をセットします。
     * @param $boss_type
     */
    public function setData7($boss_type)
    {
        $this->set(10, 206, $boss_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 乗船者英字姓をセットします。
     * @param $passenger_last_eij
     */
    public function setData8($passenger_last_eij)
    {
        $this->set(20, 216, $passenger_last_eij, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 乗船者英字名をセットします。
     * @param $passenger_first_eij
     */
    public function setData9($passenger_first_eij)
    {
        $this->set(20, 236, $passenger_first_eij, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 乗船者漢字姓をセットします。
     * @param $passenger_last_knj
     */
    public function setData10($passenger_last_knj)
    {
        $this->set(22, 256, $passenger_last_knj, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 乗船者漢字名をセットします。
     * @param $passenger_first_knj
     */
    public function setData11($passenger_first_knj)
    {
        $this->set(22, 278, $passenger_first_knj, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 乗船者カナ姓をセットします。
     * @param $passenger_last_kana
     */
    public function setData12($passenger_last_kana)
    {
        $this->set(20, 300, $passenger_last_kana, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 乗船者カナ名をセットします。
     * @param $passenger_first_kana
     */
    public function setData13($passenger_first_kana)
    {
        $this->set(20, 320, $passenger_first_kana, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 性別をセットします。
     * @param $gender
     */
    public function setData14($gender)
    {
        $this->set(8, 340, $gender, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 生年月日をセットします。
     * @param $birth_date
     */
    public function setData15($birth_date)
    {
        $this->set(10, 348, $birth_date, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 結婚記念日をセットします。
     * @param $wedding_anniversary
     */
    public function setData16($wedding_anniversary)
    {
        $this->set(10, 358, $wedding_anniversary, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 郵便番号をセットします。
     * @param $zip_code
     */
    public function setData17($zip_code)
    {
        $this->set(8, 368, $zip_code, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 都道府県をセットします。
     * @param $prefecture
     */
    public function setData18($prefecture)
    {
        $this->set(8, 376, $prefecture, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 住所１（市区町村）をセットします。
     * @param $address1
     */
    public function setData19($address1)
    {
        $this->set(102, 384, $address1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 住所２（番地以降）をセットします。
     * @param $address2
     */
    public function setData20($address2)
    {
        $this->set(102, 486, $address2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 住所３（建物名）をセットします。
     * @param $address3
     */
    public function setData21($address3)
    {
        $this->set(102, 588, $address3, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 電話番号１をセットします。
     * @param $tel1
     */
    public function setData22($tel1)
    {
        $this->set(16, 690, $tel1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 電話番号２をセットします。
     * @param $tel2
     */
    public function setData23($tel2)
    {
        $this->set(16, 706, $tel2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 緊急連絡先名前をセットします。
     * @param $emergency_contact_name
     */
    public function setData24($emergency_contact_name)
    {
        $this->set(42, 722, $emergency_contact_name, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 緊急連絡先名前カナをセットします。
     * @param $emergency_contact_kana
     */
    public function setData25($emergency_contact_kana)
    {
        $this->set(42, 764, $emergency_contact_kana, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 緊急連絡先電話番号をセットします。
     * @param $emergency_contact_tel
     */
    public function setData26($emergency_contact_tel)
    {
        $this->set(16, 806, $emergency_contact_tel, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 緊急連絡先続柄をセットします。
     * @param $emergency_contact_relationship
     */
    public function setData27($emergency_contact_relationship)
    {
        $this->set(12, 822, $emergency_contact_relationship, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 国籍をセットします。
     * @param $country
     */
    public function setData28($country)
    {
        $this->set(10, 834, $country, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 居住国をセットします。
     * @param $residence
     */
    public function setData29($residence)
    {
        $this->set(10, 844, $residence, ['overflow' => true]);
    }

    /**
     * 要求パラメータ パスポート番号をセットします。
     * @param $passport_number
     */
    public function setData30($passport_number)
    {
        $this->set(12, 854, $passport_number, ['overflow' => true]);
    }

    /**
     * 要求パラメータ パスポート発給日をセットします。
     * @param $passport_issued_date
     */
    public function setData31($passport_issued_date)
    {
        $this->set(10, 866, $passport_issued_date, ['overflow' => true]);
    }

    /**
     * 要求パラメータ パスポート発給地をセットします。
     * @param $passport_issued_place
     */
    public function setData32($passport_issued_place)
    {
        $this->set(10, 876, $passport_issued_place, ['overflow' => true]);
    }

    /**
     * 要求パラメータ パスポート失効日をセットします。
     * @param $passport_lose_date
     */
    public function setData33($passport_lose_date)
    {
        $this->set(10, 886, $passport_lose_date, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 子供食区分をセットします。
     * @param $child_meal_type
     */
    public function setData34($child_meal_type)
    {
        $this->set(32, 896, $child_meal_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 幼児食区分をセットします。
     * @param $item_code
     */
    public function setData35($infant_meal_type)
    {
        $this->set(32, 928, $infant_meal_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 記念日区分をセットします。
     * @param $anniversary_type
     */
    public function setData36($anniversary_type)
    {
        $this->set(32, 960, $anniversary_type, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 食事希望何回目をセットします。
     * @param $seating_request
     */
    public function setData37($seating_request)
    {
        $this->set(10, 992, $seating_request, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 客室タイプリクエストをセットします。
     * @param $cabin_type_request
     */
    public function setData38($cabin_type_request)
    {
        $this->set(42, 1002, $cabin_type_request, ['overflow' => true]);
    }

    /**
     * 要求パラメータ キャビンリクエスト備考をセットします。
     * @param $cabin_request_free
     */
    public function setData39($cabin_request_free)
    {
        $this->set(102, 1044, $cabin_request_free, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 割引券番号１をセットします。
     * @param $discount_number1
     */
    public function setData40($discount_number1)
    {
        $this->set(11, 1146, $discount_number1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 割引券番号２をセットします。
     * @param $discount_number2
     */
    public function setData41($discount_number2)
    {
        $this->set(11, 1157, $discount_number2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 割引券番号３をセットします。
     * @param $discount_number3
     */
    public function setData42($discount_number3)
    {
        $this->set(11, 1168, $discount_number3, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 割引券番号４をセットします。
     * @param $discount_number4
     */
    public function setData43($discount_number4)
    {
        $this->set(11, 1179, $discount_number4, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 割引券番号５をセットします。
     * @param $discount_number5
     */
    public function setData44($discount_number5)
    {
        $this->set(11, 1190, $discount_number5, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 食事アレルギー有無をセットします。
     * @param $question1
     */
    public function setData45($question1)
    {
        $this->set(32, 1201, $question1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 妊婦有無をセットします。
     * @param $question2
     */
    public function setData46($question2)
    {
        $this->set(32, 1233, $question2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 車椅子有無をセットします。
     * @param $question3
     */
    public function setData47($question3)
    {
        $this->set(32, 1265, $question3, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 健康をがいしている有無をセットします。
     * @param $question4
     */
    public function setData48($question4)
    {
        $this->set(32, 1297, $question4, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 備考１をセットします。
     * @param $remark1
     */
    public function setData49($remark1)
    {
        $this->set(302, 1329, $remark1, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 備考２をセットします。
     * @param $remark2
     */
    public function setData50($remark2)
    {
        $this->set(155, 1631, $remark2, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 備考３をセットします。
     * @param $remark3
     */
    public function setData51($remark3)
    {
        $this->set(155, 1786, $remark3, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 旅行社登録日をセットします。
     * @param $travel_company_new_register_date
     */
    public function setData52($travel_company_new_register_date)
    {
        $this->set(10, 1941, $travel_company_new_register_date, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 旅行社変更日をセットします。
     * @param $travel_company_last_update_date
     */
    public function setData53($travel_company_last_update_date)
    {
        $this->set(10, 1951, $travel_company_last_update_date, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 旅行社取消日をセットします。
     * @param $travel_company_delete_date
     */
    public function setData54($travel_company_delete_date)
    {
        $this->set(10, 1961, $travel_company_delete_date, ['overflow' => true]);
    }

    /**
     * 要求パラメータ 客室番号をセットします。
     * @param $cabin_number
     */
    public function setData55($cabin_number)
    {
        $this->set(4, 1971, $cabin_number, ['overflow' => true]);
    }

    /**
     * 回答ソケットを定義します。
     * @return array
     */
    public function parseResponse()
    {
        $response = [
            'import_management_number' => trim($this->parse(11, 16)),
            'import_date_time' => $this->parse(17, 27)
        ];
        return $response;
    }
}