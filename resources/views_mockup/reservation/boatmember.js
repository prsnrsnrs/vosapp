require('../layout/base');
var swal = require("sweetalert2");

/**
 * ページ内リンクスクロール
 */
var scrollJump = function (elem) {
    var speed = 400;
    var href = $(elem).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $('body,html').animate({scrollTop: position}, speed, 'swing');
    return false;
};

/**
 * 乗船者No.1のデータコピー
 */
var copyUserdata = function (elem) {
    var copy_data = [];
    var my_id = $(elem).parent().parent().attr('id');
    var flag = true;
    var i = 0;
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
        var val = $(this).val();
        if(i != 1) {
            if(val != "" && val != "0") {
                flag = false;
            }
        } else {
            if(val != "滋賀") {
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
            html: '既に入力されている内容は破棄されますが、よろしいでしょうか',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            copy();
        }).catch(swal.noop);
    }
};


/**
 * 保存確認アラートを表示します
 */
var showConfirm = function () {
    swal({
        type: 'warning',
        html: '<p>入力内容を保存しますか？</p>',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ',
        allowOutsideClick: false
    }).then(function () {
        swal({
            type: 'success',
            text: '保存しました。'
        }).then(function () {
            location.href = './order_detail'
        });
    },function (dismiss) {
        if (dismiss === 'cancel') {
            location.href = './order_detail'
        }
    })
};

/**
 *  郵便番号自動入力
 */
var setPostNumber = function (elem) {
    var tbody = $(elem).closest('tbody');
    tbody.find('select[name=prefectures]').val('大阪');
    tbody.find('input[name=city]').val('北区梅田2丁目');
};

/**
 * 郵便番号検索
 * @param elem
 */
var openSearchZip = function (elem) {
    var index = $(elem).closest('div.customer_details').attr("id");
    $('input[name=target_index]').val(index);
    $('form#index').submit();
};


$(function () {


    // ページ内リンク
    $('a[href^="#"]').click(function () {
        scrollJump(this);
    });

    // 乗船者No.1のデータコピー
    $('.copy_userdata').click(function () {
        copyUserdata(this);
    });

    $('.skip').on('click', function () {
        showConfirm();
    });


    // 郵便番号自動入力
    $('.auto_post_number').on('click', function () {
        setPostNumber(this);
    });

    // 郵便番号検索
    $('.search_zip').on('click', function () {
        openSearchZip(this);
    });
});