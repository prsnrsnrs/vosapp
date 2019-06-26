@extends('layout.base')

@section('title', 'クルーズプラン検索')

@section('style')
  <link href="{{ mix('css/search_plan.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/search_plan.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞クルーズプラン検索
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
    <form class="search_form">
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">クルーズプラン検索条件</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th>商品コード</th>
          <td>
            <input type="text">
          </td>
        </tr>
        <tr>
          <th>出発日</th>
          <td class="calendar">
            <label><input type="text" class="datepicker before_date"></label>
            <p style="display: inline-block; margin: 0 10px">～</p>
            <label><input type="text" class="datepicker after_date"></label>
          </td>
        </tr>
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
          <th>出発地</th>
          <td>
            <select>
              <option value=""></option>
              <option value="1">東京</option>
              <option value="2">横浜</option>
              <option value="3">名古屋</option>
              <option value="4">大阪</option>
              <option value="5">神戸</option>
              <option value="6">博多</option>
              <option value="7">羽田空港</option>
              <option value="8">仙台</option>
              <option value="9">東京駅</option>
              <option value="10">新大阪駅</option>
              <option value="11">小名浜</option>
              <option value="12">名古屋駅</option>
              <option value="13">直江津</option>
              <option value="14">鳥取</option>
              <option value="15">宇部</option>
              <option value="16">博多駅</option>
            </select>
          </td>
        </tr>
        </tbody>
      </table>
      <div>
        <button class="done search">検索</button>
        <div style="float: right">
          <button type="button" id="clearForm" class="back">検索内容をクリア</button>
        </div>
      </div>
    </form>
    <div class="confirm_time">
      <label id="time"></label>
    </div>

    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="16">クルーズプラン検索結果一覧</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width:34%">クルーズ名（コース）</th>
          <th style="width:14%">出発日</th>
          <th style="width:4%">ｽﾃｰﾄ<br>J</th>
          <th style="width:4%">ｽﾃｰﾄ<br>H</th>
          <th style="width:4%">ｽﾃｰﾄ<br>G</th>
          <th style="width:4%">ｽﾃｰﾄ<br>F</th>
          <th style="width:4%">ｽﾃｰﾄ<br>E</th>
          <th style="width:4%">ﾃﾞﾗｯｸｽ</th>
          <th style="width:4%">ｽｲｰﾄ</th>
          <th style="width:4%">ﾛｲﾔﾙ<br>ｽｲｰﾄ<br>B</th>
          <th style="width:4%">ﾛｲﾔﾙ<br>ｽｲｰﾄ<br>A</th>
          <th style="width:4%">予約<br>件数</th>
          <th style="width:6%">処理</th>
        </tr>
        <tr>
          <td>春の日本一周クルーズ</td>
          <td>神戸発<br/>2017/05/08(月)</td>
          <td>-</td>
          <td></td>
          <td>-</td>
          <td></td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td><a href="../sale_reception">5</a></td>
          <td>
            <div>
              <a href="{{ url('reservation/choose_guestroom') }}">
                <button class="add">予約</button>
              </a>
            </div>
            <div>
              <a href="{{ url('capture/select') }}">
                <button class="add">取込</button>
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td>新緑の東北・三陸復興国立公園クルーズ</td>
          <td>神戸発<br/>2017/05/19(金)</td>
          <td>△</td>
          <td>△</td>
          <td>△</td>
          <td>△</td>
          <td>△</td>
          <td>○</td>
          <td>×</td>
          <td>-</td>
          <td>-</td>
          <td><a href="../sale_reception">1</a></td>
          <td>
            <div>
              <a href="{{ url('reservation/choose_guestroom') }}">
                <button class="add">予約</button>
              </a>
            </div>
            <div>
              <a href="{{ url('capture/select') }}">
                <button class="add">取込</button>
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td>初夏の八丈島クルーズ</td>
          <td>神戸発<br/>2017/05/25(木)</td>
          <td>△</td>
          <td>△</td>
          <td>○</td>
          <td>△</td>
          <td>○</td>
          <td>○</td>
          <td>△</td>
          <td>-</td>
          <td>-</td>
          <td><a href="../sale_reception">3</a></td>
          <td>
            <div>
              <a href="{{ url('reservation/choose_guestroom') }}">
                <button class="add">予約</button>
              </a>
            </div>
            <div>
              <a href="{{ url('capture/select') }}">
                <button class="add">取込</button>
              </a>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <table class="default">
        <tr>
          <td colspan="13" class="right">
            〇…空席あり、△…空席わずか、×…満席(キャンセル待ち)、－…受付不可
          </td>
        </tr>
      </table>
        <?php
        $pages = ['1', '2', '3'];
        $all_num = 1000;
        $disp_limit = 10;
        $current_page = request('page', 1);
        $option = ['path' => '/reservation/search_plan'];
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($pages, $all_num, $disp_limit, $current_page, $option);
        ?>
      {{ $paginator }}
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('mypage') }}">
      <button class="back">戻る</button>
    </a>
  </div>

@endsection