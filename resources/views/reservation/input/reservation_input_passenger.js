/**
 * 町名選択画面のURL
 */
let url_town_select;

/**
 * ページ内リンクスクロール
 */
function scrollJump(elem) {
    let speed = 400;
    let href = $(elem).attr("href");
    let target = $(href === "#" || href === "" ? 'html' : href);
    let position = target.offset().top;
    $('body,html').animate({scrollTop: position}, speed, 'swing');
}

/**
 * 乗船者No.1のデータコピー
 */
function copyUserdata(elem) {
    let copy_data = [];
    let my_id = $(elem).parent().parent().attr('id');
    let flag = true;
    let i = 0;

    function copy() {
        i = 0;
        //　コピー元の情報を取得
        $("#no1 .copy_data").each(function () {
            copy_data[i] = $(this).val();
            i++;
        });
        //  コピー先に設定
        i = 0;
        $('#' + my_id + ' .copy_data').each(function () {
            $(this).val(copy_data[i]);
            i++;
        });
    }

    //　コピー先の情報に値が入っているのか判定
    i = 0;
    $('#' + my_id + ' .copy_data').each(function () {
        let val = $(this).val();
        if (i != 1) {
            if (val != "" && val != "0") {
                flag = false;
            }
        }
        i++;
    });
    if (flag) {
        copy();
    } else {
        swal({
            type: 'info',
            html: '既に入力されている内容は破棄されます。<br>よろしいでしょうか？',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            copy();
        }).catch(swal.noop);
    }
}

/**
 * ご乗船者入力情報保存
 * @param needSuccessMessage
 */
function save(needSuccessMessage) {
    let $form = $('#passenger_form');
    let skipUrl = $('#skip').data('skip_url');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serializeArray(),
        dataType: 'json'
    })
        .done(function (data) {
            if (needSuccessMessage) {
                swal({
                    type: 'success',
                    text: '保存しました。'
                }).then(function () {
                    window.location.href = skipUrl;
                });
            } else {
                window.location.href = data.redirect;
            }
        })
}

/**
 * 郵便番号自動入力
 * @param zipCode
 * @param $prefecture 都道府県のドロップダウン
 * @param $address1 住所1テキストボックス
 * @returns {boolean}
 */
function autoAddress(zipCode, $prefecture, $address1) {
    if (zipCode.length !== 7) {
        return false;
    }

    let $form = $('#address_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: {'zip_code': zipCode},
        dataType: 'json'
    })
        .done(function (data) {
            voss.unlock();
            $prefecture.val(data.prefecture_code);
            $address1.val(data.address1);
        })
}

/**
 * 町名選択画面を閉じる処理
 * @param url_town_select
 */
function closeTownSelect(url_town_select) {
    if (url_town_select !== "") {
        url_town_select.close();
    }
}

// -------------------------------------------------------------------- //

/**
 * ページ内リンククリックイベント
 */
$(document).on('click', 'a[href^="#"]', function (e) {
    e.preventDefault();
    scrollJump(this);
});

/**
 * 次へクリックイベント
 */
$(document).on('click', '#next', function (e) {
    save(false);
});

/**
 * スキップクリックイベント
 */
$(document).on('click', '#skip', function (e) {
    let skipUrl = $(this).data('skip_url');
    swal({
        type: 'warning',
        html: '<p>入力内容を保存しますか？</p>',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        save(true);
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            location.href = skipUrl;
        }
    })
});

/**
 * 乗船者No1のコピークリックイベント
 */
$(document).on('click', '.copy_userdata', function (e) {
    copyUserdata(this);
});


/**
 * 郵便番号検索クリックイベント
 */
$(document).on('click', '.search_zip', function (e) {
    e.preventDefault();
    let target = $(this).data('target');
    let url_obj = $(this).data('url');

    url_obj = url_obj + '?target=' + target;
    url_town_select = window.open(url_obj);
});

/**
 * 郵便番号変更イベント
 */
$(document).on('change', '.zip_code', function (e, town_select) {
    let $this = $(this);
    let zipCode = $this.val();
    let index = $this.data('index');

    let $prefecture = $('[name="passengers[' + index + '][prefecture_code]');
    let $address1 = $('[name="passengers[' + index + '][address1]');
    autoAddress(zipCode, $prefecture, $address1);
    if (town_select) {
        closeTownSelect(url_town_select);
    }

});

/**
 * 国籍変更イベント
 */
$(document).on('change', '#nationality', function () {
    let $this = $(this);
    let countryCode = $this.val();
    let index = $this.data('index');
    let residence_code = document.getElementById(['residence' + index]).getElementsByTagName('option');
    for (i = 0; i < residence_code.length; i++) {
        if (residence_code[i].value === countryCode) {
            residence_code[i].selected = true;
            break;
        }
    }
});
