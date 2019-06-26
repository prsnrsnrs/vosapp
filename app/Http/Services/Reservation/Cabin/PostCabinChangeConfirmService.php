<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CabinChangeOperation;
use function request;


/**
 *  客室タイプ変更確認画面：客室タイプ変更処理のサービスです
 * Class PostCabinChangeConfirmService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostCabinChangeConfirmService extends BaseService
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
     * サービスの処理を行います
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {

        // 客室タイプ変更ソケット
        $operation = new CabinChangeOperation();
        $operation->setTempReservationNumber(VossSessionManager::get('reservation_cabin.temp_reservation_number'));
        $operation->setCabinLineNumber(request('cabin_line_number'));
        $operation->setCabinType(request('cabin_type'));
        $operation->setInsertMode(config('const.insert_mode.value.' . $this->insert_mode));
        $result = $operation->execute();

        if ($result['status'] === config('const.answer_status.value.request')) {
            // 回答ソケットのステータスが"R"（要求あり）の場合
            $this->response_data['confirm'] = [
                'message' => config('messages.alert.A050-0205'),
            ];
            return;
        } else if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }

        $this->response_data['redirect'] = ext_route('reservation.cabin.passenger_entry');

    }
}