@extends('layout.base')

@section('title', '会員情報編集')

@section('style')
  <link href="{{ mix('css/edit.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  <a href='{{ url("end_user/venus_club/menu") }}'>マイページ</a>＞会員情報編集
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
  <main class="edit">
    <table class="venus">
      <thead>
      <tr>
        <th colspan="8">びいなす倶楽部会員情報</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th rowspan="3" class="vertical">お<br>名<br>前</th>
        <th>英字</th>
        <td colspan="6" class="name">
          （姓）<input type="text" value="NAKAGAWA">（名）<input type="text" value="YOSHIO">
        </td>
      </tr>
      <tr>
        <th>漢字</th>
        <td colspan="6" class="name">
          （姓）<input type="text" value="中川">（名）<input type="text" value="善夫">
        </td>
      </tr>
      <tr>
        <th>カナ</th>
        <td colspan="6" class="name">
          （姓）<input type="text" value="ナカガワ">（名）<input type="text" value="ヨシオ">
        </td>
      </tr>
      <tr>
        <th colspan="2">性別</th>
        <td>
          <label><input type="radio" name="sex" checked>男</label><label><input type="radio" name="sex">女</label>
        </td>
        <th colspan="2">生年月日</th>
        <td>
          <select class="year" name="birth_year">
            <option value="0">1991</option>
            <option value="1">1992</option>
            <option value="2">1993</option>
          </select>年
          <select class="month_day" name="birth_month">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>月
          <select class="month_day" name="birth_day">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>日
        </td>
        <th>結婚記念日</th>
        <td>
          <select class="year" name="marry_year">
            <option value="0">1991</option>
            <option value="1">1992</option>
            <option value="2">1993</option>
          </select>年
          <select class="month_day" name="marry_month">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>月
          <select class="month_day" name="marry_day">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>日
        </td>
      </tr>
      <tr>
        <th rowspan="5" class="vertical">住<br>所<br></th>
        <th>郵便番号<span class="required">※</span></th>
        <td colspan="6">
          <input type="name" name="post_number" class="copy_data" value="5201621" style="width: 13%;"/>
          （半角数字、ハイフン不要）
          <button class="default auto_post_number">郵便番号から住所を自動入力する</button>
          　わからない場合は
          <button class="default search_zip">郵便番号検索へ</button>
        </td>
      </tr>
      <tr>
        <th>都道府県</th>
        <td colspan="6">
          <select style="width: 17%;" class="copy_data" name="prefectures">
            <option value="滋賀">滋賀</option>
            <option value="大阪">大阪</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>市区町村まで</th>
        <td colspan="6">
          <input type="name" name="city" class="copy_data" value="高島市今津町今津" style="width: 61%;"
                 placeholder="例）大阪市北区梅田"/>
        </td>
      </tr>
      <tr>
        <th>番地以降</th>
        <td colspan="6"><input type="text" name="lot_number" class="copy_data" value="１ー２３４－５" style="width: 61%;"
                               placeholder="例）２－５－２５"/>
        </td>
      </tr>
      <tr>
        <th>建物名</th>
        <td colspan="6"><input type="text" name="building" class="copy_data" value="びわこハイツ301" style="width: 61%;"
                               placeholder="例）ハービスOSAKA1502号室"/>
        </td>
      </tr>
      <tr>
        <th colspan="2">電話番号1<span class="required">※</span></th>
        <td colspan="6">
          <input name="tel_1" class="copy_data" value="09000000000" style="width: 20%;"/>（ハイフン不要）
          <label><input type="radio" name="radio_tel_1">携帯</label>
          <label><input type="radio" name="radio_tel_1">自宅</label>
          <p class="danger">※携帯電話をお持ちの方は携帯電話番号を入力してください</p>
        </td>
      </tr>
      <tr>
        <th colspan="2">電話番号2</th>
        <td colspan="6">
          <input type="tel" name="tel_2" class="copy_data" value="08000000000" style="width: 20%;"/>（ハイフン不要）
          <label><input type="radio" name="radio_tel_2">携帯</label>
          <label><input type="radio" name="radio_tel_2">自宅</label>
        </td>
      </tr>
      <tr>
        <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
        <th>お名前<span class="required">※</span></th>
        <td><input type="text" name="contact_name" class="copy_data" value="中川　小太郎"/></td>
        <th colspan="2">お名前カナ<span class="required">※</span></th>
        <td><input type="text" name="contact_name_ruby" class="copy_data" value="ナカガワ　ショウタロウ"/></td>
        <th>続柄<span class="required">※</span></th>
        <td><input type="text" name="relationship"/></td>
      </tr>
      <tr>
        <th>電話番号<span class="required">※</span></th>
        <td colspan="6">
          <input type="tel" name="tel_2" class="copy_data" value="08000000000" style="width: 20%;"/>（ハイフン不要）
          <label><input type="radio" name="radio_urgency">携帯</label>
          <label><input type="radio" name="radio_urgency">自宅</label>
          <p class="danger">※緊急時に連絡が取れる番号を入力してください。</p>
        </td>
      </tr>
      <tr>
        <th colspan="2">国籍<span class="required">※</span></th>
        <td>
          <select class="copy_data" name="cuntory">
            <option value="0" selected>日本</option>
            <option value="1">アメリカ</option>
            <option value="2">フランス</option>
          </select>
        </td>
        <th rowspan="2" style="width: 4%; padding: 0 9px;">旅<br>券</th>
        <th>番号</th>
        <td><input type="text" name="contact_no"/></td>
        <th>発給地</th>
        <td>
          <select>
            <option>日本</option>
          </select>
        </td>
      </tr>
      <tr>
        <th colspan="2">居住国</th>
        <td>
          <select class="copy_data" name="cuntory">
            <option value="0" selected>日本</option>
            <option value="1">アメリカ</option>
            <option value="2">フランス</option>
          </select>
        </td>
        <th>発給日</th>
        <td>
          <select class="year" name="birth_year">
            <option value="0">2015</option>
            <option value="1">2016</option>
            <option value="2">2017</option>
          </select>年
          <select class="month_day" name="birth_month">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>月
          <select class="month_day" name="birth_day">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>日
        </td>
        <th>失効日</th>
        <td>
          <select class="year" name="birth_year">
            <option value="0">2025</option>
            <option value="1">2026</option>
            <option value="2">2027</option>
          </select>年
          <select class="month_day" name="birth_month">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>月
          <select class="month_day" name="birth_day">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>日
        </td>
      </tr>
      <tr>
        <th colspan="2">ネット予約リンクID</th>
        <td colspan="6">123456789</td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/venus_club/confirm') }}"><button class="back">戻る</button></a>
    <a href="{{ url('end_user/venus_club/menu') }}"><button class="done">登録</button></a>
  </div>
@endsection