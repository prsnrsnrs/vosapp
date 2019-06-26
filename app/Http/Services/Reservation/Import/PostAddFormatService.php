<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossUplClient;
use App\Operations\ImportFormatAddOperation;
use App\Queries\ImportQuery;
use Illuminate\Http\UploadedFile;

/**
 * フォーマットの登録処理サービスです
 *
 * Class PostAddFormatService
 * @package App\Http\Services\Reservation\Import
 */
class PostAddFormatService extends BaseService
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
     * @var UploadedFile
     */
    protected $import_file;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->auth = VossAccessManager::getAuth();
        $this->import_query = new ImportQuery();
        $this->import_file = request()->file('import_file');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        $operation = new ImportFormatAddOperation();
        $operation->setFormatName(request('format_name'));
        $operation->setFileType(request('file_type'));
        $operation->setHeaderLineNumber(request('header_line_number'));
        $operation->setImportStartLineNumber(request('import_start_line_number'));
        $operation_result = $operation->execute();
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }

        // フォーマットファイルの保存
        $disk = 'reservation_import_format';
        $uploaded_file_path = $this->import_file->getRealPath();
        $save_path = $this->auth['travel_company_code'];
        $save_file_name = $operation_result['format_number'] . '.' . config('const.file_type.extension.' . request('file_type'));
        VossUplClient::upload($disk, $uploaded_file_path, $save_path, $save_file_name);

        $this->response_data['message'] = config('messages.alert.A100-0101');
        $this->response_data['redirect'] = ext_route('reservation.import.format_setting', ['format_number' => $operation_result['format_number']]);
    }
}