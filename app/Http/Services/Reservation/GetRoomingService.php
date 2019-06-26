<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;

/**
 * ルーミング変更のサービスです
 *
 * Class GetRoomingService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetRoomingService extends BaseService
{

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // 予約見出し情報の取得
        $query = new ReservationQuery();
        $this->response_data['item_info'] = $query->getReservationByNumber(request('reservation_number'));

        // 予約詳細情報の取得
        $reservation_details = $query->findReservationDetailsByNumber(request('reservation_number'));
        $this->response_data['cabins'] = $this->formatReservationDetail($reservation_details);
    }


    /**
     * ビューで表示しやすいようにデータを整形します
     * @param $reservation_details
     * @return array
     */
    private function formatReservationDetail($reservation_details)
    {
        // 客室ごとに振り分け
        $items = new Collection($reservation_details);
        $group_by_cabins = $items->groupBy('cabin_line_number');
        $cabins = [];
        foreach ($group_by_cabins as $cabin_line_number => $key) {
            // 一階層深いので浅くする
            $cabins[$cabin_line_number] = $key->first();
            $cabins[$cabin_line_number]['passengers'] = $group_by_cabins[$cabin_line_number]->toArray();
        }
        return $cabins;
    }
}


