@extends('layout.base')

@section('title', 'ユーザーIDの変更')

@section('style')
  <link href="{{ mix('css/id_edit.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞ユーザーIDの変更
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
  <main class="id_edit">
    @include('include.info', ['info' => '新しいユーザーID（メールアドレス）を入力し、「送信」ボタンを押して下さい。'])
    <table class="default">
      <tbody>
      <tr>
        <th colspan="2" class="bold">ユーザーID(メールアドレスの変更)</th>
      </tr>
      <tr>
        <th style="width: 20%">現在のユーザーID<br>(メールアドレス)</th>
        <td style="width: 80%;">nakagawa@snf.co.jp</td>
      </tr>
      <tr>
        <th>新しいユーザーID<br>(メールアドレス)</th>
        <td><input type="email"></td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/mypage') }}"><button class="back">戻る</button></a>
    <button class="done">送信</button>
  </div>
@endsection