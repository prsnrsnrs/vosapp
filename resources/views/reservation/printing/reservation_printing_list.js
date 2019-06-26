require('../../../assets/js/require/calendar');

let $item_options;
let $can_download_csv;

/**
 * 検索日付から検索候補のクルーズを絞り込みます。
 */
function receptionFiltering() {
    let $item_select = $('#item_code');
    $item_select.children().remove();
    $item_select.append($item_options.clone());

    let selected_from = $('#departure_date_from').val().replace(/\//g, '');
    let selected_to = $('#departure_date_to').val().replace(/\//g, '');

    selected_from = selected_from ? parseInt(selected_from) : 0;
    selected_to = selected_to ? parseInt(selected_to) : 99999999;
    $('#item_code').children().each(function () {
        let $option = $(this);
        if ($option.val() === "") {
            return true;
        }
        let from = parseInt($option.data('item_departure_date'));
        let to = parseInt($option.data('item_arrival_date'));
        if (selected_from <= to && selected_to >= from) {
            $option.show();
        } else {
            $option.remove();
        }
    });
}

/**
 * 選択された予約の中に、出力できるものが含まれているか判断します。
 * @param buttonType
 * @returns {boolean}
 */
function hasNotPrinting(buttonType) {

    $tbody = $('.result_list table tbody');
    let topRows = $tbody.find('input[type="checkbox"]:checked').closest('tr');
    let printingFlg = false;

    $.each(topRows, function () {
        $topRow = $(this);
        let index = $topRow.attr('class');
        let rows = $tbody.find('tr.' + index);
        $.each(rows, function () {
            $row = $(this);
            if ($row.find('.' + buttonType).text().trim() === '〇') {
                printingFlg = true;
                return false;
            }
        });
    });

    if (printingFlg) {
        return true;
    } else {
        $('html,body').animate({scrollTop: 0}, 'fast');
        voss.showMessages('warning', '出力可能なデータが含まれていません。');
        return false;
    }
}

/**
 * フッター：各種印刷ボタンの制御
 */
function switchCheckBox() {
    $checkbox = $('table.hover_rows_custom input');
    let checkedFlg = false;

    $.each($checkbox, function () {
        $this = $(this);
        if ($this.prop('checked')) {
            checkedFlg = true;
            return;
        }
    });

    if (checkedFlg) {
        $('.button_bar .add').attr('disabled', false);
    } else {
        $('.button_bar .add').attr('disabled', true);
    }
}

$(document).ready(function () {

    // 画面ロード時に$can_download_csvをN:不可にする
    // 検索条件のクルーズもしくは予約番号が空でなければ$can_download_csvをY:可にする
    $can_download_csv = "N";
    let $search_con_item_code = $('#item_code').val();
    let $search_con_reservation_number = $('#reservation_number').val();
    if ($search_con_item_code || $search_con_reservation_number) {
        $can_download_csv = "Y";
    }

    //クルーズ名(コース)のセレクトボックス内の全要素を取得し、複製する
    $item_options = $('#item_code').children().clone();

    /**
     * ちらつき防止
     */
    $('body').show();

    /**
     * 検索：カレンダー
     */
    $('.datepicker').datepicker({
        minDate: $('#departure_date_from').data('default').min_calender
    });
    receptionFiltering();

    /**
     * 検索：クリア処理
     */
    $('.clear_form').bind('click', function () {
        $(this.form).find("textarea, :text, .hidden, select").val("").end().find(":checked").prop("checked", false);
        let $departure_date_from = $('#departure_date_from');
        $departure_date_from.val($departure_date_from.data('default').default_departure);
        receptionFiltering();
    });

    /**
     * 検索：出発日変更イベント
     */
    $(document).on('change', '#departure_date_from, #departure_date_to', function (e) {
        receptionFiltering();
    });

    /**
     * 検索：乗船者名入力時の処理
     */
    $('input[name="search_con[passenger_name1]"]').on('change', function () {
        let str = "";
        str = $(this).val();
        $('input[name="search_con[passenger_name2]"]').val(str);
    }).change();

    /**
     * 一覧（ヘッダー）：全選択ボタンのクリック処理
     */
    $('input[name="all_check"]').on('change', function () {
        $('.move_check').prop('checked', this.checked);
        switchCheckBox();
    });

    /**
     * 一覧：全選択ボタンの制御
     */
    $('.no_data').find('input').attr('disabled', true);

    /**
     * 一覧：チェックボックスクリック時
     */
    $('table.hover_rows_custom input').on('click', function () {
        switchCheckBox();
    });


    /**
     * フッター：各種印刷ボタンクリック時
     */
    $(document).on('submit', '.button_bar form', function (e) {

        let $form = $(this);
        $form.find('input').remove();
        $('.info').css('display', 'none');

        if ($form.find('button').data('csv') === "Y") {
            if ($can_download_csv === "N") {
                $('html,body').animate({scrollTop: 0}, 'fast');
                voss.showMessages('warning', '検索条件でクルーズを絞り直してからCSV出力を行ってください。');
                return false;
            }
        }

        // 出力可能なデータが含まれているかチェック
        if (!hasNotPrinting($form.find('button').data('printing_type'))) {
            return false;
        }

        // 選択された乗船者分、inputタグ生成
        $table = $('.result_list table tbody');
        let reservations = $table.find('input[type="checkbox"]:checked');
        $.each(reservations, function () {
            let $row = $(this);
            let reservationNumber = $row.data('reservation_number');
            let passengerLineNumber = $row.data('passenger_line_number');
            $('<input>').attr({
                'type': 'hidden',
                'name': 'reservations[' + reservationNumber + '][]',
                'value': passengerLineNumber,
            }).appendTo($form);
        });

        // トークンキー追加
        $('<input>').attr({
            'type': 'hidden',
            'name': '_token',
            'value': $('meta[name="csrf-token"]').attr('content'),
        }).appendTo($form);

    });

    /**
     * 検索ボタンクリック時にセッションストレージに検索条件のクルーズ名(コース)、予約番号を保存する
     */
    $(document).on('click', '.done', function (e) {
        let $search_con_item = $('#item_code').val();
        let $search_con_reservation_number = $('#reservation_number').val();
        if ($search_con_item || $search_con_reservation_number) {
            $can_download_csv = "Y";
        }
    });
});