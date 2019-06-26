<?php

namespace App\Http\Services\Agent\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Operations\AgentImportCompleteOperation;

/**
 * 販売店一括登録確認画面 登録処理実行ボタン押下処理
 * Class PostFileConfirmService
 * @package App\Http\Services\Agent\Import
 */
class PostFileConfirmService extends BaseService
{
    /**
     * 一次インポート管理No
     * @var string
     */
    protected $importManagementNumber;

    /**
     * 初期化処理を実行します
     */
    protected function init()
    {
        //一次インポート管理No取得
        $this->importManagementNumber = request('import_management_number');
    }

    /**
     * サービスを実行します
     * @return mixed|void
     */
    public function execute()
    {
        //ソケット通信用
        $operation_result = $this->socketComplete($this->importManagementNumber);

        //ソケット通信結果から成功データ数取得
        $import_success_count = $operation_result['import_count'];
        if ($import_success_count === "0000") {
            $import_success_count = 0;
        } else {
            $import_success_count = ltrim($import_success_count, "0");
        }

        //一次インポートソケット通信時のデータ数を取得
        $request_success_count = request('import_count');
        //エラーデータ数算出
        $import_error_count = $request_success_count - $import_success_count;

        //セッション削除
        VossSessionManager::forget('import_data');


        //複数一括登録完了画面に遷移する
        $this->response_data['redirect'] = ext_route('import.file_complete',
            ['import_data_count' => $import_success_count, 'import_error_count' => $import_error_count]);
    }

    /**
     * 旅行社販売店複数登録ソケット
     */
    private function socketComplete($import_management_number)
    {
        $operation = new AgentImportCompleteOperation();
        $operation->setImportManagementNumber($import_management_number);
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            return $operation_result;
        }
        return $operation_result;
    }
}