@extends('layout.base')

@section('title', 'パスワードの変更')

@section('style')
  <link href="{{ mix('css/password_edit.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞パスワードの変更
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
  <main class="password_edit">
    @include('include.info', ['info' => '新しいパスワードを入力し、「変更」ボタンを押して下さい。'])
    <table class="default">
      <tbody>
      <tr>
        <th colspan="2">パスワードの変更</th>
      </tr>
      <tr>
        <th style="width: 20%">現在のパスワード</th>
        <td style="width: 80%;"><input type="password"></td>
      </tr>
      <tr>
        <th rowspan="2">新しいパスワード</th>
        <td><input type="password">（4~12文字）</td>
      </tr>
      <tr>
        <td>
          4文字以上の半角英数字、および半角記号(#$%&()={}*:+_?.<-/@;>!|[])が使用できます。<br>
          パスワードには、ユーザIDと同じものは登録できません。<br>
          第三者による不正なアクセスを防止するためにも、できるだけ複雑なパスワードを設定することをお勧めします。
        </td>
      </tr>
      <tr>
        <th>新しいパスワード(確認)</th>
        <td><input type="password">（4~12文字）</td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/mypage') }}"><button class="back">戻る</button></a>
    <button class="done">変更</button>
  </div>
@endsection