@extends('layout.base')

@section('title', '割引券情報照会')

@section('style')
  <link href="{{ mix('css/discount_ticket.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/discount_ticket.js') }}"></script>
@endsection
@section('breadcrumb')
  <a href='{{ url("end_user/venus_club/menu") }}'>マイページ</a>＞割引券情報照会
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
          <th colspan="2">びいなす倶楽部割引券情報検索条件</th>
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
          ['date' => '2015/07/12', 'name' => '多島美の瀬戸内会と音楽会クルーズ', 'type' => 'クルーズ割引券',
              'no' => 'C9999999', 'money' => '15,000', 'effective' => '2016/07/15', 'use' => ''],
          ['date' => '2013/05/07', 'name' => '春の日本一周クルーズ', 'type' => 'クルーズ割引券',
              'no' => 'C9999999', 'money' => '25,000', 'effective' => '2014/05/16', 'use' => '多島美の瀬戸内会を音楽会クルーズ'],
          ['date' => '2012/06/30', 'name' => '利尻島・礼文島クルーズ', 'type' => 'クルーズ割引券',
              'no' => 'C9999999', 'money' => '15,000', 'effective' => '2013/07/05', 'use' => '有効期限切れ'],
      ]
      ?>
    <table class="venus center">
      <thead>
      <tr>
        <th colspan="7">びいなす倶楽部割引券情報</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th style="width: 10%">出発日</th>
        <th style="width: 25%">クルーズ名称</th>
        <th style="width: 10%">割引券種類</th>
        <th style="width: 10%">割引券番号</th>
        <th style="width: 10%">金額</th>
        <th style="width: 10%">有効期限</th>
        <th style="width: 25%">使用クルーズ</th>
      </tr>
      @foreach($datas as $data)
        <tr>
          <td>{{ $data['date'] }}</td>
          <td>{{ $data['name'] }}</td>
          <td>{{ $data['type'] }}</td>
          <td>{{ $data['no'] }}</td>
          <td class="right">{{ $data['money'] }}</td>
          <td>{{ $data['effective'] }}</td>
          <td>{{ $data['use'] }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/venus_club/menu') }}"><button class="back">戻る</button></a>
  </div>
@endsection