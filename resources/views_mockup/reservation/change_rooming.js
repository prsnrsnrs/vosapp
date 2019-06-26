require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('.done').on('click', function () {
        swal({
            type: 'warning',
            html: '料金が変更されます。よろしいでしょうか？</p>',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            location.href = './order_detail'
        });
    });
});