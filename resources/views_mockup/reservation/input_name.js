require('../layout/base');
var swal = require("sweetalert2");
var entryName = {
    /**
     * 追加処理
     * @param elem
     */
    insertRow: function (elem) {
        var template = $(elem).closest('table').find('.add_row');
        var cloneRow = $(template).clone(true).removeClass().show();
        var selectType = $(elem).closest('tr').find('select').val();

        $(cloneRow).children('td.type').text(selectType);
        $(template).before(cloneRow);
    },

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
     * 行を追加します
     * @param elem
     * @param maxCount
     */
    tryInsertRow: function (elem, maxCount) {
        var rowCount = $(elem).closest('table').children('tbody').children('tr:not(.add_row)');
        if (rowCount.length <= maxCount) {
            entryName.insertRow(elem);
            entryName.sortIndex();
        } else {
            swal({
                type: 'warning',
                html: '<p>定員数以上となるため、追加できません。</p>',
                allowOutsideClick:false
            })
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
                entryName.deleteRow(elem);
                entryName.sortIndex();
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
    $('.deluxe_room_add').on('click', function () {
        entryName.tryInsertRow(this, 2)
    });

    $('.state_room_add').on('click', function () {
        entryName.tryInsertRow(this, 3)
    });

    $('.row_delete').on('click', function () {
        entryName.tryDeleteRow(this);
    });
    $('.table_delete').on('click', function () {
        entryName.tryDeleteTable(this);
    });

    $('.mypage').on('click', function () {
        swal({
            type: 'warning',
            html: '<p>予約を取り消しますか？</p>',
            showCancelButton: true,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ',
            allowOutsideClick:false
        }).then(function () {
            location.href = './search_plan'
        })
    });

    $('.detail').on('click', function () {
        swal({
            type: 'success',
            html: '[予約番号：123456789]<br><p>お客様のお部屋が確保されました。<br>引き続き詳細入力へ進みますか？</p>',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ'
        }).then(function () {
                location.href = './boatmember'
        },function (dismiss) {
            if (dismiss === 'cancel') {
                location.href = './order_detail'
            }
        })
    });

    $('.edit_fix').on('click', function() {
        swal({
            type: 'success',
            html: '<p>変更内容を保存しました。</p>',
            allowOutsideClick: false
        }).then(function () {
            location.href = './order_detail'
        })
    });

});



