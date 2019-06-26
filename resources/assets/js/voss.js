voss = {

    /**
     * 画面ロックします。
     */
    lock: function () {
        $('#layer').addClass('loading');
        $('form').attr('onsubmit', 'return false;');
    },

    /**
     * 画面をアンロックします。
     */
    unlock: function () {
        $('#layer').removeClass('loading');
        $('form').removeAttr('onsubmit');
    },

    /**
     * メッセージ表示
     * @param icon
     * @param messages
     */
    showMessages: function (icon, messages) {
        if (!messages) {
            voss.showServerErrorMessages();
        }

        let information = $('.info');
        let iconTag = $(information).find('.icon');
        let messageTag = $(information).find('.message');
        $(iconTag).removeClass().addClass('icon');
        $(messageTag).empty();

        $(iconTag).addClass('icon_' + icon);
        let span = $('<span></span>').addClass(icon);
        if ($.isPlainObject(messages)) {
            $.each(messages, function (key, message) {
                if (icon === 'warning' && message.length > 1) {
                    // 入力チェック：1つの項目に対して複数
                    $.each(message, function (index, term) {
                        setTag = $(span).clone(true).html(term);
                        $(messageTag).append(setTag);
                    });
                    if (isNaN(key)) {
                        voss.setHasError(key);
                    }
                } else {
                    // 入力チェック：1つの項目に対して1つ
                    setTag = $(span).clone(true).html(message);
                    $(messageTag).append(setTag);
                    if (isNaN(key)) {
                        voss.setHasError(key);
                    }
                }
            });

        } else {
            // 入力チェック以外の複数エラーは<br>タグで返ってくるため、line-heightで余白を指定
            $(span).html(messages).css('line-height', '1.9');
            $(messageTag).append(span);
        }
        $(information).show();
    },

    /**
     * インフォメーションメッセージを表示します
     * @param message
     */
    showInformationMessages: function (message) {
        voss.showMessages('info', message);
    },

    /**
     * 成功メッセージを表示します
     * @param message
     */
    showSuccessMessages: function (message) {
        voss.showMessages('success', message);
    },


    /**
     * ajax通信失敗時のメッセージを表示します
     * @param message
     */
    showAjaxErrorMessages: function () {
        message = {"messages": "サーバーとの通信に失敗しました。"};
        voss.showMessages('error', message);
    },

    /**
     * サーバーエラー時のメッセージを表示します
     * @param
     */
    showServerErrorMessages: function () {
        message = {"messages": "サーバーエラーが発生しました。"};
        voss.showMessages('error', message);
    },

    /**
     * トークンエラー時のメッセージを表示します
     * @param
     */
    showTokenErrorMessages: function () {
        message = {"messages": "トークンエラーが発生しました。画面をリロードしてください。"};
        voss.showMessages('error', message);
    },

    /**
     * 入力エラーの要素にhas_errorのクラスを付与します。
     * @param name
     */
    setHasError: function (name) {
        name = this.strReplaceDotToBracket(name);
        $elem = $('[name="' + name + '"]');
        if ($elem.length > 0) {
            $elem.addClass('has_error');
        }
    },

    /**
     *  has_errorのクラスを削除します。
     */
    removeHasError: function () {
        $('.has_error').removeClass('has_error');
    },

    /**
     * ドット記法の文字列をブラケット記法の文字列に変換します。
     * @param str
     * @returns string
     */
    strReplaceDotToBracket: function (str) {
        let arr = str.split('.');
        let arrLen = arr.length;
        if (arrLen === 1) {
            return str;
        }

        let ret = "";
        for (let i = 0; i < arrLen; i++) {
            if (i === 0) {
                ret += arr[i];
            }
            else {
                ret += '[' + arr[i] + ']';
            }
        }
        return ret;
    }
};

/**
 * ホバーテーブルのhover処理
 */
$(document).on('mouseenter', 'table.hover_rows tr', function (e) {
    let $elem = $(this);
    if ($elem.closest('table').find('td[rowspan]').length == 0) {
        return false;
    }

    if ($elem.has('td[rowspan]').length == 0) {
        $(this).prev('tr').addClass('hover');
    }
    else {
        $(this).next('tr').addClass('hover');
    }
});
/**
 * ホバーテーブルのhover処理
 */
$(document).on('mouseleave', 'table.hover_rows tr', function (e) {
    $('table.hover_rows tr.hover').removeClass('hover');
});


/**
 * カスタムホバーテーブルのhover処理（3行以上）
 */
$(document).on('mouseenter', 'table.hover_rows_custom tr', function () {
    let $elem = $(this);
    let reservationNumber = $elem.attr('class');
    $('table.hover_rows_custom tr.' + reservationNumber).addClass('hover');

});

/**
 * カスタムホバーテーブルのhover処理（3行以上）
 */
$(document).on('mouseleave', 'table.hover_rows_custom tr', function () {
    $('table.hover_rows_custom tr.hover').removeClass('hover');
});


/**
 *
 */
$(document).on('click', 'a.prev_confirm', function (e) {
    e.preventDefault();
    let href = $(this).prop('href');
    swal({
        type: 'warning',
        html: '<p>入力内容が破棄されます。よろしいでしょうか？</p>',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        location.href = href;
    });
});

$(document).on('click', 'a.disabled', function (e) {
    e.preventDefault();
});
