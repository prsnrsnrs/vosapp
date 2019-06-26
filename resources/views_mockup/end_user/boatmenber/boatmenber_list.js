require('../../layout/base');
var swal = require("sweetalert2");
var entryName = {
    /**
     * 行を削除します
     * @param elem
     */
    tryDeleteRow: function (elem) {
        var rowCount = $(elem).closest('tbody').find('tr:not(.add_row)');
        if (rowCount.length - 1 > 1) {
            swal({
                type: 'warning',
                html: '<p>お客様情報を削除しますか？</p>',
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'いいえ',
                allowOutsideClick:false
            }).catch(swal.noop);
        } else {
            swal({
                type: 'warning',
                html: '<p>TODO</p>'
            })
        }
    }
};

$(function () {
       $('.row_delete').on('click', function () {
        entryName.tryDeleteRow(this);
    });
});



