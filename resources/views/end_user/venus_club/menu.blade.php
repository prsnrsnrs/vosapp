@extends('layout.base')

@section('title', 'びいなす倶楽部会員メニュー')

@section('style')
  <link href="{{ mix('css/menu.css') }}" rel="stylesheet"/>
@endsection

@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li>マイページ</li>
    <li><a href="{{ url('end_user/venus_club/login') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="menu">
    <div class="left_block">
      <div class="panel_venus">
        <div class="header">びいなす倶楽部会員様メニュー</div>
        <div class="body">
          <ul>
            <li><span><a href="{{ url('end_user/venus_club/confirm') }}">会員情報の照会・変更</a></span></li>
            <li><span><a href="{{ url('end_user/venus_club/history')  }}">過去のご乗船クルーズの照会</a></span></li>
            <li><span><a href="{{ url('end_user/venus_club/discount_ticket')  }}">割引券情報の照会</a></span></li>
            <li><span><a href="{{ url('')  }}">パスワードの変更</a></span></li>
          </ul>
          <div class="button">
            <button class="net_contract">びいなす倶楽部会員ネット利用規約</button>
          </div>
        </div>
      </div>
      <div class="ssl_info">
        <small>当サイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</small>
        <img src="{{ ext_asset('/images/norton.png') }}"/>
      </div>
    </div>
    <div class="right_block">
      <div class="panel_venus">
        <div class="header">びいなす倶楽部会員メニューについて</div>
        <div class="body">
          <div class="venus_icon center">
            <img src="{{ ext_asset('images/venus_icon.png') }}"/>
          </div>
          <dl>
            <dd>
              ・会員様情報の確認・変更ができます
            </dd>
            <dd>
              ・過去の乗船実績やご利用可能な割引券をご確認頂けます
            </dd>
            <dd>
              ・ネット予約で割引特典を受けるのに必要な「ネット予約リンクID」をご確認頂けます
            </dd>
            <dd>
              ・お客様の大切な情報が保持されていますのでユーザーIDとパスワードの管理にはくれぐれもご注意ください
            </dd>
          </dl>
        </div>
        </div>
      </div>
    </div>
  </main>
@endsection