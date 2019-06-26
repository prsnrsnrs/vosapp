/**
 * 販売店情報折りたたみ
 */
$(document).on('click', '.folding', function () {
    $(".shop_table tbody").toggle();
    $('a').toggleClass('desc asc');
});

/**
 * 削除ボタンクリック時
 */
$(document).on('click', '.delete', function (e) {
    e.preventDefault();
    let $form = $(this).parent();
    swal({
        html: '選択したユーザーを削除しますか？',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serializeArray(),
            dataType: 'json'
        })
            .done(function (data) {
                location.href = data.redirect;
            })
    }).catch(swal.noop);
});

/**
 * パスワード再設定モーダル
 */
$(document).on('click', '.reset', function (e) {
    e.preventDefault();
    let $form = $(this).parent();
    let data = $form.serializeArray();
    swal({
        html: 'パスワードを変更するユーザーの<br> メールアドレスを入力してください',
        input: 'text',
        confirmButtonText: '送信',
        showCancelButton: true,
        cancelButtonText: 'キャンセル',
        allowOutsideClick: false
    }).then(function (text) {
        data.push({name: 'mail_address', value: text});
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            dataType: 'json',
            data: data
        }).done(function (data) {
            location.href = data.redirect;
        })
    }).catch(swal.noop);
});