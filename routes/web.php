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
//
//
///**
// * 旅行社向け
// */
//Route::group(['as' => 'agent.', 'prefix' => 'agent'], function() {
//    /** ログイン */
//    Route::get('/', ['as' => 'login', 'uses' => 'LoginController@getLogin']);
//    Route::post('/', 'LoginController@postLogin');
//    /** マイページ */
//    Route::get('mypage', ['as' => 'mypage', 'uses' => 'MypageController@getMypage',  'middleware' =>['voss.auth']]);
//    /** クルーズプラン検索 */
//    Route::get('cruise_plan/search', function () {
//        return view('cruise_plan/cruise_plan_search');
//    });
//    // 客室タイプ選択画面
//    Route::get('reservation/cabin/type_select/', function () {
//        return view('reservation/cabin/reservation_cabin_type_select');
//    });
//    // 客室人数選択画面
//    Route::get('reservation/cabin/passenger_select/', function () {
//        return view('reservation/cabin/reservation_cabin_passenger_select');
//    });
//    // ご乗船のお客様入力画面
//    Route::get('reservation/cabin/passenger_entry/', function () {
//        return view('reservation/cabin/reservation_cabin_passenger_entry');
//    });
//    // ご乗船者詳細入力
//    Route::get('reservation/input/passenger/', function () {
//        return view('reservation/input/reservation_input_passenger');
//    });
//    // リクエスト入力画面
//    Route::get('reservation/input/cabin_request/', function () {
//        return view('reservation/input/reservation_input_cabin_request');
//    });
//    // 割引券情報入力画面
//    Route::get('reservation/input/discount/', function () {
//        return view('reservation/input/reservation_input_discount');
//    });
//    // 質問事項のチェック
//    Route::get('reservation/input/question/', function () {
//        return view('reservation/input/reservation_input_question');
//    });
//    // 備考情報入力
//    Route::get('reservation/input/passenger_request/', function () {
//        return view('reservation/input/reservation_input_passenger_request');
//    });
//    // 内容照会画面
//    Route::get('reservation/detail', function () {
//        return view('reservation/reservation_detail');
//    });
//    // ルーミング変更画面
//    Route::get('reservation/rooming', function () {
//        return view('reservation/reservation_rooming');
//    });
//// 客室タイプ変更確認画面
//    Route::get('reservation/cabin/change_confirm/', function () {
//        return view('reservation/cabin/reservation_cabin_change_confirm');
//    });
//// 全面取消確認画面
//    Route::get('reservation/cancel/', function () {
//        return view('reservation/reservation_cancel');
//    });
//// 電話予約呼び出し画面
//    Route::get('reservation/telephone/', function () {
//        return view('reservation/reservation_telephone');
//    });
//// 郵便番号検索画面（都道府県）
//    Route::get('/address/prefecture_select/', function () {
//        return view('address/address_prefecture_select');
//    });
//// 郵便番号検索画面（市区群町村）
//    Route::get('/address/city_select/', function () {
//        return view('address/address_city_select');
//    });
//// 郵便番号検索画面（町名）
//    Route::get('/address/town_select/', function () {
//        return view('address/address_town_select');
//    });
//
//    /*
//     * 提出書類画面
//     */
//    Route::get('reservation/document/list', function () {
//        return view('reservation/document/reservation_document_list');
//    });
//
//    /*
//     * 乗船控えと各種確認書の印刷画面
//     */
//    Route::get('reservation/printing/list', function () {
//        return view('reservation/printing/reservation_printing_list');
//    });
//
//    /*
//     * ご連絡一覧
//     */
//// ご連絡一覧画面
//    Route::get('reservation/contact/list', function () {
//        return view('reservation/contact/reservation_contact_list');
//    });
//// ご連絡閲覧画面
//    Route::get('reservation/contact/detail', function () {
//        return view('reservation/contact/reservation_contact_detail');
//    });
//
//    /*
//     * 予約一括取込
//     */
//// 取込一覧画面
//    Route::get('reservation/import/result', function () {
//        return view('reservation/import/reservation_import_result');
//    });
//// 取込フォーマット管理画面
//    Route::get('reservation/import/format_list', function () {
//        return view('reservation/import/reservation_import_format_list');
//    });
//// 取込フォーマット設定画面
//    Route::get('reservation/import/format_setting', function () {
//        return view('reservation/import/reservation_import_format_setting');
//    });
//// 一括取込ファイル指定
//    Route::get('reservation/import/file_select', function () {
//        return view('reservation/import/reservation_import_file_select');
//    });
//    /*
//     * 販売店情報管理
//     */
//// 販売店一覧
//    Route::get('agent/list/', function () {
//        return view('agent/agent_list');
//    });
//// 販売店新規追加
//    Route::get('agent/edit/', function () {
//        return view('agent/agent_edit');
//    });
//// 販売店一括登録
//    Route::get('agent/import/add', function (){
//        return view('agent/import/agent_import_add');
//    });
//// 販売店一括登録確認
//    Route::get('agent/import/confirm', function (){
//        return view('agent/import/agent_import_confirm');
//    });
//// 販売店一括登録完了
//    Route::get('agent/import/complete', function (){
//        return view('agent/import/agent_import_complete');
//    });
//// 販売店情報＆ユーザー情報追加
//    Route::get('agent/detail/', function () {
//        return view('agent/agent_detail');
//    });
//// ユーザー作成画面
//    Route::get('agent/user/edit', function () {
//        return view('agent/user/agent_user_edit');
//    });
//// ユーザー変更画面
//    Route::get('agent/user/edit______plan-to-delete', function () {
//        return view('agent/user/agent_user_edit______plan-to-delete');
//    });
//// パスワード再設定（リセット）
//    Route::get('password_reset/', function () {
//        return view('password_reset/password_reset');
//    });
//    /*
//     * 販売店受付情報
//     */
//// 販売店受付一覧
//    Route::get('reservation/reception/list/', function () {
//        return view('reservation/reception/reservation_reception_list');
//    });
//});
//
///**
// * 旅行社向けテスト
// */
//Route::group(['as' => 'agent.', 'prefix' => 'agent/test'], function() {
//    /** ログイン */
//    Route::get('/', ['as' => 'login', 'uses' => 'LoginController@getLogin']);
//    Route::post('/', 'LoginController@postLogin');
//    /** マイページ */
//    Route::get('mypage', ['as' => 'mypage', 'uses' => 'MypageController@getMypage', 'middleware' => ['voss.auth']]);
//});
//
