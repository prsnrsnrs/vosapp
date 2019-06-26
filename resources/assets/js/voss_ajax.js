/**
 * ajax通信の仕様について。
 * 2重サブミット防止のため、ajaxの処理中は自動的に画面をロックします。
 * エラー発生時は自動的にロック解除されますが、成功時は解除されません。
 * 明示的に解除する場合は、voss.unlock()を呼び出してください。
 */

ajax = {
    /**
     * 初期設定
     */
    setup: function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function (xhr, settings) {
                voss.lock();
                voss.removeHasError();
            },
            complete: function (xhr, textStatus) {

            },
        });
    },
};

/**
 * 初期表示処理
 */
$(document).ready(function () {
    ajax.setup();
});

/**
 * エラー時の処理
 */
$(document).ajaxError(function (event, jqXHR, settings, exception) {
    voss.unlock();

    // 強制リダイレクト処理
    let forcedRedirect = jqXHR.responseJSON.forced_redirect || null;
    if (forcedRedirect) {
        location.href = forcedRedirect;
    }

    let errors = jqXHR.responseJSON.errors || null;
    if (errors) {
        if (errors.warning || errors.web) {
            voss.showMessages('warning', errors.web);
        } else if (errors.socket) {
            voss.showMessages('error', errors.socket);
        } else if (jqXHR.status === 422) {
            voss.showMessages('warning', errors);
        } else {
            // エラーメッセージが取得できなかった場合
            voss.showServerErrorMessages();
        }
    } else if (jqXHR.status === 419) {
        voss.showTokenErrorMessages();
    } else {
        voss.showServerErrorMessages();
    }
    $('body, html').animate({scrollTop: 0}, 200);
});