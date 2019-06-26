<?php

/** ログイン */
Route::get('/', 'LoginController@getAgentLogin')
    ->name('login');
Route::post('/', 'LoginController@postAgentLogin')
    ->name('login');

/** ログアウト */
Route::get('/logout', 'LoginController@getAgentLogout')
    ->name('logout');

/** マイページ */
Route::get('mypage', 'MypageController@getAgentMypage')
    ->name('mypage')
    ->middleware(['voss.auth']);

/** クルーズプラン検索 */
Route::get('cruise_plan/search', 'CruisePlanController@getSearch')
    ->name('cruise_plan.search')
    ->middleware(['voss.auth']);
/** クルーズプラン検索 (予約ボタンクリック時) 予約に進む前の事前処理 */
Route::post('cruise_plan/before_reservation', 'CruisePlanController@postBeforeReservation')
    ->name('cruise_plan.before_reservation')
    ->middleware(['voss.auth']);

// 客室タイプ選択画面
Route::get('reservation/cabin/type_select/', 'ReservationCabinController@getTypeSelect')
    ->name('reservation.cabin.type_select')
    ->middleware(['voss.auth']);

// 客室人数選択画面
Route::get('reservation/cabin/passenger_select/', 'ReservationCabinController@getPassengerSelect')
    ->name('reservation.cabin.passenger_select')
    ->middleware(['voss.auth']);
// 客室人数選択画面：客室追加
Route::post('reservation/cabin/passenger_select/cabin_create/', 'ReservationCabinController@postCabinCreate')
    ->name('reservation.cabin.passenger_select.cabin_create')
    ->middleware(['voss.auth']);

// ご乗船者名入力画面
Route::get('reservation/cabin/passenger_entry/', 'ReservationCabinController@getPassengerEntry')
    ->name('reservation.cabin.passenger_entry')
    ->middleware(['voss.auth']);
// ご乗船者名入力画面:予約確定
Route::post('reservation/cabin/passenger_entry/reservation_done/', 'ReservationCabinController@postReservationDone')
    ->name('reservation.cabin.passenger_entry.reservation_done')
    ->middleware(['voss.auth']);
// ご乗船者名入力画面:客室一人追加
Route::post('reservation/cabin/passenger_entry/cabin_passenger_add/', 'ReservationCabinController@postCabinPassengerAdd')
    ->name('reservation.cabin.passenger_entry.cabin_passenger_add')
    ->middleware(['voss.auth']);
// ご乗船者名入力画面:客室一人削除
Route::post('reservation/cabin/passenger_entry/cabin_passenger_delete/', 'ReservationCabinController@postCabinPassengerDelete')
    ->name('reservation.cabin.passenger_entry.cabin_passenger_delete')
    ->middleware(['voss.auth']);
// ご乗船者名入力画面:客室タイプ追加
Route::post('reservation/cabin/passenger_entry/cabin_add/', 'ReservationCabinController@postCabinAdd')
    ->name('reservation.cabin.passenger_entry.cabin_add')
    ->middleware(['voss.auth']);
// ご乗船者名入力画面:客室タイプ削除
Route::post('reservation/cabin/passenger_entry/cabin_delete/', 'ReservationCabinController@postCabinDelete')
    ->name('reservation.cabin.passenger_entry.cabin_delete')
    ->middleware(['voss.auth']);
// ご乗船者名入力画面:客室タイプ変更
Route::post('reservation/cabin/passenger_entry/cabin_change/', 'ReservationCabinController@postCabinChange')
    ->name('reservation.cabin.passenger_entry.cabin_change')
    ->middleware(['voss.auth']);

// ご乗船者詳細入力
Route::get('reservation/input/passenger/', 'ReservationInputController@getPassenger')
    ->name('reservation.input.passenger')
    ->middleware(['voss.auth', 'voss.reservation']);
Route::post('reservation/input/passenger/', 'ReservationInputController@postPassenger')
    ->middleware(['voss.auth']);

// 客室リクエスト入力画面
Route::get('reservation/input/cabin_request/', 'ReservationinputController@getCabinRequest')
    ->name('reservation.input.cabin_request')
    ->middleware(['voss.auth', 'voss.reservation']);
Route::post('reservation/input/cabin_request/', 'ReservationinputController@postCabinRequestChange')
    ->name('reservation.input.cabin_request')
    ->middleware(['voss.auth']);

// 割引券情報入力画面
Route::get('reservation/input/discount/', 'ReservationinputController@getDiscount')
    ->name('reservation.input.discount')
    ->middleware(['voss.auth', 'voss.reservation']);
