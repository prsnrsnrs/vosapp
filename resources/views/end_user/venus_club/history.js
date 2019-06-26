require('../../assets/js/require/calendar');

var searchPlan = {
    setDate: function () {
        var date = new Date();
        var tommorow = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
        var yyyymmdd = tommorow.getFullYear() + '/' + ( "0"+( tommorow.getMonth()+1 ) ).slice(-2) + '/' + ( "0"+tommorow.getDate() ).slice(-2);

        return yyyymmdd;
    }
};
$(function () {
    // カレンダー
    $('.before_date ').val(searchPlan.setDate());
    $('.datepicker').datepicker();
    // 検索フォームのクリア
    $('#clearForm').bind('click', function () {
        $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
        $('.before_date ').val(searchPlan.setDate());
    })
});
