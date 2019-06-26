require('../../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('button.file_upload').on('click', function () {
        swal({
            html:'ファイルが送信されました。</p>',
            type: 'success',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        })
    })

    $('.delete').on('click', function() {
        $('.file').val('');
    });
});
