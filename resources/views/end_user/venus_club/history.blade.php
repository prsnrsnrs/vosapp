@extends('layout.base')

@section('title', 'ご乗船履歴')

@section('style')
  <link href="{{ mix('css/history.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/history.js') }}"></script>
@endsection
@section('breadcrumb')
  <a href='{{ url("end_user/venus_club/menu") }}'>マイページ</a>＞ご乗船履歴
@endsection
@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('end_user/venus_club/menu') }}">マイページ</a></li>
    <li><a href="{{ url('end_user/venus_club/login') }}">ログアウト</a></li>
  </ul>
@endsection
@section('content')
  <main class="history">
    <form class="search_form">
      <table class="venus">
        <thead>
          <tr>
            <th colspan="2">びいなす倶楽部ご乗船履歴検索条件</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th style="width: 17%">クルーズ名</th>
            <td style="width: 83%">
              <select>
                <option value=""></option>
                <option value="1">春の日本一周クルーズ</option>
                <option value="2">新緑の東北・三陸復興国立公園クルーズ</option>
                <option value="3">初夏の八丈島クルーズ</option>
              </select>
            </td>
          </tr>
          <tr>
            <th>出発日</th>
            <td>
              <label><input type="text" class="datepicker before_date"></label>
              <p style="display: inline-block; margin: 0 10px">～</p>
              <label><input type="text" class="datepicker after_date"></label>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="search_btn">
        <button class="done">検索</button>
        <div style="float: right">
          <button type="button" id="clearForm" class="back">検索内容のクリア</button>
        </div>
      </div>
    </form>
    <?php
      $datas = [
          ['date' => '2016/08/12 12:00', 'name' => '阿波踊りと関門海峡花火クルーズ【Ｂコース】', 'type' => 'G', 'no' => '611', 'nights' => '3', 'sum_nights' => '20'],
          ['date' => '2015/07/12 23:30', 'name' => '大島美の瀬戸内会と音楽会クルーズ', 'type' => 'E', 'no' => '926', 'nights' => '3', 'sum_nights' => '17'],
          ['date' => '2013/05/07 19:00', 'name' => '春の日本一周クルーズ【Ｂコース/神戸発着】', 'type' => 'G', 'no' => '658', 'nights' => '9', 'sum_nights' => '14'],
          ['date' => '2012/06/30 17:00', 'name' => '利尻島・礼文島クルーズ', 'type' => 'G', 'no' => '615', 'nights' => '5', 'sum_nights' => '5'],
      ]
      ?>
    <table class="venus center">
      <thead>
        <tr>
          <th colspan="6">びいなす倶楽部ご乗船履歴一覧</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th style="width: 20%">出発日</th>
          <th style="width: 40%">クルーズ名／商品名</th>
          <th style="width: 10%">客室タイプ</th>
          <th style="width: 10%">客室番号</th>
          <th style="width: 10%">泊数</th>
          <th style="width: 10%">累計泊数</th>
        </tr>
        @foreach($datas as $data)
        <tr>
          <td>{{ $data['date'] }}</td>
          <td>{{ $data['name'] }}</td>
          <td>{{ $data['type'] }}</td>
          <td>{{ $data['no'] }}</td>
          <td>{{ $data['nights'] }}</td>
          <td>{{ $data['sum_nights'] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/venus_club/menu') }}"><button class="back">戻る</button></a>
  </div>
@endsection