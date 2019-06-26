/**
 * 登録モード
 * check：確認モード
 * force：強制モード
 */
let insertMode = 'check';
/**
 * 最終更新日時
 */
let lastUpdated = '';
/**
 * 確認更新日時
 */
let lastUpdateDateTime = '';
/**
 * 客室行No
 */
let cabinLineNumber = '';
/**
 * 画面処理モード
 */
let mode = '';
/**
 * クリックされた客室
 */
let cabin = '';
/**
 * クリックされた乗船者行
 */
let index = '';
// /**
//  * 客室数
//  */
// let cabinsCount = $('#cabins_count').val();


/**
 * HK,WT客室混在時の確認アラート表示
 * @param data
 */
function bothStatusConfirm(data) {
    swal({
        type: 'info',
        html: data.message,
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ'
    }).then(function () {
        // 強制モードをセット
        insertMode = 'force';
        lastUpdateDateTime = data.last_update_date_time;
        postReservationDone();
    })
}

/**
 * WT客室のみ時の確認アラート表示
 * @param data
 */
function waitOnlyStatusConfirm(data) {
    swal({
        type: 'info',
        html: data.message,
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ'
    }).then(function () {
        // 強制モードをセット
        insertMode = 'force';
        lastUpdateDateTime = data.last_update_date_time;
        postReservationDone();
    })
}

/**
 * 取消時の確認アラート表示
 * @param data
 */
function cancelConfirm(data) {
    mode = data.mode;
    swal({
        type: 'warning',
        html: data.message,
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ'
    }).then(function (data) {
        if (mode === 'cabin_cancel') {
            // 強制モードをセット
            insertMode = 'force';
            postReservationCabinCancel();
        } else if (mode === 'passenger_cancel') {
            // 強制モードをセット
            insertMode = 'force';
            postReservationPassengerCancel();
        }
    })
}

/**
 * 詳細入力確認モーダル
 * @param data
 */
function successConfirm(data) {
    swal({
        type: 'success',
        html: data.message,
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: 'はい',
        cancelButtonText: 'いいえ'
    }).then(function () {
        location.href = data.done;
    }, function () {
        location.href = data.cancel
    })
}

/**
 * ご乗船者情報を返します
 * @return {{}}
 */
function getPassengersData() {
    let passenger = $('.passenger_data').get();
    let condition = {};
    let index = 1;
    Object.keys(passenger).forEach(function (key) {
        let tr = passenger[key];
        let $tr = $(tr);
        let $index = $tr.find('.index');
        condition[index] = {
            'show_passenger_line_number': $index.data('show-passenger-line-number'),
            'passenger_line_number': $index.data('passenger-line-number'),
            'pre_passenger_line_number': $tr.find('[name=registered]').val() || null, // TODO:フェーズ2
            'boss_status': $tr.find('[name="custom[boss_status]"]').prop('checked') ? 'Y' : '',
            'age_type': $tr.find('.type').data('age-type'),
            'passenger_last_eij': $tr.find('[name="passengers[' + index + '][passenger_last_eij]"]').val(),
            'passenger_first_eij': $tr.find('[name="passengers[' + index + '][passenger_first_eij]"]').val(),
            'registered_list': $tr.find('[name=registered]').val() || null, // TODO:フェーズ2
        };
        index++;
    });
    return condition;
}


/**
 * 予約確定処理
 */
function postReservationDone() {
    let form = $('.form_reservation_done');
    $.ajax({
        url: $(form).attr('action'),
        type: $(form).attr('method'),
        dataType: 'json',
        data: {
            passengers: getPassengersData(),
            insert_mode: insertMode,
            last_updated: lastUpdated,
            last_update_date_time: lastUpdateDateTime,
            cabins_count: $('#cabins_count').val()
        }
    }).done(function (data) {
        voss.unlock();
        if (data.both) {
            bothStatusConfirm(data.both);
        } else if (data.wait_only) {
            waitOnlyStatusConfirm(data.wait_only);
        } else if (data.new) {
            successConfirm(data.new);
        } else if (data.edit) {
            location.href = data.edit.redirect;
        }
    })
}

