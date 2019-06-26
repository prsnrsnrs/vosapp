<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\PostAgentLoginRequest;
use App\Http\Services\Login\GetAgentLogoutService;
use App\Http\Services\Login\PostAgentLoginService;

/**
 * ログインのコントローラーです
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends BaseController
{
    /**
     * 旅行社向け：ログイン画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAgentLogin()
    {
        return view('login.agent_login');
    }

    /**
     * 旅行社向け：ログイン処理
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAgentLogin(PostAgentLoginRequest $request)
    {
        $service = new PostAgentLoginService();
        $service->execute();

        if ($service->isSuccess()) {
            return response()->json($service->getResponseData());
        } else {
            return response()->json($service->getErrorMessages(), 500);
        }
    }

    /**
     * 旅行社向け：ログアウト処理
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAgentLogout()
    {
        $service = new GetAgentLogoutService();
        $service->execute();
        return response()->redirectTo(ext_route('login'));
    }
}