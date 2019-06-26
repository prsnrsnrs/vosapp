@extends('layout.base')

@section('title', 'マイページ')

@section('style')
  <link href="{{ mix('css/user_mypage.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  マイページ
@endsection

@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li>マイページ</li>
    <li><a href="{{ url('end_user/login/login') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="mypage">
    <div class="left_block">
      <div class="panel">
        <div class="header">ご予約の流れ</div>
        <div class="body">
          <div class="step">
            <p>①ご乗船されるお客様を事前に登録する</p>
            <a href="{{ url('end_user/boatmenber/add') }}">ご乗船のお客様登録</a>
          </div>
          <img src="{{ ext_asset('images/arrow_down.png') }}"/>
          <div class="step">
            <p>②クルーズプランを検索して、<br>そのままインターネット予約へ進む</p>
            <a href="http://www.venus-cruise.co.jp/plan/plan.php">クルーズプランの検索（ご予約へ）</a>
          </div>
          <img src="{{ ext_asset('images/arrow_down.png') }}"/>
          <div class="step">
            <p>③ご予約済みクルーズを呼び出して、<br>確認、変更、取消をする</p>
            <a href="{{ url('reservation/reception/list') }}">ご予約済みクルーズの確認・変更・取消</a>
          </div>
          <div class="guide">
            <button>インターネット予約利用ガイド</button>
          </div>
        </div>
      </div>
    </div>

    <div class="center_block">
      <div class="panel">
        <div class="header">ネット予約ご利用者様メニュー</div>
        <div class="body">
          <div class="default">
            <ul class="links">
              <li><span><a href="http://www.venus-cruise.co.jp/plan/plan.php">クルーズプランの検索（ご予約へ）</a></span></li>
              <li><span><a href="{{ url('reservation/reception/list') }}">ご予約済みクルーズの確認・変更・取消</a></span></li>
              <li><span><a href="{{ url('reservation/contact/list')  }}">日本クルーズ客船からのご連絡一覧</a></span></li>
              <li><span><a href="">過去のご乗船クルーズの照会</a></span></li>
            </ul>
          </div>
          <p></p>
          <div class="user_info">
            <ul>
              <li><span><a href="{{ url('end_user/user_data/user_edit') }}">ネット予約利用者情報の確認・変更</a></span></li>
              <li><span><a href="{{ url('end_user/boatmenber/list') }}">ご乗船のお客様登録</a></span></li>
              <li><span><a href="{{ url('end_user/user_data/id_edit') }}">ユーザーID（メールアドレス）の変更</a></span></li>
              <li><span><a href="{{ url('end_user/user_data/password_edit') }}">パスワードの変更</a></span></li>
              <li><span><a href="{{ url('end_user/user_data/user_delete') }}">ネット予約利用者情報の削除（退会）</a></span></li>
              <li><span><a href="https://www.venus-cruise.co.jp/contact/">お問い合わせ・パンフット請求</a></span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="right_block">
      <div class="panel">
        <div class="header">お知らせ</div>
        <div class="body">
          @include('include.information.user_mypage')
          <div class="venus">
            <a href="{{ url('end_user/venus_club/login') }}"><button>びいなす倶楽部会員メニュー</button></a>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection