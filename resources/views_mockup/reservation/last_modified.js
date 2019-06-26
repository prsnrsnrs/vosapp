require('../layout/base');
var swal = require("sweetalert2");
var lastModified = {

    /**
     * 削除処理
     * @param elem
     */
    deleteRow: function (elem) {
        $(elem).parents('tr').remove();
    },

    /**
     * 番号を振りなおします
     */
    sortIndex: function () {
        var index = $('table.default tbody tr:not(.add_row) td.index').get();
        var count = 1;
        for (var i = 0; i < index.length; i++) {
            $(index[i]).text(count);
            count++;
        }
    },

    /**
     * 行を削除します
     * @param elem
     */
    tryDeleteRow: function (elem) {
        var rowCount = $(elem).closest('tbody').find('tr:not(.add_row)');
        var thisRow = $(elem).closest('tr');
        var data = {
            index: $(thisRow).find('td.index').text(),
            name: $(thisRow).find('.name span').text(),
        };
        if (rowCount.length - 1 > 1) {
            swal({
                html: 'No' + data.index + '　' + data.name + 'を<br>取消しますか？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'いいえ'
            }).then(function () {
                lastModified.deleteRow(elem);
                lastModified.sortIndex();
            }).catch(swal.noop);
        } else {
            swal({
                html: '客室情報を取消しますか？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'いいえ'
            }).catch(swal.noop);
        }
    },

    /**
     * 客室削除確認アラート
     */
    checkAlert: function () {
        swal({
            html: '客室情報を取消しますか？',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ'
        })
    }
};

$(function () {
    $('.row_delete').on('click', function () {
        lastModified.tryDeleteRow(this);
    });

    $('.table_delete').on('click', function () {
        lastModified.checkAlert();
    });
});



