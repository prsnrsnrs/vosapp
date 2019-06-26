@extends('layout.base')

@section('title', 'マイページ')

@section('style')
  <link href="{{ mix('css/mypage.css') }}" rel="stylesheet"/>
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li>マイページ</li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="mypage">
    <div class="left_block">
      <div class="panel">
        <div class="header">販売店様メニュー</div>
        <div class="body">
          <div class="default">
            <a href = "{{ url('reservation/search_plan') }}">
              <button class="mypage_btn" >クルーズ予約</button>
            </a>
            <div class="links">
              <ul>
                <li><span><a href="{{ url('sale_reception') }}">ご予約済みクルーズの確認・変更・取消</a></span></li>
                <li><span><a href="{{ url('contact/contact_list')  }}">日本クルーズ客船からのご連絡一覧</a></span></li>
                <li><span><a href="{{ url('print/print_document') }}">乗船控えと各種確認書</a></span></li>
              </ul>
            </div>
          </div>
          <div class="user_info">
            <ul>
              <li>
                <span><a href="{{ url('sale_management/list_shop') }}">販売店の管理</a></span>
              </li>
              <li>
                <span><a href="{{ url('sale_management/info_shop_user') }}">販売店様情報とユーザーの管理</a></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="right_block">
      <div class="panel">
        <div class="header">お知らせ</div>
        <div class="body">
          @include('include.information.mypage')
        </div>
      </div>
    </div>
  </main>
@endsection