/**
 * 質問入力情報保存
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
                window.location.href = skipUrl;
            }
        })
}

$(function () {
    /**
     * 次へボタン押下時
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
});