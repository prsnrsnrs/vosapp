require('../layout/base');
var swal = require("sweetalert2");
var waitCancel = {
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
        if (rowCount.length - 1 > 1) {
            swal({
                type: 'warning',
                html: '<p>削除しますか？</p>',
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'いいえ',
                allowOutsideClick:false
            }).then(function () {
                waitCancel.deleteRow(elem);
                waitCancel.sortIndex();
            }).catch(swal.noop);
        } else {
            swal({
                type: 'warning',
                html: '<p>TODO</p>'
            }).catch(swal.noop);
        }
    },

    /**
     * テーブルを削除します
     * @param elem
     */
    tryDeleteTable: function (elem) {
        swal({
            type: 'warning',
            html: '<p>客室を削除しますか？</p>',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick:false
        }).catch(swal.noop);
    },

    /**
     * 確認アラートを表示します
     */
    showConfirm: function () {
        swal({
            type: 'warning',
            html: '<p>詳細入力を中断します。<br>入力内容が破棄されます。</p>',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick:false
        }).then(function () {
            swal({
                type: 'success',
                text: '処理を中断しました。',
                allowOutsideClick:false
            }).then(function () {
                location.href = './search_plan'
            });
        }).catch(swal.noop);
    }
};

$(function () {
    $('.row_delete').on('click', function () {
        waitCancel.tryDeleteRow(this);
    });

    $('.table_delete').on('click', function () {
        waitCancel.tryDeleteTable(this);
    });

    $('.suspension').on('click', function () {
        waitCancel.showConfirm();
    });
});



