<?php
/**
 * upload
 */
Route::post('upload', 'UplController@postUpload')
    ->name('upload');
/**
 * copy
 */
Route::post('copy', 'UplController@postCopy')
    ->name('copy');
/**
 * download
 */
Route::get('download', 'UplController@getDownload')
    ->name('download');
/**
 * delete
 */
Route::post('delete', 'UplController@postDelete')
    ->name('delete');