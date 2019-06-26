<?php

namespace App\Http\Services\Reservation\Import;

use App\Http\Services\BaseService;
use App\Operations\ImportFormatChangeOperation;
use App\Operations\ImportFormatDetailUpdateOperation;

/**
 * フォーマットの更新処理サービスです
 *
 * Class PostUpdateFormatService
 * @package App\Http\Services\Reservation\Import
 */
class PostUpdateFormatService extends BaseService
{
    private $format_number;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->format_number = request('format_number');
    }

    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        $change_op_result = $this->sendFormatChangeOperation();
        if ($change_op_result['status'] === 'E') {
            $this->setSocketErrorMessages($change_op_result['event_number']);
            return;
        }
        $detail_update_op_result = $this->sendFormatDetailUpdateOperation($change_op_result['last_update_date_time']);
        if ($detail_update_op_result['status'] === 'E') {
            $this->setSocketErrorMessages($detail_update_op_result['event_number']);
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.import.format_list');
    }

    /**
     * 取込フォーマット変更  ソケット通信
     * @return array
     */
    private function sendFormatChangeOperation()
    {
        $operation = new ImportFormatChangeOperation();
        $operation->setFormatNumber($this->format_number);
        $operation->setFormatName(request('format_name'));
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        return $operation->execute();
    }

    /**
     * 取込フォーマット明細更新 ソケット通信
     * @return array
     */
    private function sendFormatDetailUpdateOperation($last_update_date_time)
    {
        $operation = new ImportFormatDetailUpdateOperation();
        // 開始データ
        $operation->setRecordType('1');
        $operation->setFormatNumber($this->format_number);
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            return $operation_result1;
        }

        foreach (request('format_details') as $format_point_manage_number => $format_detail) {
            // データ
            $operation->reset();
            $operation->setRecordType("2");
            $operation->setTempWorkManagementNumber($operation_result1['temp_work_management_number']);
            $operation->setFormatNumber($this->format_number);
            $operation->setFormatPointManageNumber($format_point_manage_number);
            $operation->setTravelCompanyColIndex($format_detail['travel_company_col_index']);
            if (isset($format_detail['delimiter_char'])) {
                $operation->setDelimiterChar($format_detail['delimiter_char']);
            }

            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                return $operation_result2;
            }
        }

        // 終了
        $operation->reset();
        $operation->setRecordType('9');
        $operation->setTempWorkManagementNumber($operation_result1['temp_work_management_number']);
        $operation->setFormatNumber($this->format_number);
        $operation->setLastUpdateDateTime($last_update_date_time);
        $operation_result9 = $operation->execute();

        return $operation_result9;
    }
}