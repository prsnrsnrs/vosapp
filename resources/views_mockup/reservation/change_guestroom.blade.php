@extends('layout.base')

@section('title', '客室タイプ変更確認画面')

@section('style')
  <link href="{{ mix('css/change_guestroom.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/choose_guestroom') }}">客室タイプ選択</a>＞客室タイプ変更
@endsection

@section('js')
  <script src="{{ mix('js/change_guestroom.js') }}"></script>
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
  <main class="change_guestroom">
      @include('include/course', ['menu_display' => false])
      @include('include/info', ['info' => '変更した客室タイプが正しければ「確定」ボタンを押して下さい'])

    <div class="detail_area">
      <table rules="all" class="default">
        <tbody>
        <tr>
          <th style="width:100%" colspan="4">デラックスルーム(２名定員)</th>
        </tr>
        <tr>
          <td class="room" style="width:27%">
            <div class="slider slide_lightbox">
              <div><a href="{{ asset('/images/deluxe_room.png') }}" data-lightbox="group01"><img
                          src="{{ asset('/images/deluxe_room.png') }}" class="deluxe_room"></a></div>
              <div><a href="{{ asset('/images/suite_room.png') }}" data-lightbox="group01"><img
                          src="{{ asset('/images/suite_room.png') }}" class="deluxe_room"></a></div>
              <div><a href="{{ asset('/images/deluxe_room.png') }}" data-lightbox="group01"><img
                          src="{{ asset('/images/deluxe_room.png') }}" class="deluxe_room"></a></div>
            </div>
          </td>
          <td style="width:45%; padding: 0 10px" class="description" colspan="2">
            海側に大きな窓を配し、リビングベッドルームの２部屋に分かれたセパレートタイプのゆとりのあるお部屋。
            落ち着いたインテリアと広いバスルーム、専用のバルコニーを設けています。
          </td>
          <td style="width:28%">
            <dl>
              <dt class="room_rates">2名1室大人</dt>
              <dd class="room_rates">\700,000 (税込)</dd>
            </dl>
            <dl>
              <dt class="room_rates">2名1室小人</dt>
              <dd class="room_rates">\525,000 (税込)</dd>
            </dl>
            <dl>
              <dt class="room_rates">1名1室大人</dt>
              <dd class="room_rates">\1,120,000 (税込)</dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td class="zumen" style="width: 25%" rowspan="4">
            <div class="slider slide_lightbox">
              <div><a href="{{ asset('/images/zumen_deluxe_room.png') }}" data-lightbox="group02"><img
                          src="{{ asset('/images/zumen_deluxe_room.png') }}"></a></div>
              <div><a href="{{ asset('/images/zumen_deluxe_room.png') }}" data-lightbox="group02"><img
                          src="{{ asset('/images/zumen_deluxe_room.png') }}"></a></div>
            </div>
          </td>
          <td style="width: 8%" class="center">フロア</td>
          <td style="width: 67%" colspan="2" class="description default_style">9階</td>
        </tr>
        <tr>
          <td style="width: 8%" class="center">広さ</td>
          <td style="width: 67%" colspan="2" class="description default_style">23.5㎡</td>
        </tr>
        <tr>
          <td style="width: 8%" class="center">設備</td>
          <td style="width: 67%" colspan="2" class="description default_style">ツインベッド、クローゼット、ドレッサー、ソファーセット、バスタブ、シャワー、
            ウォシュレット型トイレ、26V型液晶テレビ、ブルーレイプレーヤー、冷蔵庫、金庫、湯沸しポット
          </td>
        </tr>
        <tr>
          <td style="width: 8%" class="center">備品</td>
          <td style="width: 67%" colspan="2" class="description default_style">浴衣、バスタオル、フェイスタオル、スリッパ、ポット、茶器セット、
            ドライヤー、石鹸、リンスインシャンプー、歯ブラシ、ティッシュ
          </td>
        </tr>
        </tbody>
      </table>

      <div class="member_area" style="margin-top: 10px">
        <table rules="all" class="default">
          <tbody>
          <tr>
            <th style="width:7%">No.</th>
            <th style="width:13%">大小幼</th>
            <th style="width:35%">お名前</th>
            <th style="width:15%">性別</th>
            <th style="width:15%">年齢</th>
            <th style="width:15%">料金ﾀｲﾌﾟ</th>
          </tr>
          <tr>
            <td>1</td>
            <td>大人</td>
            <td class="name">ナカガワ　ヨシオ</td>
            <td>男</td>
            <td>44</td>
            <td>ツイン</td>
          </tr>
          <tr>
            <td>2</td>
            <td>大人</td>
            <td class="name">ナカガワ　タロウ</td>
            <td>男</td>
            <td>15</td>
            <td>ツイン</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/choose_guestroom') }}">
      <button type="submit" class="back">戻る</button>
    </a>
    <a href="{{ url('reservation/order_detail') }}">
      <button type="submit" class="done">確定</button>
    </a>
  </div>
@endsection