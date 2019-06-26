@extends('layout.base')

@section('title', 'ログイン')

@section('style')
  <link href="{{ mix('css/user_login.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'ログイン'],
  ]])
@endsection

@section('content')
  <main class="login">
    <div class="left_block">
      <div class="panel">
        <div class="header">ご利用者様ログイン</div>
        <div class="body">
          <form action="{{ url('end_user/mypage/') }}">
            <dl>
              <dt>ユーザーID</dt>
              <dd><input type="text" class="input input_text_form"></dd>
              <dd style="margin-top: 7px">
                <input id="remember" class="remember" type="checkbox">
                <label for="remember" class="check">ID情報を保持する</label>
              </dd>
            </dl>
            <dl>
              <dt>パスワード</dt>
              <dd><input type="password" class="input input_text_form"></dd>
              <dd class="forget_password"><a href="{{ url('end_user/mail/forget_password') }}">パスワードをお忘れの方はこちら</a></dd>
            </dl>
            <button class="login_btn">ログイン</button>
          </form>
        </div>
      </div>
      <div class="ssl_info">
        <small>当サイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</small>
        <img src="{{ ext_asset('/images/norton.png') }}"/>
      </div>
    </div>
    <div class="right_block">
      <div class="panel">
        <div class="header">インターネット予約について</div>
        <div class="body">
          @include('include.information.user_login')
        </div>
      </div>
    </div>
  </main>
@endsection