$(document).ready(function () {

    /**
     * 共通：画面ロード時のちらつき防止
     */
    $('body').show();

    /**
     * 共通：スライドバー初期化
     */
    $('.slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });

    /**
     * 客室数変更時：客室数の表示切替
     */
    $('.select_cabin').change(function () {
        let val = $('.select_cabin option:selected').val();

        if (val == 1) {
            $('.select_form_2').css('display', 'none');
            $('.select_form_3').css('display', 'none');
        } else if (val == 2) {
            $('.select_form_2').css('display', 'block');
            $('.select_form_3').css('display', 'none');
        } else if (val == 3) {
            $('.select_form_2').css('display', 'block');
            $('.select_form_3').css('display', 'block');
        }
    });

    /**
     * 次へボタン押下時
     */
    $('.done').on('click', function () {
        let tag = $('.cabin_passenger div:visible').closest('td').get();
        let passengers = {};
        Object.keys(tag).forEach(function (key) {
            passengers[key] = {
                'adult': $(tag[key]).find('.adult').val(),
                'children': $(tag[key]).find('.children').val(),
                'child': $(tag[key]).find('.child').val()
            };
        });

        let form = $('.form');
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            dataType: 'json',
            data: {
                'item_code': $('.item_code').val(),
                'cabin_type': $('.cabin_type').val(),
                'passengers': passengers
            }
        }).done(function (data) {
            let param = '';
            let itemCode = $('.item_code').val();
            if (itemCode) {
                param = "?item_code=" + itemCode;
            }
            window.location.href = data.redirect + param;
        })
    });
});





