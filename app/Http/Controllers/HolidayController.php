<?php

namespace App\Http\Controllers;

use App\Http\Services\Holiday\GetListService;

class HolidayController extends BaseController
{
    /**
     * 祝日データを返します。
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        $service = new GetListService();
        $service->execute();
        return response()->json($service->getResponseData());
    }
}