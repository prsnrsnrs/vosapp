require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('.delete').on('click', function () {
        swal({
            type: 'warning',
            text: '予約を取消しますか？',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick:false
        }).then(function () {
            swal({
                type: 'success',
                text: '正常に取消されました。',
                allowOutsideClick:false
            }).then(function () {
                location.href = '../reservation/order_detail'
            });
        }).catch(swal.noop);
    });
});