Route::post('reservation/input/discount/', 'ReservationinputController@postDiscountChange')
    ->name('reservation.input.discount')
    ->middleware(['voss.auth']);

// 質問事項のチェック
Route::get('reservation/input/question/', 'ReservationinputController@getQuestion')
    ->name('reservation.input.question')
    ->middleware(['voss.auth', 'voss.reservation']);
Route::post('reservation/input/question/', 'ReservationinputController@postQuestionChange')
    ->name('reservation.input.question')
    ->middleware(['voss.auth']);

// ご乗船者リクエスト入力
Route::get('reservation/input/passenger_request/', 'ReservationinputController@getPassengerRequest')
    ->name('reservation.input.passenger_request')
    ->middleware(['voss.auth', 'voss.reservation']);
Route::post('reservation/input/passenger_request/', 'ReservationinputController@postPassengerRequestChange')
    ->name('reservation.input.passenger_request')
    ->middleware(['voss.auth']);

// 予約照会画面
Route::get('reservation/detail', 'ReservationController@getDetail')
    ->name('reservation.detail')
    ->middleware(['voss.auth', 'voss.reservation']);
// 予約照会 (客室追加・変更クリック) 客室追加・変更に進む前の事前処理
Route::post('reservation/before_cabin_edit', 'ReservationController@postBeforeCabinEdit')
    ->name('reservation.before_cabin_edit')
    ->middleware(['voss.auth']);
// 予約照会 (予約取消クリック) 予約取消に進む前の事前処理
Route::post('reservation/before_cabin_cancel', 'ReservationController@postBeforeCabinCancel')
    ->name('reservation.before_cabin_cancel')
    ->middleware(['voss.auth']);

// ルーミング変更画面
Route::get('reservation/rooming', 'ReservationController@getRooming')
    ->name('reservation.rooming')
    ->middleware(['voss.auth', 'voss.reservation']);
// ルーミング変更画面：決定ボタンクリック時
Route::post('reservation/rooming', 'ReservationController@postRooming')
    ->name('reservation.rooming')
    ->middleware(['voss.auth']);


// 客室タイプ変更確認画面
Route::get('reservation/cabin/change_confirm/', 'ReservationCabinController@getCabinChangeConfirm')
    ->name('reservation.cabin.change_confirm')
    ->middleware(['voss.auth']);

// 客室タイプ変更確認画面：客室タイプ変更
Route::post('reservation/cabin/change_confirm', 'ReservationCabinController@postCabinChangeConfirm')
    ->name('reservation.cabin.change_confirm')
    ->middleware(['voss.auth']);

// 全面取消確認画面
Route::get('reservation/cancel/', 'ReservationController@getReservationCancel')
    ->name('reservation.cancel')
    ->middleware(['voss.auth']);
// 全面取消確認画面:確定ボタンクリック
Route::post('reservation/cancel/', 'ReservationController@postReservationCancel')
    ->name('reservation.cancel')
    ->middleware(['voss.auth']);

// 郵便番号検索画面（都道府県）
Route::get('address/prefecture_select', 'AddressController@getPrefecture')
    ->name('address.prefecture_select');
// 郵便番号検索画面（市区群町村）
Route::get('address/city_select', 'AddressController@getCity')
    ->name('address.city_select');
// 郵便番号検索画面（町名）
Route::get('address/town_select', 'AddressController@getTown')
    ->name('address.town_select');
// 郵便番号から住所の取得
Route::get('address', 'AddressController@getAddress')
    ->name('address');

/*
 * 提出書類画面
 */
Route::get('reservation/document/list', 'ReservationDocumentController@getList')
    ->name('reservation.document.list')
    ->middleware(['voss.auth', 'voss.reservation']);
/**
 * PDF押下時
 */
Route::get('pdf/document_download', 'ReservationDocumentController@getDocumentPdf')
    ->name('pdf.document.download')
    ->middleware(['voss.auth', 'voss.reservation']);

/*
 * 乗船控えと各種確認書の印刷画面
 */
Route::get('reservation/printing/list', 'ReservationPrintingController@getList')
    ->name('reservation.printing.list')
    ->middleware(['voss.auth']);
// 乗船券控え
Route::post('reservation/printing/ticket', 'ReservationPrintingController@getTicket')
    ->name('reservation.printing.ticket')
    ->middleware(['voss.auth', 'voss.reservations']);
