<?php

namespace App\Http\Controllers;

use App\Http\Services\Reservation\Document\GetDocumentPdfService;
use App\Http\Services\Reservation\Document\GetListService;
use App\Libs\StringUtil;


/**
 * 提出書類一覧のコントローラークラスです。
 * Class ReservationDocumentController
 * @package App\Http\Controllers
 */
class ReservationDocumentController extends BaseController
{
    /**
     * 提出書類
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $service = new GetListService();
        $service->execute();

        return view('reservation/document/reservation_document_list', $service->getResponseData());
    }

    /**
     * PDF出力(テスト)
     * @return \Illuminate\Http\Response
     */
    public function getDocumentPdf()
    {
        $service = new GetDocumentPdfService();
        $service->execute();
        $response_data = $service->getResponseData();

        $pdf = \PDF::loadView('pdf/document_download', $service->getResponseData());
        return $pdf->inline(StringUtil::downloadFileName($response_data['progress_manage_info']['progress_manage_short_name'] . '_' . $response_data['passenger_line_number'] . '.pdf'));
    }
}