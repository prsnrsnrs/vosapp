@extends('layout.base')

@section('title', '利用者情報の削除（退会）')

@section('style')
  <link href="{{ mix('css/user_delete.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞ネット予約利用者情報の削除（退会）
@endsection

@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('end_user/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('end_user/login/login') }}">ログアウト</a></li>
  </ul>
@endsection
@section('content')
  <main class="user_delete">
    @include('include.info', ['info' => 'ネット予約利用者情報を削除します。削除後は乗船者情報や受付履歴も削除されます。<br>
　ネット予約をご利用頂くには再度の登録が必要となります。よろしければ「削除」ボタンを押して下さい。'])
    <table class="default">
      <tbody>
      <tr>
        <th colspan="3" class="bold">ネット予約利用者情報の変更</th>
      </tr>
      <tr>
        <th style="width: 20%">お客様名（英字）</th>
        <td style="width: 30%;" class="name">（姓）NAKAGAWA</td>
        <td style="width: 50%;" class="name">（名）YOSHIO</td>
      </tr>
      <tr>
        <th>お客様名（漢字）</th>
        <td class="name">（姓）中川</td>
        <td class="name">（名）義夫</td>
      </tr>
      <tr>
        <th>性別</th>
        <td colspan="2">男</td>
      </tr>
      <tr>
        <th>生年月日</th>
        <td colspan="2">1972年06月24日</td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td colspan="2">0663453881</td>
      </tr>
      <tr>
        <th>ユーザーID<br>(メールアドレス)</th>
        <td colspan="2">nakagawa@snf.co.jp</td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/mypage') }}"><button class="back">戻る</button></a>
    <button class="delete">削除</button>
  </div>
@endsection