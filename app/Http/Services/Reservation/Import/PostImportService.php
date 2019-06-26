<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Libs\DateUtil;
use App\Libs\ImportUtil;
use App\Libs\StringUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossUplClient;
use App\Operations\ReservationImportOperation;
use App\Queries\AddressQuery;
use App\Queries\ImportQuery;
use Illuminate\Http\UploadedFile;

/**
 * 予約取込処理サービスです
 *
 * Class PostImportService
 * @package App\Http\Services\Reservation\Import
 */
class PostImportService extends BaseService
{
    /**
     * @var ImportQuery
     */
    protected $import_query;
    /**
     * @var AddressQuery
     */
    protected $address_query;
    /**
     * @var string
     */
    protected $format_number;
    /**
     * @var string
     */
    protected $item_code;
    /**
     * @var UploadedFile
     */
    protected $import_file;
    /**
     * @var array
     */
    protected $auth;
    /**
     * @var array
     */
    protected $prefectures;
    /**
     * @var array
     */
    protected $format_header;
    /**
     * @var array
     */
    protected $format_details;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->import_query = new ImportQuery();
        $this->address_query = new AddressQuery();
        $this->format_number = request('format_number');
        $this->item_code = request('item_code');
        $this->import_file = request()->file('import_file');
        $this->auth = VossAccessManager::getAuth();
        $this->prefectures = $this->address_query->getPrefectures();
        $this->format_header = $this->import_query->getFormatHeader($this->auth['travel_company_code'], $this->format_number);
        $this->format_details = $this->import_query->getFormatDetails($this->auth['travel_company_code'], $this->format_number);
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        //指定しているフォーマットの設定が完了しているか判別し、完了していなかったらエラーにする。
        if ($this->format_details[0]['travel_company_col_index'] == 0) {
            $this->setErrorMessage(config('messages.error.E100-0103'));
            return;
        }
        // 取込情報の取得
        $import_data = ImportUtil::readDataRows($this->import_file->getRealPath(),
            $this->format_header['header_line_number'], $this->format_header['import_start_line_number']);
        // データ変換
        $converted_import_data = $this->convertImportData($import_data);
        if (count($converted_import_data) == 0) {
            // 予約データが1件もない場合エラー
            $this->setErrorMessage(config('messages.error.E100-0104'));
            return;
        }
        // ソケット通信
        $operation_result = $this->sendOperation($converted_import_data);
        // ファイルアップロード
        $this->saveImportFile($operation_result['import_date_time']);
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.import.result', ['import_management_number' => $operation_result['import_management_number']]);
    }

    /**
     * 読み取ったデータを取込み用のデータに変換して返します。
     * @param array $import_data
     * @return array
     */
    protected function convertImportData($import_data)
    {
        $ret = [];
        // データ整形
        foreach ($import_data as $row) {
            $converted_row = $this->convertRowData($row);
            if ($converted_row) {
                $ret[] = $converted_row;
            }
        }
        return $ret;
    }

    /**
     * 生の行データを取込み用の行データに変換して返します。
     * @param array $row
     * @return array
     */
    protected function convertRowData($row)
    {
        $ret = [];
        foreach ($this->format_details as $format) {
            $col_index = $format['travel_company_col_index'] - 1;
            $value = isset($row[$col_index]) ? trim($row[$col_index]) : '';
            if ($value === "") {
                continue;
            }
            // 区切文字の制御
            $value = $this->convertDelimiterValue($value, $format['delimiter_char'], $format['delimit_type']);
            // 属性別変換処理
            $value = $this->convertAttributeTypeValue($value, $format['attribute_type']);
            $ret[$format['socket_data_number']] = $value;
        }
        return $ret;
    }

    /**
     * 値を取込フォーマットの区切り文字と区切文字区分から変換して返します。
     * @param string $value
     * @param string $delimiter_char
     * @param string $delimit_type
     */
    protected function convertDelimiterValue($value, $delimiter_char, $delimit_type)
    {
        if ($delimiter_char) {
            $delimiter_char = StringUtil::convertI5DBDelimiterToWeb($delimiter_char);
            $split = mb_split($delimiter_char, $value, 2);
            if ($delimit_type === 'F') {
                $value = isset($split[0]) ? $split[0] : '';
            } elseif ($delimit_type === 'B') {
                $value = isset($split[1]) ? $split[1] : '';
            }
        }
        return $value;
    }

    /**
     * 値を取込フォーマットの属性別に変換して返します。
     * @param string $value
     * @param string $attribute_type
     * @return string
     */
    protected function convertAttributeTypeValue($value, $attribute_type)
    {
        switch ($attribute_type) {
            case 'K': // 半角文字
                $value = StringUtil::convertHankakuKana($value);
                break;
            case 'U': // 英大文字
                $value = strtoupper(StringUtil::alnumFullToHalf($value));
                break;
            case 'N': // 数字
                $value = StringUtil::numberFullToHalf($value);
                break;
            case 'D': // 日付
                $value = DateUtil::convertFormat($value, 'Ymd');
                break;
            case 'Z': // 郵便番号
            case 'T': // 電話番号
                $value = str_replace('-', '', StringUtil::numberFullToHalf($value));
                break;
            case 'P': // 都道府県
                foreach ($this->prefectures as $prefecture) {
                    $short_prefecture_name = mb_substr($prefecture['prefecture_name'], 0, -1);
                    $pos = mb_strpos($value, $short_prefecture_name);
                    if ($pos === 0) {
                        $value = $prefecture['prefecture_code'];
                        break;
                    }
                }
                break;
            default :
                break;
        }
        return $value;
    }

    /**
     * 取込フォーマット明細更新 ソケット通信
     * @param array $import_data
     * @return array
     * @throws \Exception
     */
    protected function sendOperation($import_data)
    {
        $operation = new ReservationImportOperation();
        // 開始データ
        $operation->setRecordType('1');
        $operation->setFormatNumber($this->format_number);
        $operation->setItemCode($this->item_code);
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            return $operation_result1;
        }

        $import_line_number = 1;
        foreach ($import_data as $data) {
            // データ
            $operation->reset();
            $operation->setRecordType("2");
            $operation->setFormatNumber($this->format_number);
            $operation->setImportkManagementNumber($operation_result1['import_management_number']);
            $operation->setItemCode($this->item_code);
            $operation->setImportLineNumber($import_line_number);
            foreach ($data as $socket_data_number => $value) {
                $setMethod = 'setData' . $socket_data_number;
                $operation->$setMethod($value);
            }
            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                return $operation_result2;
            }
            $import_line_number++;
        }

        // 終了
        $operation->reset();
        $operation->setRecordType('9');
        $operation->setFormatNumber($this->format_number);
        $operation->setItemCode($this->item_code);
        $operation->setImportkManagementNumber($operation_result1['import_management_number']);
        $operation_result9 = $operation->execute();

        return $operation_result9;
    }

    /**
     * 取込ファイルを保存します。
     * @param string $save_date_time
     */
    protected function saveImportFile($save_date_time)
    {
        $uploaded_file_path = $this->import_file->getRealPath();
        $disk = 'reservation_import';
        $save_path = $this->item_code;
        $save_file_name =
            $this->auth['travel_company_code'] . '-' . $this->auth['agent_code']
            . '-' . $save_date_time
            . '.' . config('const.file_type.extension.' . $this->format_header['file_type']);

        return VossUplClient::upload($disk, $uploaded_file_path, $save_path, $save_file_name);
    }
}