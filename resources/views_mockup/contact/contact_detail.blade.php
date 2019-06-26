@extends('layout.base')

@section('title', 'ご連絡閲覧画面')

@section('style')
  <link href="{{ mix('css/contact_detail.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('contact/contact_list') }}">ご連絡一覧</a>＞ご連絡内容
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main>
    <div class="contact_detail">
      <table class="left default search">
        <thead>
          <tr>
            <th colspan="2">日本クルーズ客船からのご連絡</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">送信日時</th>
          <td style="width: 85%">2017/02/23 11：15</td>
        </tr>
        <tr>
          <th>クルーズ名（コース）</th>
          <td>春の日本一週クルーズAコース</td>
        </tr>
        <tr>
          <th>出発日</th>
          <td>神戸発 2017年5月10日(月)</td>
        </tr>
        <tr>
          <th>予約番号</th>
          <td>1234567</td>
        </tr>
        <tr>
          <th>代表者お名前</th>
          <td>	KONDO　MASAYA</td>
        </tr>
        <tr>
          <th>件名</th>
          <td>キャビンリクエスト</td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="panel">
      <div class="title" >日本クルーズ客船からのご連絡内容</div>
      <div class="body ">
        <p>予約担当の中川です。お世話になります。<br>
          コンドウ　マサヤ様のキャビンリクエストにつきまして、ご希望のお部屋がご用意できましたのでお知らせします。<br>
          部屋番号は999は・・・・・・・・・・・・・・・
        </p>
      </div>
    </div>
  </main>

  <div class="button_bar">
    <a href="{{ url('contact/contact_list') }}"><button class="back">戻る</button></a>
  </div>

@endsection