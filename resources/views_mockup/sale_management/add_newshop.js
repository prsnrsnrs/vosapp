require('../layout/base');
var swal = require("sweetalert2");

$(function () {

    $('.register').on('click', function () {
        swal({
            html: '販売店の登録が完了しました。<br>続いてユーザー登録画面へ遷移します。',
            type: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(function () {
            location.href = './create_user';
        }).catch(swal.noop);
    });
});