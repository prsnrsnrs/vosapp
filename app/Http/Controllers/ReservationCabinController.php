<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\PostCabinCreateRequest;
use App\Http\Requests\Reservation\Cabin\BaseCabinRequest;
use App\Http\Services\Reservation\Cabin\GetCabinChangeConfirmService;
use App\Http\Services\Reservation\Cabin\GetPassengerEntryService;
use App\Http\Services\Reservation\Cabin\GetPassengerSelectService;
use App\Http\Services\Reservation\Cabin\GetTypeSelectService;
use App\Http\Services\Reservation\Cabin\PostCabinAddService;
use App\Http\Services\Reservation\Cabin\PostCabinChangeConfirmService;
use App\Http\Services\Reservation\Cabin\PostCabinChangeService;
use App\Http\Services\Reservation\Cabin\PostCabinCreateService;
use App\Http\Services\Reservation\Cabin\PostCabinDeleteService;
use App\Http\Services\Reservation\Cabin\PostCabinPassengerAddService;
use App\Http\Services\Reservation\Cabin\PostCabinPassengerDeleteService;
use App\Http\Services\Reservation\Cabin\PostReservationDoneService;

/**
 * 客室系のコントローラーです
 * Class ReservationCabinController
 * @package App\Http\Controllers
 */
class ReservationCabinController extends BaseController
{

    /**
     * 客室タイプ選択
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTypeSelect()
    {
        $service = new GetTypeSelectService();
        $service->execute();

        return view('reservation/cabin/reservation_cabin_type_select', $service->getResponseData());
    }

    /**
     * 客室人数選択
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPassengerSelect()
    {
        $service = new GetPassengerSelectService();
        $service->execute();

        return view('reservation/cabin/reservation_cabin_passenger_select', $service->getResponseData());
    }

    /**
     * 客室人数選択：客室追加処理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postCabinCreate(PostCabinCreateRequest $request)
    {
        $service = new PostCabinCreateService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者名入力
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPassengerEntry()
    {
        $service = new GetPassengerEntryService();
        $service->execute();

        return view('reservation/cabin/reservation_cabin_passenger_entry', $service->getResponseData());
    }

    /**
     * ご乗船者名入力：客室一人追加処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCabinPassengerAdd(BaseCabinRequest $request)
    {
        $service = new PostCabinPassengerAddService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者名入力：客室一人削除処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCabinPassengerDelete(BaseCabinRequest $request)
    {
        $service = new PostCabinPassengerDeleteService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者名入力：客室タイプ追加処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCabinAdd(BaseCabinRequest $request)
    {
        $service = new PostCabinAddService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者名入力：客室タイプ削除処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCabinDelete(BaseCabinRequest $request)
    {
        $service = new PostCabinDeleteService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者名入力：予約確定処理
     * @param BaseCabinRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postReservationDone(BaseCabinRequest $request)
    {
        $service = new PostReservationDoneService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者名入力：客室タイプ変更処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCabinChange(BaseCabinRequest $request)
    {
        $service = new PostCabinChangeService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 客室タイプ変更確認画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function getCabinChangeConfirm()
    {
        $service = new GetCabinChangeConfirmService();
        $service->execute();

        return view('reservation/cabin/reservation_cabin_change_confirm', $service->getResponseData());
    }

    /**
     * 客室タイプ変更確認：客室タイプ変更処理
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postCabinChangeConfirm()
    {
        $service = new PostCabinChangeConfirmService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

}
