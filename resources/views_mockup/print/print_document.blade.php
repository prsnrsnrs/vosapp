@extends('layout.base')

@section('title', '乗船券控えと各種確認書の印刷画面')

@section('style')
  <link href="{{ mix('css/print_document.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/print_document.js')}}"></script>
@endsection
@section('breadcrumb')
  <a href='{{ url("mypage") }}'>マイページ</a>＞乗船券控えと各種確認書の印刷
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
  <main class="print_document">
    <form class="search_form">
      <table class="default">
        <thead>
          <tr>
            <th colspan="2">乗船券控えと各種確認書の印刷検索条件</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">出発日</th>
          <td style="width: 85%">
            <label><input type="text" class="datepicker before_date"></label>
            <p style="display: inline-block; margin: 0 10px">～</p>
            <label><input type="text" class="datepicker after_date"></label>
          </td>
        </tr>
        <tr>
          <th>クルーズ名（コース）</th>
          <td>
            <select name="cruise_name">
              <option value=""></option>
              <option value="1">春の日本一周クルーズ　Aコース</option>
              <option value="2">春の日本一周クルーズ　Bコース</option>
              <option value="3">新緑の東北・三陸復興国立公園クルーズ</option>
              <option value="4">初夏の八丈島クルーズ</option>
            </select>
          </td>
        </tr>
        </tr>
        <tr class="number">
          <th>予約番号</th>
          <td><input type="text" class="text"></td>
        </tr>
        <tr class="boatmember">
          <th>乗船者名</th>
          <td><input type="text" class="text">（部分一致）</td>
        </tr>
        </tbody>
      </table>
      <div class="search_btn">
        <button class="done">検索</button>
        <div style="float: right">
          <button type="button" id="clearForm" class="back">検索内容をクリア</button>
        </div>
      </div>
    </form>
      <?php
      $passengers = [
          ['res' => 123456789, 'no' => 1, 'human_type' => '大人',
              'name' => 'NAKAGAWA YOSHIO', 'name_knj' => '中川　善夫',
              'gender' => '男', 'age' => 44, 'status' => 'HK',
              'print1' => '○', 'print2' => '○', 'print3' => '○', 'print4' => '-'],
          ['res' => 123456789, 'no' => 2, 'human_type' => '大人',
              'name' => 'NAKAGAWA TARO', 'name_knj' => '中川　太郎',
              'gender' => '男', 'age' => 15, 'status' => 'HK',
              'print1' => '○', 'print2' => '○', 'print3' => '○', 'print4' => '-'],
          ['res' => 123456789, 'no' => 3, 'human_type' => '大人',
              'name' => 'NAKAGAWA HANAKO', 'name_knj' => '中川　花子',
              'gender' => '女', 'age' => 44, 'status' => 'HK',
              'print1' => '○', 'print2' => '○', 'print3' => '○', 'print4' => '-'],
          ['res' => 123456789, 'no' => 4, 'human_type' => '小人',
              'name' => 'NAKAGAWA KOHANA', 'name_knj' => '中川　小花',
              'gender' => '女', 'age' => 10, 'status' => 'HK',
              'print1' => '○', 'print2' => '○', 'print3' => '○', 'print4' => '-'],
          ['res' => 123456789, 'no' => 5, 'human_type' => '幼児',
              'name' => 'NAKAGAWA YOJI', 'name_knj' => '中川　洋二',
              'gender' => '男', 'age' => 1, 'status' => 'HK',
              'print1' => '○', 'print2' => '○', 'print3' => '○', 'print4' => '-'],
          ['res' => 123456789, 'no' => 1, 'human_type' => '大人',
              'name' => 'KONDO MASAYA', 'name_knj' => '近藤　雅也',
              'gender' => '男', 'age' => 36, 'status' => 'CX',
              'print1' => '-', 'print2' => '-', 'print3' => '-', 'print4' => '○'],
          ['res' => 123456789, 'no' => 1, 'human_type' => '大人',
              'name' => 'UEMURA TETSUYA', 'name_knj' => '上村　哲也',
              'gender' => '男', 'age' => 32, 'status' => 'HK',
              'print1' => '-', 'print2' => '○', 'print3' => '○', 'print4' => '-'],
      ];
      ?>
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
          <tr>
            <th colspan="12">乗船券控えと各種確認書の印刷検索一覧</th>
          </tr>
          <tr class="data_title">
            <th rowspan="2" style="width: 20px">
              <label>
                <input name="all_check" type="checkbox" class="check_style"/>
                <span class="checkbox"></span>
              </label>
            </th>
            <th rowspan="2" style="width: 110px">予約番号</th>
            {{--<th rowspan="2" style="width: 25px">No</th>--}}
            <th rowspan="2" style="width: 60px">大小幼</th>
            <th rowspan="2" style="width: 230px">乗船者名</th>
            <th rowspan="2" style="width: 40px">性別</th>
            <th rowspan="2" style="width: 40px">年齢</th>
            <th rowspan="2" style="width: 104px">ｽﾃｰﾀｽ</th>
            <th colspan="4" style="width: 460px">印刷可能な乗船券控えと各種確認書</th>
          </tr>
          <tr class="data_title">
            <th style="width: 115px">乗船券控え</th>
            <th style="width: 115px">予約確認書</th>
            <th style="width: 115px">予約内容確認書</th>
            <th style="width: 115px">取消記録確認書</th>
          </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < 10; $i++)
        @foreach ($passengers as $passenger)
        <tr>
          <td style="width: 20px">
            <label>
              <input type="checkbox" class="check_style move_check"/>
              <span class="checkbox"></span>
            </label>
          </td>
          <td style="width: 110px"><a href="{{ url('reservation/order_detail') }}">{{ $passenger['res'] }}</a></td>
          {{--<td style="width: 25px">{{ $passenger['no'] }}</td>--}}
          <td style="width: 60px">{{ $passenger['human_type'] }}</td>
          <td style="width: 230px">{{ $passenger['name'] }}<br>{{ $passenger['name_knj'] }}</td>
          <td style="width: 40px">{{ $passenger['gender'] }}</td>
          <td style="width: 40px">{{ $passenger['age'] }}</td>
          <td style="width: 104px">{{ $passenger['status'] }}</td>
          <td style="width: 115px">{{ $passenger['print1'] }}</td>
          <td style="width: 115px">{{ $passenger['print2'] }}</td>
          <td style="width: 115px">{{ $passenger['print3'] }}</td>
          <td style="width: 115px">{{ $passenger['print4'] }}</td>
        </tr>
        @endforeach
        @endfor
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('mypage') }}"><button class="back">戻る</button></a>
    <a href="{{ url('pdf/ticket') }}" target="_blank"><button class="add">乗船券控え印刷</button></a>
    <a href="{{ url('pdf/reservation') }}" target="_blank"><button class="add">予約確認書印刷</button></a>
    <a href="{{ url('pdf/detail') }}" target="_blank"><button class="add">予約内容確認書印刷</button></a>
    <a href="{{ url('pdf/delete') }}" target="_blank"><button class="add">取消記録確認書印刷</button></a>
  </div>
@endsection