<?php

namespace App\Http\Services\Agent\Import;

use App\Http\Services\BaseService;
use App\Libs\ImportUtil;
use Illuminate\Http\UploadedFile;


/**
 * 販売点一括登録ファイル指定時の処理を実施します。
 * Class GetFileSelectService
 * @package App\Http\Services\Agent\Import
 */
class PostFileSelectService extends BaseService
{
    /**
     * CSVファイル
     * @var UploadedFile
     */
    protected $import_csv_file;

    /**
     * 初期化処理を実行します。
     */
    protected  function init(){
        //CSVファイルを取得
        $this->import_csv_file = request()->file('import_csv_file');
    }

    /** サービスを実行します。
     * @return mixed|void
     */
    public function execute()
    {
        if(request()->has('import_csv_file')){

            //CSVのファイルパス取得
            $real_file_path = $this->import_csv_file->getRealPath();

            //アップロードファイルの0キロバイトチェック
            if (filesize($real_file_path) === 0) {
                $this->setErrorMessage(config('messages.error.E000-0019'));
                return;
            }

            //販売店一括登録CSVファイルの1行目データ取得
            $import_header_data = ImportUtil::readHeading($real_file_path,'1');
            $this->response_data['header_data'] = $import_header_data;
        }
    }
}