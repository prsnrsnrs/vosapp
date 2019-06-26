<?php
/**
 * ヘルパー用の関数
 * 便利関数はどんどん追加してください。
 * 案件に特化させた改変は遠慮なくどうぞ。
 */

use App\Libs\DateUtil;
use App\Libs\StringUtil;


if (!function_exists('zip_cd')) {
    /**
     * 郵便番号を画面表示用に加工して返します。
     * @param string $zip_cd
     * @return string
     */
    function zip_cd($zip_cd)
    {
        return substr($zip_cd, 0, -4) . '-' . substr($zip_cd, -4);
    }
}

if (!function_exists('convert_date_format')) {
    /**
     * \App\Libs\DateUtil::convertFormatのエイリアス。
     * @param mixed $date
     * @return string
     */
    function convert_date_format($str, $format)
    {
        return DateUtil::convertFormat($str, $format);
    }
}

if (!function_exists('get_youbi')) {
    /**
     * \App\Libs\DateUtil::getYoubiのエイリアス。
     * @param mixed $date
     * @return string
     */
    function get_youbi($str)
    {
        return DateUtil::getYoubi($str);
    }
}

if (!function_exists('ext_number_format')) {
    /**
     * 空文字は0に変換し、ナンバーフォマットして返します。
     *
     * @param string $val
     * @return string
     */
    function ext_number_format($val)
    {
        return number_format(StringUtil::emptyToZero($val));
    }
}

if (!function_exists('sort_column')) {
    /**
     * ソート項目のリンクを作成します。
     *
     * @param string $display_name
     * @param string $key
     * @param array $search_params
     * @param string $action
     * @param string $class
     * @return string
     */
    function sort_column($display_name, $key, $search_params, $action, $class = "sort")
    {
        $param_key = array_get($search_params, 'sort_key', '');
        $param_value = array_get($search_params, 'sort_value', '');
        $value = "asc";

        if ($key === $param_key) {
            $display_name .= $param_value === 'asc' ? "▲" : "▼";
            $value = $param_value === 'asc' ? 'desc' : 'asc';
        }
        return "<a href=\"{$action}?sort_key={$key}&sort_value={$value}\" class=\"{$class}\">{$display_name}</a>";
    }
}

if (!function_exists('ext_asset')) {
    /**
     * アセットの拡張
     * 自動でhttpとhttpsを切り替え
     * @param string $path
     * @return string
     */
    function ext_asset($path)
    {
        if (config('app.protocol') == 'https') {
            return secure_asset($path);
        } else {
            return asset($path);
        }
    }
}

if (!function_exists('ext_route')) {
    /**
     * ルートの拡張
     * 自動でhttpとhttpsを切り替え
     * @param string $path
     * @param array $params
     * @param bool $force_secure
     * @return string
     */
    function ext_route($path, $params = [], $force_secure = true)
    {
        $prefix = \App\Libs\Voss\VossAccessManager::getRoutePrefix();
        $path = str_start($path, $prefix);
        if (config('app.protocol') === 'https' && $force_secure) {
            return secure_url(route($path, $params, false));
        } else {
            return route($path, $params);
        }
    }
}

if (!function_exists('ext_url')) {
    /**
     * urlの拡張
     * 自動でhttpとhttpsを切り替え
     * @param string $path
     * @param array $params
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function ext_url($path, $params = [])
    {
        if (config('app.protocol') === 'https') {
            return url($path, $params, true);
        } else {
            return url($path, $params);
        }
    }
}

if (!function_exists('shipping_cruise_plan')) {

    /**
     * クルーズプラン情報を成形
     * @param array $cruise_data
     * @return string
     */
    function shipping_cruise_plan($cruise_data)
    {

        $array = [
            'item_departure_date' => [
                'date' => $cruise_data['item_departure_date'],
                'format' => 'Y年m月d日'
            ],
            'item_arrival_date' => [
                'date' => $cruise_data['item_arrival_date'],
                'format' => 'm月d日'
            ]
        ];

        $date = [];
        foreach ($array as $key => $values) {
            $data = new \DateTime($values['date']);
            $date[$key] = $data->format($values['format']);
        }

        $cruise_info = $cruise_data['item_name'] . " " . $cruise_data['item_name2'] . "<br>"
            . $date['item_departure_date'] . "～" . $date['item_arrival_date']
            . "[" . $cruise_data['departure_place_knj'] . "発/" . $cruise_data['arrival_place_knj'] . "着"
            . $cruise_data['stays'] . "泊" . $cruise_data['days'] . "日]";

        return $cruise_info;
    }
}

