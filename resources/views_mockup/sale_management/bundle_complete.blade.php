@extends('layout.base')

@section('title', '販売店一括登録完了')

@section('style')
  <link href="{{ mix('css/bundle_complete.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('sale_management/list_shop') }}">販売店一覧</a>＞
  <a href="{{ url('sale_management/bundle_input') }}">販売店一括登録</a>＞販売店一括登録結果
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
  <main>
  @include('include.info', ['info' => '登録されました'])

    <table class="default">
      <thead>
      <tr>
        <th colspan="3">複数登録結果</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th style="width: 50%">インポート件数</th>
        <th style="width: 50%">エラー件数</th>
      </tr>
      <tr>
        <td>1,120件</td>
        <td>3件</td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('sale_management/list_shop') }}"><button class="back">販売店一覧に戻る</button></a>
  </div>
@endsection