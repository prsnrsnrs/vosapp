require('../layout/base');
require('core-js');
var swal = require("sweetalert2");

$(function () {
    $('.setting').on('click', function() {
        swal({
            html: '選択したフォーマットを既定に設定しますか？',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick:false
        });
    });
    $('.delete').on('click', function(){
        swal({
            html: '選択したフォーマットを削除しますか？',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick:false
        });
    });
});
