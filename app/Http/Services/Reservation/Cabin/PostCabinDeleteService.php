<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CabinDeleteOperation;
use function request;


/**
 * 客室人数選択：客室タイプ削除のサービスです
 * Class PostCabinDeleteService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostCabinDeleteService extends BaseService
{

    /**
     * @var string 登録モード
     */
    private $insert_mode;

    /**
     * パラメーターを初期化します
     */
    public function init()
    {
        $this->insert_mode = request('insert_mode');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // 乗船者見出しソケット
        $passenger_heading = new GetPassengerHeadingService();
        $result = $passenger_heading->execute();
        if (!is_array($result)) {
            $this->setSocketErrorMessages($result);
            return;
        };

        //インチャージ期間前の場合のレスポンスデータ作成
        $this->response_data['confirm'] = [
            'message' => '取り消しますか？',
            'mode' => 'cabin_cancel'
        ];

        // 客室タイプ削除ソケット
        $operation = new CabinDeleteOperation();
        $operation->setTempReservationNumber(VossSessionManager::get('reservation_cabin.temp_reservation_number'));
        $operation->setDeleteCabinLineNumber(request('cabin_line_number'));
        $operation->setShowCabinLineNumber(request('show_cabin_line_number'));
        $operation->setInsertMode(config('const.insert_mode.value.' . $this->insert_mode));
        $result = $operation->execute();
        if ($result['status'] === config('const.answer_status.value.request')) {
            // 回答ソケットのステータスが"R"（要求あり）の場合
            $this->response_data['confirm']['message'] = config('messages.alert.A050-0207');
            return;
        } else if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        } else if ($result['status'] === 'S' && $this->insert_mode === 'force') {
            unset($this->response_data['confirm']);
            return;
        }
    }
}