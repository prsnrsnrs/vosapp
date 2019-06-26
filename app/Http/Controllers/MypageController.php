<?php

namespace App\Http\Controllers;


/**
 * マイページのコントローラークラスです。
 * Class MypageController
 * @package App\Http\Controllers
 */
class MypageController extends BaseController
{
    /**
     * マイページ画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAgentMypage()
    {
        return view('mypage.agent_mypage');
    }

}