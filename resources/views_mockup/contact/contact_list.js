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
    // カレンダーの初期値
    $('.before_date').val(searchPlan.setDate());
    $('.datepicker').datepicker();

    // ソート処理
    $('.sort').on('click', function(){
        var $target = $(this);
        var sortBy = $($target).hasClass('desc') ? 'asc' : 'desc';
        $('a.sort').removeClass('desc asc');
        $target.addClass(sortBy);
    });

    // 検索フォームのクリア
    $('#clearForm').bind('click', function () {
        $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
        $('.before_date ').val(searchPlan.setDate());
    })

});
