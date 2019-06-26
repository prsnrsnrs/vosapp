<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\GetAddressRequest;
use App\Http\Services\Address\GetAddressService;
use App\Http\Services\Address\GetCityService;
use App\Http\Services\Address\GetPrefectureService;
use App\Http\Services\Address\GetTownService;


/**
 * 郵便番号検索系のコントローラークラスです。
 * Class AddressController
 * @package App\Http\Controllers
 */
class AddressController extends BaseController
{
    /**
     * 都道府県選択画面のviewを返します
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View]
     */
    public function getPrefecture()
    {
        return view('address/address_prefecture_select', ['target' => request('target', '#zip_code')]);
    }

    /**
     * 市町村を取得し、viewに返します
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCity()
    {
        $service = new GetCityService();
        $service->execute();

        if ($service->isSuccess()) {
            return view('address/address_city_select', $service->getResponseData());
        } else {
            return view('address/address_city_select', $service->getErrorMessages());
        }
    }

    /**
     * 町名を取得し、viewに返します
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTown()
    {
        $service = new GetTownService();
        $service->execute();

        if ($service->isSuccess()) {
            return view('address/address_town_select', $service->getResponseData());
        } else {
            return view('address/address_town_select', $service->getErrorMessages());
        }
    }

    /**
     * 郵便番号から住所を返します。
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAddress(GetAddressRequest $request)
    {
        $service = new GetAddressService();
        $service->execute();
        return response()->json($service->getResponseData());
    }

}