// 祝日を配列で確保
let holidays = {};
/**
 * 祝日データ取得
 */
$(window).on('load',function(){
    let $form = $('#holiday_form');
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        dataType: 'json'
    })
        .done(function (data) {
            if (data.errors) {
                return;
            }
            holidays = data.holidays;
        })
        .always(function () {
            voss.unlock();
        });
});

/**
 * カレンダー設定
 */
$.datepicker.setDefaults({
    monthNamesShort: ['1月','2月','3月','4月','5月','6月', '7月','8月','9月','10月','11月','12月'],
    monthNames: ['1月','2月','3月','4月','5月','6月', '7月','8月','9月','10月','11月','12月'],
    dayNamesMin: ["日", "月", "火", "水", "木", "金", "土"],
    dateFormat: "yy/mm/dd",
    firstDay: 1,
    showMonthAfterYear: true,
    yearSuffix: "年",
    hideIfNoPrevNext: true,
    nextText: '>',
    prevText: '<',
    // defaultDate: (searchPlan.setDate()),
    // maxDate: new Date('2020/10/10'),
    // minDate: (searchPlan.setDate()),
    /**
     * TOの日付がブランクの場合、TOの初期表示カレンダーにFROMの年月を表示する。
     * @param input
     * @param inst
     * @returns {boolean}
     */
    beforeShow: function (input, inst) {
        if (input.value !== "") {
            return true;
        }
        let thisID = inst.id;
        let fromID = inst.id.replace('to', 'from');
        if (thisID === fromID) {
            return true;
        }
        setTimeout(function () {
            try {
                let fromID = inst.id.replace('to', 'from');
                let fromDate = $('#' + fromID).val();
                let year = parseInt(fromDate.split('/')[0]);
                let month = parseInt(fromDate.split('/')[1]) - 1;

                if (isNaN(year) || isNaN(month) || month <= 0 || 12 <= month) {
                    return true;
                }
                inst.drawYear = year;
                inst.drawMonth = month;
                inst.selectedYear = year;
                inst.selectedMonth = month;
                $.datepicker._updateDatepicker(inst)
            } catch (e) {
                return true;
            }
        }, 0);
    },
    /**
     * カレンダーに祝日をセットして表示します。
     * @param date
     * @returns {*}
     */
    beforeShowDay: function(date) {
        let targetYear = date.getFullYear();
        let len = holidays[targetYear] ? holidays[targetYear].length : 0;
        for (let i = 0; i < len; i++) {
            let holiday = $.datepicker.parseDate('yymmdd', holidays[targetYear][i].holiday_date);

            // 祝日
            if (holiday.getMonth() === date.getMonth() && holiday.getDate() === date.getDate()) {
                return [true, 'holiday', holidays[targetYear][i].holiday_name];
            }
        }
        switch(date.getDay()) {
            case 0:
                return [true, 'sunday'];
                break;
            case 6:
                return [true, 'saturday'];
                break;
            default:
                return [true, 'weekday'];
                break;
        }
    },
});