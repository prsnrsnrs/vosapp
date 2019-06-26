/**
 * フォームサブミット
 */
$(document).on('submit', '#password_reset_form', function (e) {
    e.preventDefault();
    let $form = $(this);
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serializeArray(),
        dataType: 'json'
    }).done(function (data) {
        if (data.message) {
            swal({
                type: 'success',
                text: data.message
            }).then(function () {
                window.location.href = data.redirect;
            });
        } else {
            window.location.href = data.redirect;
        }
    });
});