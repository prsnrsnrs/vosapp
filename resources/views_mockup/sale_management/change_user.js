require('../layout/base');
var swal = require("sweetalert2");

$(function () {

    // 再設定アラート
    $('.pw_reset').on('click', function(){
        swal({
            html: 'パスワードを変更するユーザーのメールアドレスを入力してください',
            input: 'email',
        }).then(function (email) {
            swal({
                type: 'success',
                html: 'パスワード変更メールを送信しました<br> ' + email,
                allowOutsideClick: false
            })
        }).catch(swal.noop)
    });

});