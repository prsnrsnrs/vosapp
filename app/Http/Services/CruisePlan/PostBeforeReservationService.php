<?php

namespace App\Http\Services\CruisePlan;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;

/**
 * (予約ボタンクリック時)
 * 予約に進む前の事前処理サービスです。
 * Class PostBeforeReservationService
 * @package App\Http\Services\CruisePlan
 */
class PostBeforeReservationService extends BaseService
{
    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // セッション情報の削除
        VossSessionManager::forget("reservation_cabin");
        $this->response_data['redirect'] = ext_route('reservation.cabin.type_select', ['item_code' => request('item_code')]);
    }
}