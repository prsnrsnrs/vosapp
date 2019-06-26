/**
 * 設定ボタンクリックイベント
 */
$(document).on('click', '.format_default', function () {
    let $this = $(this);
    let formatNumber = $this.data('format_number');
    let lastUpdateDateTime = $this.data('last_update_date_time');
    swal({
        html: '選択したフォーマットを既定に設定しますか？',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        let $form = $('#default_form');
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: {'format_number': formatNumber, 'last_update_date_time': lastUpdateDateTime},
            dataType: 'json'
        })
            .done(function (data) {
                window.location.href = data.redirect;
            });
    });
});

/**
 * 削除ボタンクリックイベント
 */
$(document).on('click', '.format_delete', function () {
    let $this = $(this);
    let formatNumber = $this.data('format_number');
    let lastUpdateDateTime = $this.data('last_update_date_time');
    swal({
        html: '選択したフォーマットを削除しますか？',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        let $form = $('#delete_form');
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: {'format_number': formatNumber, 'last_update_date_time': lastUpdateDateTime},
            dataType: 'json'
        })
            .done(function (data) {
                window.location.href = data.redirect;
            });
    });
});

/**
 * 複製ボタンクリックイベント
 */
$(document).on('click', '.format_copy', function () {
    let $this = $(this);
    let formatNumber = $this.data('format_number');
    let $form = $('#copy_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: {'format_number': formatNumber},
        dataType: 'json'
    })
        .done(function (data) {
            window.location.href = data.redirect;
        });
});