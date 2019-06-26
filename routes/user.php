<?php

// TODO:フェーズ2

/*************
 * 個人向け *
 *************/

// TODO: エラーを回避するため一旦追加。後から適切な場所に移動する。
// 祝日データ取得
Route::get('holiday/list', 'HolidayController@getList')
    ->name('holiday.list');

///*
// * ログイン
// */
//Route::get('end_user/login/login', function (){
//    return view('end_user/login/login');
//});
///**
// * パスワード忘れメール入力送信
// */
//Route::get('end_user/mail/forget_password', function (){
//    return view('end_user/mail/forget_password');
//});
///**
// * パスワード忘れ再設定(リセット)
// */
//Route::get('user/password_reset', 'UserController@getPasswordReset')
//    ->name('user.password_reset');
//Route::post('user/password_reset', 'UserController@postPasswordReset');
//
///**
// * メール登録
// */
//Route::get('end_user/mail/register_mail', function (){
//    return view('end_user/mail/register_mail');
//});
///**
// * メール登録(入力)
// */
//Route::get('end_user/mail/register_mail_input', function (){
//    return view('end_user/mail/register_mail_input');
//});
///*
// * マイページ
// */
//Route::get('end_user/mypage', function (){
//    return view('end_user/mypage');
//});
///*
// * ユーザー情報
// */
//// ユーザー登録画面
//Route::get('end_user/user_data/user_add', function (){
//    return view('end_user/user_data/user_add');
//});
//// ユーザー編集画面
//Route::get('end_user/user_data/user_edit', function (){
//    return view('end_user/user_data/user_edit');
//});
//// ID編集画面
//Route::get('end_user/user_data/id_edit', function (){
//    return view('end_user/user_data/id_edit');
//});
//// ID確認画面
//Route::get('end_user/user_data/id_confirm', function (){
//    return view('end_user/user_data/id_confirm');
//});
//// パスワード編集画面
//Route::get('end_user/user_data/password_edit', function (){
//    return view('end_user/user_data/password_edit');
//});
//// ユーザー削除画面
//Route::get('end_user/user_data/user_delete', function (){
//    return view('end_user/user_data/user_delete');
//});
///*
// * 乗船者情報
// */
//// 一覧画面
//Route::get('end_user/boatmenber/list', function (){
//    return view('end_user/boatmenber/list');
//});
//// 新規追加画面
//Route::get('end_user/boatmenber/add', function (){
//    return view('end_user/boatmenber/add');
//});
//// 確認画面
//Route::get('end_user/boatmenber/confirm', function (){
//    return view('end_user/boatmenber/confirm');
//});
///*
// * 決済
// */
//// 合意画面
//Route::get('end_user/pay_off/agreement', function (){
//    return view('end_user/pay_off/agreement');
//});
//// 選択画面
//Route::get('end_user/pay_off/pay_select', function (){
//    return view('end_user/pay_off/pay_select');
//});
//// 入力画面
//Route::get('end_user/pay_off/pay_input', function (){
//    return view('end_user/pay_off/pay_input');
//});
//// 確認画面
//Route::get('end_user/pay_off/pay_confirm', function (){
//    return view('end_user/pay_off/pay_confirm');
//});
///*
// * アンケート
// */
//// 健康アンケート入力画面
//Route::get('end_user/question_sheet/health', function () {
//    return view('end_user/question_sheet/health');
//});
//// 食物アレルギーや食事制限の方へのアンケート入力画面
//Route::get('end_user/question_sheet/food', function () {
//    return view('end_user/question_sheet/food');
//});
//// 特別な配慮が必要な方へのアンケート入力画面
//Route::get('end_user/question_sheet/assist', function () {
//    return view('end_user/question_sheet/assist');
//});
//// アンケート等アップロード画面
//Route::get('end_user/question_sheet/upload', function () {
//    return view('end_user/question_sheet/upload');
//});
///**
// * びいなす倶楽部
// */
//// ログイン
//Route::get('end_user/venus_club/login', function (){
//    return view('end_user/venus_club/login');
//});
//// マイページ
//Route::get('end_user/venus_club/menu', function (){
//    return view('end_user/venus_club/menu');
//});
//// 確認画面
//Route::get('end_user/venus_club/confirm', function (){
//    return view('end_user/venus_club/confirm');
//});
//// 編集画面
//Route::get('end_user/venus_club/edit', function (){
//    return view('end_user/venus_club/edit');
//});
//// 乗船履歴画面
//Route::get('end_user/venus_club/history', function (){
//    return view('end_user/venus_club/history');
//});
//// 割引券画面
//Route::get('end_user/venus_club/discount_ticket', function (){
//    return view('end_user/venus_club/discount_ticket');
//});
//
//
///*
// * エラー
// */
//// ブラウザチェックエラー
//Route::get('error/agent_error', function () {
//    return view('error/agent_error');
//});
//// システムエラー
//Route::get('error/system_error', function () {
//    return view('error/system_error');
//});
//
///*
// * 帳票
// */
//// 予約内容
//Route::get('pdf/reservation', function () {
//    $pdf = PDF::loadView('pdf/reservation_confirm');
//    return $pdf->inline();
//});
//// 予約詳細
//Route::get('pdf/detail', function () {
//    $pdf = PDF::loadView('pdf/reservation_detail');
////    ->setOrientation('Landscape');
//    return $pdf->inline();
////    return view('pdf/detail');
//});
//// 乗船券控え
//Route::get('pdf/ticket', function () {
//    $pdf = PDF::loadView('pdf/reservation_ticket');
//    return $pdf->inline();
//});
//// 取消記録確認書
//Route::get('pdf/delete', function () {
//    $pdf = PDF::loadView('pdf/reservation_delete');
//    return $pdf->inline();
//});
//// test
//Route::get('pdf/test', function () {
//    $pdf = PDF::loadView('pdf/test');
//    return $pdf->inline();
////    return view('pdf/test');
//});