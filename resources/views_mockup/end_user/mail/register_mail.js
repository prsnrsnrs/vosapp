require('../../layout/base');

$(function () {
    $('input[name="agree"]').on('change',function () {
        var prop = $('#agree').prop('checked');

        if(prop){
            $('.register_button').show();
        }
        else{
            $('.register_button').hide();
        }
    })
})