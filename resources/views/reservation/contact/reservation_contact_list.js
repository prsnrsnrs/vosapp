require('../../../assets/js/require/calendar');

let $item_options;

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

$(function () {

    /**
     * 検索：代表者名入力時の処理
     */
    $('input[name="search_con[boss_name1]"]').on('change', function () {
        var str = "";
        str = $(this).val();
        $('input[name="search_con[boss_name2]"]').val(str);
    }).change();

    /**
     * ドキュメントロード時の処理
     */
    $(document).ready(function () {
        // カレンダー
        $('.datepicker').datepicker({
            minDate: $('#departure_date_from').data('default').min_calender
        });
        //クルーズ名(コース)のセレクトボックス内の全要素を取得し、複製する
        $item_options = $('#item_code').children().clone();
        receptionFiltering();
    });

    /**
     * 検索フォームのクリアボタンクリックイベント
     */
    $(document).on('click', '#clearForm', function (e) {
        $(this.form).find("textarea, :text, .hidden, select").val("").end().find(":checked").prop("checked", false);
        let $departure_date_from = $('#departure_date_from');
        $departure_date_from.val($departure_date_from.data('default').default_departure);
        receptionFiltering();
    });

    /**
     * 出発日変更イベント
     */
    $(document).on('change', '#departure_date_from, #departure_date_to', function (e) {
        receptionFiltering();
    });

});