// 予約確認書
Route::post('reservation/printing/document', 'ReservationPrintingController@getDocument')
    ->name('reservation.printing.document')
    ->middleware(['voss.auth', 'voss.reservations']);
// 予約内容確認書
Route::post('reservation/printing/detail', 'ReservationPrintingController@getDetail')
    ->name('reservation.printing.detail')
    ->middleware(['voss.auth', 'voss.reservations']);
// 取消記録確認書
Route::post('reservation/printing/cancel', 'ReservationPrintingController@getCancel')
    ->name('reservation.printing.cancel')
    ->middleware(['voss.auth', 'voss.reservations']);
// CSV出力
Route::post('reservation/printing/csv', 'ReservationPrintingController@getCsv')
    ->name('reservation.printing.csv')
    ->middleware(['voss.auth', 'voss.reservations']);

/*
 * ご連絡一覧
 */
// ご連絡一覧画面
Route::get('reservation/contact/list', 'ReservationContactController@getList')
    ->name('reservation.contact.list')
    ->middleware(['voss.auth']);
// ご連絡閲覧画面
Route::get('reservation/contact/detail', 'ReservationContactController@getDetail')
    ->name('reservation.contact.detail')
    ->middleware(['voss.auth']);

/*
 * 予約一括取込
 */
// 一括取込ファイル指定
Route::get('reservation/import/file_select', 'ReservationImportController@getFileSelect')
    ->name('reservation.import.file_select')
    ->middleware(['voss.auth']);
// フォーマットファイルのダウンロード
Route::get('reservation/import/format_download', 'ReservationImportController@getFormatDownload')
    ->name('reservation.import.format_download')
    ->middleware(['voss.auth']);
// 取込結果一覧画面
Route::get('reservation/import/result', 'ReservationImportController@getResult')
    ->name('reservation.import.result')
    ->middleware(['voss.auth']);
// 取込フォーマット管理画面
Route::get('reservation/import/format_list', 'ReservationImportController@getFormatList')
    ->name('reservation.import.format_list')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);
// 取込フォーマット設定画面
Route::get('reservation/import/format_setting', 'ReservationImportController@getFormatSetting')
    ->name('reservation.import.format_setting')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);
// 一括取り込み処理
Route::post('reservation/import/import', 'ReservationImportController@postImport')
    ->name('reservation.import.import')
    ->middleware(['voss.auth']);
// 既定フォーマットの設定処理
Route::post('reservation/import/default_format', 'ReservationImportController@postDefaultFormat')
    ->name('reservation.import.default_format')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);
// フォーマットの登録処理
Route::post('reservation/import/add_format', 'ReservationImportController@postAddFormat')
    ->name('reservation.import.add_format')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);
// フォーマットの登録処理
Route::post('reservation/import/update_format', 'ReservationImportController@postUpdateFormat')
    ->name('reservation.import.update_format')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);
// フォーマットの削除処理
Route::post('reservation/import/delete_format', 'ReservationImportController@postDeleteFormat')
    ->name('reservation.import.delete_format')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);
// フォーマットの複製処理
Route::post('reservation/import/copy_format', 'ReservationImportController@postCopyFormat')
    ->name('reservation.import.copy_format')
    ->middleware(['voss.auth', 'voss.jurisdiction_agent', 'voss.admin_agent']);

/*
 * 販売店情報管理
 */
// 販売店一覧
Route::get('list', 'AgentController@getList')
    ->name('list')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
Route::post('delete', 'AgentController@postDelete')
    ->name('delete')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
// 販売店編集
Route::get('edit', 'AgentController@getEdit')
    ->name('edit')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
Route::post('edit', 'AgentController@postEdit')
    ->name('edit')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
// 販売店一括登録
Route::get('import/file_select', 'AgentImportController@getFileSelect')
    ->name('import.file_select')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
Route::post('import/file_select', 'AgentImportController@postFileSelect')
    ->name('import.file_select')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
// 販売店一括登録 Step2
Route::post('import/file_import', 'AgentImportController@postFileImport')
    ->name('import.file_import')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
// 販売店一括登録確認
Route::get('import/file_confirm', 'AgentImportController@getConfirm')
    ->name('import.file_confirm')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
Route::post('import/file_confirm', 'AgentImportController@postFileImportComplete')
    ->name('import.file_confirm')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);
// 販売店一括登録完了
Route::get('import/file_complete', 'AgentImportController@getComplete')
    ->name('import.file_complete')
    ->middleware(['voss.auth','voss.jurisdiction_agent', 'voss.admin_agent']);

