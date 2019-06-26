@extends('layout.base')

@section('title', '電話予約呼び出し')

@section('style')
  <link href="{{ mix('css/reservation/reservation_telephone.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('agent/mypage') }}">マイページ</a>＞電話予約呼び出し
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('agent/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('agent') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main>
    <div class="panel">
      <div class="title">お電話で予約された方</div>
      <div class="main">
        <div>
          <p>電話でお申し込みされた予約のご確認ができます。</p>
          <table>
            <tbody>
            <tr>
              <td>申し込み番号<span class="danger">*</span></td>
              <td><input type="text" placeholder="例）123456789"></td>
            </tr>
            <tr>
              <td>予約時に登録された電話番号<span class="danger">*</span></td>
              <td><input type="text" style="width: 110px;" placeholder="例）080"> - <input type="text" style="width: 110px;" placeholder="例）0000"> - <input
                        type="text" style="width: 110px;" placeholder="例）0000"></td>
            </tr>
            <tr>
              <td rowspan="2">申込者のお名前<span class="danger">*</span></td>
              <td><input type="text" style="width: 373px;" placeholder="例）NAKAGAWA"></td>
            </tr>
            <tr>
              <td><input type="text" style="width: 373px;" placeholder="例）YOSHIO"></td>
            </tr>
            </tbody>
          </table>
          <div class="button_bar">
            <a href="{{ url('agent/mypage')  }}">
              <button class="back">戻る</button>
            </a>
            <a href="{{ url('reservation/last_modified') }}">
              <button class="done">予約確認</button>
            </a>
          </div>
          <div class="ssl_info">
            <ul>
              <li><small>当サイトは、プライバシー保護のため、<br>SSL暗号化通信を採用しています。</small></li>
              <li><img src="{{ ext_asset('/images/norton.png') }}"/></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection