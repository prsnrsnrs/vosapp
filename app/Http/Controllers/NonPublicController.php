<?php

namespace App\Http\Controllers;

use App\Libs\Voss\VossCacheManager;

/**
 * WEBサーバーのコントローラです
 * Class NonPublicController
 * @package App\Http\Controllers
 */
class NonPublicController extends BaseController
{

    /**
     * WEBサーバーのキャッシュを削除します
     */
    public function getCashFlush()
    {
        VossCacheManager::flush();
        return response()->json(['result' => true]);
    }
}