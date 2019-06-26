@extends('layout.base')

@section('title', '受付一覧')

@section('style')
  <link href="{{ mix('css/sale_reception.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/sale_reception.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞受付一覧
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
<?php $error = false; ?>
@section('content')
  <main>
    @if($error)
      @include('include/info', ['info' => 'errorMessage'])
    @endif
    <form class="search_form">
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">
            受付一覧検索条件
          </th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width:20%">出発日</th>
          <td style="width:80%" class="calendar">
            <label><input class="datepicker before_date"></label>
            <p style="display: inline-block; margin: 0 10px">～</p>
            <label><input class="datepicker after_date"></label>
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
        <tr class="number">
          <th>予約番号</th>
          <td><input type="text" class="text"></td>
        </tr>
        <tr>
          <th>代表者名</th>
          <td><input type="text" class="text" style="width: 19em">（部分一致）</td>
        </tr>
        <tr>
          <th>ｽﾃｰﾀｽ</th>
          <td>
            <label>
              <input type="checkbox" class="check_style" name="status"/>
              <span class="checkbox"></span>
              HK
            </label>
            <label>
              <input type="checkbox" class="check_style" name="status"/>
              <span class="checkbox"></span>
              WT
            </label>
            <label style="width: auto">
              <input type="checkbox" class="check_style" name="status"/>
              <span class="checkbox"></span>
              CX
            </label>
          </td>
        </tr>
        <tr>
          <th>詳細入力</th>
          <td>
            <label>
              <input type="checkbox" class="check_style" name="detail"/>
              <span class="checkbox"></span>
              未
            </label>
            <label>
              <input type="checkbox" class="check_style" name="detail"/>
              <span class="checkbox"></span>
              済
            </label>
          </td>
        </tr>
        <tr>
          <th>提出書類</th>
          <td>
            <label>
              <input type="checkbox" class="check_style" name="document"/>
              <span class="checkbox"></span>
              未
            </label>
            <label>
              <input type="checkbox" class="check_style" name="document"/>
              <span class="checkbox"></span>
              済
            </label>
          </td>
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
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="11">株式会社PVトラベル／東京支店　様の受付一覧</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 6%">受付<br>日時</th>
          <th style="width: 8%">予約番号</th>
          <th style="width: 25%">クルーズ名（コース）</th>
          <th style="width: 13%">出発日</th>
          <th style="width: 17%">代表者名</th>
          <th style="width: 5%">ｽﾃｰﾀｽ</th>
          <th style="width: 5%">詳細<br>入力</th>
          <th style="width: 5%">提出<br>書類</th>
          <th style="width: 5%">ご連絡</th>
          <th style="width: 5%">印刷</th>
          <th style="width: 6%">ｸﾞﾙｰﾌﾟ</th>
        </tr>
        <tr>
          <td>02/23<br>12:34</td>
          <td><a href="{{ url('reservation/order_detail') }}">123456789</a></td>
          <td>春の日本一周クルーズＡコース</td>
          <td>神戸発<br>2017年5月8日(月)</td>
          <td><div>NAKAGAWA YOSHIO</div><div>中川　善夫</div></td>
          <td>HK</td>
          <td>済</td>
          <td class="still">末</td>
          <td><a href="{{ url('contact/contact_list') }}">5</a></td>
          <td>
            <a href="{{ url('print/print_document') }}">
              <button class="add">印刷</button>
            </a>
          </td>
          <td class="new_group_button">
              <button class="default new_group">未設定</button>
          </td>
        </tr>
        <tr class="waiting">
          <td>02/23<br>11:15</td>
          <td><a href="{{ url('reservation/order_detail') }}">123456785</a></td>
          <td>春の日本一周クルーズＡコース</td>
          <td>神戸発<br>2017年5月8日(月)</td>
          <td>KONDO MASAYA<br>近藤　雅也</td>
          <td>WT</td>
          <td>済</td>
          <td>済</td>
          <td><a href="{{ url('contact/contact_list') }}">2</a></td>
          <td><a href="{{ url('print/print_document') }}">
              <button class="add">印刷</button>
            </a></td>
          <td>
            <button class="success edit_group">設定済</button>
          </td>
        </tr>
        <tr class="cancel">
          <td>02/25<br>16:45</td>
          <td><a href="{{ url('contact/contact_list') }}">123456786</a></td>
          <td>春の日本一周クルーズＡコース</td>
          <td>神戸発<br>2017年5月8日(月)</td>
          <td>UEMURA TETUYA<br>上村　哲也</td>
          <td>CX</td>
          <td>-</td>
          <td>-</td>
          <td><a href="{{ url('contact/contact_list') }}">3</a></td>
          <td><a href="{{ url('print/print_document') }}">
              <button class="add">印刷</button>
            </a></td>
          <td></td>
        </tr>
        </tbody>
      </table>
    </div>

      <?php
      $pages = ['1', '2', '3'];
      $all_num = 1000;
      $disp_limit = 10;
      $current_page = request('page', 1);
      $option = ['path' => '/sale_reception'];
      $paginator = new \Illuminate\Pagination\LengthAwarePaginator($pages, $all_num, $disp_limit, $current_page, $option);
      ?>
    {{ $paginator }}
  </main>
  <div class="button_bar">
    <a href="{{ url('mypage') }}">
      <button class="back">戻る</button>
    </a>
  </div>

  <!-- モーダル部分 -->
  <div id="modal_contents" style="width: 835px">
    <div class="modal_title">グループ設定<div class="close">×</div></div>
    <table class="default">
      <tbody class="center">
      <tr>
        <th style="width: 11%">受付<br>日時</th>
        <th style="width: 12%">予約番号</th>
        <th style="width: 35%">クルーズ名（コース）</th>
        <th style="width: 14%">出発日</th>
        <th style="width: 20%">代表者名</th>
        <th style="width: 8%">ｽﾃｰﾀｽ</th>
      </tr>
      <tr>
        <td>02/23<br>12:34</td>
        <td>123456789</td>
        <td class="left">
          春の日本一周クルーズＡコース
        </td>
        <td class="left">
          神戸発<br>
          2017年5月8日(月)
        </td>
        <td class="left"><div>NAKAGAWA YOSHIO</div><div>中川　善夫</div></td>
        <td>HK</td>
      </tr>
      </tbody>
    </table>

      <?php
      $cruises = [
          ['accept_date' => '02/23', 'accept_time' => '12:34', 'res' => 123456789, 'cruise' => '春の日本一周クルーズ',
              'course' => 'Ａコース', 'cruise_date' => '2017年5月8日(月)', 'cruise_term' => '神戸発',
              'represent' => 'NAKAGAWA YOSHIO', 'name' => '中川　善夫', 'status' => 'HK'],
          ['accept_date' => '02/23', 'accept_time' => '11:15',  'res' => 123456789, 'cruise' => '春の日本一周クルーズ',
              'course' => 'Ａコース', 'cruise_date' => '2017年5月8日(月)', 'cruise_term' => '神戸発',
              'represent' => 'KONDO MASAYA', 'name' => '近藤　雅也', 'status' => 'WT'],
          ['accept_date' => '02/25', 'accept_time' => '16:45',  'res' => 123456789, 'cruise' => '春の日本一周クルーズ',
              'course' => 'Ａコース', 'cruise_date' => '2017年5月8日(月)', 'cruise_term' => '神戸発',
              'represent' => 'UEMURA TETUYA', 'name' => '上村　哲也', 'status' => 'HK'],
      ];
      ?>

    <div class="group_list">
      <table class="default" style="width: 835px">
        <thead class="center" style="width: 816px">
        <tr class="list_title">
          <th style="width: 25px">
            <label>
              <input name="all_check" type="checkbox" class="check_style"/>
              <span class="checkbox"></span>
            </label>
          </th>
          <th style="width: 50px">受付<br>日時</th>
          <th style="width: 90px">予約番号</th>
          <th style="width: 280px">クルーズ名（コース）</th>
          <th style="width: 105px">出発日</th>
          <th style="width: 150px">代表者名</th>
          <th style="width: 35px">ｽﾃｰﾀｽ</th>
        </tr>
        </thead>
        <tbody class="center">
        @for ($i = 0; $i < 10; $i++)
          @foreach ($cruises as $cruise)
            <tr class="list_foot">
              <td style="width: 25px">
                <label>
                  <input type="checkbox" class="check_style move_check"/>
                  <span class="checkbox"></span>
                </label>
              </td>
              <td style="width: 50px">{{ $cruise['accept_date'] }}<br>{{ $cruise['accept_time'] }}</td>
              <td style="width: 90px">{{ $cruise['res'] }}</td>
              <td style="width: 280px" class="left">{{ $cruise['cruise'] }}{{ $cruise['course'] }}</td>
              <td style="width: 105px" class="left">{{ $cruise['cruise_term'] }}<br>{{ $cruise['cruise_date'] }}</td>
              <td style="width: 150px" class="left">
                <div>{{ $cruise['represent'] }}</div><div>{{ $cruise['name'] }}</div>
              </td>
              <td style="width: 35px">{{ $cruise['status'] }}</td>
            </tr>
          @endforeach
         @endfor
        </tbody>
      </table>

      <div class="button_bar_group">
        <button class="delete" id="cancel_button">キャンセル</button>
        <button class="done group_new">設定</button>
        <button class="done group_new">グループを抜ける</button>
      </div>
    </div>
  </div>

@endsection