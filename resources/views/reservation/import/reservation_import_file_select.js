/**
 * 取込のサブミットイベント
 */
$(document).on('submit', '#reservation_import_form', function (e) {
    e.preventDefault();

    swal({
        title: '取り込み中',
        allowOutsideClick: false
    });
    swal.showLoading();
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
            window.location.href = data.redirect;
        })
        .fail(function (data) {
            swal.close();
        });
});
/**
 * ダウンロードクリック
 */
$(document).on('click', '#download_format', function (e) {
    e.preventDefault();
    $('#download_format_number').val($('#format_number').val());
    $('#download_form').submit();
});