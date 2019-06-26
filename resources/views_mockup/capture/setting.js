require('../layout/base');
var swal = require("sweetalert2");

$(function () {

    $('input[name="file"]').on("change", function() {
        var inputOptions = new Promise(function (resolve) {
            setTimeout(function () {
                $('.file_setting').css('display', 'block');
            }, 2000)
        });
        swal({
            title: '取り込み中',
            input: 'radio',
            inputOptions: inputOptions,
            timer: 2000,
            allowOutsideClick:false
        }).catch(swal.noop)
    });

    // $('#check').on("click", function() {
    //     swal({
    //         title: '確認中',
    //         input: 'radio',
    //         inputOptions: inputOptions,
    //         timer: 2000,
    //         allowOutsideClick:false
    //     }).catch(swal.noop)
    // });

});