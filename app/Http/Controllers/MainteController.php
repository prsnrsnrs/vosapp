<?php

namespace App\Http\Controllers;

use App\Http\Services\Mainte\GetCashFlashService;

/**
 * メンテナンス系のコントローラーです
 * Class MainteController
 * @package App\Http\Controllers
 */
class MainteController extends BaseController
{

    /**
     * APサーバー、WEBサーバーのキャッシュを削除します
     * @throws \App\Exceptions\VossException
     */
    public function getCashFlash()
    {
        $service = new GetCashFlashService();
        $service->execute();

        echo 'キャッシュクリア成功';
        exit;
    }
}