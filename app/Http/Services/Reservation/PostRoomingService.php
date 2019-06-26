<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Operations\RoomingChangeOperation;
use function request;

/**
 * ルーミング変更：ルーミング変更処理です
 * Class PostRoomingService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostRoomingService extends BaseService
{

    const STATUS_SUCCESS = 'success';

    const STATUS_REQUEST = 'request';

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // 予約番号
        $reservation_number = request('reservation_number');
        // ご乗船者
        $passengers = request('passengers');
        // 一次ワーク管理番号）
        $temp_work_number = 0;
        // 客室ルーミング変更
        $operation = new RoomingChangeOperation();

        // レコード区分：開始
        $record_status = config('const.record_status.value.begin');
        $operation->setRecordStatus($record_status);
        $operation->setTempWorkNumber($temp_work_number);
        $operation->setReservationNumber($reservation_number);
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }
        $temp_work_number = $result['temp_work_number'];
        $operation->reset();

        // レコード区分：データ
        $record_status = config('const.record_status.value.data');
        for ($i = 1; $i <= count($passengers); $i++) {
            $operation->setRecordStatus($record_status);
            $operation->setTempWorkNumber($temp_work_number);
            $operation->setReservationNumber($reservation_number);
            $operation->setPassengerLineNumber($passengers[$i]['passenger_line_number']);
            $operation->setShowPassengerLineNumber($passengers[$i]['show_passenger_line_number']);
            $operation->setCabinLineNumber($passengers[$i]['select_cabin_line_number']);
            $result = $operation->execute();
            if ($result['status'] === 'E') {
                $this->setSocketErrorMessages($result['event_number']);
                return;
            }
            $operation->reset();
        }

        // レコード区分：チェック
        $record_status = config('const.record_status.value.check');
        $operation->setRecordStatus($record_status);
        $operation->setTempWorkNumber($temp_work_number);
        $operation->setReservationNumber($reservation_number);
        $operation->setUpdateDateTime(request('last_update_date_time'));
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        } elseif ($result['status'] === 'R' && request('checked') === 'false') {
            // 料金に増額があるかつ、ユーザーに未確認の場合
            $this->response_data['status'] = self::STATUS_REQUEST;
            return;
        }
       $temp_reservation_number = $result['temp_reservation_number'];

        // レコード区分：終了
        $record_status = config('const.record_status.value.finish');
        $operation->setRecordStatus($record_status);
        $operation->setTempWorkNumber($temp_work_number);
        $operation->setReservationNumber($reservation_number);
        $operation->setUpdateDateTime(request('last_update_date_time'));
        $operation->setTempReservationNumber($temp_reservation_number);
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }
        $this->response_data['status'] = self::STATUS_SUCCESS;
        $this->response_data['redirect'] = ext_route('reservation.detail', ['reservation_number' => $reservation_number]);

    }
}