
/**
 * 客室情報
 * @type {{}}
 */
let cabinInfo = {
    /**
     * 登録モード
     * check：確認モード
     * force：強制モード
     */
    'insert_mode': 'check'
};


$(document).ready(function(){

    /**
     * 共通：画面ロード時のちらつき防止
     */
    $('body').show();

    /**
     * 共通：スライダー
     */
    $('.slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });


    /**
     * フッター：確定ボタンクリック時
     */
    $(document).on('submit', '#reservation_change_done', function (e) {
        // イベント中止
        e.preventDefault();
        postReservationChange();
    });


    /**
     * 客室タイプ変更処理
     */
    function postReservationChange() {

        let form = $('#reservation_change_done');
        cabinInfo.cabin_type = $(form).find('.cabin_type').val();
        cabinInfo.cabin_line_number = $(form).find('.cabin_line_number').val();

        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            dataType: 'json',
            data: cabinInfo
        }).done(function (data) {
            voss.unlock();
            if (data.confirm) {
                cancelChargeConfirm(data.confirm);
            } else {
                location.href = data.redirect;
            }
        })
    }

    /**
     * 取消料発生時の確認アラート表示
     * @param data
     */
    function cancelChargeConfirm(data) {
        swal({
            type: 'info',
            html: data.message,
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ'
        }).then(function () {
            // 強制モードをセット
            cabinInfo.insert_mode = 'force';
            postReservationChange();
        })
    }
});


