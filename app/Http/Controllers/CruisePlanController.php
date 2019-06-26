<?php

namespace App\Http\Controllers;

use App\Http\Requests\CruisePlan\GetSearchRequest;
use App\Http\Services\CruisePlan\GetSearchService;
use App\Http\Services\CruisePlan\PostBeforeReservationService;


/**
 * クルーズプラン検索系のコントローラークラスです。
 * Class CruisePlanController
 * @package App\Http\Controllers
 */
class CruisePlanController extends BaseController
{
    /**
     * クルーズブラン検索画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSearch(GetSearchRequest $request)
    {
        $service = new GetSearchService();
        $service->execute();
        return view('cruise_plan/cruise_plan_search', $service->getResponseData());
    }

    /**
     * (予約ボタンクリック時) 予約に進む前の事前処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBeforeReservation()
    {
        $service = new PostBeforeReservationService();
        $service->execute();
        return response()->json($service->getResponseData());
    }
}