// 販売店情報
Route::get('detail', 'AgentController@getDetail')
    ->name('detail')
    ->middleware(['voss.auth', 'voss.admin_agent','voss.request_other_agent']);

// ユーザー作成画面
Route::get('user/edit', 'AgentUserController@getEdit')
    ->name('user.edit')
    ->middleware(['voss.auth', 'voss.admin_agent','voss.request_other_agent']);
// ユーザー変更画面
Route::post('user/edit', 'AgentUserController@postEdit')
    ->name('user.edit')
    ->middleware(['voss.auth', 'voss.admin_agent','voss.request_other_agent']);
// 販売店ユーザー情報削除
Route::post('user/delete', 'AgentUserController@postDelete')
    ->name('user.delete')
    ->middleware(['voss.auth', 'voss.admin_agent','voss.request_other_agent']);
// 販売店ユーザー情報パスワード再設定
Route::post('user/password_reset_mail', 'AgentUserController@postPasswordResetMail')
    ->name('user.password_reset_mail')
    ->middleware(['voss.auth', 'voss.admin_agent','voss.request_other_agent']);
// パスワード忘れ再設定(リセット)
Route::get('user/password_reset', 'AgentUserController@getPasswordReset')
    ->name('user.password_reset');
Route::post('user/password_reset', 'AgentUserController@postPasswordReset');

/*
 * 販売店受付情報
 */
// 販売店受付一覧
Route::get('reservation/reception/list', 'ReservationReceptionController@getReceptionList')
    ->name('reservation.reception.list')
    ->middleware(['voss.auth']);
//グループ設定
Route::get('reservation/reception/group', 'ReservationReceptionController@getGroup')
    ->name('reservation.reception.group')
    ->middleware(['voss.auth']);
Route::post('reservation/reception/group', 'ReservationReceptionController@postGroup')
    ->middleware(['voss.auth']);

// 祝日データ取得
Route::get('holiday/list', 'HolidayController@getList')
    ->name('holiday.list');
//
//// メール送信テスト
//Route::get('mail_test', function () {
//    $options = [
//        'view' => 'emails.test',
//        'view_params' => [
//            'free' => 'これはフリー入力したものです。'
//        ],
//        "subject" => 'テストメール',
//        'type' => 'text',
//        'attach_file_path' => \Storage::disk('attach')->path('.gitignore'),
//    ];
//    $ret = \Mail::to('kita-kouichi@wiznet.co.jp')->send(new \App\Mail\VossMail($options));
//    \Log::debug($ret);
//});

//// メールデータ作成
//Route::get('mail_sql', function() {
//    $mails = [
//        'kozakura-shota@wiznet.co.jp',
//        'kita-kouichi@wiznet.co.jp',
//        'enoki-monami@wiznet.co.jp',
//        'kamino-misato@wiznet.co.jp',
//        ''
//    ];
//    $reservations ='3722';
//    $items ="'12018OTA001'";
//    for ($i = 1; $i <= 10; $i++) {
//        $operation_number = 200000+$i;
//        $reservation_number = $reservations;
//        $item_code= $items;
//        $type = rand(1, 3);
//        $mail1 = $mails[rand(0, 3)];
//        $mail2 = $mails[rand(0, 4)];
//        $sql = <<<EOF
//INSERT
//INTO VOSDTL.VOSNMILU(
//    NMIL010
//  , NMIL020
//  , NMIL030
//  , NMIL040
//  , NMIL050
//  , NMIL060
//  , NMIL070
//  , NMIL071
//  , NMIL072
//  , NMIL073
//  , NMIL074
//  , NMIL075
//  , NMIL080
//  , NMIL090
//  , NMIL100
//  , NMIL110
//  , NMIL120
//  , NMIL130
//  , NMIL140
//)
//VALUES (
//   {$operation_number}
//  ,{$reservation_number}
//  ,{$type}
//  ,'テストメール{$operation_number}の'|| chr(10) ||'件名です'
//  ,'テストメール{$operation_number}の'|| chr(10) ||'本文です'
//  ,20180310212329
//  ,'{$mail1}'
//  ,'{$mail2}'
//  ,NULL
//  ,NULL
//  ,NULL
//  ,NULL
//  ,'T'
//  ,NULL
//  ,'WZT0001'
//  ,'kmn001'
//  ,'1'
//  ,{$item_code}
//  ,0
//);
//EOF;
//        echo nl2br($sql);
//        echo '<br>';
//    }
//});