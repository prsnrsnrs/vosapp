<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agent\PostEditRequest;
use App\Http\Requests\Agent\PostPasswordResetMailRequest;
use App\Http\Services\Agent\GetDetailService;
use App\Http\Services\Agent\GetEditService;
use App\Http\Services\Agent\GetListService;
use App\Http\Services\Agent\PostDeleteService;
use App\Http\Services\Agent\PostEditService;
use App\Http\Services\Agent\PostPasswordResetMailService;

/**
 * 販売店管理画面のコントローラです。
 * Class AgentController
 * @package App\Http\Controllers
 */
class AgentController extends BaseController
{
    /**
     * 販売店一覧画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        // 検索処理
        $service = new GetListService();
        $service->execute();

        return view('agent/agent_list', $service->getResponseData());
    }

    /**
     * 販売店削除処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete()
    {
        $service = new PostDeleteService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 販売店追加・変更画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit()
    {
        $service = new GetEditService();
        $service->execute();

        return view('agent/agent_edit', $service->getResponseData());
    }

    /**
     * 販売店登録・更新処理
     * @param PostEditRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit(PostEditRequest $request)
{
    $service = new PostEditService();
    $service->execute($request);

    if ($service->isSuccess()) {
        return response()->json($service->getResponseData());
    } else {
        return response()->json($service->getErrorMessages(),500);
    }
}

    /**
     * 販売店・ユーザ情報
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetail()
    {
        // 検索処理
        $service = new GetDetailService();
        $service->execute();

        return view('agent/agent_detail', $service->getResponseData());
    }
}