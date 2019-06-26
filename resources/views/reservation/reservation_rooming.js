/**
 * ご乗船者情報を取得します
 * @returns {{}}
 */
function getPassengersCondition() {
    let passengers = $('.passenger_data').get();
    let informations = {};
    let index = 1;
    Object.keys(passengers).forEach(function (key) {
        let tr = passengers[key];
        let $tr = $(tr);
        let $index = $tr.find('.index');
        informations[index] = {
            'show_passenger_line_number': $index.data('show_passenger_line_number'),
            'passenger_line_number': $index.data('passenger_line_number'),
            'select_cabin_line_number': $tr.find('[name="select_cabin_line_number"]').val()
        };
        index++;
    });
    return informations;
}

/**
 * サーバーにデータを送ります
 */
function sendChangeRooming(checked = false) {
    let $form = $('#change_reservation_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        dataType: 'json',
        data: {
            'passengers': getPassengersCondition(),
            'last_update_date_time': $('.last_update_date_time').val(),
            'reservation_number': $('.reservation_number').val(),
            'checked': checked
        }
    }).done(function (data) {
        if (data.status === 'success') {
            location.href = data.redirect;
        } else if (data.status === 'request') {
            voss.unlock();
            showConfirm();
        }
    });
}

/**
 * 料金増額時の確認モーダル
 */
function showConfirm() {
    swal({
        type: 'warning',
        html: '<p>料金が変更されます。<br>よろしいでしょうか？</p>',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        sendChangeRooming(true);
    });
}

$(function () {
    $('.change_reservation').on('click', function () {
        sendChangeRooming();
    });
});