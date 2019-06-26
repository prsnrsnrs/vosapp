@extends('layout.base')

@section('title', '客室リクエスト入力')

@section('style')
  <link href="{{ mix('css/input_request.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/input_request.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/order_detail') }}">予約照会</a>＞客室リクエスト入力
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
  <main class="input_request">

    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => 'リクエスト情報を入力してください<br />
<span class="danger">※第1希望の客室タイプがＷＴの場合のみ客室タイプをリクエストして下さい</span>'])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li class="current">③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

      <table rules="all" class="default request">
        <tbody>
        <tr>
          <th style="width:8%">客室No.</th>
          <th style="width:20%">タイプ</th>
          <th style="width:24%">客室タイプリクエスト</th>
          <th style="width:48%">キャビンリクエスト</th>
        </tr>
        <tr>
          <td>１</td>
          <td>デラックスルーム</td>
          <td>
            <select style="width: 90%" name="room_type">
              <option value="0"></option>
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </td>
          <td><input type="text" style="width: 95%" placeholder="例)視界の良い左舷"></td>
        </tr>
        <tr>
          <td>２</td>
          <td>ステートルームF</td>
          <td>
            <select style="width: 90%" name="room_type">
              <option value="0">デラックスルーム</option>
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </td>
          <td><input type="text" style="width: 95%" placeholder="例)視界の良い左舷"></td>
        </tr>
        <tr>
          <td>３</td>
          <td>ステートルームE</td>
          <td>
            <select style="width: 90%" name="room_type">
              <option value="0"></option>
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </td>
          <td><input type="text" style="width: 95%" placeholder="例)視界の良い左舷"></td>
        </tr>
        </tbody>
      </table>

    <div class="button_deck">
      <a href="http://www.venus-cruise.co.jp/intro/floor.html" target=”_blank”>
        <button type="submit" class="add">
          デッキプランを見る
        </button>
      </a>
    </div>
  </main>

  <div class="button_bar">
    <a href="{{ url('reservation/input_remarks') }}">
      <button type="submit" class="back">戻る</button>
    </a>
    <a href="{{ url('reservation/input_ticket') }}">
      <button type="submit" class="done">次へ（割引情報入力）
      </button>
    </a>
      <button type="submit" class="skip done">スキップ（照会へ）</button>
  </div>

@endsection