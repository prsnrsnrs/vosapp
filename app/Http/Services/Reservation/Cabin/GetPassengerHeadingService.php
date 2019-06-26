<?php


namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\PassengerHeadingOperation;
use function request;


/**
 * 乗船者見出情報変更ソケットを送信します
 *
 * Class GetCabinTypeChangeConfirmService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetPassengerHeadingService extends BaseService
{
    public function execute()
    {
        // ご乗船者
        $passengers = request('passengers');
        // インスタンス生成
        $operation = new PassengerHeadingOperation();
        // 一次ワーク管理番号）
        $temp_work_number = 0;
        // 一次予約番号
        if (request('type') === 'cancel') {
            $temp_reservation_number = VossSessionManager::get('reservation_cancel.temp_reservation_number');
        } else {
            $temp_reservation_number = VossSessionManager::get('reservation_cabin.temp_reservation_number');
        }

        // レコード区分：開始
        $record_status = config('const.record_status.value.begin');
        $operation->setRecordStatus($record_status);
        $operation->setTempWorkNumber($temp_work_number);
        $operation->setTempReservationNumber($temp_reservation_number);
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            return $result['event_number'];
        }
        $temp_work_number = $result['temp_work_number'];
        $operation->reset();

        // レコード区分：データ
        $record_status = config('const.record_status.value.data');
        for ($i = 1; $i <= count($passengers); $i++) {
            $operation->setRecordStatus($record_status);
            $operation->setTempWorkNumber($temp_work_number);
            $operation->setTempReservationNumber($temp_reservation_number);
            $operation->setShowPassengerLineNumber($passengers[$i]['show_passenger_line_number']);
            $operation->setPassengerLineNumber($passengers[$i]['passenger_line_number']);
            $operation->setPrePassengerLineNumber($passengers[$i]['pre_passenger_line_number']);
            $operation->setBossStatus($passengers[$i]['boss_status']);
            $operation->setPassengerLastEij($passengers[$i]['passenger_last_eij']);
            $operation->setPassengerFirstEij($passengers[$i]['passenger_first_eij']);
            $result = $operation->execute();
            if ($result['status'] === 'E') {
                return $result['event_number'];
            }
            $operation->reset();
        }

        // レコード区分：終了
        $record_status = config('const.record_status.value.finish');
        $operation->setRecordStatus($record_status);
        $operation->setTempWorkNumber($temp_work_number);
        $operation->setTempReservationNumber($temp_reservation_number);
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            return $result['event_number'];
        }
        $operation->reset();

        return $result;
    }
}