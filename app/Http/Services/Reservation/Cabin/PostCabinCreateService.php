<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CabinAddOperation;
use App\Operations\CabinCreateOperation;
use function request;


/**
 *  客室人数選択：客室追加のサービスです
 *
 * Class PostCabinCreateService
 * @package App\Http\Services\Reservation\Cabin
 */
class PostCabinCreateService extends BaseService
{
    /**
     * @var String
     */
    private $temp_reservation_number;
    /**
     * @var String
     */
    private $reservation_number;
    /**
     * @var String
     */
    private $item_code;
    /**
     * @var String
     */
    private $cabin_type;
    /**
     * @var array
     */
    private $passengers;


    /**
     * サービスクラスを初期化します。
     */
    public function init()
    {
        // パラメーターの初期化
        $this->temp_reservation_number = VossSessionManager::get('reservation_cabin.temp_reservation_number');
        $this->reservation_number = VossSessionManager::get('reservation_cabin.reservation_number');
        $this->item_code = request('item_code');
        $this->cabin_type = request('cabin_type');
        $this->passengers = $this->formatPassengers(request('passengers'));
    }


    public function execute()
    {
        // モードを判定
        $mode = $this->getMode();

        if ($mode === 'new') {
            $reservation = $this->sendCabinTypeCreate();
            if (!$reservation) {
                return;
            }
            // 新規作成はセッションに保存
            $this->setSessionReservationNumber($reservation);

        } elseif ($mode === 'new_add' || $mode == 'edit_add') {
            if (!$this->sendCabinTypeAdd()) {
                return;
            }
        }
        $this->response_data['redirect'] = ext_route('reservation.cabin.passenger_entry');
    }

    /**
     * 画面モードを返します。
     * @return string
     */
    private function getMode()
    {
        // 画面モードの判定
        $mode = 'new';
        if (!$this->temp_reservation_number && !$this->reservation_number && $this->item_code) {
            $mode = "new";
        } elseif ($this->temp_reservation_number && !$this->reservation_number && !$this->item_code) {
            $mode = "new_add";
        } elseif ($this->temp_reservation_number && $this->reservation_number && !$this->item_code) {
            $mode = "edit_add";
        }
        return $mode;
    }


    /**
     * 一次予約番号を発番します
     * @return array|bool
     */
    private function sendCabinTypeCreate()
    {
        // 客室タイプ新規作成（一次予約）ソケット送信
        $operation = new CabinCreateOperation();
        $operation->setItemCode($this->item_code);
        $operation->setCabinTypeCode($this->cabin_type);
        for ($i = 0; $i < 3; $i++) {
            $operation->setHumanTypeAdult($this->passengers[$i]['adult'], $i);
            $operation->setHumanTypeChildren($this->passengers[$i]['children'], $i);
            $operation->setHumanTypeChild($this->passengers[$i]['child'], $i);
        }
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return false;
        }
        return $result;
    }


    /**
     * 予約番号をセッションに保存します
     */
    private function setSessionReservationNumber($reservation)
    {
        $reservation_con = array_merge([
            'temp_reservation_number' => '',
            'reservation_number' => '',
        ], VossSessionManager::get("reservation_cabin", []), ['temp_reservation_number' => $reservation['temp_reservation_number']]);
        VossSessionManager::set("reservation_cabin", $reservation_con);
    }


    /**
     *  客室タイプを追加します
     * @return bool
     */
    private function sendCabinTypeAdd()
    {
        // 客室タイプ追加ソケット送信
        $operation = new CabinAddOperation();
        $operation->setTempReservationNumber($this->temp_reservation_number);
        $operation->setCabinTypeCode($this->cabin_type);
        for ($i = 0; $i < 3; $i++) {
            $operation->setHumanTypeAdult($this->passengers[$i]['adult'], $i);
            $operation->setHumanTypeChildren($this->passengers[$i]['children'], $i);
            $operation->setHumanTypeChild($this->passengers[$i]['child'], $i);
        }
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return false;
        }
        return true;
    }


    /**
     * 乗船者人数情報を整形します
     * @param $passengers
     * @return array
     */
    private function formatPassengers($passengers)
    {
        if (count($passengers) <= 3) {
            for ($i = 3 - count($passengers); $i <= 3; $i++) {
                array_push($passengers, []);
            }
        }
        $array = [];
        for ($i = 0; $i < 3; $i++) {
            $array[$i] = array_merge([
                'adult' => '0',
                'children' => '0',
                'child' => '0'
            ], $passengers[$i]);
        }
        return $array;
    }


}