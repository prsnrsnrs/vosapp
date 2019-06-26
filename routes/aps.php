<?php
/**
 * i5専用メール確認画面
 */
Route::get('reservation/contact/detail', 'ReservationContactController@getDetailForAps')
    ->name('reservation.contact.detail');
/**
 * キャッシュ削除処理
 */
Route::get('mainte/cash_flash', 'MainteController@getCashFlash')
    ->name('mainte.cash_flash');

/**
 * 乗船控えと各種確認書の印刷
 */
// 乗船券控え
Route::get('reservation/printing/ticket', 'ReservationPrintingController@getTicketForAps')
    ->name('reservation.printing.ticket');

// 予約確認書
Route::get('reservation/printing/document', 'ReservationPrintingController@getDocumentForAps')
    ->name('reservation.printing.document');

// 予約内容確認書
Route::get('reservation/printing/detail', 'ReservationPrintingController@getDetailForAps')
    ->name('reservation.printing.detail');

// 取消記録確認書
Route::get('reservation/printing/cancel', 'ReservationPrintingController@getCancelForAps')
    ->name('reservation.printing.cancel');