if (!function_exists('str_concat')) {
    /**
     * 文字列を結合します。
     * @param string $str1
     * @param string $str2
     * @param string $delimiter
     * @param bool $escape
     * @return string
     */
    function str_concat($str1, $str2, $delimiter = '<br/>', $escape = true)
    {
        $str = $escape ? e($str1) : $str1;
        if ($str2) {
            $str .= $delimiter;
            $str .= $escape ? e($str2) : $str2;
        }
        return $str;
    }
}

if (!function_exists('cabin_type_for_cruise_plan_search')) {
    /**
     * クルーズプラン検索で客室タイプの改行位置を調整します。
     * @param $cabin_type
     * @return string
     */
    function cabin_type_for_cruise_plan_search($cabin_type)
    {
        $str_pos = false;
        $needles = ['ﾙｰﾑ', 'ｽｲｰﾄ'];
        foreach ($needles as $needle) {
            $str_pos = mb_strpos($cabin_type, $needle);
            if ($str_pos) {
                return e(mb_substr($cabin_type, 0, $str_pos)) . '<br/>' . e(mb_substr($cabin_type, $str_pos));
            }
        }
        return e($cabin_type);
    }
}

if (!function_exists('option_selected')) {
    /**
     * 文字列が一致する場合は、selectedの文字列を返します。
     * @param $val1
     * @param $val2
     * @return string
     */
    function option_selected($val1, $val2)
    {
        return $val1 == $val2 ? 'selected' : '';
    }
}

if (!function_exists('option_year')) {
    /**
     * 年のドロップダウンオプションを返します。
     * @param mixed $date
     * @param int $yeas_ago
     * @param int $addFromYear
     * @return string
     */
    function option_year($date, $yeas_ago=100, $addFromYear=0)
    {
        $selected = DateUtil::convertFormat($date, 'Y');
        $year = (int)DateUtil::now('Y') + $addFromYear;
        $options = "";
        for ($i = 0; $i < $yeas_ago; $i++) {
            $options .= '<option value="' . $year . '" ' . option_selected($year,
                    $selected) . '>' . $year . '</option>';
            $year = $year - 1;
        }
        return $options;
    }
}

if (!function_exists('option_month')) {
    /**
     * 月のドロップダウンオプションを返します。
     * @param mixed $date
     * @return string
     */
    function option_month($date)
    {
        $selected = DateUtil::convertFormat($date, 'n');
        $options = "";
        for ($month = 1; $month <= 12; $month++) {
            $options .= '<option value="' . str_pad($month, '2', '0', STR_PAD_LEFT) . '" ' . option_selected($month,
                    $selected) . '>' . $month . '</option>';
        }
        return $options;
    }
}

if (!function_exists('option_day')) {
    /**
     * 日のドロップダウンオプションを返します。
     * @param mixed $date
     * @return string
     */
    function option_day($date)
    {
        $selected = DateUtil::convertFormat($date, 'j');
        $options = "";
        for ($day = 1; $day <= 31; $day++) {
            $options .= '<option value="' . str_pad($day, '2', '0', STR_PAD_LEFT) . '" ' . option_selected($day,
                    $selected) . '>' . $day . '</option>';
        }
        return $options;
    }
}

