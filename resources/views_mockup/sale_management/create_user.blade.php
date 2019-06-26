@extends('layout.base')

@section('title', 'ユーザー作成画面')

@section('style')
  <link href="{{ mix('css/create_user.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞<a href="{{ url('sale_management/list_shop') }}">販売店一覧</a>＞<a href="{{ url('sale_management/info_shop_user') }}">販売店情報</a>＞ユーザー作成
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
  <main class="create_user">
    <div class="area">
      <table class="default">
        <thead>
          <tr>
            <th colspan="2">ユーザー作成</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">ユーザーID</th>
          <td style="width: 85%">
            <input type="text">※半角英数6～12文字
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
            <input class="radio" type="radio" name="user_class" value="0">管理者
            <input class="radio" type="radio" name="user_class" value="1">一般
          </td>
        </tr>
        <tr>
          <th>ログイン</th>
          <td>
            <input class="radio" type="radio" name="login" value="0">有効
            <input class="radio" type="radio" name="login" value="1">無効
          </td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td>
            <input type="text">
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div style="margin-top: 10px">
      <a href="{{ url('sale_management/list_shop') }}">
        <button class="back">戻る</button>
      </a>
      <a href="{{ url('sale_management/info_shop_user') }}">
        <button class="done">ユーザー作成</button>
      </a>
    </div>
  </main>
@endsection