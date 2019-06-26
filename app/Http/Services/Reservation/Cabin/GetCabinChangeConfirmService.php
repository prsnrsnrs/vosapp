<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CabinSelectOperation;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;
use function request;


/**
 * 客室タイプ変更確認のサービスです
 *
 * Class GetCabinChangeConfirmService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetCabinChangeConfirmService extends BaseService
{
    /**
     * 予約番号・一次予約番号
     * @var array
     */
    private $reservation_cabin;

    /**
     * 一次予約番号
     * @var string
     */
    private $temp_reservation_number;

    /**
     * 画面モード
     * @var string
     */
    private $mode;

    /**
     * 画面モード：新規
     */
    const MODE_NEW = 'new';

    /**
     * 画面モード：編集
     */
    const MODE_EDIT = 'edit';


    /**
     * 初期化します
     */
    public function init()
    {
        $this->reservation_cabin = VossSessionManager::get('reservation_cabin');
        $this->temp_reservation_number = $this->reservation_cabin['temp_reservation_number'];
        $this->mode = $this->getMode();
    }

    /**
     * 処理を実行します
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // パンくず取得
        $this->response_data['breadcrumbs'] = $this->getBreadCrumbs();

        // 予約見出し情報の取得
        $reservation_query = new ReservationQuery();
        $item_info = $reservation_query->getReservationByNumber($this->temp_reservation_number);
        $this->response_data['item_info'] = $item_info;
        $this->response_data['shipping_cruise_plan'] = shipping_cruise_plan($item_info);

        //タリフ情報の取得
        $temp_tariffs = $reservation_query->getTariffs($item_info['item_code']);
        $tariffs = [];
        foreach ($temp_tariffs as $key => $value) {
            $tariffs[$value['tariff_code']] = $value;
        }
        $this->response_data['tariffs'] = $tariffs;

        // 客室タイプ選択のソケット通信
        $operation = new CabinSelectOperation();
        $operation->setItemCode($item_info['item_code']);
        $operation->setCabinTypeCode(request('cabin_type'));
        $cabin_detail = $operation->execute();
        if ($cabin_detail['status'] === 'E') {
            $this->setSocketErrorMessages($cabin_detail['event_number']);
            return;
        }
        $this->response_data['detail'] = $cabin_detail;

        // 客室情報の取得
        $this->response_data['cabin'] = $reservation_query->getCabin($item_info['cruise_id'], request('cabin_type'));

        // 変更対象のご乗船者取得
        $passengers = $reservation_query->findReservationDetailsByNumber($this->temp_reservation_number);
        $group_by_cabin_line_number = collect($passengers)->groupBy('cabin_line_number')->toArray();
        $this->response_data['passengers'] = $group_by_cabin_line_number[request('cabin_line_number')];
    }

    /**
     * 画面モードを取得します
     * @return string
     */
    private function getMode()
    {
        $mode = '';
        if ($this->reservation_cabin['temp_reservation_number'] && !$this->reservation_cabin['reservation_number']) {
            $mode = self::MODE_NEW;
        } elseif ($this->reservation_cabin['temp_reservation_number'] && $this->reservation_cabin['reservation_number']) {
            $mode = self::MODE_EDIT;
        }
        return $mode;
    }

    /**
     * パンくずを取得します
     * @return array
     */
    private function getBreadCrumbs()
    {
        $breadcrumbs = [];
        if ($this->mode === self::MODE_NEW) {
            $breadcrumbs = [
                ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search'), 'confirm' => true],
                ['name' => 'ご乗船者名入力', 'url' => ext_route('reservation.cabin.passenger_entry')],
                ['name' => '客室タイプ選択', 'url' => ext_route('reservation.cabin.type_select', ['cabin_line_number' => request('cabin_line_number')])],
                ['name' => '客室タイプ変更確認']
            ];
        } else if ($this->mode === self::MODE_EDIT) {
            $breadcrumbs = [
                ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
                ['name' => '予約照会', 'url' => ext_route('reservation.detail', ['reservation_number' => VossSessionManager::get('reservation_cabin.reservation_number')]), 'confirm' => true],
                ['name' => 'ご乗船者名入力', 'url' => ext_route('reservation.cabin.passenger_entry')],
                ['name' => '客室タイプ選択', 'url' => ext_route('reservation.cabin.type_select', ['cabin_line_number' => request('cabin_line_number')])],
                ['name' => '客室タイプ変更確認']
            ];
        }

        return $breadcrumbs;
    }
}