if (!function_exists('input_checked')) {
    /**
     * 文字列が一致する場合は、checkedの文字列を返します。
     * @param string $val1
     * @param string $val2
     * @return string
     */
    function input_checked($val1, $val2)
    {
        return $val1 === $val2 ? 'checked' : '';
    }
}

if (!function_exists('cabin_status')) {

    /**
     * 客室選択・客室人数選択で空室情報を返します
     * @param $vacancy
     * @param $mode
     * @return string
     */
    function cabin_status($vacancy, $cabin_select = false)
    {
        $name = "";
        $class = "";
        $remarks = "";
        if ($vacancy == config('const.vacancy.value.not')) {
            $name = '予約受付不可';
        } else {
            if ($vacancy == config('const.vacancy.value.yet')) {
                $name = '予約受付前';
            } else {
                if ($cabin_select && $vacancy == config('const.vacancy.value.full')) {
                    $name = config('const.vacancy.name.' . $vacancy);
                    $remarks = '<p>キャンセル<br>待ち</p>';
                    $class = 'bold';
                } else {
                    if ($vacancy == config('const.vacancy.value.full')) {
                        $name = config('const.vacancy.name.' . $vacancy);
                    } else {
                        $name = config('const.vacancy.name.' . $vacancy);
                        $class = 'bold';
                    }
                }
            }
        }

        return "<p class=\"{$class}\">" . $name . "</p>" . $remarks;
    }
}

if (!function_exists('cabin_select_next_btn')) {
    /**
     * 客室選択の次画面に遷移するボタンを返します。
     * @param string $vacancy
     * @param string $mode
     * @return string
     */
    function cabin_select_next_btn($vacancy, $mode)
    {
        $class = "add";
        $disabled = "";
        if ($vacancy == config('const.vacancy.value.full')) {
            $class = "add wait_cancel";
            if ($mode === "new_change" || $mode === "edit_add" || $mode === "edit_change") {
                $disabled = "disabled";
            }
        } elseif ($vacancy == config('const.vacancy.value.not')) {
            $disabled = 'disabled';
        }

        return "<button class=\"{$class}\" {$disabled}>" . "選択" . "</button>";
    }
}

if (!function_exists('passenger_name')) {
    /**
     * 乗船者名を成形して返します。
     * @param string $last_name
     * @param string $first_name
     * @return string
     */
    function passenger_name($last_name, $first_name)
    {
        if ($last_name || $first_name) {
            return e("{$last_name} {$first_name}");
        } else {
            return '<span class="danger">(未入力)</span>';
        }
    }
}

if (!function_exists('passenger_name_kana')) {
    /**
     * 乗船者名(様付け)を全角カナに成形して返します。
     * @param string $last_name
     * @param string $first_name
     * @return string
     */
    function passenger_name_kana($last_name, $first_name)
    {
        if ($last_name || $first_name) {
            $last_name = convert_zenkaku_kana($last_name);
            $first_name = convert_zenkaku_kana($first_name);
            return e("{$last_name} {$first_name}    様");
        } else {
            return '<span class="danger">(未入力)</span>';
        }
    }
}

if (!function_exists('convert_zenkaku_kana')) {
    /**
     * \App\Libs\StringUtil::convertZenkakuKanaのエイリアス。
     * @param string $str
     * @return string
     */
    function convert_zenkaku_kana($str)
    {
        return StringUtil::convertZenkakuKana($str);
    }
}

if (!function_exists('convert_i5db_delimiter_to_web')) {
    /**
     * \App\Libs\StringUtil::convertI5DBDelimiterToWebのエイリアス。
     * @param string $delimiter
     * @return string
     */
    function convert_i5db_delimiter_to_web($delimiter)
    {
        return StringUtil::convertI5DBDelimiterToWeb($delimiter);
    }
}

