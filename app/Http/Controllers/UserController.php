<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\PostPasswordResetRequest;
use App\Http\Services\User\GetPasswordResetService;
use App\Http\Services\User\PostPasswordResetService;

/**
 * ユーザー情報系のコントローラです。
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends BaseController
{
    /**
     * パスワード再設定
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPasswordReset()
    {
        $service = new GetPasswordResetService();
        $service->execute();
        return view('user/user_password_reset', $service->getResponseData());
    }

    /**
     * パスワード再設定処理
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