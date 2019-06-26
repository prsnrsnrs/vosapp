@extends('layout.base')

@section('title', 'ご乗船のお客様情報照会')

@section('style')
  <link href="{{ mix('css/boatmenber_confirm.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞<a href="{{ url('end_user/boatmenber/list') }}">ご乗船のお客様登録一覧</a>
  ＞ご乗船のお客様情報照会
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
  <main class="add">
    @include('include.info', ['info' => 'ご乗船されるお客様情報の情報を表示しています。変更するには編集ボタンを押してください。'])
    <table class="default">
      <thead>
      <tr>
        <th colspan="8">ご乗船者のお客様情報(No.1)</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th rowspan="3" class="vertical">お<br>名<br>前</th>
        <th>英字</th>
        <td colspan="3" class="name">（姓）NAKAGAWA</td>
        <td colspan="3" class="name">（名）YOSHIO</td>
      </tr>
      <tr>
        <th>漢字</th>
        <td colspan="3" class="name">（姓）中川</td>
        <td colspan="3" class="name">（名）善夫</td>
      </tr>
      <tr>
        <th>カナ</th>
        <td colspan="3" class="name">（姓）ナカガワ</td>
        <td colspan="3" class="name">（名）ヨシオ</td>
      </tr>
      <tr>
        <th colspan="2">性別</th>
        <td>男</td>
        <th colspan="2">生年月日</th>
        <td>1972年06月24日</td>
        <th>結婚記念日</th>
        <td>2000年11月22日</td>
      </tr>
      <tr>
        <th rowspan="5" class="vertical">住<br>所<br></th>
        <th>郵便番号</th>
        <td colspan="6">520-1621</td>
      </tr>
      <tr>
        <th>都道府県</th>
        <td colspan="6">滋賀県</td>
      </tr>
      <tr>
        <th>市区町村まで</th>
        <td colspan="6">高島市今津町今津</td>
      </tr>
      <tr>
        <th>番地以降</th>
        <td colspan="6">１ー２３４－５</td>
      </tr>
      <tr>
        <th>建物名</th>
        <td colspan="6">びわこハイツ301</td>
      </tr>
      <tr>
        <th colspan="2">電話番号1</th>
        <td colspan="6">09000000000</td>
      </tr>
      <tr>
        <th colspan="2">電話番号2</th>
        <td colspan="6">08000000000</td>
      </tr>
      <tr>
        <th rowspan="2">緊急<br>連絡先</th>
        <th>お名前</th>
        <td>中川　小太郎</td>
        <th colspan="2">お名前カナ</th>
        <td>ナカガワ　ショウタロウ</td>
        <th>続柄</th>
        <td>子</td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td colspan="6">08000000000</td>
      </tr>
      <tr>
        <th colspan="2" style="width: 15%">国籍</th>
        <td style="width: 21%">日本</td>
        <th rowspan="2" style="width: 3%; padding: 0 9px;">旅<br>券</th>
        <th style="width: 7%">番号</th>
        <td style="width: 17%"></td>
        <th style="width: 10%">発給地</th>
        <td style="width: 17%"></td>
      </tr>
      <tr>
        <th colspan="2">居住国</th>
        <td>日本</td>
        <th>発給日</th>
        <td>2017年11月04日</td>
        <th>失効日</th>
        <td>2027年11月10日</td>
      </tr>
      <tr>
        <th colspan="2">ネット予約リンクID</th>
        <td colspan="6">123456789 <label class="icon success">びいなす倶楽部会員</label></td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/boatmenber/list') }}"><button class="back">戻る</button></a>
    <a href="{{ url('end_user/boatmenber/add') }}"><button class="edit">編集</button></a>
  </div>
@endsection