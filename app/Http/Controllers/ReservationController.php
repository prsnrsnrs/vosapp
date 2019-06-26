<?php

namespace App\Http\Controllers;


use App\Http\Services\Reservation\GetDetailService;
use App\Http\Services\Reservation\GetReservationCancelService;
use App\Http\Services\Reservation\GetRoomingService;
use App\Http\Services\Reservation\PostBeforeCabinCancelService;
use App\Http\Services\Reservation\PostBeforeCabinEditService;
use App\Http\Services\Reservation\PostReservationCancelService;
use App\Http\Services\Reservation\PostRoomingService;

/**
 * 予約系のコントローラーです
 * Class ReservationController
 * @package App\Http\Controllers
 */
class ReservationController extends BaseController
{
    /**
     * 予約照会
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetail()
    {
        $service = new GetDetailService();
        $service->execute();

        return view('reservation/reservation_detail', $service->getResponseData());
    }

    /**
     * 予約照会 (客室追加・変更クリック) 客室追加・変更に進む前の事前処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBeforeCabinEdit()
    {
        $service = new PostBeforeCabinEditService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 予約照会 (予約取消クリック) 予約取消に進む前の事前処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBeforeCabinCancel()
    {
        $service = new PostBeforeCabinCancelService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 全面取消確認
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReservationCancel()
    {
        $service = new GetReservationCancelService();
        $service->execute();
        return view('reservation/reservation_cancel', $service->getResponseData());
    }

    /**
     * 全面取消確認：予約取消処理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postReservationCancel()
    {
        $service = new PostReservationCancelService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ルーミング変更
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRooming()
    {
        $service = new GetRoomingService();
        $service->execute();
        return view('reservation/reservation_rooming', $service->getResponseData());
    }

    /**
     * ルーミング変更：確定処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRooming()
    {
        $service = new PostRoomingService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }


}