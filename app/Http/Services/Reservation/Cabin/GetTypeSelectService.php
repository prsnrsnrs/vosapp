<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\DateUtil;
use App\Libs\Voss\VossSessionManager;
use App\Operations\InquiryVacancyDetailOperation;
use App\Queries\ReservationQuery;


/**
 *
 * 客室タイプ選択のサービスです
 *
 * Class GetTypeSelectService
 * @package App\Http\Services\ReservationCabin
 */
class GetTypeSelectService extends BaseService
{
    /**
     * @var string
     */
    private $item_code;
    /**
     * @var string
     */
    private $cabin_line_number;
    /**
     * @var string
     */
    private $temp_reservation_number;
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var ReservationQuery
     */
    private $reservation_query;

    /**
     * サービスクラスを初期化します。
     */
    public function init()
    {
        // パラメータの取得
        $this->item_code = request('item_code');
        $this->cabin_line_number = request('cabin_line_number');
        $this->temp_reservation_number = VossSessionManager::get('reservation_cabin.temp_reservation_number');
        $this->reservation_number = VossSessionManager::get('reservation_cabin.reservation_number');
        // インスタンス初期化
        $this->reservation_query = new ReservationQuery();
    }

    /**
     * サービスクラスの処理を実行します。
     */
    public function execute()
    {
        /**
         * 画面モードの判定
         */
        $mode = $this->getMode();
        $this->response_data['mode'] = $mode;
        $this->response_data['breadcrumbs'] = $this->getBreadcrumbs($mode);
        $this->response_data['info_message'] = $this->getInfoMessage($mode);
        $this->response_data['next_route_name'] = $this->getNextRouteName($mode);

        // 商品情報の取得
        $item_info = $this->getItemInfo();
        $this->item_code = $item_info['item_code'];
        $this->response_data['item_info'] = $item_info;
        $this->response_data['item_code'] = $this->item_code;

        //タリフ情報の取得
        $tariffs = $this->reservation_query->getTariffs($item_info['item_code']);
        $this->response_data['tariffs'] = $tariffs;

        // 客室タイプ別料金空席照会のソケット通信
        $operation = new InquiryVacancyDetailOperation();
        $operation->setItemCode($this->item_code);
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }
        $this->response_data['inquiry_date_time'] = DateUtil::convertFormat($operation_result['inquiry_date_time'],
            'Y/m/d/ H:i');

        // 客室情報の取得
        $cabins = $this->reservation_query->getCabins($item_info['cruise_id']);
        foreach ($operation_result['cabins'] as &$row) {
            foreach ($cabins as $cabin) {
                if ($row['cabin_type'] === $cabin['cabin_type']) {
                    $row['cabin'] = $cabin;
                    break;
                }
            }
        }
        $this->response_data['cabins'] = $operation_result['cabins'];
    }

    /**
     * 画面モードを返します。
     * @return string
     */
    private function getMode()
    {
        // 画面モードの判定
        $mode = 'new';
        if (!$this->temp_reservation_number && !$this->reservation_number && $this->item_code && !$this->cabin_line_number) {
            $mode = "new";
        } elseif ($this->temp_reservation_number && !$this->reservation_number && !$this->item_code && !$this->cabin_line_number) {
            $mode = "new_add";
        } elseif ($this->temp_reservation_number && !$this->reservation_number && !$this->item_code && $this->cabin_line_number) {
            $mode = "new_change";
        } elseif ($this->temp_reservation_number && $this->reservation_number && !$this->item_code && !$this->cabin_line_number) {
            $mode = "edit_add";
        } elseif ($this->temp_reservation_number && $this->reservation_number && !$this->item_code && $this->cabin_line_number) {
            $mode = "edit_change";
        }
        return $mode;
    }

    /**
     * パンくずリストを返します。
     * @param string $mode
     * @return array
     */
    private function getBreadcrumbs(string $mode)
    {
        $breadcrumbs = [
            ['name' => 'マイページ', 'url' => ext_route('mypage')],
        ];
        if ($mode === 'new') {
            $breadcrumbs[] = ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search')];
            $breadcrumbs[] = ['name' => '客室タイプ選択'];
        } elseif ($mode === 'new_add' || $mode === 'new_change') {
            $breadcrumbs[] = ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search'), 'confirm' => true];
            $breadcrumbs[] = ['name' => 'ご乗船者名入力', 'url' => ext_route('reservation.cabin.passenger_entry')];
            $breadcrumbs[] = ['name' => '客室タイプ選択'];
        } else {
            $breadcrumbs[] = ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true];
            $breadcrumbs[] = [
                'name' => '予約照会',
                'url' => ext_route('reservation.detail', ['reservation_number' => $this->reservation_number]),
                'confirm' => true
            ];
            $breadcrumbs[] = ['name' => 'ご乗船者名入力', 'url' => ext_route('reservation.cabin.passenger_entry')];
            $breadcrumbs[] = ['name' => '客室タイプ選択'];
        }
        return $breadcrumbs;
    }

    /**
     * インフォメーションメッセージを返します。
     * @param string $mode
     * @return \Illuminate\Config\Repository|mixed|string
     */
    private function getInfoMessage(string $mode)
    {
        $info_message = "";
        if ($mode === 'new' || $mode === 'new_add' || $mode === 'edit_add') {
            $info_message = config('messages.info.I050-0101');
        } elseif ($mode === 'new_change' || $mode === 'edit_change') {
            $info_message = config('messages.info.I050-0103');
        }
        return $info_message;
    }

    /**
     * 次画面のroute名を返します。
     * @param string $mode
     * @return string
     */
    private function getNextRouteName(string $mode)
    {
        $route_name = "";
        if ($mode === 'new' || $mode === 'new_add' || $mode === 'edit_add') {
            $route_name = 'reservation.cabin.passenger_select';
        } elseif ($mode === 'new_change' || $mode === 'edit_change') {
            $route_name = 'reservation.cabin.change_confirm';
        }
        return $route_name;
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
            $item_info = $this->reservation_query->findCruiseByItemCode($this->item_code);
        }
        return $item_info;
    }


}