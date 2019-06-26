require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('input[name="csv_file"]').on('change', function () {
        var inputOptions = new Promise(function (resolve) {
            setTimeout(function () {
                $('.step2').show();
            }, 1000)
        });
        swal({
            title: 'CSVヘッダー情報読み込み中',
            input: 'radio',
            inputOptions: inputOptions,
            timer: 1000,
            allowOutsideClick:false
        }).catch(swal.noop)
    });

    $('#done').on('click', function () {
        var inputOptions = new Promise(function (resolve) {
            setTimeout(function () {
                location.href = './bundle_confirm';
            }, 1000)
        });
        swal({
            title: 'CSV取り込み中',
            input: 'radio',
            inputOptions: inputOptions,
            timer: 5000,
            allowOutsideClick: false
        }).catch(swal.noop)
    });

});

