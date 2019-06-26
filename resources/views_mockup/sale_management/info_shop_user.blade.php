@extends('layout.base')

@section('title', '販売店情報＆ユーザ情報')

@section('style')
  <link href="{{ mix('css/info_shop_user.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/info_shop_user.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('sale_management/list_shop') }}">販売店一覧</a>＞販売店情報
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
  <main class="info_shop_user">
    <div class="area">
      <table class="default shop_table">
        <thead>
         <tr>
           <th colspan="4">販売店情報<label class="folding"><a href="#" class="asc"></a></label></th>
         </tr>
        </thead>
        <tbody>
          <tr>
            <th style="width: 15%">販売店コード</th>
            <td style="width: 35%">TKY1</td>
            <th style="width: 15%">販売店名</th>
            <td style="width: 35%">東京支店</td>
          </tr>
          <tr>
            <th>郵便番号</th>
            <td>1000011</td>
            <th>都道府県</th>
            <td>東京都</td>
          </tr>
          <tr>
            <th>住所１</th>
            <td colspan="3">千代田区内幸町</td>
          </tr>
          <tr>
            <th>住所２</th>
            <td colspan="3">1-1-7</td>
          </tr>
          <tr>
            <th>住所３</th>
            <td colspan="3">NBF日比谷ビル22階</td>
          </tr>
          <tr>
            <th>TEL</th>
            <td>0399999999</td>
            <th>FAX</th>
            <td>0399999999</td>
          </tr>
          <tr>
            <th>メールアドレス１</th>
            <td>yoyaku-tokyo1@pvtravel.com</td>
            <th>メールアドレス２</th>
            <td>yoyaku-tokyo2@pvtravel.com</td>
          </tr>
          <tr>
            <th>メールアドレス３</th>
            <td>yoyaku-tokyo3@pvtravel.com</td>
            <th>メールアドレス４</th>
            <td>yoyaku-tokyo4@pvtravel.com</td>
          </tr>
          <tr>
            <th>メールアドレス５</th>
            <td>yoyaku-tokyo5@pvtravel.com</td>
            <th>メールアドレス６</th>
            <td>yoyaku-tokyo6@pvtravel.com</td>
          </tr>
          <tr>
            <th>販売店区分</th>
            <td>一般店</td>
            <th>ログイン</th>
            <td>有効</td>
          </tr>
          <tr>
            <th>販売店ログインID</th>
            <td>PVT0001TKY1</td>
            <th>ユーザー数</th>
            <td>3（管理者：1　一般：2）</td>
          </tr>
        </tbody>
      </table>
      <table class="default user_table hover_rows">
        <thead>
        <tr>
          <th colspan="10">販売店ユーザー情報</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 12%">ユーザーID</th>
          <th style="width: 16%">ユーザー名称</th>
          <th style="width: 7%">区分</th>
          <th style="width: 7%">ﾛｸﾞｲﾝ</th>
          <th style="width: 12%">最終ﾛｸﾞｲﾝ日</th>
          <th style="width: 12%">登録日</th>
          <th style="width: 12%">変更日</th>
          <th style="width: 10%">パスワード</th>
          <th style="width: 12%" colspan="2">処理</th>
        </tr>
        <tr>
          <td>pvadmin555</td>
          <td>管理者</td>
          <td>管理者</td>
          <td>有効</td>
          <td>2017/03/28<br>12:22</td>
          <td>2017/02/25<br>11:28</td>
          <td>2017/01/15<br>13:55</td>
          <td>
            <button class="default pw_reset">再設定</button>
          </td>
          <td>
            <a href="{{ url('sale_management/change_user') }}"><button class="edit">変更</button></a>
          </td>
          <td>
            <button type="submit" class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td>pvuser111</td>
          <td>一般ユーザー1</td>
          <td>一般</td>
          <td>有効</td>
          <td>2017/02/25<br>17:05</td>
          <td>2017/01/04<br>11:28</td>
          <td>2017/02/05<br>10:55</td>
          <td>
            <button class="default pw_reset">再設定</button>
          </td>
          <td>
            <a href="{{ url('sale_management/change_user') }}"><button class="edit">変更</button></a>
          </td>
          <td>
            <button type="submit" class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td>pvuser222</td>
          <td>一般ユーザー2</td>
          <td>一般</td>
          <td>有効</td>
          <td>2017/03/05<br>12:50</td>
          <td>2017/01/04<br>11:51</td>
          <td>2017/02/05<br>10:35</td>
          <td>
            <button class="default pw_reset">再設定</button>
          </td>
          <td>
            <a href="{{ url('sale_management/change_user') }}"><button class="edit">変更</button></a>
          </td>
          <td>
            <button type="submit" class="delete row_delete">削除</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>

  <div class="button_bar">
    <button class="back" onclick="location.href='../mypage'">戻る</button>
    <button class="add" onclick="location.href='./create_user'">ユーザー追加</button>
  </div>
@endsection