/**
 * 客室取消処理
 */
function postReservationCabinCancel() {
    cabinLineNumber = $(cabin).find('.index').data('cabin-line-number');
    let form = $('.form_cabin_delete');
    $.ajax({
        url: $(form).attr('action'),
        type: $(form).attr('method'),
        dataType: 'json',
        data: {
            passengers: getPassengersData(),
            cabin_line_number: $(cabin).find('.index').data('cabin-line-number'),
            show_cabin_line_number: $(cabin).data('show-cabin-line-number'),
            insert_mode: insertMode
        }
    }).done(function (data) {
        voss.unlock();
        if (data.confirm) {
            cancelConfirm(data.confirm);
        } else {
            location.reload();
        }
    });
}

/**
 * 乗船者一人取消処理
 */
function postReservationPassengerCancel() {
    let form = $('.form_passenger_delete');
    $.ajax({
        url: $(form).attr('action'),
        type: $(form).attr('method'),
        dataType: 'json',
        data: {
            passenger_line_number: $(index).data('passenger-line-number'),
            show_passenger_line_number: $(index).data('show-passenger-line-number'),
            passengers: getPassengersData(),
            insert_mode: insertMode
        }
    }).done(function (data) {
        voss.unlock();
        if (data.confirm) {
            cancelConfirm(data.confirm);
        } else {
            location.reload();
        }
    })
}


$(function () {

    /**
     * 一覧：乗船者追加ボタンクリック時
     */
    $('.passenger_add').on('click', function () {

        let index = $(this).closest('table').find('.index');
        let form = $('.form_passenger_add');

        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            dataType: 'json',
            data: {
                passengers: getPassengersData(),
                cabin_line_number: $(index).data('cabin-line-number'),
                show_cabin_line_number: $(index).closest('table').data('show-cabin-line-number'),
                age_type: $(this).siblings('[name=age_type]').val()
            }
        }).done(function () {
            location.reload();
        })
    });

    /**
     * 一覧：客室タイプ変更ボタンクリック時
     */
    $(document).on('submit', '#cabin_type_change', function (e) {
        e.preventDefault();
        let form = $(this);
        let cabinLineNumber = $(form).find('.cabin_line_number').val();
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            dataType: 'json',
            data: {
                passengers: getPassengersData(),
            }
        }).done(function (data) {
            window.location.href = data.redirect + '?cabin_line_number=' + cabinLineNumber;
        })
    });

    /**
     * フッターボタン：客室追加
     */
    $(document).on('submit', '#form_cabin_add', function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            dataType: 'json',
            data: {
                passengers: getPassengersData(),
            }
        }).done(function (data) {
            window.location.href = data.redirect;
        })
    });


    /**
     * フッターボタン：予約の取消/入力の取消ボタンクリック時
     */
    $('.reservation_cancel').on('click', function (e) {
        e.preventDefault();
        let $a = $(this);
        let mode = $a.attr('data-mode');
        let message = mode === 'new' ? '予約を取り消してもよろしいでしょうか？' : '入力内容が破棄されます。よろしいでしょうか？';
        swal({
            type: 'warning',
            html: message,
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: 'はい',
            cancelButtonText: 'いいえ'
        }).then(function () {
            window.location.href = $a.attr('href');
        })
    });

    /**
     * フッターボタン：予約確定ボタンクリック時
     */
    $('.done_reservation').on('click', function () {
        postReservationDone();
    });

    /**
     * 一覧：客室取消ボタンクリック時
     */
    $('.cabin_cancel').on('click', function () {
        cabin = $(this).closest('table');
        postReservationCabinCancel();
    });

    /**
     * 一覧：乗船者取消ボタンクリック時
     */
    $('.passenger_delete').on('click', function () {
        index = $(this).closest('tr').find('.index');
        postReservationPassengerCancel();
    });
});