if (!function_exists('total_charger')) {
    /**
     * 旅行代金-割引券金額＋取消料の計算し、ご請求金額を返します
     * @param array $passenger
     * @return string
     */
    function total_charger($passenger)
    {
        return $passenger['total_travel_charge'] - $passenger['total_discount_charge'] + $passenger['total_cancel_charge'];
    }
}

if (!function_exists('explode_to_comma')) {

    /**
     * カンマ区切りの文字列を配列で返します
     * @param string $str
     * @return array
     */
    function explode_to_comma(string $str)
    {
        $array = [];
        if (strpos($str, ',')) {
            $array = explode(',', $str);
        } else {
            $array[] = $str;
        }
        return $array;
    }
}

if (!function_exists('convert_check_finish_type')) {
    /**
     * 書類確認区分が"N"の時はハイフン、確認済日が0の時は'未(赤字)'、1以上の時は'済'を返します。
     * @param $check_finish_date
     * @param $document_check_type
     * @return string
     */
    function convert_check_finish_type($check_finish_date, $document_check_type)
    {
        if ($document_check_type == "N") {
            return '-';
        } elseif ($check_finish_date == '') {
            return '';
        } elseif ($check_finish_date == '0') {
            return '<span class="danger">未</span>';
        } else {
            return '済';
        }
    }
}

if (!function_exists('convert_answer_upload')) {
    /**
     * 書類入手区分に応じた、返信区分:アップロードの項目の表示を返します。
     * @param $document_get_type
     * @param $answer_format
     * @param $upload_possible
     * @return string
     */
    function convert_answer_upload($document_get_type, $answer_format, $upload_possible)
    {
        if ($document_get_type == "0") {
            return '-';
        } elseif ($document_get_type == '1' && $answer_format == 'Y' && $upload_possible == 'Y') {
            return '要 or  ' . '<button class="done">アップロード</button>';
        } elseif ($answer_format == 'Y') {
            return '要';
        } elseif ($answer_format == 'N') {
            return '不要';
        } else {
            return '';
        }
    }
}

if (!function_exists('matched_circle_ticket')) {

    /**
     * 乗船券控えの"〇"or"-"の表示を判定します
     * @param $cancel_date_time
     * @param $reservation_type
     * @param $ticketing_flag
     * @return string
     */
    function matched_circle_ticket($cancel_date_time, $reservation_type, $ticketing_flag)
    {
        if ($cancel_date_time == 0 && ($reservation_type == "1" || $reservation_type == "4") && $ticketing_flag == "1") {
            return '〇';
        } else {
            return '-';
        }
    }
}

if (!function_exists('matched_circle_confirm')) {

    /**
     * 予約確認書の"〇"or"-"の表示を判定します
     * @param $cancel_date_time
     * @param $reservation_type
     * @return string
     */
    function matched_circle_confirm($cancel_date_time, $reservation_type)
    {
        if ($cancel_date_time == 0 && ($reservation_type == "1" || $reservation_type == "4")) {
            return '〇';
        } else {
            return '-';
        }
    }
}

if (!function_exists('matched_circle_detail_confirm')) {

    /**
     * 予約内容確認書の"〇"or"-"の表示を判定します
     * @param $cancel_date_time
     * @param $reservation_type
     * @param $reservation_status
     * @return string
     */
    function matched_circle_detail_confirm($cancel_date_time, $reservation_type, $reservation_status)
    {
        if ($cancel_date_time == 0 && ($reservation_type == "1" || $reservation_type == "4") && $reservation_status == "HK") {
            return '〇';
        } else {
            return '-';
        }
    }
}

if (!function_exists('matched_circle_cancel')) {

    /**
     * 取消記録確認書の"〇"or"-"の表示を判定します。
     * @param $cancel_date_time
     * @param $reservation_type
     * @return string
     */
    function matched_circle_cancel($cancel_date_time, $reservation_type)
    {
        if ($cancel_date_time > 0 && ($reservation_type == "1" || $reservation_type == "4")) {
            return '〇';
        } else {
            return '-';
        }
    }
}

