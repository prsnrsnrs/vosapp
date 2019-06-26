@extends('layout.base')

@section('title', '販売店一括登録確認')

@section('style')
  <link href="{{ mix('css/bundle_confirm.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/bundle_confirm.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('sale_management/list_shop') }}">販売店一覧</a>＞
  <a href="{{ url('sale_management/bundle_input') }}">販売店一括登録</a>＞販売店一括登録確認
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">大阪本社</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="bundle_complete">
    @include('include.info', ['info' => '以下のデータで登録します'])
    <div class="result">
      <table class="default">
        <thead>
        <tr>
          <th colspan="3">複数登録結果</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 50%">インポート件数</th>
          <th style="width: 50%">インポートエラー件数</th>
        </tr>
        <tr>
          <td>1,123件</td>
          <td>0件</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="panel list">
      <div class="title">データ一覧</div>
      <div class="body">
        <table class="default hover_rows" style="width: 3340px">
          <thead class="data_title">
          <tr>
            <th style="width: 50px">No.</th>
            <th style="width: 100px">販売店コード</th>
            <th style="width: 100px">販売店名</th>
            <th style="width: 80px">郵便番号</th>
            <th style="width: 80px">都道府県</th>
            <th style="width: 210px">住所１</th>
            <th style="width: 200px">住所２</th>
            <th style="width: 200px">住所３</th>
            <th style="width: 100px">TEL</th>
            <th style="width: 100px">FAX</th>
            <th style="width: 230px">メールアドレス１</th>
            <th style="width: 230px">メールアドレス２</th>
            <th style="width: 230px">メールアドレス３</th>
            <th style="width: 230px">メールアドレス４</th>
            <th style="width: 230px">メールアドレス５</th>
            <th style="width: 230px">メールアドレス６</th>
            <th style="width: 100px">販売店区分</th>
            <th style="width: 100px">ログイン区分</th>
            <th style="width: 100px">ユーザーID</th>
            <th style="width: 100px">パスワード</th>
          </tr>
          </thead>
          <tbody>
          @for($i = 1; $i <= 15; $i++)
            <tr class="{{ ($i == 5)?  'error': ''}} ">
              <td style="width: 50px">{{ $i }}</td>
              <td style="width: 100px">KTY1</td>
              <td style="width: 100px">東京支店</td>
              <td style="width: 80px">1000011</td>
              <td style="width: 80px">東京都</td>
              <td style="width: 210px">千代田区内幸町</td>
              <td style="width: 200px">1-1-7</td>
              <td style="width: 200px">NBF日比谷ビル22階</td>
              <td style="width: 100px">039999999</td>
              <td style="width: 100px">039999999</td>
              <td style="width: 230px">yoyaku-tokyo1@pvtravel.com</td>
              <td style="width: 230px">yoyaku-tokyo2@pvtravel.com</td>
              <td style="width: 230px">yoyaku-tokyo3@pvtravel.com</td>
              <td style="width: 230px">yoyaku-tokyo4@pvtravel.com</td>
              <td style="width: 230px">yoyaku-tokyo5@pvtravel.com</td>
              <td style="width: 230px">yoyaku-tokyo6@pvtravel.com</td>
              <td style="width: 100px">管轄店</td>
              <td style="width: 100px">有効</td>
              <td style="width: 100px">123456789</td>
              <td style="width: 100px">password</td>
            </tr>
          @endfor
          <tr class="error">
            <td>{{ $i }}</td>
            <td>OSA1</td>
            <td>大阪本社</td>
            <td>PVT0001</td>
            <td>大阪府</td>
            <td>大阪市北区梅田</td>
            <td>2丁目2番22号</td>
            <td>ハービスOSAKA</td>
            <td>039999999</td>
            <td>039999999</td>
            <td>yoyaku-osaka1@pvtravel.com</td>
            <td>yoyaku-osaka2@pvtravel.com</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>管轄店</td>
            <td>有効</td>
            <td>abcdefg</td>
            <td>password</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('sale_management/bundle_input') }}"><button class="back">戻る</button></a>
    <button id="done_btn" class="done">登録処理実行</button>
  </div>
@endsection