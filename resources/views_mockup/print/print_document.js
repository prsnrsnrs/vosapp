require('../layout/base');
require('../../assets/js/common/calendar');

var searchPlan = {
    setDate: function () {
        var date = new Date();
        var basedate = new Date(date.getFullYear(), date.getMonth() - 2, date.getDate());
        var yyyymmdd = basedate.getFullYear() + '/' + ( "0"+( basedate.getMonth()+1 ) ).slice(-2) + '/' + ( "0"+basedate.getDate() ).slice(-2);

        return yyyymmdd;
    }
};

$(function () {

    $('input[name="all_check"]').on('change', function () {
        $('.move_check').prop('checked', this.checked);
    });

    // カレンダー
    $('.before_date ').val(searchPlan.setDate());
    $('.datepicker').datepicker();


    // 検索フォームのクリア
    $('#clearForm').bind('click', function () {
        $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
        $('.before_date ').val(searchPlan.setDate());
    })

});