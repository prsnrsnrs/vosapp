@extends('layout.base')

@section('title', 'ログイン')

@section('style')
  <link href="{{ mix('css/login/agent_login.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/login/agent_login.js')}}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'ログイン']
  ]])
@endsection

@section('content')
  <main class="login">
    @include('include/information', ['info' => ''])
 <div class="left_block">
   <div class="panel">
     <div class="header">ログイン</div>
     <div class="body">
       <form id="login_form" method="post" action="{{ ext_route('login') }}">
         <dl>
           <dt>販売店ログインID</dt>
           <dd><input type="text" id="store_id" name="store_id" class="input input_text_form"></dd>
         </dl>
         <dl>
           <dt>ユーザーID</dt>
           <dd><input type="text" id="user_id" name="user_id" class="input input_text_form"></dd>
           <dd style="margin-top: 7px">
             <input id="remember" class="remember" type="checkbox">
             <label for="remember" class="check">ID情報を保持する</label>
           </dd>
         </dl>
         <dl>
           <dt>パスワード</dt>
           <dd><input type="password" name="password" class="input input_text_form"></dd>
         </dl>
         <button class="login_btn" id="btn_login">
           <img class="login_img" src="{{  ext_asset('images/icon/login.png') }}">ログイン
         </button>
       </form>
     </div>
   </div>
   <div class="ssl_info">
     <small>当サイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</small>
     @if (config('app.env') === 'web')
       <script language="JavaScript" type="text/javascript"
               src="https://trusted-web-seal.cybertrust.ne.jp/seal/getScript?host_name=voss.venus-cruise.co.jp&type=33"></script>
     @else
       <img src="{{ ext_asset('/images/site_seal.gif') }}"/>
     @endif
   </div>
 </div>
 <div class="right_block">
   <div class="panel">
     <div class="header">お知らせ</div>
     <div class="body">
       @include('include.jcl.agent_login')
     </div>
   </div>
 </div>
</main>
@endsection