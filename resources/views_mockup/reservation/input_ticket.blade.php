@extends('layout.base')

@section('title', '割引券情報入力画面')

@section('style')
  <link href="{{ mix('css/input_ticket.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/input_ticket.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/order_detail') }}">予約照会</a>＞割引情報入力
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
  <main class="input_ticket">

    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => '割引券情報を入力して下さい<br><span class="danger">利用できない番号です（お客様№2）</span>'])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li class="current">④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

    <div class="input_area">
      <table rules="all" class="default">
        <tbody>
        <tr>
          <th style="width:4%">No.</th>
          <th style="width:8%">大小幼</th>
          <th style="width:20%">お名前</th>
          <th style="width:4%">性別</th>
          <th style="width:4%">年齢</th>
          <th style="width:50%">割引券番号</th>
          <th style="width:10%">割引券額</th>
        </tr>
        <tr>
          <td>1</td>
          <td>大人</td>
          <td class="name">NAKAGAWA YOSHIO</td>
          <td>男</td>
          <td>44</td>
          <td>
            <input type="text" value="C9999999999">
            <input type="text">
            <input type="text">
            <input type="text">
            <input type="text">
          </td>
          <td>
            <label class="ticket_fee">15,000円</label>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>大人</td>
          <td class="name">NAKAGAWA TAROU</td>
          <td>男</td>
          <td>15</td>
          <td>
            <input type="text" placeholder="C9999999999">
            <input type="text">
            <input type="text">
            <input type="text">
            <input type="text">
          </td>
          <td>
            <label class="ticket_fee"></label>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>大人</td>
          <td class="name">NAKAGAWA HANAKO</td>
          <td>女</td>
          <td>44</td>
          <td>
            <input type="text" placeholder="C9999999999">
            <input type="text">
            <input type="text">
            <input type="text">
            <input type="text">
          </td>
          <td>
            <label class="ticket_fee"></label>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td>小人</td>
          <td class="name">NAKAGAWA KOHANA</td>
          <td>女</td>
          <td>10</td>
          <td>
            <input type="text" placeholder="C9999999999">
            <input type="text">
            <input type="text">
            <input type="text">
            <input type="text">
          </td>
          <td>
            <label class="ticket_fee"></label>
          </td>
        </tr>
        <tr>
          <td>5</td>
          <td>幼児</td>
          <td class="name">NAKAGAWA YOUZI</td>
          <td>男</td>
          <td>1</td>
          <td>
            <input type="text" placeholder="C9999999999">
            <input type="text">
            <input type="text">
            <input type="text">
            <input type="text">
          </td>
          <td>
            <label class="ticket_fee"></label>
          </td>
        </tr>
        </tbody>
      </table>

      <div class="button_ticket">
        <button type="submit" class="default use_ticket">割引券使用確定</button>
      </div>
    </div>
  </main>

  <div class="button_bar">
    <a href="{{ url('reservation/input_request') }}">
      <button type="submit" class="back">戻る
      </button>
    </a>
    <a href="{{ url('reservation/check_question') }}">
      <button type="submit" class="done">
        次へ（質問事項のチェック）
      </button>
    </a>
      <button type="submit" class="skip done">
        スキップ（照会へ）</button>
  </div>

@endsection