/**
 * ご乗船者情報を返します
 * @returns {{}}
 */
function getPassengerDatas() {
    let passenger = $('.passenger_data').get();
    let passengerData = {};
    let index = 1;
    Object.keys(passenger).forEach(function (key) {
        let tr = passenger[key];
        let $tr = $(tr);
        let $index = $tr.find('.index');
        passengerData[index] = {
            'show_passenger_line_number': $index.data('show-passenger-line-number'),
            'passenger_line_number': $index.data('passenger-line-number'),
            'pre_passenger_line_number': $tr.find('[name=registered]').val() || null, // TODO:フェーズ2
            'boss_status': $tr.find('.boss_type').data('boss_status'),
            'age_type': $tr.find('.type').data('age_type'),
            'passenger_first_eij': $tr.find('[name="passenger_first_eij"]').val(),
            'passenger_last_eij': $tr.find('[name="passenger_last_eij"]').val(),
            'registered_list': $tr.find('[name=registered]').val() || null, // TODO:フェーズ2
        };
        index++;
    });
    return passengerData;
}

$(function () {
    /**
     * 確定ボタンクリック時
     */
    $('.reservation_cancel').on('click', function () {
        let in_charge = $('#in_charge').val();
        let text;
        if(in_charge === 'before'){
            text = '予約を取消しますか？';
        }
        else if(in_charge === 'after'){
            text = '取消料が発生します。<br>予約を取消してもよろしいでしょうか？';
        }
        swal({
            type: 'warning',
            html: text,
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            let $form = $('#reservation_cancel_form');
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                dataType: 'json',
                data: {
                    'passengers': getPassengerDatas(),
                    'last_update_date_time': $form.data('last_update_date_time')
                }
            }).done(function (data) {
                swal({
                    type: 'success',
                    text: '正常に取消されました。',
                    allowOutsideClick: false
                }).then(function () {
                    location.href = data.redirect;
                });
            })
        }).catch(swal.noop);
    });
});



