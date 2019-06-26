<?php
namespace App\Http\Services\Agent\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;

/**
 * 販売店一括登録 初期表示処理
 * Class getListServices
 * @package App\Http\Services\Agent\Import
 */
class getListServices extends BaseService
{
    /**
     * 処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //TODO:販売店複数登録 keyは実装後に適当なものに変更する
        VossSessionManager::forget("agent.agent_import");
    }
}