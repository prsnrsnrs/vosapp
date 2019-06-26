@extends('layout.base')

@section('title', 'ユーザー変更画面')

@section('style')
  <link href="{{ mix('css/change_user.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/change_user.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('sale_management/list_shop') }}">販売店一覧</a>＞
  <a href="{{ url('/sale_management/info_shop_user') }}">販売店情報</a>＞ユーザー変更
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">大阪本社</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="change_user">
    <table class="default">
      <thead>
        <tr>
          <th colspan="2">ユーザー変更</th>
        </tr>
      </thead>
      <tbody>
      <tr>
        <th style="width: 15%">ユーザーID</th>
        <td style="width: 85%">
          <label>pvuser111</label>
        </td>
      </tr>
      <tr>
        <th>ユーザー名称</th>
        <td>
          <input type="text">※全角で２０文字まで、半角でも可
        </td>
      </tr>
      <tr>
        <th>ユーザー区分</th>
        <td>
          <input class="radio" type="radio" name="user_class" value="0" selected>管理者
          <input class="radio" type="radio" name="user_class" value="1">一般
        </td>
      </tr>
      <tr>
        <th>ログイン</th>
        <td>
          <input class="radio" type="radio" name="login" value="0" selected>有効
          <input class="radio" type="radio" name="login" value="1">無効
        </td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>
          <label>**********</label>
        </td>
      </tr>
      </tbody>
    </table>
    <div class="button_create">
      <a href="{{ url('sale_management/info_shop_user') }}">
        <button class="back">戻る</button>
      </a>
      <a href="{{ url('sale_management/info_shop_user') }}">
        <button class="done">決定</button>
      </a>
    </div>
  </main>

@endsection