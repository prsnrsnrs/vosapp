@extends('layout.base')

@section('title', '提出書類画面')

@section('style')
  <link href="{{ mix('css/send_document.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/order_detail') }}">予約照会</a>＞提出書類一覧
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
  <main class="body">
    @include('include.course', ['menu_display' => false])
    @include('include.info', ['info' => 'ご乗船者様ごとに以下のご提出書類がございます。<br>書類により入力や提出方法が違いますので、ご確認の上、ご提出をお願い致します。'])
    <div class="list">
      <table class="default">
        <thead>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 22%">お名前</th>
          <th style="width: 40%">書類一覧</th>
          <th style="width: 13%">入力・申込方法</th>
          <th style="width: 15%">返信</th>
          <th style="width: 5%">確認</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td rowspan="4" class="index">1</td>
          <td rowspan="4">ナカガワ　ヨシオ　様</td>
          <td rowspan="2">健康アンケート</td>
          <td></td>
          <td></td>
          <td rowspan="2">済</td>
        </tr>
        <tr>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>要</td>
        </tr>
        <tr>
          <td rowspan="2">食物アレルギーや食事制限の方へのアンケート</td>
          <td></td>
          <td></td>
          <td rowspan="2">済</td>
        <tr>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>要</td>
        </tr>
        </tbody>
        <tbody>
        <tr>
          <td class="index">2</td>
          <td>ナカガワ　タロウ　様</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        </tbody>
        <tbody>
        <tr>
          <td class="index">3</td>
          <td>ナカガワ　ハナコ　様</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        </tbody>
        <tbody>
        <tr>
          <td class="index">4</td>
          <td>ナカガワ　コハナ　様</td>
          <td>特別な配慮が必要な方へのアンケート</td>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>要</td>
          <td>済</td>
        </tr>
        </tbody>
        <tbody>
        <tr>
          <td rowspan="4" class="index">5</td>
          <td rowspan="4">ナカガワ　ヨウジ　様</td>
          <td>幼児のお子様の乗車について</td>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>不要</td>
          <td>-</td>
        </tr>
        <tr>
          <td>承諾書（乳幼児）</td>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>要</td>
          <td class="still">未</td>
        </tr>
        <tr>
          <td>主治医あて案内文（乳幼児）</td>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>不要</td>
          <td>-</td>
        </tr>
        <tr>
          <td>診断書（乳幼児）</td>
          <td>
            PDF印刷
            <img src="{{ asset('/images/pdf.png') }}">
            {{--<img src="{{ asset('/images/arrow.png') }}">--}}
          </td>
          <td>要</td>
          <td class="still">未</td>
        </tr>
        </tbody>
      </table>
    </div>
    <p>※済マークは当社の確認後になりますので、回答後でもすぐには反映されません。</p>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/order_detail') }}"><button class="back">戻る</button></a>
  </div>
@endsection