if (!function_exists('prev_much')) {

    /**
     * 連想配列で、現在の配列とひとつ前の配列の値と比較します。
     * 同じ場合は真、異なる場合は偽を返します。
     * @param $target_value
     * @param $array
     * @param $key
     * @param $value
     * @return bool
     */
    function prev_much($target_value, $array, $key, $value)
    {
        if ($key == 0) {
            return false;
        }

        $index = $key - 1;
        $prev_array = $array[$index];
        if ($prev_array[$value] == $target_value) {
            return true;
        } else {
            false;
        }
    }
}

if (!function_exists('next_much')) {

    /**
     * 連想配列で、現在の配列と次の配列の値と比較します。
     * 同じ場合は真、異なる場合は偽を返します。
     * @param $target_value
     * @param $array
     * @param $key
     * @param $value
     * @return bool
     */
    function next_much($target_value, $array, $key, $value)
    {
        $index = $key + 1;
        if (!array_key_exists($index, $array)) {
            return false;
        }

        $prev_array = $array[$index];
        if ($prev_array[$value] == $target_value) {
            return true;
        } else {
            false;
        }
    }
}

if (!function_exists('is_canceled_reservation')) {

    /**
     * 予約取消（予約状況見出しの状況FLAGが"D"、または、取消日時が"0"以外）の場合にdisabledを返します。
     * @param $reservation_info
     * @return string
     */
    function is_canceled_reservation($reservation_info)
    {
        $class_name = '';
        if ($reservation_info['state_flag'] === config('const.state.value.delete') || $reservation_info['cancel_date_time'] > 0) {
            $class_name = 'disabled';
        }
        return $class_name;
    }
}

if (!function_exists('return_route')) {

    /**
     * 遷移元（戻るボタンのURL）を返します。
     * @return string
     */
    function return_route()
    {
        $return_param = request('return_param');
        if ($return_param) {
            VossSessionManager::set("return_param", array_merge(
                config('const.return_param'),
                request('return_param')
            ));
        }
        $return_param = VossSessionManager::get('return_param');

        if ($return_param['reservation_number']) {
            $url = ext_route($return_param['route_name'],
                ['reservation_number' => $return_param['reservation_number']]);
        } else {
            $url = ext_route($return_param['route_name']);
        }

        return $url;
    }
}

if (!function_exists('params_for_return')) {

    /**
     * 遷移先の戻るボタン・パンくず用のパラメータを返します
     * ['return_param' => paramsForReturn()]のように使ってください
     * @param bool $reservation_number
     * @return array
     */
    function params_for_return($reservation_number = false)
    {
        if ($reservation_number) {
            $param = [
                'route_name' => request()->route()->getName(),
                'reservation_number' => $reservation_number
            ];

        } else {
            $param = [
                'route_name' => request()->route()->getName()
            ];
        }

        return $param;
    }
}

if (!function_exists('count_from_to')) {

    /**
     * 検索計画面の「件中 件～件目を表示」の件目の文言を判定して返します。
     * @param $max_page
     * @param $count_all
     * @return mixed
     */
    function count_from_to($max_page, $count_all)
    {
        if ($max_page <= $count_all) {
            return $max_page;
        } else {
            return $count_all;
        }
    }
}

if (!function_exists('passenger_travel_charge')) {

    /**
     * 予約照会画面で乗船者がCXのデータなら空欄、幼児でかつ、CXではない時は０円、それ以外は旅行代金を返します。
     * @param $age_type
     * @param $reservation_status
     * @param $total_travel_charge
     * @return string
     */
    function passenger_travel_charge($age_type, $reservation_status, $total_travel_charge)
    {
        if ($reservation_status === 'CX') {
            return '';
        } else {
            return $total_travel_charge . '円';
        }
    }
}