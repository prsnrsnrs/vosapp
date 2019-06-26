<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CabinSelectOperation;
use App\Queries\ReservationQuery;

/**
 * 客室人数選択のサービスです
 *
 * Class GetPassengerSelectService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetPassengerSelectService extends BaseService
{
    /**
     * @var ReservationQuery
     */
    private $reservation_query;
    /**
     * @var string
     */
    private $temp_reservation_number;


    /**
     * サービスクラスを初期化します。
     */
    public function init()
    {
        // パラメータの取得;
        $this->response_data['cabin_type'] = request('cabin_type');
        $this->temp_reservation_number = VossSessionManager::get('reservation_cabin.temp_reservation_number');
        // インスタンス初期化
        $this->reservation_query = new ReservationQuery();
    }


    public function execute()
    {
        // 画面モード
        $mode = $this->getMode();
        $this->response_data['mode'] = $mode;
        $this->response_data['breadcrumbs'] = $this->getBreadcrumbs($mode);

        // 商品情報の取得
        $item_info = $this->getItemInfo();
        $this->response_data['item_info'] = $item_info;
        $this->item_code = $item_info['item_code'];

        //タリフ情報の取得
        $temp_tariffs = $this->reservation_query->getTariffs($item_info['item_code']);
        $tariffs = [];
        foreach ($temp_tariffs as $key => $value) {
            $tariffs[$value['tariff_code']] = $value;
        }
        $this->response_data['tariffs'] = $tariffs;

        // 客室タイプ選択ソケット送信
        $operation = new CabinSelectOperation();
        $operation->setItemCode($item_info['item_code']);
        $operation->setCabinTypeCode(request('cabin_type'));
        $cabin_by_type = $operation->execute();
        if ($cabin_by_type['status'] === 'E') {
            $this->setSocketErrorMessages($cabin_by_type['event_number']);
            return;
        }
        $this->response_data['cabin_by_type'] = $cabin_by_type;

        // 客室情報の取得
        $this->response_data['cabin_detail'] = $this->reservation_query->getCabin($item_info['cruise_id'],
            request('cabin_type'));
    }

    /**
     * 商品情報を返します。
     * @return array
     */
    private function getItemInfo()
    {
        // 商品情報の取得
        if ($this->temp_reservation_number) {
            // 予約見出し情報の取得
            $item_info = $this->reservation_query->getReservationByNumber($this->temp_reservation_number);
        } else {
            // 商品情報の取得
            $item_info = $this->reservation_query->findCruiseByItemCode(request('item_code'));
        }
        return $item_info;
    }

    /**
     * 画面モードを返します。
     * @return string
     */
    private function getMode()
    {
        $reservation_number = VossSessionManager::get('reservation_cabin.reservation_number');
        // 画面モードの判定
        $mode = 'new';
        if (!$this->temp_reservation_number && !$reservation_number) {
            $mode = "new";
        } elseif ($this->temp_reservation_number && !$reservation_number) {
            $mode = "new_add";
        } elseif ($this->temp_reservation_number && $reservation_number) {
            $mode = "edit_add";
        }
        return $mode;
    }

    /**
     * パンくずを返します
     * @param $mode
     * @return array $$breadcrumbs
     */
    private function getBreadcrumbs($mode)
    {
        $breadcrumbs = [];
        if ($mode === 'new') {
            $breadcrumbs = [
                ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search'), 'confirm' => true],
                [
                    'name' => '客室タイプ選択',
                    'url' => ext_route('reservation.cabin.type_select', ['item_code' => request('item_code')])
                ],
                ['name' => '客室人数選択']
            ];
        } else {
            if ($mode === 'new_add') {
                $breadcrumbs = [
                    ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                    ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search'), 'confirm' => true],
                    ['name' => 'ご乗船者名入力', 'url' => ext_route('reservation.cabin.passenger_entry')],
                    ['name' => '客室タイプ選択', 'url' => ext_route('reservation.cabin.type_select')],
                    ['name' => '客室人数選択']
                ];
            } else {
                if ($mode === 'edit_add') {
                    $breadcrumbs = [
                        ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                        ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
                        [
                            'name' => '予約照会',
                            'url' => ext_route('reservation.detail',
                                ['reservation_number' => VossSessionManager::get('reservation_cabin.reservation_number')]),
                            'confirm' => 'true'
                        ],
                        ['name' => 'ご乗船者名入力', 'url' => ext_route('reservation.cabin.passenger_entry')],
                        ['name' => '客室タイプ選択', 'url' => ext_route('reservation.cabin.type_select')],
                        ['name' => '客室人数選択']
                    ];
                }
            }
        }

        return $breadcrumbs;
    }


}