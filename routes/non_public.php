<?php

/**
 * キャッシュ削除処理
 */
Route::get('cash_flush', 'NonPublicController@getCashFlush')
    ->name('cash_flash');