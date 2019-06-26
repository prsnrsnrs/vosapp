@extends('layout.base')

@section('title', 'マイページ')

@section('style')
  <link href="{{ mix('css/mypage/agent_mypage.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ']
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="mypage">
    <div class="left_block">
      <div class="panel">
        <div class="header">販売店様メニュー</div>
        <div class="body">
          <div class="default">
            <a href="{{ ext_route('cruise_plan.search') }}">
              <button class="mypage_btn">
                <img class="cruise_reservation" src="{{  ext_asset('images/icon/reservation.png') }}">クルーズ予約
              </button>
            </a>
            <div class="links">
              <ul>
                <li><span><a href="{{ ext_route('reservation.reception.list', ['return_param' => ['route_name' => request()->route()->getName()]]) }}">ご予約済みクルーズの確認・変更・取消</a></span></li>
                <li><span><a href="{{ ext_route('reservation.contact.list', ['return_param' => ['route_name' => request()->route()->getName()]])  }}">日本クルーズ客船からのご連絡一覧</a></span></li>
                <li><span><a href="{{ ext_route('reservation.printing.list', ['return_param' => ['route_name' => request()->route()->getName()]]) }}">乗船券控えと各種確認書</a></span></li>
              </ul>
            </div>
          </div>
          <div class="user_info">
            <ul>
              @if(\App\Libs\Voss\VossAccessManager::isJurisdictionAgent() && \App\Libs\Voss\VossAccessManager::isAgentAdmin())
                <li>
                  <span><a href="{{ ext_route('list') }}">販売店の管理</a></span>
                </li>
              @endif
              @if(\App\Libs\Voss\VossAccessManager::isAgentAdmin())
                <li>
                  <span><a href="{{ ext_route('detail') }}">販売店様情報とユーザーの管理</a></span>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="right_block">
      <div class="panel">
        <div class="header">お知らせ</div>
        <div class="body">
          @include('include.jcl.agent_mypage')
        </div>
      </div>
    </div>
  </main>
@endsection