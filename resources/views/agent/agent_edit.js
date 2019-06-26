/**
 * 登録ボタンクリック時
 */
$(document).on('click', '.register', function (e) {
    e.preventDefault();
    let $form = $('.input_shop');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serializeArray(),
        dataType: 'json'
     })
    //登録・編集の分岐　
        // 登録：モーダル→ユーザ作成画面遷移　
        // 編集：販売店一覧画面遷移
        .done(function (data) {
            console.log(data);
            let $mode = $('input[name="is_edit"]').val();
              if($mode ==="1"){
                  //編集：一覧画面へ遷移
                  window.location.href = data['redirect'];
              }
                  else{ //登録：モーダル表示→画面遷移
                    swal({
                        html: '販売店の登録が完了しました。<br>続いてユーザー登録画面へ遷移します。',
                        type: 'warning',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(function () {
                        //ユーザ作成画面へ遷移
                        window.location.href = data['redirect'];
                    }).catch(swal.noop);
            }
        })
});
/**
 * 郵便番号検索処理
 */
$(document).on('change', 'input[name="zip_code"]', function (e) {
    let $zipCode = $(this).val();
       let $form = $('#address_form');

    if ($(this).val().length !== 7) {
        //郵便番号検索処理終了
        return false;
    }
    $.ajax({
        //郵便番号検索処理実行
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: {'zip_code': $zipCode},
        dataType: 'json'
    })
    //成功
        .done(function (response_data) {
            voss.unlock();
            if (response_data.address1 !== "" && response_data.prefecture_code !== "") {
                //都道府県
                $('#prefecture_code').val(response_data.prefecture_code);
                //住所１
                $('input[name="address1"]').val(response_data.address1);
            }
        })
});