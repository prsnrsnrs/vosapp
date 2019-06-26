require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('.done').on('click', function () {
        swal({
            type: 'success',
            html: 'パスワードを変更しました',
            allowOutsideClick: false
        }).then(function () {
            location.href = '../'
        })
    })
});
