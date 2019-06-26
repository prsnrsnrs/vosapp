<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Operations\DiscountChangeOperation;


/**
 * 割引情報入力更新のサービスクラスです。
 * 次へ(質問事項)クリック時、スキップ(照会へ)クリック時
 * Class PostDiscountChangeService
 * @package App\Http\Services\Reservation\Input
 */
class PostDiscountChangeService extends BaseService
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
     * @var string
     */
    private $success_message;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->last_update_date_time = request('last_update_date_time');
        $this->success_message = request('success_message');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        if (!$this->sendDiscountChangeOperation()) {
            return;
        }

        if ($this->success_message == 'need') {
            $this->setRedirectSuccessMessage(config('messages.info.I050-0502'));
        }
        $this->response_data['redirect'] = ext_route('reservation.input.question', ['reservation_number' => $this->reservation_number]);
    }

    /**
     * 割引券情報変更ソケット送信
     * @return bool
     * @throws \Exception
     */
    private function sendDiscountChangeOperation()
    {
        $operation = new DiscountChangeOperation();

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
        foreach (request('passengers') as $passenger) {
            //割引券番号を昇順にソート(ブランクデータは後ろにセット)
            $passenger['discount_number'] = collect($passenger['discount_number'])->sortBy(function ($value, $key) {
                return $value ? $key : $key + 99;
            })->toArray();
            //キーを0～4に振りなおす
            $passenger['discount_number'] = array_values($passenger['discount_number']);

            $operation->reset();
            $operation->setRecordType('2');
            $operation->setTempWorkManagementNumber($operation_result1['temp_work_number']);
            $operation->setReservationNumber($this->reservation_number);
            $operation->setPassengerLineNumber($passenger['passenger_line_number']);
            $operation->setDisplayLineNumber($passenger['display_line_number']);
            $operation->setDiscountNumber1($passenger['discount_number'][0]);
            $operation->setDiscountNumber2($passenger['discount_number'][1]);
            $operation->setDiscountNumber3($passenger['discount_number'][2]);
            $operation->setDiscountNumber4($passenger['discount_number'][3]);
            $operation->setDiscountNumber5($passenger['discount_number'][4]);
            $operation->setTariffCode($passenger['tariff_code']);
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