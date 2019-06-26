<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Operations\ImportFormatDefaultSettingOperation;

/**
 * 既定フォーマットの設定処理サービスです。
 * Class PostDefaultFormatService
 * @package App\Http\Services\Reservation\Import
 */
class PostDefaultFormatService extends BaseService
{

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        $operation = new ImportFormatDefaultSettingOperation();
        $operation->setFormatNumber(request('format_number'));
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.import.format_list');
    }
}