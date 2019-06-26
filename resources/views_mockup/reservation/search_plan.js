require('../layout/base');
require('../../assets/js/common/calendar');

var searchPlan = {
    setDate: function () {
        var date = new Date();
        var tommorow = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
        var yyyymmdd = tommorow.getFullYear() + '/' + ( "0"+( tommorow.getMonth()+1 ) ).slice(-2) + '/' + ( "0"+tommorow.getDate() ).slice(-2);

        return yyyymmdd;
    }
};
var confirmTime = {
    setDateTime: function () {
        // 1桁の数字を0埋めで2桁にする
        var toDoubleDigits = function(num) {
            num += "";
            if (num.length === 1) {
                num = "0" + num;
            }
            return num;
        };

        var date = new Date();
        var day = date.getFullYear() + '/' + ( "0"+( date.getMonth()+1 ) ).slice(-2) + '/' + ( "0"+date.getDate() ).slice(-2);
        var time = toDoubleDigits(date.getHours()) + ':' +  toDoubleDigits(date.getMinutes());

        return day+ ' ' + time + '現在';
    }
};

$(function () {
    // カレンダー
    $('.before_date ').val(searchPlan.setDate());
    $('.datepicker').datepicker({
        minDate: (searchPlan.setDate()),
    });
    $('#time').text(confirmTime.setDateTime());

    // 検索フォームのクリア
    $('#clearForm').bind('click', function () {
        $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
        $('.before_date ').val(searchPlan.setDate());
    })



});


