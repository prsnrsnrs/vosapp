@extends('layout.base')

@section('title', '販売店一覧')

@section('style')
  <link href="{{ mix('css/list_shop.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/list_shop.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞販売店一覧
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
  <main class="list_shop">
    <form class="search_form">
      <table class="default">
        <thead>
          <tr>
            <th colspan="2">販売店一覧検索条件</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 10%">区分</th>
          <td style="width: 90%">
            <label>
              <input type="checkbox" class="check_style">
              <span class="checkbox"></span>管轄店
            </label>

            <label>
              <input type="checkbox" class="check_style">
              <span class="checkbox"></span>一般店
            </label>
          </td>
        </tr>
        <tr>
          <th>販売店名</th>
          <td>
            <input type="text" class="shop_name">(部分一致)
          </td>
        </tr>
        </tbody>
      </table>
      <div class="middle_button">
        <button class="done">検索</button>
        <div style="float: right">
          <button type="button" id="clearForm" class="back">検索内容をクリア</button>
        </div>
      </div>
    </form>
    <div class="button_menu">
      <a href="{{ url('sale_management/add_newshop') }}">
        <button class="add">販売店追加</button>
      </a>
      <a href="{{ url('sale_management/bundle_input') }}"><button class="add" style="float: right">複数一括登録</button></a>
    </div>
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
          <tr>
            <th colspan="10">販売店一覧</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width:8%">販売店コード</th>
          <th style="width:16%">販売店名</th>
          <th style="width:12%">TEL</th>
          <th style="width:6%">区分</th>
          <th style="width:6%">ログイン</th>
          <th style="width:15%">販売店ログインID</th>
          <th style="width:16%">ユーザ数</th>
          <th style="width:7%"></th>
          <th style="width:7%"></th>
          <th style="width:7%"></th>
        </tr>
        <tr>
          <td>OSA1</td>
          <td>大阪本社</td>
          <td>06-6345-3881</td>
          <td>管轄店</td>
          <td>有効</td>
          <td>PVT0001OSA1</td>
          <td>3</td>
          <td>
            <a href="{{ url('sale_management/info_shop_user') }}">
              <button class="show add">表示
              </button>
            </a>
          </td>
          <td>
            <a href="{{ url('sale_management/add_newshop') }}">
              <button class="edit">変更</button>
            </a>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td>TKY1</td>
          <td>東京支店</td>
          <td>03-9999-9999</td>
          <td>一般店</td>
          <td>有効</td>
          <td>PVT0001TKY1</td>
          <td>2</td>
          <td>
            <a href="{{ url('sale_management/info_shop_user') }}">
              <button class="show add">表示
              </button>
            </a>
          </td>
          <td>
            <a href="{{ url('sale_management/add_newshop') }}">
              <button class="edit">変更</button>
            </a>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td>NGO1</td>
          <td>名古屋支店</td>
          <td>052-999-9999</td>
          <td>一般店</td>
          <td>有効</td>
          <td>PVT0001NGO1</td>
          <td>1</td>
          <td>
            <a href="{{ url('sale_management/info_shop_user') }}">
              <button class="show add">表示
              </button>
            </a>
          </td>
          <td>
            <a href="{{ url('sale_management/add_newshop') }}">
              <button class="edit">変更</button>
            </a>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td>SAP1</td>
          <td>札幌予約センター</td>
          <td>011-999-9999</td>
          <td>一般店</td>
          <td>無効</td>
          <td>PVT0001SAP1</td>
          <td>1</td>
          <td>
            <a href="{{ url('sale_management/info_shop_user') }}">
              <button class="show add">表示
              </button>
            </a>
          </td>
          <td>
            <a href="{{ url('sale_management/add_newshop') }}">
              <button class="edit">変更</button>
            </a>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <?php
    $pages = ['1', '2', '3'];
    $all_num = 1000;
    $disp_limit = 10;
    $current_page = request('page', 1);
    $option = ['path' => '/sale_management/list_shop'];
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($pages, $all_num, $disp_limit, $current_page, $option);
    ?>
  {{ $paginator }}
  </main>
  <div class="button_bar">
    <a href="{{ url('mypage') }}">
      <button class="back">戻る</button>
    </a>
  </div>
@endsection