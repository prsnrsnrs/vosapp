require('../layout/base');
var swal = require("sweetalert2");

/*
* 子供食インフォメーション
*/
var showKidsMenu = function () {
    var img = $(".kids_menu_img").clone().show();
    swal({
        html: img,
        animation: false,
        allowOutsideClick: false
    }).catch(swal.noop);
};

$(function () {
    $('.skip').on('click', function() {
        swal({
            type: 'warning',
            html: '<p>入力内容を保存しますか</p>',
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
    // 子供食モーダル表示
    $('.kids_menu').on('click', function () {
        showKidsMenu();
    });

});