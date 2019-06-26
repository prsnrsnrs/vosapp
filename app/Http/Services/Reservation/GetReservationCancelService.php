<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 全画面取消のサービスです
 *
 * Class GetDetailService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetReservationCancelService extends BaseService
{

    private $session;

    /**
     * 初期化します
     */
    protected function init()
    {
        // セッション情報の取得
        $this->session = VossSessionManager::get('reservation_cancel');
        if (!$this->session) {
            throw new NotFoundHttpException();
        }
    }

    public function execute()
    {
        // 現在のサイトを判定
        $this->response_data['is_user_site'] = VossAccessManager::isUserSite();

        //インチャージ期間か判定
        $this->response_data['in_charge'] = $this->session['in_charge'];

        // 予約見出し情報の取得
        $query = new ReservationQuery();
        $this->response_data['item_info'] = $query->getReservationByNumber($this->session['temp_reservation_number']);

        // 予約詳細情報の取得
        $reservation_details = $query->findReservationDetailsByNumber($this->session['temp_reservation_number']);
        $format_data = $this->formatReservationDetail($reservation_details);
        $this->response_data['cabins'] = $format_data['cabins'];
        $this->response_data['charger'] = $format_data['charger'];

        return true;
    }


    /**
     * ビュー側で表示しやすいようにデータを整形
     * @param $reservation_details
     * @return array
     */
    private function formatReservationDetail($reservation_details)
    {

        $items = new Collection($reservation_details);
        $group_by_cabins = $items->groupBy('cabin_line_number');

        $cabins = [];
        foreach ($group_by_cabins as $cabin_line_number => $key) {
            // 一階層深いので浅くする
            $cabins[$cabin_line_number] = $key->first();
            $cabins[$cabin_line_number]['passengers'] = $group_by_cabins[$cabin_line_number]->toArray();
        }

        $travel = 0;  // 旅行代金合計
        $discount = 0;  // 割引券金額合計
        $cancel = 0;  // 取消料等
        foreach ($reservation_details as $passenger) {
            $travel += (int)$passenger['total_travel_charge'];
            $discount += (int)$passenger['total_discount_charge'];
            $cancel += (int)$passenger['total_cancel_charge'];
        }

        $response = [];
        array_push($response, [
            'charger' => [
                'travel' => $travel,
                'discount' => $discount,
                'cancel' => $cancel,
                'total' => $travel + $discount - $cancel  // ご請求額合計
            ],
            'cabins' => $cabins
        ]);

        return $response[0];
    }
}


