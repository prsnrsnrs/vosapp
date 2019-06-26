require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('#btn_result_list').on('click', function () {

        var inputOptions = new Promise(function (resolve) {
            setTimeout(function () {
                location.href = './list';
            }, 1000)
        });
        swal({
            title: '取り込み中',
            input: 'radio',
            inputOptions: inputOptions,
            timer: 2000,
            allowOutsideClick:false
        }).catch(swal.noop)
    });
});
