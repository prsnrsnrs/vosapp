/**
 * 割引券情報保存
 * @param mode
 */
function save(mode,message) {
    let $form = $('#passenger_form');
    let skipUrl = $('#skip').data('skip_url');
    let $data = $form.serializeArray();
    $data.push({name:'success_message',value:message});
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $data,
        dataType: 'json'
    })
        .done(function (data) {
            if (mode === 'skip') {
                swal({
                    type: 'success',
                    text: '保存しました。'
                }).then(function () {
                    window.location.href = skipUrl;
                });
            } else if (mode === 'next') {
                window.location.href = data.redirect;
            }
            else {
                window.location.reload(true);
            }
        })
}


$(function () {

    /**
     * 次へボタン押下時
     */
    $(document).on('click', '#next', function (e) {
        save('next','no');
    });

    /**
     * 割引券確定ボタン押下時
     */
    $(document).on('click', '#discount_confirm', function (e) {
        save('discountConfirm','need');
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
            save('skip','no');
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                location.href = skipUrl;
            }
        })
    });
});