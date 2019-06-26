@extends('layout.base')

@section('title', 'ログイン')

@section('style')
  <link href="{{ mix('css/login.css') }}" rel="stylesheet"/>
@endsection

@section('content')
  <main class="login">
    <div class="left_block">
      <div class="panel">
        <div class="header">ログイン</div>
        <div class="body">
          <form action="{{ url('mypage/') }}">
            <dl>
              <dt>販売店ログインID</dt>
              <dd><input type="text" class="input input_text_form"></dd>
            </dl>
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
            </dl>
            <button class="login_btn">ログイン</button>
          </form>
        </div>
      </div>
      <div class="ssl_info">
        <small>当サイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</small>
        <img src="{{ asset('/images/norton.png') }}"/>
      </div>
    </div>
    <div class="right_block">
      <div class="panel">
        <div class="header">お知らせ</div>
        <div class="body">
          @include('include.information.login')
        </div>
      </div>
    </div>
  </main>
@endsection