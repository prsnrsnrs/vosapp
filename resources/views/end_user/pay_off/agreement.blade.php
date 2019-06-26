@extends('layout.base')

@section('title', '確定画面')

@section('style')
<link href="{{ mix('css/agreement.css') }}" rel="stylesheet"/>
@endsection

@section('js')
{{--    <script src="{{ mix('js/last_modified.js') }}"></script>--}}
@endsection

@section('breadcrumb')
<a href="{{ url('end_user/mypage') }}">マイページ</a>＞<a href="{{ url('cruise_plan/search') }}">新規予約</a>＞詳細入力
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
<main class="agreement">
    @include('include.course', ['menu_display' => true])
    @include('include/information', ['info' => 'お申込みの内容は以下の通りです。<br>
　ご旅行条件書を確認し、よろしければ同意欄にチェックを入れ、「確定」ボタンをクリックしてください。'])

  <div class="headline">
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
  </div>
  <div class="list">
    <table class="center default">
      <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.1</th>
          <td colspan="5" class="left">デラックスルーム（２名店員）</td>
          <th>客室番号</th>
          <td class="left" colspan="3">未定</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th style="width: 4%">No</th>
          <th style="width: 6%">代表者</th>
          <th style="width: 6%">大小幼</th>
          <th style="width: 20%">お名前</th>
          <th style="width: 4%">性別</th>
          <th style="width: 4%">年齢</th>
          <th style="width: 11%">ステータス</th>
          <th style="width: 9%">料金タイプ</th>
          <th style="width: 9%">旅行代金</th>
          <th style="width: 9%">割引券額</th>
          <th style="width: 9%">取消料等</th>
          <th style="width: 9%">精算額</th>
        </tr>
        <tr>
          <td class="index">1</td>
          <td>○</td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA YOSHIO</span></td>
          <td>男</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">700,000円</td>
          <td class="right">-15,000円</td>
          <td class="right">0円</td>
          <td class="right">685,000円</td>
        </tr>
        <tr>
          <td class="index">2</td>
          <td></td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA TAROU</span></td>
          <td>男</td>
          <td>15</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">700,000円</td>
          <td class="right">-150,000円</td>
          <td class="right">0円</td>
          <td class="right">685,000円</td>
        </tr>
      </tbody>
    </table>
    <table class="center default">
      <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.2</th>
          <td colspan="5" class="left">ステートルームF（3名店員）</td>
          <th>客室番号</th>
          <td class="left" colspan="3">未定</td>
          </td>
       </tr>
      </thead>
      <tbody>
        <tr>
          <th style="width: 4%">No</th>
          <th style="width: 6%">代表者</th>
          <th style="width: 6%">大小幼</th>
          <th style="width: 20%">お名前</th>
          <th style="width: 4%">性別</th>
          <th style="width: 4%">年齢</th>
          <th style="width: 11%">ステータス</th>
          <th style="width: 9%">料金タイプ</th>
          <th style="width: 9%">旅行代金</th>
          <th style="width: 9%">割引券額</th>
          <th style="width: 9%">取消料等</th>
          <th style="width: 9%">精算額</th>
        </tr>
        <tr>
          <td class="index">3</td>
          <td></td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA HANAKO</span></td>
          <td>女</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">500,000円</td>
          <td class="right">0円</td>
          <td class="right">0円</td>
          <td class="right">500,000円</td>
        </tr>
        <tr>
          <td class="index">4</td>
          <td></td>
          <td>小人</td>
          <td class="name left"><span>NAKAGAWA KOHANA</span></td>
          <td>女</td>
          <td>10</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">375,000円</td>
          <td class="right">0円</td>
          <td class="right">0円</td>
          <td class="right">375,000円</td>
        </tr>
        <tr>
          <td class="index">5</td>
          <td></td>
          <td>幼児</td>
          <td class="name left"><span>NAKAGAWA YOUZI</span></td>
          <td>男</td>
          <td>1</td>
          <td>HK</td>
          <td>-</td>
          <td class="right">0円</td>
          <td class="right">0円</td>
          <td class="right">0円</td>
          <td class="right">0円</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="panel">
    <div class="body">
      <p class="center">＜ご旅行条件書＞</p>
      <label>・・・・・・・・・・・・</label>
    </div>
    <div class="footer">
      <label>
        <input type="checkbox" class="check_style"/>
        <span class="checkbox"></span>ご旅行条件書に同意する
      </label>
    </div>
  </div>
  <div class="quiestion">
    <label>
      <input type="checkbox" class="check_style"/>
      <span class="checkbox"></span>
      乗船者情報の中に事前登録されていないデータがあった場合、今回の入力情報をもって事前登録をする<br>
      （次回予約時に入力の手間が省けます。びいなす会員であればリンクIDを登録することで割引券等の特典が受けられます）
    </label>
  </div>
</main>
<div class="button_bar">
  <a href="{{ url('reservation/input/passenger_request') }}">
    <button type="submit" class="back">戻る</button>
  </a>
  <a href="{{ url('end_user/pay_off/pay_input') }}">
    <button type="submit" class="done">確定</button>
  </a>
</div>
@endsection
