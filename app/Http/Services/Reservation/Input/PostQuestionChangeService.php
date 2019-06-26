<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Operations\QuestionChangeOperation;


/**
 * 質問事項入力更新のサービスクラスです。
 * Class PostQuestionChangeService
 * @package App\Http\Services\Reservation\Input
 */
class PostQuestionChangeService extends BaseService
{
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var string
     */
    private $last_update_date_time;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->last_update_date_time = request('last_update_date_time');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        if (!$this->sendQuestionChangeOperation()) {
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.detail', ['reservation_number' => $this->reservation_number]);
    }

    /**
     * 質問事項チェックの変更ソケット送信
     * @return bool
     * @throws \Exception
     */
    private function sendQuestionChangeOperation()
    {
        $operation = new QuestionChangeOperation();

        //開始
        $operation->setRecordType('1');
        $operation->setTempWorkManagementNumber('0');
        $operation->setReservationNumber($this->reservation_number);
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result1['event_number']);
            return false;
        }

        // データ
        foreach (request('passengers') as $display_line_number => $passenger) {
            //回答1～10まで値がない場合は空を入れる
            $end_question = request('questions') + 1;
            for ($i = $end_question; $i <= 10; $i++) {
                $passenger['answers'][$i] = "";
            }
            $data = request('passengers');
            $operation->reset();
            $operation->setRecordType('2');
            $operation->setTempWorkManagementNumber($operation_result1['temp_work_number']);
            $operation->setReservationNumber($this->reservation_number);
            $operation->setPassengerLineNumber($passenger['passenger_line_number']);
            $operation->setDisplayLineNumber($passenger['display_line_number']);
            $operation->setAnswer1($passenger['answers'][1]);
            $operation->setAnswer2($passenger['answers'][2]);
            $operation->setAnswer3($passenger['answers'][3]);
            $operation->setAnswer4($passenger['answers'][4]);
            $operation->setAnswer5($passenger['answers'][5]);
            $operation->setAnswer6($passenger['answers'][6]);
            $operation->setAnswer7($passenger['answers'][7]);
            $operation->setAnswer8($passenger['answers'][8]);
            $operation->setAnswer9($passenger['answers'][9]);
            $operation->setAnswer10($passenger['answers'][10]);
            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                $this->setSocketErrorMessages($operation_result2['event_number']);
                return false;
            }
        }

        // 終了
        $operation->reset();
        $operation->setRecordType('9');
        $operation->setTempWorkManagementNumber($operation_result1['temp_work_number']);
        $operation->setReservationNumber($this->reservation_number);
        $operation->setConfirmUpdateDateTime($this->last_update_date_time);
        $operation_result9 = $operation->execute();
        if ($operation_result9['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result9['event_number']);
            return false;
        }
        return true;
    }
}