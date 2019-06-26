require('../../assets/js/require/calendar');

let $cruise_options;

/**
 * 検索日付から検索候補のクルーズを絞り込みます。
 */
function cruiseFiltering() {
    let $cruise_select = $('#cruise_id');
    $cruise_select.children().remove();
    $cruise_select.append($cruise_options.clone());

    let selected_from = $('#departure_date_from').val().replace(/\//g, '');
    let selected_to = $('#departure_date_to').val().replace(/\//g, '');

    selected_from = selected_from ? parseInt(selected_from) : 0;
    selected_to = selected_to ? parseInt(selected_to) : 99999999;
    $('#cruise_id').children().each(function () {
        $option = $(this);
        if ($option.val() === "") {
            return true;
        }
        let from = parseInt($option.data('start_date'));
        let to = parseInt($option.data('end_date'));
        if (selected_from <= to && selected_to >= from) {
            $option.show();
        } else {
            $option.remove();
        }
    });
}

/**
 * ドキュメントロード時の処理
 */
$(document).ready(function () {
    // カレンダー
    $('.datepicker').datepicker({
        minDate: $('#departure_date_from').data('default')
    });
    //クルーズ名のセレクトボックス内の全要素を取得し、複製する
    $cruise_options = $('#cruise_id').children().clone();
    cruiseFiltering();
});

/**
 * 検索フォームのクリアボタンクリックイベント
 */
$(document).on('click', '#clearForm', function (e) {
    $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
    let $departure_date_from = $('#departure_date_from');
    $departure_date_from.val($departure_date_from.data('default'));
    cruiseFiltering();
});

/**
 * 出発日変更イベント
 */
$(document).on('change', '#departure_date_from, #departure_date_to', function (e) {
    cruiseFiltering();
});

/**
 * 予約ボタンクリックイベント
 */
$(document).on('click', '.btn_reservation', function (e) {
    e.preventDefault();
    let $form = $('#before_reservation_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        dataType: 'json',
        data: {'item_code': $(this).data('item_code')}
    })
        .done(function (data) {
            location.href = data.redirect;
        });
});