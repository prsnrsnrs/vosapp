<?php

namespace App\Http\Services\Reservation\Reception;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Queries\ReceptionQuery;


/**
 * グループ設定のサービスクラスです
 * Class GetGroupListService
 * @package App\Http\Services\Reservation\Reception
 */
class GetGroupService extends BaseService
{
    /**
     * @var array
     */
    private $auth;
    /**
     * @var string
     */
    private $cruise_id;
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var ReceptionQuery
     */
    private $reception_query;

    /**
     * サービスを初期化します。
     */
    public function init()
    {
        $this->auth = VossAccessManager::getAuth();
        $this->cruise_id = request('cruise_id');
        $this->reservation_number = request('reservation_number');
        $this->reception_query = new ReceptionQuery();
    }

    /**
     * サービスの処理を実行します
     * @return mixed|void
     */
    public function execute()
    {
        // グループ対象の予約の取得
        $reservations = $this->reception_query->getReservationGroups($this->cruise_id, $this->auth['travel_company_code'], $this->auth['agent_code']);

        // グループ対象から親となる予約情報を抽出
        $selected_reservation = [];
        $len = count($reservations);
        for ($i = 0; $i < $len; $i++) {
            if ($reservations[$i]['reservation_number'] === $this->reservation_number) {
                $selected_reservation = $reservations[$i];
                unset($reservations[$i]);
                $reservations = array_values($reservations);
                break;
            }
        }

        // トラベルウィズが設定済みの場合、同一グループを上位にくるよう並び替え
        $travelwith_number = $selected_reservation['travelwith_number'];
        if ($travelwith_number) {
            $len = count($reservations);
            $same_group = [];
            for ($i = 0; $i < $len; $i++) {
                if ($reservations[$i]['travelwith_number'] === $travelwith_number) {
                    $same_group[] = $reservations[$i];
                    unset($reservations[$i]);
                }
            }
            $reservations = array_merge($same_group, $reservations);
        }

        $this->response_data['selected_reservation'] = $selected_reservation;
        $this->response_data['reservations'] = $reservations;
    }
}