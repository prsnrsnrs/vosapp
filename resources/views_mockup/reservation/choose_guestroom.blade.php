@extends('layout.base')

@section('title', '客室タイプ選択画面')

@section('style')
  <link href="{{ mix('css/choose_guestroom.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/search_plan.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/search_plan') }}">クルーズプラン検索</a>＞客室タイプ選択
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="choose_guestroom">

    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => '客室タイプを選択してください　※キャンセル待ち登録する場合は通常のご予約とは混在して登録することはできません'])
    <div class="confirm_time">
      <label id="time"></label>
    </div>
    <div class="room_area">
      <table class="default">
        <tbody>
        <tr>
          <th style="width:25%">客室タイプ</th>
          <th style="width:35%">説明</th>
          <th style="width:22%">金額(大人おひとり様)</th>
          <th style="width:18%">選択</th>
        </tr>
        <tr>
          <td>スイートルーム<br><img src="{{ asset('/images/suite_room.png') }}" class="suite_room"></td>
          <td class="description"><br>海側に大きな窓を配し、リビングベッドルームの２部屋に分かれたセパレートタイプのゆとりのあるお部屋。
            落ち着いたインテリアと広いバスルーム、専用のバルコニーを設けています。
          </td>
          <td>
            <dl>
              <dt>2名1室</dt>
              <dd>\1,000,000 (税込)</dd>
            </dl>
            <dl>
              <dt>1名1室</dt>
              <dd>\1,600,000 (税込)</dd>
            </dl>
          </td>
          <td>
            <a href="{{ url('reservation/choose_guestnumber') }}">
              <button type="submit" class="add wait_cancel">
                ×キャンセル待ち<br>登録
              </button>
            </a>
          </td>
        </tr>
        <tr>
          <td>デラックスルーム<br><img src="{{ asset('/images/deluxe_room.png') }}" class="deluxe_room"></td>
          <td class="description"><br>ゆったりと開放感のある設計で、室内のカラーコーディネイトが美しく調和しています。</td>
          <td>
            <dl>
              <dt>2名1室</dt>
              <dd>\700,000 (税込)</dd>
            </dl>
            <dl>
              <dt>1名1室</dt>
              <dd>\1,120,000 (税込)</dd>
            </dl>
          </td>
          <td>
            <a href="{{ url('reservation/choose_guestnumber') }}">
              <button type="submit" class="add">△予約</button>
            </a>
          </td>
        </tr>
        <tr>
          <td>ステートルームＦ</td>
          <td class="description">アイボリー調のまとめられた開放感のあるお部屋。ソファーベッドの使用により
            ３名様までご利用いただける客室もございます。８階角窓となります。
          </td>
          <td>
            <dl>
              <dt>3名1室</dt>
              <dd>\400,000 (税込)</dd>
            </dl>
            <dl>
              <dt>2名1室</dt>
              <dd>\500,000 (税込)</dd>
            </dl>
            <dl>
              <dt>1名1室</dt>
              <dd>\650,000 (税込)</dd>
            </dl>
          </td>
          <td>
            <a href="{{ url('reservation/change_guestroom') }}">
              <button type="submit" class="add">〇予約</button>
            </a>
          </td>
        </tr>
        </tbody>
      </table>
      <table class="default"  style="border: none">
        <tr>
          <td colspan="13" class="right"  style="border-top: none">
            〇…空席あり、△…空席わずか、×…満席(キャンセル待ち)、－…受付不可
          </td>
        </tr>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('/reservation/search_plan') }}">
      <button class="back">戻る</button>
    </a>
  </div>

@endsection