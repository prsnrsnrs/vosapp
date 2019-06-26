/**
 *  削除ボタンクリック時
 */
$(document).on('click', '.delete_agent', function (e) {
    e.preventDefault();
    let $form = $(this).parent();
    swal({
        html: '販売店を削除しますか？',
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
 * 検索フォームのクリア
 */
$(document).on('click', '#clearForm', function (e) {
    $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
});