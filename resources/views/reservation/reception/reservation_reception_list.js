require('../../../assets/js/require/calendar');

let $cruise_options;

/**
 * 検索日付から検索候補のクルーズを絞り込みます。
 */
function receptionFiltering() {
    let $cruise_select = $('#cruise_id');
    $cruise_select.children().remove();
    $cruise_select.append($cruise_options.clone());

    let selected_from = $('#departure_date_from').val().replace(/\//g, '');
    let selected_to = $('#departure_date_to').val().replace(/\//g, '');

    selected_from = selected_from ? parseInt(selected_from) : 0;
    selected_to = selected_to ? parseInt(selected_to) : 99999999;
    $('#cruise_id').children().each(function () {
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

function modalResize() {

    let w = $(window).width();
    let h = $(window).height();

    let cw = $("#modal_contents").outerWidth();
    let ch = $("#modal_contents").outerHeight();

    let tempSize = Math.ceil(h * 0.8);
    if (tempSize < ch) {
        $("#modal_contents").css(
            "height", Math.ceil(h * 0.8) + "px"
        );
        ch = $("#modal_contents").outerHeight();
    }

    //取得した値をcssに追加する
    $("#modal_contents").css({
        "left": ((w - cw) / 2) + "px",
        "top": ((h - ch) / 2) + "px",
    });
}

/**
 * モーダル閉じる処理
 */
function modalClose() {
    $("#modal_contents,#modal_bg").fadeOut("slow", function () {
        $('body').css({'overflow': 'auto', 'padding-right': '0'});
        //挿入した<div id="modal-bg"></div>を削除
        $('#modal_bg').remove();
    });
}


$(function () {

    /**
     * ドキュメントロード時の処理
     */
    $(document).ready(function () {
        // カレンダー
        $('.datepicker').datepicker({
            minDate: $('#departure_date_from').data('default').min_calender
        });
        //クルーズ名のセレクトボックス内の全要素を取得し、複製する
        $cruise_options = $('#cruise_id').children().clone();
        receptionFiltering();
    });

    /**
     * 一覧：検索フォームのクリアボタンクリックイベント
     */
    $(document).on('click', '#clearForm', function (e) {
        $(this.form).find("textarea, :text, .hidden, select").val("").end().find(":checked").prop("checked", false);
        let $departure_date_from = $('#departure_date_from');
        $departure_date_from.val($departure_date_from.data('default').default_departure);
        receptionFiltering();
    });

    /**
     * 一覧：出発日変更イベント
     */
    $(document).on('change', '#departure_date_from, #departure_date_to', function (e) {
        receptionFiltering();
    });

    /**
     * 一覧：グループ設定ボタンクリック
     */
    $(document).on('submit', '.group_setting_form', function (e) {
        e.preventDefault();
        let $form = $(this);
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serializeArray(),
            dataType: 'json'
        })
            .done(function (data) {
                voss.unlock();
                let $body = $('body');
                let scroll_bar = window.innerWidth - $(window).width();
                $body.css({'overflow': 'hidden', 'padding-right': scroll_bar});
                $body.append('<div id="modal_bg"></div>');
                $('#modal_contents').empty().append(data.view);
                modalResize();
                $("#modal_bg, #modal_contents").fadeIn("slow");
                $(window).resize(modalResize);
                $('.no_data input[name="all_check"]').prop('disabled', true);
                $('.no_data').closest('#modal_contents').find('#set_group').prop('disabled', true);
                $('#modal_contents').scrollTop(0);
            });
    });

    /**
     * グループ設定：設定ボタンクリック
     */
    $(document).on('submit', '#group_setting_form', function (e) {
        e.preventDefault();
        let $form = $(this);
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serializeArray(),
            dataType: 'json'
        })
            .done(function (data) {
                location.href = data.redirect;
            })
            .fail(function () {
                modalClose();
            });
    });

    /**
     * グループ設定：すべてチェック変更
     */
    $(document).on('change', 'input[name="all_check"]', function () {
        $('.move_check').prop('checked', this.checked);
    });

    /**
     * グループ設定：グループを抜けるボタンクリック
     */
    $(document).on('click', '#leave_group', function (e) {
        e.preventDefault();
        let $form = $('#group_setting_form');
        $form.find('#group_setting_mode').val('leave');
        $form.submit();
    });

    /**
     * グループ設定：キャンセルボタン、閉じるボタンクリック
     */
    $(document).on('click', "#cancel_button, .close", function () {
        modalClose();
    });
});