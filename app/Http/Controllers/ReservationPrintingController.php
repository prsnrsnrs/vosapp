<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\Printing\GetPrintingListRequest;
use App\Http\Services\Reservation\Printing\GetCancelServiceForAPS;
use App\Http\Services\Reservation\Printing\GetDetailServiceForAPS;
use App\Http\Services\Reservation\Printing\GetDocumentServiceForAPS;
use App\Http\Services\Reservation\Printing\GetListService;
use App\Http\Services\Reservation\Printing\GetTicketServiceForAPS;
use App\Http\Services\Reservation\Printing\PostCancelService;
use App\Http\Services\Reservation\Printing\PostCsvService;
use App\Http\Services\Reservation\Printing\PostDetailService;
use App\Http\Services\Reservation\Printing\PostDocumentService;
use App\Http\Services\Reservation\Printing\PostTicketService;
use App\Libs\StringUtil;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

/**
 * 乗船者控えと確認書印刷のコントローラークラスです
 * Class ReservationPrintingController
 * @package App\Http\Controllers
 */
class ReservationPrintingController extends BaseController
{

    /**
     * 乗船券控え・確認書の印刷画面
     * @param GetPrintingListRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function getList(GetPrintingListRequest $request)
    {
        $service = new GetListService();
        $service->execute();

        return view('reservation/printing/reservation_printing_list', $service->getResponseData());
    }

    /**
     * 乗船券控えのPDF出力を行います
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getTicket()
    {
        $service = new PostTicketService();
        $service->execute();

        if ($service->isSuccess()) {
            $response = $service->getResponseData();
            $pdf = PDF::loadView('reservation/printing/reservation_printing_ticket', $response);
            return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
        } else {
            return view('error/popup', $service->getErrorMessages());
        }
    }

    /**
     * 予約確認書のPDF出力を行います
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getDocument()
    {

        $service = new PostDocumentService();
        $service->execute();

        $response = $service->getResponseData();
        $pdf = PDF::loadView('reservation/printing/reservation_printing_document', $response)
            ->setOption('header-right', '（[page] ／ [topage]）')
            ->setOption('header-font-name', 'ＭＳ 明朝')
            ->setOption('header-font-size', 10)
            ->setOption('margin-right', 3)
            ->setOption('margin-bottom', 0);
        return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
    }

    /**
     * 予約内容確認書のPDF出力を行います
     * @return mixed
     */
    public function getDetail()
    {
        $service = new PostDetailService();
        $service->execute();

        $response = $service->getResponseData();
        $pdf = PDF::loadView('reservation/printing/reservation_printing_detail', $response)
            ->setOption('header-right', '（[page] ／ [topage]）')
            ->setOption('header-font-name', 'ＭＳ 明朝')
            ->setOption('header-font-size', 10)
            ->setOption('margin-right', 3)
            ->setOption('margin-bottom', 0);

        return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
    }

    /**
     * 取消記録確認書のPDF出力を行います
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getCancel()
    {
        $service = new PostCancelService();
        $service->execute();

        $response = $service->getResponseData();
        $pdf = PDF::loadView('reservation/printing/reservation_printing_cancel', $response)
            ->setOption('header-right', '（[page] ／ [topage]）')
            ->setOption('header-font-name', 'ＭＳ 明朝')
            ->setOption('header-font-size', 10)
            ->setOption('margin-right', 3)
            ->setOption('margin-bottom', 0);;
        return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
    }

    /**
     * csv出力を行います。
     * @throws \Exception
     */
    public function getCsv()
    {
        $service = new PostCsvService();
        $service->execute();
    }


    /**
     * 乗船券控えのPDF出力を行います : APSより出力
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getTicketForAps()
    {
        $service = new GetTicketServiceForAPS();
        $service->execute();

        if ($service->isSuccess()) {
            $response = $service->getResponseData();
            $pdf = PDF::loadView('reservation/printing/reservation_printing_ticket', $response);
            return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
        } else {
            return view('error/popup', $service->getErrorMessages());
        }
    }

    /**
     * 予約確認書のPDF出力を行います : APSより出力
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getDocumentForAps()
    {
        $service = new GetDocumentServiceForAPS();
        $service->execute();

        $response = $service->getResponseData();
        $pdf = PDF::loadView('reservation/printing/reservation_printing_document', $response)
            ->setOption('header-right', '（[page] ／ [topage]）')
            ->setOption('header-font-name', 'ＭＳ 明朝')
            ->setOption('header-font-size', 10)
            ->setOption('margin-right', 3)
            ->setOption('margin-bottom', 0);
        return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
    }

    /**
     * 予約内容確認書のPDF出力を行います : APSより出力
     * @return mixed
     */
    public function getDetailForAps()
    {
        $service = new GetDetailServiceForAPS();
        $service->execute();

        $response = $service->getResponseData();
        $pdf = PDF::loadView('reservation/printing/reservation_printing_detail', $response)
            ->setOption('header-right', '（[page] ／ [topage]）')
            ->setOption('header-font-name', 'ＭＳ 明朝')
            ->setOption('header-font-size', 10)
            ->setOption('margin-right', 3)
            ->setOption('margin-bottom', 0);
        return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
    }


    /**
     * 取消記録確認書のPDF出力を行います : APSより出力
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getCancelForAps()
    {
        $service = new GetCancelServiceForAPS();
        $service->execute();

        $response = $service->getResponseData();
        $pdf = PDF::loadView('reservation/printing/reservation_printing_cancel', $response)
            ->setOption('header-right', '（[page] ／ [topage]）')
            ->setOption('header-font-name', 'ＭＳ 明朝')
            ->setOption('header-font-size', 10)
            ->setOption('margin-right', 3)
            ->setOption('margin-bottom', 0);
        return $pdf->inline(StringUtil::downloadFileName($response['file_name']));
    }
}