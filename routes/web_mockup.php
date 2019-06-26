<?php
//
///*
//|--------------------------------------------------------------------------
//| Web Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register web routes for your application. These
//| routes are loaded by the RouteServiceProvider within a group which
//| contains the "web" middleware group. Now create something great!
//|
//*/
///*
// *  ログイン
// */
//Route::get('/', function () {
//    return view('login/login');
//});
///*
// * マイページ
// */
//Route::get('mypage/', function () {
//    return view('mypage/mypage');
//});
///*
// * 予約
// */
//// クルーズプラン検索
//Route::get('reservation/search_plan/', function () {
//    return view('reservation/search_plan');
//});
//// コース選択画面
//Route::get('reservation/choose_course/', function () {
//    return view('reservation/choose_course');
//});
//// 客室タイプ選択画面
//Route::get('reservation/choose_guestroom/', function () {
//    return view('reservation/choose_guestroom');
//});
//// 客室人数選択画面
//Route::get('reservation/choose_guestnumber/', function () {
//    return view('reservation/choose_guestnumber');
//});
//// ご乗船のお客様入力画面
//Route::get('reservation/input_name/', function () {
//    return view('reservation/input_name');
//});
//// キャンセル待ち確認画面
//Route::get('reservation/wait_cancel/', function () {
//    return view('reservation/wait_cancel');
//});
//// ご乗船者詳細入力
//Route::get('reservation/boatmember/', function () {
//    return view('reservation/boatmember');
//});
//// リクエスト入力画面
//Route::get('reservation/input_request/', function () {
//    return view('reservation/input_request');
//});
//// 割引券情報入力画面
//Route::get('reservation/input_ticket/', function () {
//    return view('reservation/input_ticket');
//});
//// 質問事項のチェック
//Route::get('reservation/check_question/', function () {
//    return view('reservation/check_question');
//});
//// 備考情報入力
//Route::get('reservation/input_remarks/', function () {
//    return view('reservation/input_remarks');
//});
//// 予約詳細画面
//Route::get('reservation/last_modified/', function () {
//    return view('reservation/last_modified');
//});
//// 内容照会画面
//Route::get('reservation/order_detail', function () {
//    return view('reservation/order_detail');
//});
//// ルーミング変更画面
//Route::get('reservation/change_rooming', function () {
//    return view('reservation/change_rooming');
//});
//// 客室タイプ変更確認画面
//Route::get('reservation/change_guestroom/', function () {
//    return view('reservation/change_guestroom');
//});
//// 全面取消確認画面
//Route::get('reservation/cancel_front/', function () {
//    return view('reservation/cancel_front');
//});
//// 電話予約呼び出し画面
//Route::get('reservation/telephone/', function () {
//    return view('reservation/telephone');
//});
//// 郵便番号検索画面（都道府県）
//Route::get('/search_zip_prefecture/', function () {
//    return view('reservation/search_zip_prefecture');
//});
//// 郵便番号検索画面（市区群町村）
//Route::get('/search_zip_city/', function () {
//    return view('reservation/search_zip_city');
//});
//// 郵便番号検索画面（町名）
//Route::get('/search_zip_town/', function () {
//    return view('reservation/search_zip_town');
//});
//
///*
// * 提出書類画面
// */
//Route::get('document/send_document', function () {
//    return view('document/send_document');
//});
//
///*
// * 乗船控えと各種確認書の印刷画面
// */
//Route::get('print/print_document', function () {
//    return view('print/print_document');
//});
//
///*
// * ご連絡一覧
// */
//// ご連絡一覧画面
//Route::get('contact/contact_list', function () {
//    return view('contact/contact_list');
//});
//// ご連絡閲覧画面
//Route::get('contact/contact_detail', function () {
//    return view('contact/contact_detail');
//});
//
///*
// * 予約一括取込
// */
//// 取込一覧画面
//Route::get('capture/list', function () {
//    return view('capture/list');
//});
//// 取込フォーマット管理画面
//Route::get('capture/management', function () {
//    return view('capture/management');
//});
//// 取込フォーマット設定画面
//Route::get('capture/setting', function () {
//    return view('capture/setting');
//});
//// 一括取込ファイル指定
//Route::get('capture/select', function () {
//    return view('capture/select');
//});
///*
// * 販売店情報管理
// */
//// 販売店一覧
//Route::get('sale_management/list_shop/', function () {
//    return view('sale_management/list_shop');
//});
//// 販売店新規追加
//Route::get('sale_management/add_newshop/', function () {
//    return view('sale_management/add_newshop');
//});
//// 販売店一括登録
//Route::get('sale_management/bundle_input', function (){
//    return view('sale_management/bundle_input');
//});
//// 販売店一括登録確認
//Route::get('sale_management/bundle_confirm', function (){
//    return view('sale_management/bundle_confirm');
//});
//// 販売店一括登録完了
//Route::get('sale_management/bundle_complete', function (){
//    return view('sale_management/bundle_complete');
//});
//// 販売店情報＆ユーザー情報追加
//Route::get('sale_management/info_shop_user/', function () {
//    return view('sale_management/info_shop_user');
//});
//// ユーザー作成画面
//Route::get('sale_management/create_user', function () {
//    return view('sale_management/create_user');
//});
//// ユーザー変更画面
//Route::get('sale_management/change_user', function () {
//    return view('sale_management/change_user');
//});
//// パスワード再設定（リセット）
//Route::get('sale_management/reset_password', function () {
//    return view('sale_management/reset_password');
//});
///*
// * 販売店受付情報
// */
//// 販売店受付一覧
//Route::get('sale_reception/', function () {
//    return view('sale_reception/sale_reception');
//});
//
///*************
// * 個人向け *
// *************/
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
//Route::get('end_user/mail/reset_password', function (){
//    return view('end_user/mail/reset_password');
//});
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
//   return view('end_user/mypage');
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
//  return view('end_user/pay_off/pay_input');
//});
//// 確認画面
//Route::get('end_user/pay_off/pay_confirm', function (){
//  return view('end_user/pay_off/pay_confirm');
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
//    $pdf = PDF::loadView('pdf/reservation');
//    return $pdf->inline();
//});
//// 予約詳細
//Route::get('pdf/detail', function () {
//    $pdf = PDF::loadView('pdf/detail');
////    ->setOrientation('Landscape');
//    return $pdf->inline();
//});
//// 乗船券控え
//Route::get('pdf/ticket', function () {
//    $pdf = PDF::loadView('pdf/ticket');
//    return $pdf->inline();
//});
//// 取消記録確認書
//Route::get('pdf/delete', function () {
//    $pdf = PDF::loadView('pdf/delete');
//    return $pdf->inline();
//});
//// test
//Route::get('pdf/test', function () {
//    $pdf = PDF::loadView('pdf/test');
//    return $pdf->inline();
////    return view('pdf/test');
//});