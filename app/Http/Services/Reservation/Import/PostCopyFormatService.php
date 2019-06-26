<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossUplClient;
use App\Operations\ImportFormatCopyOperation;
use App\Queries\ImportQuery;

/**
 * フォーマットの複製処理サービスです。
 * Class PostCopyFormatService
 * @package App\Http\Services\Reservation\Import
 */
class PostCopyFormatService extends BaseService
{
    /**
     * @var array
     */
    private $auth;
    /**
     * @var ImportQuery
     */
    private $import_query;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->auth = VossAccessManager::getAuth();
        $this->import_query = new ImportQuery();
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // 取込フォーマットコピーソケット
        $operation = new ImportFormatCopyOperation();
        $operation->setOriginalFormatNumber(request('format_number'));
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }
        // フォーマットファイルのコピー
        $this->copyFormatFile(request('format_number'), $operation_result['copy_to_format_number']);
        $this->response_data['redirect'] = ext_route('reservation.import.format_list');
    }

    /**
     * フォーマットファイルをコピーします。
     * @param $format_number
     * @param $copy_to_format_number
     * @return bool
     */
    private function copyFormatFile($format_number, $copy_to_format_number)
    {
        $format_header = $this->import_query->getFormatHeader($this->auth['travel_company_code'], $format_number);

        $disk = 'reservation_import_format';
        $from_path = $format_header['upload_file_name'];
        $ext = substr($from_path, strrpos($from_path, '.') + 1);
        $to_path = $this->auth['travel_company_code'] . DIRECTORY_SEPARATOR . $copy_to_format_number . '.' . $ext;
        return VossUplClient::copy($disk, $from_path, $to_path);
    }
}