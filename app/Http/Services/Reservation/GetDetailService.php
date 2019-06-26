<?php

namespace App\Http\Services\Reservation;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;

/**
 * 予約照会のサービスです
 *
 * Class GetDetailService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetDetailService extends BaseService
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
        $reservation_details = $query->findReservationDetailsByNumber(request('reservation_number'), true);
        $format_data = $this->formatReservationDetail($reservation_details);
        $this->response_data['cabins'] = $format_data['cabins'];
        $this->response_data['charger'] = $format_data['charger'];
        $this->response_data['counts'] = $format_data['counts'];

        // アクセス中のサイト判断
        $this->response_data['is_site'] = $this->getIsSite();

        // インフォメーションメッセージ取得
        $this->response_data['info_message'] = $this->getInformationMessage();

        // 予約詳細の変更可能期間内なのか判断
        $this->response_data['expired'] = $this->getReservationStatus();

        // 遷移先パラメータ用にセッション上書
        VossSessionManager::set('return_param', [
            'route_name' => request()->route()->getName(),
            'reservation_number' => request('reservation_number')
        ]);

    }


    /**
     * 販売店なのかユーザー向けなのか配列で返します
     * @return array
     */
    private function getIsSite()
    {
        return [
            'agent' => VossAccessManager::isAgent(),
            'agent_test' => VossAccessManager::isAgentTestSite(),
            'user' => VossAccessManager::isUserSite()
        ];
    }


    /**
     * インフォメーションメッセージを返します
     *
     * @param $is_site
     * @return \Illuminate\Config\Repository|mixed|string
     */
    private function getInformationMessage()
    {
        $message = '';

        if (VossAccessManager::isAgent()) {
            $message = config('messages.info.I050-0801');
        } else {
            if (VossAccessManager::isUserSite()) {
                $message = config('messages.info.I050-0802');
            }
        }
        return $message;
    }


    /**
     * ビューで表示しやすいようにデータを整形します
     *
     * @param $reservation_details
     * @return array
     */
    private function formatReservationDetail($reservation_details)
    {
        $response = [];

        // 客室ごとに振り分け
        $items = new Collection($reservation_details);
        $group_by_cabins = $items->groupBy('cabin_line_number');
        $cabins = [];
        $canceled_cabin = 0;
        foreach ($group_by_cabins as $cabin_line_number => $key) {
            //客室内乗船者が全員CXの場合は取消客室数を1ずつ足していく
            $collect = new Collection($key);
            $is_canceled_cabin = $collect->whereNotIn('reservation_status', ["CX"])->all() ? false : true;
            if ($is_canceled_cabin) {
                $canceled_cabin += 1;
            }
            // 一階層深いので浅くする
            $cabins[$cabin_line_number] = $key->first();
            $cabins[$cabin_line_number]['passengers'] = $group_by_cabins[$cabin_line_number]->toArray();
        }
        // 旅行代金、割引券金額、取消料等,ステータスがCXの乗船者を計算
        $travel = 0;
        $discount = 0;
        $cancel = 0;
        $cancel_passenger = 0;
        foreach ($reservation_details as $passenger) {
            $travel += (int)$passenger['total_travel_charge'];
            $discount += (int)$passenger['total_discount_charge'];
            $cancel += (int)$passenger['total_cancel_charge'];
            if ($passenger['reservation_status'] === "CX") {
                $cancel_passenger += 1;
            }
        }

        array_push($response, [
            'charger' => [
                'travel' => $travel,
                'discount' => $discount,
                'cancel' => $cancel,
                'total' => $travel + $discount - $cancel
            ],
            'counts' => [
                'passenger' => count($reservation_details) - $cancel_passenger,
                'cabin' => count($cabins) - $canceled_cabin,
            ],
            'cabins' => $cabins
        ]);

        return $response[0];
    }

    /**
     * 予約詳細の入力できるかどうか判断します
     *
     * @return null
     */
    private function getReservationStatus()
    {
        // TODO：予約の詳細を変更できる期間であるか判断する処理

        // return 'disabled';
        return null;
    }

}


