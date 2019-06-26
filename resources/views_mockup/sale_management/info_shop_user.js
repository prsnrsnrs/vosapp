require('../layout/base');
var swal = require("sweetalert2");

$(function () {

    // 販売店情報折りたたみ
    $('.folding').on('click', function () {
        $(".shop_table tbody").toggle();
        $('a').toggleClass('desc asc');
    });

    // 削除アラート
    $('.row_delete').on('click', function () {
        var targetRow = $(this).closest('tr');
        swal({
            html: '選択したユーザーを削除しますか？',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            $(targetRow).remove();
        }).catch(swal.noop);
    });
    // 再設定アラート
    $('.pw_reset').on('click', function(){
        swal({
            html: 'パスワードを変更するユーザーのメールアドレスを入力してください',
            input: 'text',
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    if (email.length >= 15) {
                        // ここで入力チェック？エラー
                        reject('メールアドレスとして正しくありません。')
                    } else {
                        resolve()
                    }
                })
            },
            // allowOutsideClick: false
        }).then(function (email) {
            swal({
                type: 'success',
                html: 'パスワード変更メールを送信しました<br> ' + email,
                allowOutsideClick: false
            })
        }).catch(swal.noop)
    });

});