<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\Input\PostCabinRequestChangeRequest;
use App\Http\Requests\Reservation\Input\PostDiscountChangeRequest;
use App\Http\Requests\Reservation\Input\PostPassengerRequest;
use App\Http\Requests\Reservation\Input\PostPassengerRequestChangeRequest;
use App\Http\Requests\Reservation\Input\PostQuestionChangeRequest;
use App\Http\Services\Reservation\Input\GetCabinRequestService;
use App\Http\Services\Reservation\Input\GetDiscountService;
use App\Http\Services\Reservation\Input\GetPassengerRequestService;
use App\Http\Services\Reservation\Input\GetPassengerService;
use App\Http\Services\Reservation\Input\GetQuestionService;
use App\Http\Services\Reservation\Input\PostCabinRequestChangeService;
use App\Http\Services\Reservation\Input\PostDiscountChangeService;
use App\Http\Services\Reservation\Input\PostPassengerRequestChangeService;
use App\Http\Services\Reservation\Input\PostPassengerService;
use App\Http\Services\Reservation\Input\PostQuestionChangeService;

/**
 * 予約詳細入力系のコントローラークラスです。
 * Class ReservationInputController
 * @package App\Http\Controllers
 */
class ReservationInputController extends BaseController
{
    /**
     * ご乗船者詳細入力
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPassenger()
    {
        $service = new GetPassengerService();
        $service->execute();

        return view('reservation/input/reservation_input_passenger', $service->getResponseData());
    }

    /**
     * ご乗船者詳細入力の更新
     * @param PostPassengerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPassenger(PostPassengerRequest $request)
    {
        $service = new PostPassengerService();
        $service->execute();
        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }

    }

    /**
     * 客室リクエスト入力
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function getCabinRequest()
    {
        $service = new GetCabinRequestService();
        $service->execute();

        return view('reservation/input/reservation_input_cabin_request', $service->getResponseData());
    }

    /**
     * 客室リクエスト入力の更新
     * @param PostCabinRequestChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCabinRequestChange(PostCabinRequestChangeRequest $request)
    {
        $service = new PostCabinRequestChangeService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * ご乗船者リクエスト入力
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPassengerRequest()
    {
        $service = new GetPassengerRequestService();
        $service->execute();

        return view('reservation/input/reservation_input_passenger_request', $service->getResponseData());
    }

    /**
     * ご乗船者リクエスト入力の更新
     * @param PostPassengerRequestChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPassengerRequestChange(PostPassengerRequestChangeRequest $request)
    {
        $service = new PostPassengerRequestChangeService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 割引情報入力
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDiscount()
    {
        $service = new GetDiscountService();
        $service->execute();

        return view('reservation/input/reservation_input_discount', $service->getResponseData());
    }

    /**
     * 割引情報入力の更新
     * @param PostDiscountChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDiscountChange(PostDiscountChangeRequest $request)
    {
        $service = new PostDiscountChangeService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 質問事項のチェック
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getQuestion()
    {
        $service = new GetQuestionService();
        $service->execute();

        return view('reservation/input/reservation_input_question', $service->getResponseData());
    }

    /**
     * 質問事項のチェックの更新
     * @param PostQuestionChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postQuestionChange(PostQuestionChangeRequest $request)
    {
        $service = new PostQuestionChangeService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }
}