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
    $('.before_date ').val(searchPlan.setDate());
    $('.datepicker').datepicker();

    $(document).on('change', 'input[name="all_check"]', function () {
        $('.move_check').prop('checked', this.checked);
    });

    //グループ化モーダル表示
    $(document).on('click', '.new_group',function () {
        $('body').css('overflow','hidden');
        $("body").append('<div id="modal_bg"></div>');
        modalResize();
        $("#modal_bg,#modal_contents").fadeIn("slow");
        $(window).resize(modalResize);

        function modalResize() {

            var w = $(window).width();
            var h = $(window).height();

            var cw = $("#modal_contents").outerWidth();
            var ch = $("#modal_contents").outerHeight();

            //取得した値をcssに追加する
            $("#modal_contents").css({
                "left": ((w - cw) / 2) + "px",
                "top": ((h - ch) / 2) + "px"
            });
        }
    });
    //グループ化モーダル表示
    $(document).on('click','.edit_group',function () {
        $('body').css('overflow','hidden');
        $("body").append('<div id="modal_bg"></div>');
        modalResize();
        $("#modal_bg,#modal_contents").fadeIn("slow");
        $(window).resize(modalResize);

        function modalResize() {

            var w = $(window).width();
            var h = $(window).height();

            var cw = $("#modal_contents").outerWidth();
            var ch = $("#modal_contents").outerHeight();

            //取得した値をcssに追加する
            $("#modal_contents").css({
                "left": ((w - cw) / 2) + "px",
                "top": ((h - ch) / 2) + "px"
            });
        }
    });

    /*    //グループ化モーダル表示
        $(document).on('click','.new_group', function () {
            swal({
                title: 'グループ化 新規',
                html: $("#modal-new").html(),
                width: '1000px',
                showConfirmButton: false,
                allowOutsideClick: false
            })
        });

        $(document).on('click','.edit_group', function () {
            swal({
                title: 'グループ化 編集',
                html: $("#modal-edit").html(),
                width: '1000px',
                showConfirmButton: false,
                allowOutsideClick: false
            })
        });*/

    $(document).on('click', "#cancel_button, .close", function () {
        $("#modal_contents,#modal_bg").fadeOut("slow", function () {
            $('body').css('overflow','auto');
            //挿入した<div id="modal-bg"></div>を削除
            $('#modal_bg').remove();
        });
    });
    $(document).on('click', '.group_new', function () {
        $('body').css('overflow','auto');
        $("td.new_group_button").html("<button class=\"edit edit_group\">設定済</button>");
        $("#modal_contents,#modal_bg").fadeOut("slow", function () {
            //挿入した<div id="modal-bg"></div>を削除
            $('#modal_bg').remove();
        });
    });
    // 検索フォームのクリア
    $('#clearForm').bind('click', function () {
        $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
        $('.before_date ').val(searchPlan.setDate());
    })
});
