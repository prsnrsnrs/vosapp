<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\Contact\GetListRequest;
use App\Http\Services\Reservation\Contact\GetDetailForApsService;
use App\Http\Services\Reservation\Contact\GetDetailService;
use App\Http\Services\Reservation\Contact\GetListService;


/**
 * ご連絡系のコントローラークラスです。
 * Class ReservationContactController
 * @package App\Http\Controllers]
 */
class ReservationContactController extends BaseController
{
    /**
     * ご連絡一覧
     * @param GetListRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function getList(GetListRequest $request)
    {
        $service = new GetListService();
        $service->execute();

        return view('reservation/contact/reservation_contact_list', $service->getResponseData());
    }

    /**
     * ご連絡閲覧
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetail()
    {
        $service = new GetDetailService();
        $service->execute();

        return view('reservation/contact/reservation_contact_detail', $service->getResponseData());
    }

    /**
     * i5専用のメール確認
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetailForAps(){
        $service = new  GetDetailForApsService();
        $service->execute();
        return view('reservation/contact/reservation_contact_detail_for_aps',$service->getResponseData());
    }
}