@extends('layout.base')

@section('title', '客室人数選択画面')

@section('style')
  <link href="{{ mix('css/choose_guestnumber.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/choose_guestnumber.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>
  ＞<a href="{{ url('reservation/search_plan') }}">クルーズプラン検索</a>
  ＞<a href="{{ url('reservation/choose_guestroom') }}">客室タイプ選択</a>
  ＞客室人数選択
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
  <main class="choose_guestnumber">

    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => '人数を選択して下さい'])

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
        <tr>
          <td class="center">客室数選択</td>
          <td colspan="3" class="select_room_number">
            <select class="select_room" name="select_room_number">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
            <span class="danger">※選択された部屋数が確実に確保されるわけではございません。あらかじめご了承ください。</span>
          </td>
        </tr>
        <tr>
          <td style="width: 25%" class="center">人数選択</td>
          <td style="width: 75%" colspan="3" class="choose_number default_style">
            <table>
              <tbody>
              <tr>
              @for($i = 1; $i <= 3; $i++)
                <td>
                  <div class="select_form_{{ $i }}" style="{{ $i != 1 ? 'display:none' : '' }}">
                    <span>客室{{ $i }}</span>
                    <dl>
                      <dt class="choose_number">大人（中学生以上）</dt>
                      <dd class="choose_number">
                        <select name="select_number">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </dd>
                    </dl>
                    <dl>
                      <dt class="choose_number">１２歳（小学生）</dt>
                      <dd class="choose_number">
                        <select name="select_number">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </dd>
                    </dl>
                    <dl>
                      <dt class="choose_number">２歳～１１歳</dt>
                      <dd class="choose_number">
                        <select name="select_number">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </dd>
                    </dl>
                    <dl>
                      <dt class="choose_number">１歳～　２歳</dt>
                      <dd class="choose_number">
                        <select name="select_number">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </dd>
                    </dl>
                    <dl>
                      <dt class="choose_number">６カ月～０歳</dt>
                      <dd class="choose_number">
                        <select name="select_number">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </dd>
                    </dl>
                    <dl>
                      <dt class="choose_number">※ご乗船時の年齢（就学状況）</dt>
                    </dl>
                  </div>
                </td>
                @endfor
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/choose_guestroom') }}">
      <button type="submit" class="back">戻る
      </button>
    </a>
    <a href="{{ url('reservation/input_name') }}">
      <button type="submit" class="done">
        次へ（ご乗船者入力）
      </button>
    </a>
  </div>


@endsection