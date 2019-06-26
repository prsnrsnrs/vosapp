require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('#done_btn').on('click', function () {
        var inputOptions = new Promise(function (resolve) {
            setTimeout(function () {
                location.href = './bundle_complete';
            }, 2000)
        });
        swal({
            title: '実行中',
            input: 'radio',
            inputOptions: inputOptions,
            timer: 5000,
            allowOutsideClick: false
        }).catch(swal.noop)
    });

});
