@extends('layout.base')

@section('title', 'ご乗船者リクエスト入力')

@section('style')
  <link href="{{ mix('css/input_remarks.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/input_remarks.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/order_detail') }}">予約照会</a>＞ご乗船者リクエスト入力
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
  <main class="input_remarks">

    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => 'リクエスト情報を入力してください。<br>
    <span style="display: inline-block;" class="danger">
    無料の幼児には食事がついておりませんので、必要な場合は子供食欄にてお申込みください（有料、船内精算のみ）。
    </span>'])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li class="current">②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

    <table class="default dinner_time">
      <tbody>
      <th style="width: 12%">食事希望</th>
      <td style="width: 88%" class="meal_request">
        <select style="width: 100px" name="meal_request">
          <option value="0">希望無し</option>
          <option value="1">1回目</option>
          <option value="2">2回目</option>
        </select>　1回目/17:30　2回目/19:30　※時間は目安です。クルーズや日によって異なります。また、ご希望に添えない場合もありますので予めご了承下さい。
      </td>
      </tbody>
    </table>

    <table class="default center">
      <tbody>
      <tr>
        <th style="width:4%">No.</th>
        <th style="width:5%">大小幼</th>
        <th style="width:18%">お名前</th>
        <th style="width:4%">性別</th>
        <th style="width:4%">年齢</th>
        <th style="width:15%">子供食<a href="javascript:void(0);" class="kids_menu">（？）</a></th>
        <th style="width:15%">記念日等</th>
        <th style="width:35%">備考</th>
      </tr>
      <tr>
        <td>1</td>
        <td>大人</td>
        <td class="name left">NAKAGAWA YOSHIO</td>
        <td>男</td>
        <td>44</td>
        <td></td>
        <td>
          <select name="anniversary">
          <option value="0">無し</option>
          <option>--------------</option>
          <option value="1">結婚記念日</option>
          <option value="2">金婚式</option>
          <option value="3">エメラルド婚式</option>
          <option value="4">ダイヤモンド婚式</option>
          <option value="5">プラチナ婚式</option>
          <option>--------------</option>
          <option value="6">ハネムーン</option>
          </select>
        </td>
        <td>
          <input type="text" style="width: 98%" placeholder="例)PVリピータのお客様です">
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>大人</td>
        <td class="name left">NAKAGAWA TAROU</td>
        <td>男</td>
        <td>15</td>
        <td></td>
        <td>
          <select name="anniversary">
          <option value="0">無し</option>
          <option>--------------</option>
          <option value="1">結婚記念日</option>
          <option value="2">金婚式</option>
          <option value="3">エメラルド婚式</option>
          <option value="4">ダイヤモンド婚式</option>
          <option value="5">プラチナ婚式</option>
          <option>--------------</option>
          <option value="6">ハネムーン</option>
          </select>
        </td>
        <td>
          <input type="text" style="width: 98%">
        </td>
      </tr>
      <tr>
        <td>3</td>
        <td>大人</td>
        <td class="name left">NAKAGAWA HANAKO</td>
        <td>女</td>
        <td>44</td>
        <td></td>
        <td>
          <select name="anniversary">
          <option value="0">無し</option>
          <option>--------------</option>
          <option value="1">結婚記念日</option>
          <option value="2">金婚式</option>
          <option value="3">エメラルド婚式</option>
          <option value="4">ダイヤモンド婚式</option>
          <option value="5">プラチナ婚式</option>
          <option>--------------</option>
          <option value="6">ハネムーン</option>
          </select>
        </td>
        <td>
          <input type="text" style="width: 98%">
        </td>
      </tr>
      <tr>
        <td>4</td>
        <td>小人</td>
        <td class="name left">NAKAGAWA KOHANA</td>
        <td>女</td>
        <td>10</td>
        <td>
          <select name="dinner">
          <option value="0"></option>
          <option value="1">要</option>
          <option value="2">不要</option>
          </select>
        </td>
        <td></td>
        <td>
          <input type="text" style="width: 98%">
        </td>
      </tr>
      <tr>
        <td>5</td>
        <td>幼児</td>
        <td class="name left">NAKAGAWA YOUZI</td>
        <td>男</td>
        <td>1</td>
        <td>
          <select name="baby">
          <option value="0">不要</option>
          <option value="1">夕食のみ(有料)</option>
          <option value="2">昼・夕食(有料)</option>
          </select>
        </td>
        <td></td>
        <td>
          <input type="text" style="width: 98%">
        </td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="kids_menu_img" style="display: none">
    <img src="{{ asset('/images/kids_menu.jpg') }}">
    <p>子供食のイメージ画像です。</p>
  </div>
  <div class="button_bar">
    <a href="{{ url('reservation/boatmember') }}">
      <button type="submit" class="back">戻る
      </button>
    </a>
    <a href="{{ url('reservation/input_request') }}">
      <button type="submit" class="done">次へ(客室リクエスト入力)
      </button>
    </a>
    <button type="submit" class="skip done">スキップ（照会へ）
    </button>
  </div>

@endsection