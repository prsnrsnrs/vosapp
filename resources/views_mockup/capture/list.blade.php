@extends('layout.base')

@section('title', '取込予約一覧')

@section('style')
  <link href="{{ mix('css/list.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞
  <a href="{{ url('reservation/search_plan') }}">クルーズプラン検索</a>＞
  <a href="{{ url('capture/select') }}">取込ファイル指定</a>＞取込予約一覧
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
    <div class="panel capture_result">
      <div class="title">取込結果</div>
      <div class="section">
        <p>
          25件のデータを取込ました。<br>
          〇件が新規で〇件が変更です。<br>
          〇件が内容チェックでエラーになりました。
        </p>
      </div>
    </div>
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
          <tr>
            <th colspan="10">取込予約一覧結果</th>
          </tr>
          <tr class="data_title">
            <th rowspan="2" style="width: 105px">旅行社管理番号</th>
            <th rowspan="2" style="width: 75px">処理</th>
            <th rowspan="2" style="width: 75px">ｽﾃｰﾀｽ</th>
            <th rowspan="2" style="width: 170px">代表者名</th>
            <th rowspan="2" style="width: 100px">電話番号</th>
            <th colspan="3">人数</th>
            <th rowspan="2" style="width: 100px">予約番号</th>
            <th rowspan="2" style="width: 250px">取込エラー内容</th>
          </tr>
          <tr class="data_title">
            <th style="width: 70px">大人</th>
            <th style="width: 70px">小人</th>
            <th style="width: 70px">幼児</th>
          </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < 10; $i++)
          <tr>
            <td style="width: 105px">015678989</td>
            <td style="width: 75px">新規</td>
            <td style="width: 75px">HK</td>
            <td style="width: 170px">ナカガワ　ヨシオ</td>
            <td style="width: 100px">090-0000-0000</td>
            <td style="width: 70px">3</td>
            <td style="width: 70px">1</td>
            <td style="width: 70px">0</td>
            <td style="width: 100px">12345</td>
            <td style="width: 250px"></td>
          </tr>
          <tr class="error">
            <td>015678901</td>
            <td>新規</td>
            <td>エラー</td>
            <td>コンドウ　マサヤ</td>
            <td>080-0000-0000</td>
            <td>2</td>
            <td>0</td>
            <td>1</td>
            <td></td>
            <td>受付期間前です</td>
          </tr>
          <tr class="error">
            <td>123456788</td>
            <td>新規</td>
            <td>エラー</td>
            <td>ナカガワ　コタロウ</td>
            <td>080-0000-0000</td>
            <td>2</td>
            <td>2</td>
            <td>0</td>
            <td></td>
            <td>お客様の住所を入力して下さい</td>
          </tr>
          <tr>
            <td>123456789</td>
            <td>変更</td>
            <td>WT</td>
            <td>タケモト　トモコ</td>
            <td>080-0000-0000</td>
            <td>2</td>
            <td>2</td>
            <td>0</td>
            <td></td>
            <td></td>
          </tr>
          <tr class="error">
            <td>015678989</td>
            <td>変更</td>
            <td>エラー</td>
            <td>ウエムラ　テツヤ</td>
            <td>070-0000-0000</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td>お客様の住所を入力して下さい</td>
          </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('capture/select') }}"><button class="back">戻る</button></a>
    <a href="{{ url('sale_reception') }}"><button class="back">受付一覧へ</button></a>
  </div>
@endsection