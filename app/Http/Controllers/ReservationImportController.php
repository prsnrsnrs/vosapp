<?php

namespace App\Http\Controllers;


use App\Http\Requests\Reservation\Import\PostAddFormatRequest;
use App\Http\Requests\Reservation\Import\PostImportRequest;
use App\Http\Requests\Reservation\Import\PostUpdateFormatRequest;
use App\Http\Services\Reservation\Import\GetFileSelectService;
use App\Http\Services\Reservation\Import\GetFormatDownloadService;
use App\Http\Services\Reservation\Import\GetFormatListService;
use App\Http\Services\Reservation\Import\GetFormatSettingService;
use App\Http\Services\Reservation\Import\GetResultService;
use App\Http\Services\Reservation\Import\PostAddFormatService;
use App\Http\Services\Reservation\Import\PostCopyFormatService;
use App\Http\Services\Reservation\Import\PostDefaultFormatService;
use App\Http\Services\Reservation\Import\PostDeleteFormatService;
use App\Http\Services\Reservation\Import\PostImportByJTBService;
use App\Http\Services\Reservation\Import\PostImportService;
use App\Http\Services\Reservation\Import\PostUpdateFormatService;
use App\Libs\Voss\VossAccessManager;

/**
 * 予約一括取り込みのコントローラーです。
 * Class ReservationImportController
 * @package App\Http\Controllers
 */
class ReservationImportController extends BaseController
{
    /**
     * 一括取込ファイル指定
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFileSelect()
    {
        $service = new GetFileSelectService();
        $service->execute();
        return view('reservation/import/reservation_import_file_select', $service->getResponseData());
    }

    /**
     * フォーマットファイルダウンロード
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getFormatDownload()
    {
        $service = new GetFormatDownloadService();
        $service->execute();

        $response_data = $service->getResponseData();
        return response($response_data['contents'], 200, $response_data['headers']);
    }

    /**
     * 取込結果一覧画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getResult()
    {
        $service = new GetResultService();
        $service->execute();
        return view('reservation/import/reservation_import_result', $service->getResponseData());
    }

    /**
     * 取込フォーマット管理画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFormatList()
    {
        $service = new GetFormatListService();
        $service->execute();
        return view('reservation/import/reservation_import_format_list', $service->getResponseData());
    }

    /**
     * 取込フォーマット設定画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFormatSetting()
    {
        $service = new GetFormatSettingService();
        $service->execute();
        return view('reservation/import/reservation_import_format_setting', $service->getResponseData());
    }

    /**
     * 予約一括取込処理
     * @param PostImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postImport(PostImportRequest $request)
    {
        if (VossAccessManager::isJTBAgent()) {
            $service = new PostImportByJTBService();
        } else {
            $service = new PostImportService();
        }
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 既定フォーマットの設定処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDefaultFormat()
    {
        $service = new PostDefaultFormatService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * フォーマットの登録処理
     * @param PostAddFormatRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postAddFormat(PostAddFormatRequest $request)
    {
        $service = new PostAddFormatService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * フォーマットの更新処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateFormat(PostUpdateFormatRequest $request)
    {
        $service = new PostUpdateFormatService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * フォーマットの複製処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCopyFormat()
    {
        $service = new PostCopyFormatService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * フォーマットの削除処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteFormat()
    {
        $service = new PostDeleteFormatService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }
}