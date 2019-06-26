<?php

namespace App\Http\Services\Agent\Import;

use App\Http\Services\BaseService;
use App\Libs\ImportUtil;
use App\Libs\StringUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Libs\Voss\VossUplClient;
use App\Operations\AgentImportOperation;
use App\Queries\AddressQuery;
use App\Queries\ImportQuery;
use App\Rules\AlphaNumber;
use App\Rules\BadChar;
use App\Rules\BetweenSoSiByteLength;
use App\Rules\MaxSoSiByteLength;
use App\Rules\Number;
use App\Rules\Password;
use Illuminate\Http\UploadedFile;

/**
 * 販売店管理一括取り込み Step2
 * Class PostFileImportService
 * @package App\Http\Services\Agent\Import
 */
class PostFileImportService extends BaseService
{
    /**
     * 半角に変換するインデックス：販売店コード、販売店区分、メールアドレス1～6、ログイン区分、ユーザーID、パスワード
     */
    const CONVERT_ALNUM_FULL_TO_HALF_INDEXES = ["0", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18"];

    /**
     * 半角に変換するインデックス：郵便番号、TEL、FAX
     */
    const CONVERT_NUM_FULL_TO_HALF_INDEXES = ["2", "7", "8"];

    /**
     * 都道府県番号取得インデックス：都道府県
     */
    const CONVERT_PREFECTURE_CODE_INDEXES = "3";

    /**
     * 半角に変換するインデックス：販売店コード
     */
    const CONVERT_AGENT_CODE_INDEX = "0";

    /**
     * 配列の列名：error_message
     */
    const CONVERT_DATA_INDEX_NAME_ERROR_MESSAGE = "error_message";


    /**
     * 住所取得用
     * @var ImportQuery
     */
    protected $address_query;

    /**
     * 取得ファイル
     * @var UploadedFile
     */
    protected $import_file;

    /**
     * 都道府県
     * @var array
     */
    protected $prefectures;

    /**
     * Auth取得
     * @var array
     */
    protected $auth;

    /**
     * 禁止文字チェック
     * @var
     */
    protected $bad_char;

    /**
     * 数値チェック
     * @var
     */
    protected $number;

    /**
     * 半角英数字チェック
     * @var
     */
    protected $alpha_number;

    /**
     * パスワードチェック
     * @var
     */
    protected $password;


    /**
     * 初期処理を実行します。
     */
    protected function init()
    {
        //都道府県情報を取得する
        $this->address_query = new  AddressQuery();
        $this->prefectures = $this->address_query->getPrefectures();
        //ファイル名取得
        $this->import_file = request()->file('import_csv_file');
        //Auth情報取得
        $this->auth = VossAccessManager::getAuth();
        //禁止文字チェック
        $this->bad_char = new BadChar();
        //数値チェック
        $this->number = new Number();
        //英数チェック
        $this->alpha_number = new AlphaNumber();
        //パスワードチェック
        $this->password = new Password();
    }

    /**
     * サービスを実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        if (request()->has('import_csv_file')) {

            //CSVファイルパスを取得
            $import_title = $this->import_file->getRealPath();
            //CSVデータ取得
            $import_data = ImportUtil::readDataRows($import_title);

            //CSVファイルチェック(データ数[1～3000]
            if (count($import_data) < 0) {
                //処理終了
                $this->setErrorMessage(config('messages.error.E000-0020'));
                return;
            } elseif (count($import_data) > 3000) {
                ///処理終了
                $this->setErrorMessage(config('messages.error.E000-0020'));
                return;
            }

            //CSVデータを変換する
            $import_item_no = $this->convertImportData();
            $import_data = $this->convertImportDataType($import_data, $import_item_no);

            //取込データ
            VossSessionManager::set('import_data', $import_data);

            //変換処理時にエラーデータが存在する場合はデータを編成する。
            $socket_import_data = $this->reorganizationImportData($import_data);

            //ソケット通信
            $operation_result = $this->sendOperation($socket_import_data);

            //一次インポート番号
            $import_management_number = $operation_result['import_management_number'];


            // ファイルアップロード
            $this->saveImportFile($operation_result['import_date_time']);

            if ($operation_result['status'] === 'E') {
                $this->setSocketErrorMessages($operation_result['event_number']);
                return;
            }

            //複数一括登録確認画面に遷移する
            $this->response_data['redirect'] = ext_route('import.file_confirm', ['import_management_number' => $import_management_number]);
        }
        return;
    }

    /**
     * 列番号取得
     * @return array
     */
    private function convertImportData()
    {
        $import_item_no = [];
        $request_data_keys = request()->keys();
        foreach ($request_data_keys as $item_key) {
            if ($item_key !== "import_csv_file") {
                $import_item_no[] = request($item_key);
            } else {
                break;
            }
        }
        return $import_item_no;
    }

    /**
     * データ変換処理
     * @param $import_data_csv
     * @param $import_data_no
     * @return array
     */
    private function convertImportDataType($import_data_csv, $import_data_no)
    {
        $convert_data = [];
        foreach ($import_data_csv as $row => $row_csv) {
            //CSVデータ列名と画面セレクトボックスのindexを統合
            $import_row_data = [];
            foreach ($import_data_no as $key => $value) {
                if (array_key_exists($value, $row_csv)) {
                    $import_row_data[$key] = $row_csv[$value];
                } else {
                    $import_row_data[$key] = '';
                }
            }

            foreach ($import_row_data as $index => $row_data) {
                if (in_array($index, self::CONVERT_ALNUM_FULL_TO_HALF_INDEXES)) {
                    //半角に変換
                    $import_row_data[$index] = StringUtil::alnumFullToHalf($row_data);
                } //ハイフン、数値変換
                elseif (in_array($index, self::CONVERT_NUM_FULL_TO_HALF_INDEXES)) {
                    $import_row_data[$index] = StringUtil::numberFullToHalf($row_data);
                } //都道府県コードに変換
                elseif ($index == self::CONVERT_PREFECTURE_CODE_INDEXES) {
                    $import_row_data[$index] = $this->convertAddress($row_data);
                } else {
                    $import_row_data[$index] = $row_data;
                }
            }

            //エラーの項目名を番号から項目名に修正
            $attributes = array(
                '0' => '販売店コード',
                '1' => '販売店名',
                '2' => '郵便番号',
                '3' => '都道府県',
                '4' => '住所1',
                '5' => '住所2',
                '6' => '住所3',
                '7' => 'TEL',
                '8' => 'FAX',
                '9' => 'メールアドレス1',
                '10' => 'メールアドレス2',
                '11' => 'メールアドレス3',
                '12' => 'メールアドレス4',
                '13' => 'メールアドレス5',
                '14' => 'メールアドレス6',
                '15' => '販売店区分',
                '16' => 'ログイン区分',
                '17' => 'ユーザーID',
                '18' => 'パスワード'
            );

            //バリデーションチェック
            $error_message = "";
            $validator = \Validator::make($import_row_data, [
                '0' => ['required', $this->alpha_number, new MaxSoSiByteLength(7)],
                '1' => ['required', $this->bad_char, new MaxSoSiByteLength(72)],
                '2' => ['required', $this->number, new MaxSoSiByteLength(7)],
                '3' => ['required'],
                '4' => ['required', $this->bad_char, new MaxSoSiByteLength(102)],
                '5' => ['required', $this->bad_char, new MaxSoSiByteLength(102)],
                '6' => [$this->bad_char, new MaxSoSiByteLength(102)],
                '7' => ['required', $this->number, new MaxSoSiByteLength(16)],
                '8' => ['required', $this->number, new MaxSoSiByteLength(16)],
                '9' => ['required', 'email', new MaxSoSiByteLength(80)],
                '10' => ['email', new MaxSoSiByteLength(80)],
                '11' => ['email', new MaxSoSiByteLength(80)],
                '12' => ['email', new MaxSoSiByteLength(80)],
                '13' => ['email', new MaxSoSiByteLength(80)],
                '14' => ['email', new MaxSoSiByteLength(80)],
                '15' => ['required'],
                '16' => ['required'],
                '17' => ['required', $this->alpha_number, new BetweenSoSiByteLength(6, 12)],
                '18' => ['required', $this->password, new BetweenSoSiByteLength(8, 12)],
            ]);
            $validator->setAttributeNames($attributes);

            //エラーメッセージ1行目のみ取得する
            $error_message = $validator->errors()->first();
            $import_row_data['error_message'] = $error_message;

            //行番号取得する
            $line_number = count($convert_data) + 1;
            $convert_data[$line_number] = $import_row_data;
        }

        return $convert_data;
    }


    /**
     * 都道府県取得処理
     * @param $import_data
     * @return string
     */
    private function convertAddress($import_data)
    {
        //半角数値化
        $value = StringUtil::numberFullToHalf($import_data);
        //都道府県番号との一致
        foreach ($this->prefectures as $prefecture) {
            $short_prefecture_name = mb_substr($prefecture['prefecture_name'], 0, -1);
            $pos = mb_strpos($value, $short_prefecture_name);
            if ($pos === 0) {
                $value = $prefecture['prefecture_code'];
                break;
            }
        }
        //一致した都道府県名を返す
        return $value;
    }

    /**
     * ソケット通信用データ配列の再編成
     * @param $import_data
     * @return array
     */
    private function reorganizationImportData($import_data)
    {
        //ソケット通信用にエラー行を除いた配列を作成する
        $convert_data = [];
        $convert_row_data = [];
        foreach ($import_data as $index => $row_data) {
            //エラー行判定
            if (!empty($import_data[$index]['error_message'])) {
                continue;
            }
            //エラーメッセージ項目を排除
            foreach ($row_data as $setIndex => $setData) {
                if ($setIndex === self::CONVERT_DATA_INDEX_NAME_ERROR_MESSAGE) {
                    continue;
                }
                $convert_row_data[$setIndex] = $setData;
            }
            $convert_data[$index] = $convert_row_data;
        }
        return $convert_data;
    }


    /**
     * ソケット通信を実行します。
     * @param $import_data
     * @return array
     * @throws \Exception
     */
    private function sendOperation($import_data)
    {
        $operation = new AgentImportOperation();
        //開始データ
        $operation->setRecordType("1");
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            return $operation_result1;
        }

        //データ
        foreach ($import_data as $line_no => $data) {
            $operation->reset();
            $operation->setRecordType("2");
            $operation->setImportManagementNumber($operation_result1['import_management_number']);
            $operation->setImportRowNo($line_no);
            $operation->setUserName("管理者");
            $operation->setUserType("1");
            $operation->setLoginType("1");

            foreach ($data as $socket_data_number => $value) {
                $setMethod = 'setData' . $socket_data_number;
                //ログイン区分は"1"固定
                if ($setMethod === "setData16") {
                    $operation->$setMethod("1");
                    continue;
                }
                $operation->$setMethod($value);
            }

            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                return $operation_result2;
            }
        }

        //終了データ
        $operation->reset();
        $operation->setRecordType('9');
        $operation->setImportManagementNumber($operation_result1['import_management_number']);
        $operation_result9 = $operation->execute();
        if ($operation_result9['status'] === 'E') {
            return $operation_result9;
        }
        return $operation_result1;
    }

    /**
     * 取込ファイルを保存します。
     * @param $save_date_time
     * @return bool
     */
    protected function saveImportFile($save_date_time)
    {
        $uploaded_file_path = $this->import_file->getRealPath();
        $disk = 'agent_import';
        $save_path = $this->auth['travel_company_code'];
        $save_file_name = $save_date_time . '.' . config('const.file_type.extension.C');

        return VossUplClient::upload($disk, $uploaded_file_path, $save_path, $save_file_name);
    }
}
