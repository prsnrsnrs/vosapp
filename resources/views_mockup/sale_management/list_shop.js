require('../layout/base');
var swal = require("sweetalert2");

$(function () {
    $('.row_delete').on('click', function () {
        var targetRow = $(this).closest('tr');
        swal({
            html: '販売店を削除しますか？',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick: false
        }).then(function () {
            $(targetRow).remove();
        })
    })
    // 検索フォームのクリア
    $('#clearForm').bind('click', function () {
        $(this.form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
    })

});