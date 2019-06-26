<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agent\User\PostEditRequest;
use App\Http\Requests\Agent\User\PostPasswordResetMailRequest;
use App\Http\Requests\Agent\User\PostPasswordResetRequest;
use App\Http\Services\Agent\User\GetEditService;
use App\Http\Services\Agent\User\GetPasswordResetService;
use App\Http\Services\Agent\User\PostDeleteService;
use App\Http\Services\Agent\User\PostEditService;
use App\Http\Services\Agent\User\PostPasswordResetMailService;
use App\Http\Services\Agent\User\PostPasswordResetService;

/**
 * 販売店ユーザー管理画面のコントローラです。
 * Class AgentUserController
 * @package App\Http\Controllers
 */
class AgentUserController extends BaseController
{
    /**
     * 販売店・ユーザー情報画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit()
    {
        $service = new GetEditService();
        $service->execute();
        return view('agent/user/agent_user_edit', $service->getResponseData());
    }


    /**
     * ユーザー作成画面登録/変更用
     * @param PostEditRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */

    public function postEdit(PostEditRequest $request)
    {
        $service = new PostEditService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(),500);
        }
    }

    /**
     * 販売店ユーザー情報削除処理
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
     * 販売店ユーザー情報パスワード再設定メール送信
     * @param PostPasswordResetMailRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postPasswordResetMail(PostPasswordResetMailRequest $request)
    {

        $service = new PostPasswordResetMailService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 販売店ユーザー パスワード再設定
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPasswordReset()
    {
        $service = new GetPasswordResetService();
        $service->execute();
        return view('agent/user/agent_user_password_reset', $service->getResponseData());
    }

    /**
     * 販売店ユーザー パスワード再設定処理
     * @param PostPasswordResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPasswordReset(PostPasswordResetRequest $request)
    {
        $service = new PostPasswordResetService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }
}