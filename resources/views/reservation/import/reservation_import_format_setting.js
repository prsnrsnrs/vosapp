/**
 * フォーマット設定フォームのサブミットイベント
 */
$(document).on('submit', '#format_setting_form', function (e) {
    e.preventDefault();

    let $form = $(this);
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: new FormData(this),
        dataType: 'json',
        processData: false,
        contentType: false
    })
        .done(function (data) {
            if (data.message) {
                swal({
                    type: 'success',
                    html: data.message,
                    allowOutsideClick: false
                }).then(function () {
                    window.location.href = data.redirect;
                });
            } else {
                window.location.href = data.redirect;
            }
        })
});

/**
 * 区切り文字変更イベント
 */
$(document).on('change', '.delimit_type_group', function (e) {
    let $this = $(this);
    $this.siblings('.delimit_type_group').val($this.val());
});