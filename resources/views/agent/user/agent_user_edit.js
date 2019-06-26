/**
 * ユーザー作成・決定ボタンクリック時
 */
$(document).on('click', '.register', function (e) {
    e.preventDefault();
    let $form = $('.input_user');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serializeArray(),
        dataType: 'json'
    })
        .done(function (data) {
            console.log(data);
            //販売店・ユーザー情報画面へ遷移
            window.location.href = data['redirect'];
        })
});
