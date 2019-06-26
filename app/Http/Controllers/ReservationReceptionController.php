<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\Reception\GetReceptionListRequest;
use App\Http\Services\Reservation\Reception\GetGroupService;
use App\Http\Services\Reservation\Reception\GetReceptionListService;
use App\Http\Services\Reservation\Reception\PostGroupService;


/**
 * 受付一覧系のコントローラークラスです。
 * Class ReservationReceptionController
 * @package App\Http\Controllers
 */
class ReservationReceptionController extends BaseController
{
    /**
     * 予約受付一覧
     * @param GetReceptionListRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReceptionList(GetReceptionListRequest $request)
    {
        $service = new GetReceptionListService();
        $service->execute();

        return view('reservation/reception/reservation_reception_list', $service->getResponseData());
    }

    /**
     * グループ設定
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getGroup()
    {
        $service = new GetGroupService();
        $service->execute();

        return response()->json(['view' => view()->make('reservation/reception/reservation_reception_group', $service->getResponseData())->render()]);
    }

    /**
     * グループ設定処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGroup()
    {
        $service = new PostGroupService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }
}