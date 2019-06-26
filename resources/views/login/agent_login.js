$(document).ready(function () {
    // ログイン情報の取得
    let login_id = localStorage.getItem('agent.login_id');
    let user_id = localStorage.getItem('agent.user_id');

    if (login_id && user_id) {
        $('#store_id').val(login_id);
        $('#user_id').val(user_id);
        $('#remember').prop('checked', true);
    }
});

/**
 * ログインフォーム submit ベント
 */
$(document).on('submit', '#login_form', function (e) {
    // イベント中止
    e.preventDefault();

    // ID情報を保持するチェック時
    let isCheck = $('#remember').prop('checked');
    if (isCheck) {
        localStorage.setItem('agent.login_id', $('#store_id').val());
        localStorage.setItem('agent.user_id', $('#user_id').val());
    } else {
        localStorage.removeItem('agent.login_id');
        localStorage.removeItem('agent.user_id');
    }

    let $form = $(this);
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serializeArray(),
        dataType: 'json'
    }).done(function (data) {
        window.location.href = data.redirect;
    })
});