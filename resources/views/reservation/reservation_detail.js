/**
 * フッター：客室追加・変更クリック
 */
$(document).on('click', '.cabin_edit', function (e) {
    e.preventDefault();
    if ($(this).hasClass('disabled')) {
        return false;
    }

    let $form = $('#before_cabin_edit_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        dataType: 'json',
        data: {
            'reservation_number': $(this).data('reservation_number'),
            'last_update_date_time': $(this).data('last_update_date_time')
        }
    }).done(function (data) {
        location.href = data.redirect;
    })
});

/**
 *  フッター：予約取消クリック
 */
$(document).on('click', '.cabin_cancel', function (e) {
    e.preventDefault();
    if ($(this).hasClass('disabled')) {
        return false;
    }

    let $form = $('#before_cabin_cancel_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        dataType: 'json',
        data: {
            'reservation_number': $(this).data('reservation_number'),
            'last_update_date_time': $(this).data('last_update_date_time')
        }
    }).done(function (data) {
        location.href = data.redirect;
    })
});


$(document).ready(function () {

    /**
     * ちらつき防止
     */
    $('body').show();
    
});
