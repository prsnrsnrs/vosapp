$(function () {
    $('#send_btn').on('click', function () {
        var inputOptions = new Promise(function (resolve) {
            setTimeout(function () {
            }, 1000)
        });
        swal({
            title: 'メール送信中',
            input: 'radio',
            inputOptions: inputOptions,
            timer: 2000,
            allowOutsideClick: false
        })

        setTimeout( function () {
            $('.success_mail_input').show();
        },2000)
    })

    $('#close_btn').on('click', function () {
        $('.success_mail_input').hide();
    })
})