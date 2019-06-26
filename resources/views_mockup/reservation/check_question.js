require('../layout/base');
var swal = require("sweetalert2");
$(function () {
    $('.skip').on('click', function() {
        swal({
            type: 'warning',
            html: '入力内容を保存しますか？</p>',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            swal({
                type: 'success',
                text: '保存しました。'
            }).then(function () {
                location.href = './order_detail'
            });
        },function (dismiss) {
            if (dismiss === 'cancel') {
                location.href = './order_detail'
            }
        })
    });
});