<?php

namespace App\Http\Services\Agent\Import;

use App\Http\Services\BaseService;

/**
 * 販売店一括登録結果のサービスです。
 * Class GetCompleteService
 * @package App\Http\Services\Agent\Import
 */
class GetCompleteService extends BaseService
{
    /**
     *サービスの処理を実行します。
     */
    public function execute()
    {
        //インポート件数
        if(request()->has('import_data_count')){
            $this->response_data['import_data_count'] = request("import_data_count");
        }

        //エラー件数
        if(request()->has('import_data_count')){
            $this->response_data['import_error_count'] = request("import_error_count");
        }
    }
}