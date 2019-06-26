<?php

namespace App\Http\Services\Reservation\Printing;

use App\Libs\DateUtil;
use App\Libs\Voss\VossSessionManager;
use App\Queries\PrintingQuery;

/**
 * CSV出力のサービスです
 *
 * Class PostCsvService
 * @package App\Http\Services\Reservation\Printing
 */
class PostCsvService extends BaseService
{
    /**
     * @var $search_con_cruise
     */
    protected $search_con_cruise;
    /**
     * @var PrintingQuery
     */
    protected $printing_query;
    /**
     * @var $reservations
     */
    protected $reservations;

    /**
     * 初期化します
     */
    protected function init()
    {
        $this->printing_query = new PrintingQuery();
        $this->reservations = request('reservations');
        $this->search_con_cruise = VossSessionManager::get("reservation_printing_list")['item_code'];
    }

    /**
     * 処理を開始します
     * @return mixed|void
     */
    public function execute()
    {
        // チェックされた乗船者情報、提出書類情報の取得
        $passengers_detail = $this->printing_query->getPassengersForCsv(array_keys($this->reservations));
        $cruise_name = $passengers_detail[0]['cruise_name'];
        //予約番号でグループ化
        $group_by_reservation_number = collect($passengers_detail)->groupBy('reservation_number')->toArray();
        //データ整形
        $passengers_detail_format = $this->getFormatPassengersByDocument($group_by_reservation_number);

        //csv出力
        $this->csvUpload($passengers_detail_format, $cruise_name);
    }

    /**
     * CSV出力のために乗船者情報を整形します
     * @param $group_by_reservation_number
     * @return array
     */
    protected function getFormatPassengersByDocument($group_by_reservation_number)
    {
        // 選択した乗船者のみを取得
        $reservations = $this->getSelectedPassenger($group_by_reservation_number);

        //予約番号ごとにループ
        foreach ($reservations as $reservation_number => &$reservation) {
            $group_by_passenger_line_number = collect($reservation)->groupBy('passenger_line_number')->toArray();

            //乗船者ごとにループ
            foreach ($group_by_passenger_line_number as $line_number => &$documents) {
                $group_by_document = collect($documents)->groupBy('progress_manage_code')->toArray();

                //提出書類をカンマ区切りで取得
                $i = 0;
                $temp_document = [];
                foreach ($group_by_document as $document) {
                    if ($document[0]['progress_manage_code']) {
                        $is_submit = $document[0]['check_finish_date'] ? '[済]' : '[未]';
                        $document_name = $document[0]['progress_manage_short_name'] . $is_submit;
                        $temp_document[$i] = $document_name;
                    }
                    $i++;

                    //discount_numberを格納
                    $j = 0;
                    $temp_discount = array(
                        'discount_number0' => '',
                        'discount_number1' => '',
                        'discount_number2' => '',
                        'discount_number3' => '',
                        'discount_number4' => ''
                    );
                    if ($j == 0) {
                        foreach ($document as $discount) {
                            $temp_discount['discount_number' . $j] = $discount['discount_number'];
                            $j++;
                        }
                    }
                }
                $documents = collect($documents)->first();
                $documents = $documents + $temp_discount;
                $documents['document'] = implode("、", $temp_document);
            }
            $reservation = $group_by_passenger_line_number;
        }
        return $reservations;
    }

    /**
     * 選択した乗船者のみを返します
     * @param $group_by_reservation_number
     * @return array
     */
    protected function getSelectedPassenger($group_by_reservation_number)
    {
        $selected = [];
        foreach ($group_by_reservation_number as $reservation_number => $passengers) {
            foreach ($passengers as $passenger) {
                // 選択した乗船者の行No.と一致する乗船者を格納
                if (in_array($passenger['passenger_line_number'], $this->reservations[$reservation_number])) {
                    $selected[$reservation_number][] = $passenger;
                }
            }
        }
        return $selected;
    }


