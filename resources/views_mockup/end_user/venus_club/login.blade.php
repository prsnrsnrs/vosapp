@extends('layout.base')

@section('title', 'びいなす倶楽部ログイン')

@section('style')
  <link href="{{ mix('css/venus_login.css') }}" rel="stylesheet"/>
@endsection

@section('content')
  <main class="login">
    <div class="left_block">
      <div class="panel_venus">
        <div class="header">びいなす倶楽部会員様ログイン</div>
        <div class="body">
          <dl>
            <dt>ユーザーID</dt>
            <dd><input type="text" class="input_venus"></dd>
            <dd style="margin-top: 7px">
              <input id="remember" class="remember" type="checkbox">
              <label for="remember" class="check">ユーザーIDを保持する</label>
            </dd>
          </dl>
          <dl>
            <dt>パスワード</dt>
            <dd><input type="password" class="input_venus"></dd>
            <p><a href="">パスワードをお忘れの方はこちら</a></p>
          </dl>
          <a href="{{ url('end_user/venus_club/menu') }}">
            <button class="login_btn">ログイン</button>
          </a>
        </div>
      </div>
      <div class="ssl_info">
        <small>当サイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</small>
        <img src="{{ asset('/images/norton.png') }}"/>
      </div>
    </div>
    <div class="right_block">
      <div class="panel_venus">
        <div class="header">びいなす倶楽部会員メニューについて</div>
        <div class="body">
          <div class="venus_icon center">
            <img src="{{ asset('images/venus_icon.png') }}"/>
          </div>
          <dl>
            <dd>
              ・こちらは「びいなす倶楽部会員様」専用のメニューです
            </dd>
            <dd>
              ・ご利用頂くには専用のユーザーIDとパスワードが必要です
            </dd>
            <dd>
              ・以下の時間帯はご利用になれません<br>
              AM02：00 –  AM04：00
            </dd>
            <dd>
              ・詳しくは以下にお問い合わせ下さい
            </dd>
            <dd>
              【びいなす倶楽部事務局】<br>
              〒530-0001<br>
              大阪市北区梅田2-5-25 ハービス大阪15階<br>
              日本クルーズ客船株式会社内<br>
              びいなす倶楽部事務局<br>
              TEL:06-6347-7521
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </main>
@endsection