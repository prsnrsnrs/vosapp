<?php

namespace App\Http\Services\Reservation\Import;

use App\Libs\ImportUtil;
use App\Operations\ReservationImportOperation;

/**
 * JTBの予約取込処理サービスです
 *
 * Class PostImportByJTBService
 * @package App\Http\Services\Reservation\Import
 */
class PostImportByJTBService extends PostImportService
{
    const HK = 'OK';
    const WT = 'WT';
    const DISCOUNT_FORMAT_NUMBERS = [40, 41, 42, 43, 44];
    /**
     * 枝番
     * @var array
     */
    private $branch_numbers;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        parent::init();
        $this->branch_numbers = [];
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        // JTB固有フォーマット以外は通常の取込と同じ。
        if ((int)$this->format_number !== config('const.travel_company.jtb.unique_format_number')) {
            parent::execute();
            return;
        }

        // 取込情報の取得
        $import_data = ImportUtil::readDataRows($this->import_file->getRealPath(),
            $this->format_header['header_line_number'], $this->format_header['import_start_line_number']);
        // データ変換
        $converted_import_data = $this->convertImportDataByJTBFormat($import_data);

        if (count($converted_import_data[self::HK]) == 0 && count($converted_import_data[self::WT]) == 0) {
            // 予約データが1件もない場合エラー
            $this->setErrorMessage(config('messages.error.E100-0104'));
            return;
        }
        // ソケット通信
        $operation_result = $this->sendOperationByJTBFormat($converted_import_data);
        // ファイルアップロード
        $this->saveImportFile($operation_result['import_date_time']);
        if ($operation_result['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result['event_number']);
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.import.result', ['import_management_number' => $operation_result['import_management_number']]);
    }

    /**
     * JTB固有フォーマット専用。
     * 読み取ったデータを取込み用のデータに変換して返します。
     * @param array $import_data
     * @return array
     */
    private function convertImportDataByJTBFormat($import_data)
    {
        $ret = [
            self::HK => [],
            self::WT => [],
        ];

        $reservation_status = self::HK;
        $import_len = count($import_data);
        $prev_converted_row = [];
        for ($row_num = 0; $row_num < $import_len; $row_num++) {
            $row = $import_data[$row_num];
            // 'OK' データの区切り
            if (str_contains($row[0], self::HK)) {
                $reservation_status = self::HK;
                $prev_converted_row = [];
                // 続いてくる、列見出し3行をスキップする
                $row_num += 3;
                continue;
            }
            // 'WT' データの区切り
            if (str_contains($row[0], self::WT)) {
                $reservation_status = self::WT;
                $prev_converted_row = [];
                // 続いてくる、列見出し3行をスキップする
                $row_num += 3;
                continue;
            }
            $converted_row = $this->convertRowDataByJTBFormat($row, $prev_converted_row, $reservation_status);
            if ($converted_row) {
                $ret[$reservation_status][] = $converted_row;
            }
            $prev_converted_row = $converted_row;
        }
        return $ret;
    }

    /**
     * JTB固有フォーマット専用。
     * 生の行データを取込み用の行データに変換して返します。
     * @param array $row
     * @param array $prev_converted_row
     * @param string $reservation_status
     * @return array
     */
    private function convertRowDataByJTBFormat($row, $prev_converted_row, $reservation_status)
    {
        $ret = [];

        // WT予約は、お申込番号の末尾に'WT'を追加。
        if ($reservation_status === self::WT) {
            $row[0] .= 'WT';
        }
        $request_number = $row[0];
        foreach ($this->format_details as $format) {
            $col_index = $format['travel_company_col_index'] - 1;
            $value = isset($row[$col_index]) ? trim($row[$col_index]) : '';
            if ($value === "") {
                continue;
            }

            $format_point_management_number = (int)$format['format_point_manage_number'];
            // 枝番号
            if ($format_point_management_number === 2) {
                $value = $this->issueBranchNumber($request_number, $value);
            }
            // 客室タイプ
            if ($format_point_management_number === 4) {
                // 「XX.」の文字を取り除く
                $value = array_get(mb_split('\.', $value), 1, '');
            }
            // 部屋割番号
            if ($format_point_management_number === 5) {
                // 部屋割番号がNoBed (乳幼児) の場合、ひとつ前の部屋割番号をセットする。
                if (mb_substr($value, 0, 2) === 'NB') {
                    $value = array_get($prev_converted_row, $format['socket_data_number'], $value);
                }
            }

            // 区切文字の制御
            if ($format['delimiter_char']) {
                $discount_index = array_search($format_point_management_number, self::DISCOUNT_FORMAT_NUMBERS);
                // 割引
                if ($discount_index !== false) {
                    $discounts = mb_split($format['delimiter_char'], $value);
                    $value = array_get($discounts, $discount_index, '');
                } // 割引以外
                else {
                    $value = $this->convertDelimiterValue($value, $format['delimiter_char'], $format['delimit_type']);
                }
            }
            // 属性別変換処理
            $value = $this->convertAttributeTypeValue($value, $format['attribute_type']);
            $ret[$format['socket_data_number']] = $value;
        }
        return $ret;
    }

    /**
     * 枝番号を発行します。
     * @param string $key1
     * @param string $key2
     * @return string
     */
    private function issueBranchNumber($key1, $key2)
    {
        $key = $key1 . '.' . $key2;
        $branch_number = array_get($this->branch_numbers, $key, 0);
        $branch_number += 1;
        array_set($this->branch_numbers, $key, $branch_number);
        return $key2 . '-' . str_pad($branch_number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * 取込フォーマット明細更新 ソケット通信
     * @param array $import_data
     * @return array
     */
    private function sendOperationByJTBFormat($import_data)
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
        foreach ($import_data as $reservation_status => $datas) {
            $record_type = $reservation_status === self::HK ? "3" : "4";
            foreach ($datas as $data) {
                // データ
                $operation->reset();
                $operation->setRecordType($record_type);
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
}