<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agent\Import\PostFileSelectRequest;
use App\Http\Requests\Agent\Import\PostImportRequest;
use App\Http\Services\Agent\Import\GetCompleteService;
use App\Http\Services\Agent\Import\GetConfirmService;
use App\Http\Services\Agent\Import\PostFileConfirmService;
use App\Http\Services\Agent\Import\PostFileImportCompleteService;
use App\Http\Services\Agent\Import\PostFileImportService;
use App\Http\Services\Agent\Import\PostFileSelectService;
use App\Http\Services\Agent\Import\GetListServices;

/**
 * 販売店一括登録画面
 * Class AgentImportController
 * @package App\Http\Controllers
 */
class AgentImportController extends BaseController
{
    /**
     * 初期表示:セッション削除
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFileSelect()
    {
        $service = new GetListServices();
        $service->execute();
        return view('agent/import/agent_import_add');
    }

    /**
     *  Step1 一括取り込み用ファイル指定する
     * @param PostFileSelectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFileSelect(PostFileSelectRequest $request)
    {
        $service = new PostFileSelectService();
        $service->execute();
        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * Step2 一括取り込み用ファイルの取り込み
     * @param PostImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postFileImport(PostImportRequest $request)
    {
        $service = new PostFileImportService();
        $service->execute();
        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 販売店一括登録確認画面 画面表示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getConfirm()
    {
        $service = new GetConfirmService();
        $service->execute();
        return view('agent/import/agent_import_confirm', $service->getResponseData());
    }

    /**
     * 販売店一括登録確認画面 販売店一括登録実行ボタン押下処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFileImportComplete()
    {
        $service = new PostFileConfirmService();
        $service->execute();
        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getResponseData(), 500);
        }
    }

    /**
     * 販売店一括登録結果画面　表示処理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getComplete()
    {
        $service = new GetCompleteService();
        $service->execute();

        return view('agent/import/agent_import_complete', $service->getResponseData());
    }
}