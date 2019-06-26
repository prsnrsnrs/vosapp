@extends('layout.base')

@section('title', '精算画面①')

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
  <main class="pay_select">
    @include('include.course', ['menu_display' => true])
    @include('include.info', ['info' => 'ご精算金額とお支払い方法を選択して下さい。'])

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

    <table class="default left money_select">
      <thead>
        <tr>
          <th colspan="4" class="title">ご精算金額の選択</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 20%">
            <label><input type="radio" name="money" checked>申込金（旅行代金の10%）</label>
          </td>
          <td style="width: 2%">：</td>
          <td style="width: 10%" class="right">225,500円</td>
          <td style="width: 68%"></td>
        </tr>
        <tr>
          <td>
            <label><input type="radio" name="money">一括全額</label>
          </td>
          <td>：</td>
          <td class="right">2,255,000円</td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <table class="default left">
      <thead>
        <tr>
          <th colspan="2" class="title">お支払い方法選択</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td rowspan="2"><label><input type="radio" name="payment" checked>クレジットカード</label></td>
          <td>※ご乗船される本人名義で出発日まで有効なもの<br>※一回払いのみ</td>
        </tr>
        <tr>
          <td><img src="{{ ext_asset('images/payment_card.png') }}"></td>
        </tr>
        <tr>
          <td rowspan="2"><label><input type="radio" name="payment">銀行振込</label></td>
          <td>※振込人名義の前に「予約番号」を入力してください</td>
        </tr>
        <tr>
          <td>振込先銀行口座<br>三菱銀行UFJ銀行　堂島支店　普通：000000</td>
        </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/detail') }}" ><button class="back">戻る</button></a>
    <a href="{{ url('end_user/pay_off/credit_data') }}" ><button class="done">選択</button></a>
  </div>
@endsection
