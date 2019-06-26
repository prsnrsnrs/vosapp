<?php

namespace App\Operations;

/**
 * 質問事項チェックの変更ソケットのメッセージクラスです
 * Class QuestionChangeOperation
 * @package App\Operations
 */
class QuestionChangeOperation extends BaseOperation
{

    /**
     * 初期化します
     */
    public function init()
    {
        $this->setCommonOperationCode('345');
        $this->setRecordType("");
        $this->setTempWorkManagementNumber("");
        $this->setReservationNumber("");
        $this->setPassengerLineNumber("");
        $this->setDisplayLineNumber("");
        $this->setAnswer1("");
        $this->setAnswer2("");
        $this->setAnswer3("");
        $this->setAnswer4("");
        $this->setAnswer5("");
        $this->setAnswer6("");
        $this->setAnswer7("");
        $this->setAnswer8("");
        $this->setAnswer9("");
        $this->setAnswer10("");
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
     * 要求パラメータ 質問1回答をセットします。
     * @param $answer1
     */
        public function setAnswer1($answer1)
    {
        $this->set(1, 70, $answer1);
    }

    /**
     * 要求パラメータ 質問2回答をセットします。
     * @param $answer2
     */
    public function setAnswer2($answer2)
    {
        $this->set(1, 71, $answer2);
    }

    /**
     * 要求パラメータ 質問3回答をセットします。
     * @param $answer3
     */
    public function setAnswer3($answer3)
    {
        $this->set(1, 72, $answer3);
    }

    /**
     * 要求パラメータ 質問4回答をセットします。
     * @param $answer4
     */
    public function setAnswer4($answer4)
    {
        $this->set(1, 73, $answer4);
    }

    /**
     * 要求パラメータ 質問5回答をセットします。
     * @param $answer5
     */
    public function setAnswer5($answer5)
    {
        $this->set(1, 74, $answer5);
    }
    /**
     * 要求パラメータ 質問6回答をセットします。
     * @param $answer6
     */
    public function setAnswer6($answer6)
    {
        $this->set(1, 75, $answer6);
    }

    /**
     * 要求パラメータ 質問7回答をセットします。
     * @param $answer7
     */
    public function setAnswer7($answer7)
    {
        $this->set(1, 76, $answer7);
    }

    /**
     * 要求パラメータ 質問8回答をセットします。
     * @param $answer8
     */
    public function setAnswer8($answer8)
    {
        $this->set(1, 77, $answer8);
    }

    /**
     * 要求パラメータ 質問9回答をセットします。
     * @param $answer9
     */
    public function setAnswer9($answer9)
    {
        $this->set(1, 78, $answer9);
    }

    /**
     * 要求パラメータ 質問10回答をセットします。
     * @param $answer10
     */
    public function setAnswer10($answer10)
    {
        $this->set(1, 79, $answer10);
    }

    /**
     * 要求パラメータ 確認更新日時をセットします。
     * @param $confirm_update_date_time
     */
    public function setConfirmUpdateDateTime($last_update_date_time)
    {
        $this->set(17, 80, $last_update_date_time);
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