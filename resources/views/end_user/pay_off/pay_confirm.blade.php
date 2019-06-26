@extends('layout.base')

@section('title', 'カード確認')

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
    @include('include.info', ['info' => 'ご精算内容を確認し、よろしければ「ご精算」ボタンを押してください。'])

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
    <table class="default left">
      <thead>
      <tr>
        <th colspan="3" class="title">クレジットカード情報の確認</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td rowspan="5" style="width: 20%">クレジットカード</td>
        <td style="width: 20%">ご利用いただけるカード</td>
        <td style="width: 60%"><img src="{{ ext_asset('images/payment_card.png') }}"></td>
      </tr>
      <tr>
        <td>カード番号</td>
        <td>40000*****</td>
      </tr>
      <tr>
        <td>カード有効期限</td>
        <td>07月18年</td>
      </tr>
      <tr>
        <td>カード名義人</td>
        <td>NAKAGAWA YOSHIO</td>
      </tr>
      <tr>
        <td>セキュリティコード</td>
        <td>***</td>
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
    <a href="{{ url('end_user/pay_off/pay_input') }}" ><button class="back">戻る</button></a>
    <a href="" ><button class="done">ご精算</button></a>
  </div>
@endsection
