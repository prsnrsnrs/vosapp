@extends('layout.base')

@section('title', '販売店新規追加')

@section('style')
  <link href="{{ mix('css/add_newshop.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/add_newshop.js') }}"></script>
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
  <main class="add_newshop">
    <div class="input_shop">
      <table rules="all" class="default">
        <thead>
          <tr>
            <th colspan="4">販売店情報</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">販売店コード<span class="required">※</span></th>
          <td style="width: 35%">
            <input type="text" class="short_text">※半角英数3～7文字
          </td>
          <th style="width: 12%">販売店名<span class="required">※</span></th>
          <td style="width: 35%">
            <input type="text" class="middle_text">
          </td>
        </tr>
        <tr>
          <th>郵便番号<span class="required">※</span></th>
          <td>
            <input type="text" class="short_text">
          </td>
          <th>都道府県<span class="required">※</span></th>
          <td>
            <select>
              <option value="0">北海道</option>
              <option value="1">青森</option>
              <option value="2">岩手</option>
              <option value="3">宮城</option>
              <option value="4">秋田</option>
              <option value="5">山形</option>
              <option value="6">福島</option>
              <option value="7">茨城</option>
              <option value="8">栃木</option>
              <option value="9">群馬</option>
              <option value="10">埼玉</option>
              <option value="11">千葉</option>
              <option value="12">東京</option>
              <option value="13">神奈川</option>
              <option value="14">新潟</option>
              <option value="15">富山</option>
              <option value="16">石川</option>
              <option value="17">福井</option>
              <option value="18">山梨</option>
              <option value="19">長野</option>
              <option value="20">岐阜</option>
              <option value="21">静岡</option>
              <option value="22">愛知</option>
              <option value="23">三重</option>
              <option value="24">滋賀</option>
              <option value="25">京都</option>
              <option value="26">大阪</option>
              <option value="27">兵庫</option>
              <option value="28">奈良</option>
              <option value="29">和歌山</option>
              <option value="30">鳥取</option>
              <option value="31">島根</option>
              <option value="32">岡山</option>
              <option value="33">広島</option>
              <option value="34">山口</option>
              <option value="35">徳島</option>
              <option value="36">香川</option>
              <option value="37">愛媛</option>
              <option value="38">高知</option>
              <option value="39">福岡</option>
              <option value="40">佐賀</option>
              <option value="41">長崎</option>
              <option value="42">熊本</option>
              <option value="43">大分</option>
              <option value="44">宮崎</option>
              <option value="45">鹿児島</option>
              <option value="46">沖縄</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>住所1<span class="required">※</span></th>
          <td colspan="3">
            <input type="text" class="long_text">
          </td>
        </tr>
        <tr>
          <th>住所2<span class="required">※</span></th>
          <td colspan="3">
            <input type="text" class="long_text">
          </td>
        </tr>
        <tr>
          <th>住所3（建物名）</th>
          <td colspan="3">
            <input type="text" class="long_text">
          </td>
        </tr>
        <tr>
          <th>TEL<span class="required">※</span></th>
          <td>
            <input type="text" class="short_text">
          </td>
          <th>FAX<span class="required">※</span></th>
          <td>
            <input type="text" class="short_text">
          </td>
        </tr>
        <tr>
          <th>メールアドレス１<span class="required">※</span></th>
          <td>
            <input type="text" class="middle_text">
          </td>
          <th>メールアドレス２</th>
          <td>
            <input type="text" class="middle_text">
          </td>
        </tr>
        <tr>
          <th>メールアドレス３</th>
          <td>
            <input type="text" class="middle_text">
          </td>
          <th>メールアドレス４</th>
          <td>
            <input type="text" class="middle_text">
          </td>
        </tr>
        <tr>
          <th>メールアドレス５</th>
          <td>
            <input type="text" class="middle_text">
          </td>
          <th>メールアドレス６</th>
          <td>
            <input type="text" class="middle_text">
          </td>
        </tr>
        <tr>
          <th>販売店区分<span class="required">※</span></th>
          <td>
            <input class="radio" type="radio" name="shop_class" value="0" selected>管轄店
            <input class="radio" type="radio" name="shop_class" value="1">一般店
          </td>
          <th>ログイン<span class="required">※</span></th>
          <td>
            <input class="radio" type="radio" name="login" value="0" selected>有効
            <input class="radio" type="radio" name="login" value="1">無効
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>

  <div class="button_bar">
    <a href="{{ url('sale_management/list_shop') }}"><button class="back">戻る</button></a>
    <button class="done register">登録</button>
  </div>
@endsection