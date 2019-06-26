/**
 * 販売店一括登録実行ボタン押下処理
 */
$(function () {
    $('#done_btn').on('click', function (e) {
        e.preventDefault();
        let $form = $(this).parent();
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serializeArray(),
            dataType: 'json'
        }).done(function (data) {
            location.href = data.redirect;
        })
    });

});
