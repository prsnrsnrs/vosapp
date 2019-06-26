@extends('layout.base')

@section('title', 'ご連絡一覧')

@section('style')
  <link href="{{ mix('css/contact_list.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/contact_list.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞ご連絡一覧
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
  <main class="contact_list">
    <form class="search_form">
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">日本クルーズ客船からのご連絡一覧検索条件</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 20%">分類</th>
          <td style="width: 80%">
            <label>
              <input type="checkbox" class="check_style" name="status">
              <span class="checkbox"></span>回答要
            </label>
            <label>
              <input type="checkbox" class="check_style" name="status">
              <span class="checkbox"></span>回答不要
            </label>
            <label>
              <input type="checkbox" class="check_style" name="status">
              <span class="checkbox"></span>ご案内
            </label>
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
          <th>クルーズ名（コース）</th>
          <td>
            <select name="cruise_name">
              <option value=""></option>
              <option value="1">春の日本一周クルーズ</option>
              <option value="2">新緑の東北・三陸復興国立公園クルーズAコース</option>
              <option value="3">新緑の東北・三陸復興国立公園クルーズBコース</option>
              <option value="4">初夏の八丈島クルーズ</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>予約番号</th>
          <td>
            <input type="text" class="middle_text">
          </td>
        </tr>
        <tr>
          <th>代表者お名前</th>
          <td>
            <input type="text" class="long_text">(部分一致)
          </td>
        </tr>
        <tr>
          <th>販売店区分</th>
          <td>
            <label>
              <input type="radio" class="check_style" name="sales_shop">
              <span class="checkbox"></span>すべての販売店
            </label>
            <label>
              <input type="radio" class="check_style" name="sales_shop">
              <span class="checkbox"></span>自販売店のみ
            </label>
            <label>
          </td>
        </tr>
        </tbody>
      </table>
      <div class="search_btn">
        <button class="done">検索</button>
        <label class="search_warning">※既読連絡の保存期間はクルーズ終了後１ヶ月です。それを過ぎると自動的に削除されます。</label>
        <div style="float: right">
          <button type="button" id="clearForm" class="back">検索内容をクリア</button>
        </div>
      </div>
    </form>
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="8">日本クルーズ客船からのご連絡一覧</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width:7%" rowspan="2">分類</th>
          <th style="width:10%" rowspan="2" class="dothesort"><a href="#" class="sort desc">ご連絡日時</a></th>
          <th colspan="4">ご連絡対象</th>
          <th style="width:25%" rowspan="2" class="subject">件名</th>
        </tr>
        <tr>
          <th style="width:27%">クルーズ名（コース）</th>
          <th style="width:12%" class="dothesort"><a href="#" class="sort">出発日</a></th>
          <th style="width:7%">予約番号</th>
          <th style="width:15%">代表者お名前</th>
        </tr>
        <tr class="sort_item">
          <td>
            <label class="icon delete">回答要</label>
          </td>
          <td>02/23 12：34</td>
          <td>春の日本一週クルーズAコース</td>
          <td>神戸発<br>2017年5月10日(月)</td>
          <td><a href="{{ url('reservation/order_detail') }}">1234567</a></td>
          <td><div>NAKAGAWA　YOSHIO</div><div>中川　善夫</div></td>
          <td><a href="{{ url('contact/contact_detail') }}">客室リクエストについて</a></td>
        <tr>
        <tr class="sort_item">
          <td>
            <label class="icon success">回答不要</label>
          </td>
          <td>02/23 11：15</td>
          <td>新緑の東北・三陸復興国立公園クルーズBコース</td>
          <td>神戸発<br>2017年5月10日(月)</td>
          <td><a href="{{ url('reservation/order_detail') }}">1234567</a></td>
          <td><div>KONDO MASAYA</div><div>近藤　政也</div></td>
          <td><a href="{{ url('contact/contact_detail') }}">キャビンリクエストについて</a></td>
        </tr>
        <tr class="sort_item">
          <td>
            <label class="icon add">ご案内</label>
          </td>
          <td>02/23 11：15</td>
          <td>春の日本一週クルーズAコース</td>
          <td>神戸発<br>2017年5月10日(月)</td>
          <td>－</td>
          <td>－</td>
          <td><a href="{{ url('contact/contact_detail') }}">乗船券の印刷が可能になりました</a></td>
        </tr>
        <tr class="sort_item">
          <td>
            <label class="icon add">ご案内</label>
          </td>
          <td>02/23 13：15</td>
          <td>春の日本一週クルーズAコース</td>
          <td>神戸発<br>2017年5月10日(月)</td>
          <td><a href="{{ url('reservation/order_detail') }}">1234567</a></td>
          <td><div>UEMURA TETHUYA</div><div>上村　哲也</div></td>
          <td><a href="{{ url('contact/contact_detail') }}">割引券番号を確認して下さい</a></td>
        </tr>
        </tbody>
      </table>
        <?php
        $pages = ['1', '2', '3'];
        $all_num = 1000;
        $disp_limit = 10;
        $current_page = request('page', 1);
        $option = ['path' => '/contact/contact_list'];
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