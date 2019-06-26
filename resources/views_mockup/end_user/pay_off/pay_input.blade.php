@extends('layout.base')

@section('title', 'カード入力')

@section('style')
  <link href="{{ mix('css/pay_select.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞精算
@endsection
@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('end_user/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('end_user/login/login') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main>
    @include('include.course', ['menu_display' => true])
    @include('include.info', ['info' => 'クレジットカード情報を入力し、「確認」ボタンを押してください。'])

    <table class="default center">
      <tbody>
      <tr>
        <th>予約番号</th>
        <th>受付日時</th>
        <th>取消日時</th>
        <th>ｽﾃｰﾀｽ</th>
        <th class="right">旅行代金<br>合計</th>
        <th class="right">割引券額<br>合計</th>
        <th>取消料等</th>
        <th class="right">ご請求額<br>合計</th>
        <th class="right total_th">上段：精算済額<br>下段：未清算額</th>
      </tr>
      <tr>
        <td rowspan="2" class="bold">123456789</td>
        <td rowspan="2">2017/02/23<br>12:34</td>
        <td rowspan="2"></td>
        <td rowspan="2">予約中</td>
        <td rowspan="2" class="right">2,275,000円</td>
        <td rowspan="2" class="right">-20,000円</td>
        <td rowspan="2" class="right">0円</td>
        <td rowspan="2" class="right">2,255,000円</td>
        <td class="right">0円</td>
      </tr>
      <tr>
        <td class="right bold">2,255,000円</td>
      </tr>
      </tbody>
    </table>
<?php
          $users = [
              ['val' => "1", 'name' => 'NAKAGAWA YOSHIO'],
              ['val' => "2", 'name' => 'NAKAGAWA TAROU'],
              ['val' => "3", 'name' => 'NAKAGAWA HANAKO'],
              ['val' => "4", 'name' => 'NAKAGAWA KOHANA'],
              ['val' => "5", 'name' => 'NAKAGAWA YOUZI'],
              ['val' => "6", 'name' => '乗船者以外']
          ]
?>
    <table class="default left">
      <thead>
      <tr>
        <th colspan="3" class="title">クレジットカード情報の入力</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td rowspan="5" style="width: 20%">クレジットカード</td>
        <td style="width: 20%">ご利用いただけるカード</td>
        <td style="width: 60%"><img src="{{ asset('images/payment_card.png') }}"></td>
      </tr>
      <tr>
        <td>カード番号</td>
        <td><input type="text" placeholder="例）0158458745687" ></td>
      </tr>
      <tr>
        <td>カード有効期限</td>
        <td>
          <select name="month">
            @for($i=1; $i <= 12; $i++)
              <option>{{ $i }}</option>
            @endfor
          </select>
          月
          <select name="year">
            @for($i=0; $i < 10; $i++)
              <option>201{{ $i }}</option>
            @endfor
          </select>
          年
        </td>
      </tr>
      <tr>
        <td>カード名義人</td>
        <td>
          <select name="user">
            @foreach($users as $user)
              <option value="{{ $user['val'] }}">{{ $user['name'] }}</option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <td>セキュリティコード</td>
        <td><input type="text" placeholder="例）015" ></td>
      </tr>
      <tr>
        <td rowspan="2">精算内訳</td>
        <td>申込金（旅行代金の10％）</td>
        <td>225,500円</td>
      </tr>
      <tr>
        <td colspan="2">
          お支払後の変更・取消には所定の変更手数料または取消料を申し受けます。詳細は<a href="">こちら</a>をご覧ください。
        </td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/pay_off/agreement') }}" ><button class="back">戻る</button></a>
    <a href="{{ url('end_user/pay_off/pay_confirm') }}" ><button class="done">確認</button></a>
  </div>
@endsection