    /**
     * CSVのアップロード処理を実行します
     * @param $passengers_detail_format
     */
    private function csvUpload($passengers_detail_format, $cruise_name)
    {

        // 出力情報の設定
        $filename = DateUtil::now() . '_' . $cruise_name . '.csv';
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename*=UTF-8\'\'' . rawurlencode($filename));
        header("Content-Transfer-Encoding: binary");

        // 変数の初期化
        $csv = null;
        $content = null;

        //ヘッダーの設定
        $header = array(
            0 => '予約番号',
            1 => '乗船者行No.',
            2 => '客室タイプ',
            3 => '客室番号',
            4 => '料金区分',
            5 => '料金タイプ',
            6 => '氏名',
            7 => '代表者',
            8 => '生年月日',
            9 => '年齢',
            10 => '性別',
            11 => '会員番号',
            12 => '大小幼',
            13 => '子供食',
            14 => '食事回数',
            15 => '国籍',
            16 => 'PPT No.',
            17 => '発行日',
            18 => '住所',
            19 => '電話番号１',
            20 => '電話番号２',
            21 => '結婚記念日',
            22 => '提出書類',
            23 => '割引券番号１',
            24 => '割引券番号２',
            25 => '割引券番号３',
            26 => '割引券番号４',
            27 => '割引券番号５',
            28 => '備考'
        );

        $csv .= '"' . implode('","', $header) . '"';
        $csv .= "\n";

        foreach ($passengers_detail_format as $reservation_number => $passengers) {
            foreach ($passengers as $line_number => $value) {
                $content = null;
                $data = $this->formatContentData($value);
                $content .= '="' . implode('",="', $data) . '"';
                $content .= "\n";
                $csv .= $content;
            }
        }
        // CSVファイル出力
        echo mb_convert_encoding($csv, "SJIS", "UTF-8");
    }

    /**
     * CSVのコンテンツ部分表示のために配列をヘッダーとリンクするよう並び替えます
     * @param $content
     * @return array
     */
    private function formatContentData($content)
    {
        $content['zip_code'] = $content['zip_code'] ? '〒' . $content['zip_code'] : '';
        //ヘッダーの設定
        $data = array(
            0 => $content['reservation_number'],
            1 => $content['passenger_line_number'],
            2 => $content['cabin_type'],
            3 => $content['cabin_number'],
            4 => $content['tariff_short_name'],
            5 => config('const.fare_type.name.' . $content['fare_type']),
            6 => mb_convert_kana($content['passenger_last_knj'],
                    "KVa") . '　' . mb_convert_kana($content['passenger_first_knj'], "KVa"),
            7 => $content['boss_type'] == "Y" ? "〇" : "",
            8 => $content['birth_date'] ? date('Y/m/d', strtotime($content['birth_date'])) : '  ',
            9 => $content['birth_date'] ? $content['age'] : '  ',
            10 => config('const.gender.name.' . $content['gender']),
            11 => $content['venus_club_number'],
            12 => config('const.age_type.short_name.' . $content['age_type']),
            13 => config('const.child_meal_type.name.' . $content['child_meal_type']),
            14 => $content['fixed_seating'] ?: '　',
            15 => $content['country_name_port'] ?: '　',
            16 => $content['passport_number'] ?: '　',
            17 => $content['passport_issue'] ?: '　',
            18 => $content['zip_code'] . '  ' . $content['address1'] . $content['address2'] . $content['address3'] ?: '　',
            19 => $content['tel1'] ?: '　',
            20 => $content['tel2'] ?: '　',
            21 => $content['wedding_anniversary'] ? date('Y/m/d', strtotime($content['wedding_anniversary'])) : '  ',
            22 => $content['document'] ?: '　',
            23 => $content['discount_number0'] ?: '　',
            24 => $content['discount_number1'] ?: '　',
            25 => $content['discount_number2'] ?: '　',
            26 => $content['discount_number3'] ?: '　',
            27 => $content['discount_number4'] ?: '　',
            28 => $content['remark'] ?: '　'
        );
        return $data;
    }
}