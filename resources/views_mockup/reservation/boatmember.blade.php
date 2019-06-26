@extends('layout.base')

@section('title', 'ご乗船者詳細入力')

@section('style')
  <link href="{{ mix('css/boatmember.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/boatmember.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/order_detail') }}">予約照会</a>＞詳細入力
@endsection
@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('mypage/') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="boatmember" id="top">

    @include('include/course',['menu_display' => false])
    @include('include/info', [
    'info' => 'ご乗船されるお客様の詳細な情報を入力して下さい。'])

    <div class="wizard">
      <ul>
        <li class="current">①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

    <table class="default customer_list">
      <tbody>
      <tr>
        <th style="width:10%">入力</th>
        <th style="width:10%">No.</th>
        <th style="width:10%">代表者</th>
        <th style="width:10%">大小幼</th>
        <th style="width:20%">お名前英字</th>
        <th style="width:20%">お名前漢字</th>
        <th style="width:10%">性別</th>
        <th style="width:10%">年齢</th>
      </tr>
      <tr>
        <td><a href="#no1">▼</a></td>
        <td>1</td>
        <td>○</td>
        <td>大人</td>
        <td>NAKAGAWA YOSHIO</td>
        <td>中川　善夫</td>
        <td>男</td>
        <td>44</td>
      </tr>
      <tr>
        <td><a href="#no2">▼</a></td>
        <td>2</td>
        <td></td>
        <td>大人</td>
        <td>NAKAGAWA TAROU</td>
        <td>中川　太郎</td>
        <td>男</td>
        <td>15</td>
      </tr>
      <tr>
        <td><a href="#no3">▼</a></td>
        <td>3</td>
        <td></td>
        <td>大人</td>
        <td>NAKAGAWA HANAKO</td>
        <td>中川　花子</td>
        <td>女</td>
        <td>44</td>
      </tr>
      <tr>
        <td><a href="#no4">▼</a></td>
        <td>4</td>
        <td></td>
        <td>小人</td>
        <td>NAKAGAWA KOHANA</td>
        <td>中川　小花</td>
        <td>女</td>
        <td>10</td>
      </tr>
      <tr>
        <td><a href="#no5">▼</a></td>
        <td>5</td>
        <td></td>
        <td>幼児</td>
        <td>NAKAGAWA YOUZI</td>
        <td>中川　洋二</td>
        <td>男</td>
        <td>1</td>
      </tr>
      </tbody>
    </table>
    <div class="button_bar middle">
      <a href="{{ url('reservation/input_remarks/') }}">
        <button type="submit" class="done">次へ（ご乗船者リクエスト入力）</button>
      </a>
        <button type="submit" class="skip done">スキップ（照会へ）</button>
    </div>
    <div class="customer_details" id="no1">
      <div class="tab_button">
        <a href="#top">
          <button class="tab default">▲一覧トップへ</button>
        </a>
      </div>

        <?php $index = 1; ?>
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">ご乗船者様No.{{$index}}</th>
          <td colspan="6" class="customer_name">
            NAKAGAWA YOSHIO
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th rowspan="2" class="vertical">お<br>名<br>前</th>
          <th>漢字<span class="required">※</span></th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="ja_familyname" value="中川"/>
            (名)<input type="text" class="name_text" name="ja_firstname" value="善夫"/>
          </td>
        </tr>
        <tr>
          <th>カナ</th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="kana_familyname" value="ナカガワ"/>
            (名)<input type="text" class="name_text" name="kana_firstname" value="ヨシオ"/>
          </td>
        </tr>
        <tr>
          <th width="16%" colspan="2">性別<span class="required">※</span></th>
          <td width="5%">
            <label><input type="radio" name="sex_{{$index}}" value="0" selected>男</label>
            <label><input type="radio" name="sex_{{$index}}" value="1">女</label>
          </td>
          <th width="13%" colspan="2">生年月日<span class="required">※</span></th>
          <td width="28%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
              <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th width="11%">結婚記念日</th>
          <td width="26%">
            <select class="year" name="marry_year">
              <option>----</option>
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="marry_month">
              <option>--</option>
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="marry_day">
              <option>--</option>
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
        <tr>
          <th rowspan="5" class="vertical">住<br>所<br></th>
          <th>郵便番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="zip_code" class="copy_data" value="5201621" style="width: 13%;"/>
            （半角数字、ハイフン不要）
            　わからない場合は
            <button class="add search_zip">郵便番号検索へ</button>
          </td>
        </tr>
        <tr>
          <th>都道府県<span class="required">※</span></th>
          <td colspan="6">
            <select style="width: 17%;" class="copy_data" name="prefectures">
              <option value="滋賀">滋賀</option>
              <option value="大阪">大阪</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>市区町村まで<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="city" class="copy_data" value="高島市今津町今津" style="width: 61%;"
                   placeholder="例）大阪市北区梅田"/>
          </td>
        </tr>
        <tr>
          <th>番地以降<span class="required">※</span></th>
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
          <th rowspan="2">電話<br>番号<br><span class="required">※</span></th>
          <th>携帯</th>
          <td colspan="6">
            <input type="tel" name="mobile_phone" class="copy_data" value="09000000000" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th>自宅</th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" value="08000000000" style="width: 20%;"/>（ハイフン不要）
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
            <input type="tel" name="home_phone" class="copy_data" value="08000000000" style="width: 20%;"/>（ハイフン不要）
            <span class="danger">※緊急時に連絡が取れる番号を入力してください。</span>
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
            <select class="year" name="">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th>失効日</th>
          <td>
            <select class="year" name="">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
{{--        <tr>
          <th colspan="2">ネット予約リンクID</th>
          <td colspan="6">
            <input type="text" class="venus_family"><p class="danger">※びいなす倶楽部会員の方は入力してください</p>
          </td>
        </tr>--}}
        </tbody>
      </table>
    </div>

      <?php $index++; ?>
    <div class="customer_details" id="no{{$index}}">
      <a name="no{{$index}}"></a>
      <div class="tab_button">
        <a href="#top">
          <button class="tab default">▲一覧トップへ</button>
        </a>
        <button class="default copy_userdata">ご乗船者様No.1の住所、電話番号、連絡先をコピーする</button>
      </div>
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">ご乗船者様No.{{$index}}</th>
          <td colspan="6" class="customer_name">
            NAKAGAWA TAROU
            {{--<label class="icon success venus">びいなす倶楽部会員</label>--}}
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th rowspan="2" class="vertical">お<br>名<br>前</th>
          <th>漢字<span class="required">※</span></th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="ja_familyname"/>
            (名)<input type="text" class="name_text" name="ja_firstname"/>
          </td>
        </tr>
        <tr>
          <th>カナ</th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="kana_familyname"/>
            (名)<input type="text" class="name_text" name="kana_firstname"/>
          </td>
        </tr>
        <tr>
          <th width="16%" colspan="2">性別<span class="required">※</span></th>
          <td width="5%">
            <label><input type="radio" name="sex_{{$index}}" value="0" selected>男</label>
            <label><input type="radio" name="sex_{{$index}}" value="1">女</label>
          </td>
          <th width="13%" colspan="2">生年月日<span class="required">※</span></th>
          <td width="28%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th width="11%">結婚記念日</th>
          <td width="26%">
            <select class="year" name="marry_year">
              <option>----</option>
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="marry_month">
              <option>--</option>
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="marry_day">
              <option>--</option>
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
        <tr>
          <th rowspan="5" class="vertical">住<br>所<br></th>
          <th>郵便番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="text" name="zip_code" class="copy_data" style="width: 13%;"/>
            （半角数字、ハイフン不要）
            　わからない場合は
            <button class="add search_zip">郵便番号検索へ</button>
          </td>
        </tr>
        <tr>
          <th>都道府県<span class="required">※</span></th>
          <td colspan="6">
            <select style="width: 17%;" class="copy_data" name="prefectures">
              <option value="滋賀">滋賀</option>
              <option value="大阪">大阪</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>市区町村まで<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="city" class="copy_data" style="width: 61%;" placeholder="例）大阪市北区梅田"/>
          </td>
        </tr>
        <tr>
          <th>番地以降<span class="required">※</span></th>
          <td colspan="6"><input type="text" name="lot_number" class="copy_data" style="width: 61%;"
                                 placeholder="例）２－５－２５"/>
          </td>
        </tr>
        <tr>
          <th>建物名</th>
          <td colspan="6"><input type="text" name="building" class="copy_data" style="width: 61%;"
                                 placeholder="例）ハービスOSAKA1502号室"/>
          </td>
        </tr>
        <tr>
          <th rowspan="2">電話<br>番号<br><span class="required">※</span></th>
          <th>携帯</th>
          <td colspan="6">
            <input name="mobile_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th>自宅</th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
          <th>お名前<span class="required">※</span></th>
          <td><input type="text" name="contact_name" class="copy_data"/></td>
          <th colspan="2">お名前カナ<span class="required">※</span></th>
          <td><input type="text" name="contact_name_ruby" class="copy_data"/></td>
          <th>続柄<span class="required">※</span></th>
          <td><input type="text" name="relationship"/></td>
        </tr>
        <tr>
          <th>電話番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" style="width: 20%;"/>（ハイフン不要）
            <span class="danger">※緊急時に連絡が取れる番号を入力してください。</span>
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
            <select class="year" name="">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th>失効日</th>
          <td>
            <select class="year" name="">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
{{--        <tr>
          <th colspan="2">ネット予約リンクID</th>
          <td colspan="6">
            <input type="text" class="venus_family"><p class="danger">※びいなす倶楽部会員の方は入力してください</p>
          </td>
        </tr>--}}
        </tbody>
      </table>
    </div>

      <?php $index++; ?>
    <div class="customer_details" id="no{{$index}}">
      <a name="no{{$index}}"></a>
      <div class="tab_button">
        <a href="#top">
          <button class="tab default">▲一覧トップへ</button>
        </a>
        <button class="default copy_userdata">ご乗船者様No.1の住所、電話番号、連絡先をコピーする</button>
      </div>
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">ご乗船者様No.{{$index}}</th>
          <td colspan="6" class="customer_name">NAKAGAWA HANAKO</td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th rowspan="2" class="vertical">お<br>名<br>前</th>
          <th>漢字<span class="required">※</span></th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="ja_familyname"/>
            (名)<input type="text" class="name_text" name="ja_firstname"/>
          </td>
        </tr>
        <tr>
          <th>カナ</th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="kana_familyname"/>
            (名)<input type="text" class="name_text" name="kana_firstname"/>
          </td>
        </tr>
        <tr>
          <th width="16%" colspan="2">性別<span class="required">※</span></th>
          <td width="5%">
            <label><input type="radio" name="sex_{{$index}}" value="0" selected>男</label>
            <label><input type="radio" name="sex_{{$index}}" value="1">女</label>
          </td>
          <th width="13%" colspan="2">生年月日<span class="required">※</span></th>
          <td width="28%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th width="11%">結婚記念日</th>
          <td width="26%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
        <tr>
          <th rowspan="5" class="vertical">住<br>所<br></th>
          <th>郵便番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="zip_code" class="copy_data" style="width: 13%;"/>
            （半角数字、ハイフン不要）
            {{--<button class="default auto_zip_code">郵便番号から住所を自動入力する</button>--}}
            　わからない場合は
            <button class="add search_zip">郵便番号検索へ</button>
          </td>
        </tr>
        <tr>
          <th>都道府県<span class="required">※</span></th>
          <td colspan="6">
            <select style="width: 17%;" class="copy_data" name="prefectures">
              <option value="滋賀">滋賀</option>
              <option value="大阪">大阪</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>市区町村まで<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="city" class="copy_data" style="width: 61%;" placeholder="例）大阪市北区梅田"/>
          </td>
        </tr>
        <tr>
          <th>番地以降<span class="required">※</span></th>
          <td colspan="6"><input type="text" name="lot_number" class="copy_data" style="width: 61%;"
                                 placeholder="例）２－５－２５"/>
          </td>
        </tr>
        <tr>
          <th>建物名</th>
          <td colspan="6"><input type="text" name="building" class="copy_data" style="width: 61%;"
                                 placeholder="例）ハービスOSAKA1502号室"/>
          </td>
        </tr>
        <tr>
          <th rowspan="2">電話<br>番号<br><span class="required">※</span></th>
          <th>携帯</th>
          <td colspan="6">
            <input name="mobile_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th>自宅</th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
          <th>お名前<span class="required">※</span></th>
          <td><input type="text" name="contact_name" class="copy_data"/></td>
          <th colspan="2">お名前カナ<span class="required">※</span></th>
          <td><input type="text" name="contact_name_ruby" class="copy_data"/></td>
          <th>続柄<span class="required">※</span></th>
          <td><input type="text" name="relationship"/></td>
        </tr>
        <tr>
          <th>電話番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" style="width: 20%;"/>（ハイフン不要）
            <span class="danger">※緊急時に連絡が取れる番号を入力してください。</span>
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
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th>失効日</th>
          <td>
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
{{--        <tr>
          <th colspan="2">ネット予約リンクID</th>
          <td colspan="6">
            <input type="text" class="venus_family"><p class="danger">※びいなす倶楽部会員の方は入力してください</p>
          </td>
        </tr>--}}
        </tbody>
      </table>
    </div>

      <?php $index++; ?>
    <div class="customer_details" id="no{{$index}}">
      <a name="no{{$index}}"></a>
      <div class="tab_button">
        <a href="#top">
          <button class="tab default">▲一覧トップへ</button>
        </a>
        <button class="default copy_userdata">ご乗船者様No.1の住所、電話番号、連絡先をコピーする</button>
      </div>
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">ご乗船者様No.{{$index}}</th>
          <td colspan="6" class="customer_name">NAKAGAWA KOHANA</td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th rowspan="2" class="vertical">お<br>名<br>前</th>
          <th>漢字<span class="required">※</span></th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="ja_familyname"/>
            (名)<input type="text" class="name_text" name="ja_firstname"/>
          </td>
        </tr>
        <tr>
          <th>カナ</th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="kana_familyname"/>
            (名)<input type="text" class="name_text" name="kana_firstname"/>
          </td>
        </tr>
        <tr>
          <th width="16%" colspan="2">性別<span class="required">※</span></th>
          <td width="5%">
            <label><input type="radio" name="sex_{{$index}}" value="0" selected>男</label>
            <label><input type="radio" name="sex_{{$index}}" value="1">女</label>
          </td>
          <th width="13%" colspan="2">生年月日<span class="required">※</span></th>
          <td width="28%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th width="11%">結婚記念日</th>
          <td width="26%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
        <tr>
          <th rowspan="5" class="vertical">住<br>所<br></th>
          <th>郵便番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="zip_code" class="copy_data" style="width: 13%;"/>
            （半角数字、ハイフン不要）
            {{--<button class="default auto_zip_code">郵便番号から住所を自動入力する</button>--}}
            　わからない場合は
            <button class="add search_zip">郵便番号検索へ</button>
          </td>
        </tr>
        <tr>
          <th>都道府県<span class="required">※</span></th>
          <td colspan="6">
            <select style="width: 17%;" class="copy_data" name="prefectures">
              <option value="滋賀">滋賀</option>
              <option value="大阪">大阪</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>市区町村まで<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="city" class="copy_data" style="width: 61%;" placeholder="例）大阪市北区梅田"/>
          </td>
        </tr>
        <tr>
          <th>番地以降<span class="required">※</span></th>
          <td colspan="6"><input type="text" name="lot_number" class="copy_data" style="width: 61%;"
                                 placeholder="例）２－５－２５"/>
          </td>
        </tr>
        <tr>
          <th>建物名</th>
          <td colspan="6"><input type="text" name="building" class="copy_data" style="width: 61%;"
                                 placeholder="例）ハービスOSAKA1502号室"/>
          </td>
        </tr>
        <tr>
          <th rowspan="2">電話<br>番号<br><span class="required">※</span></th>
          <th>携帯</th>
          <td colspan="6">
            <input name="mobile_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th>自宅</th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
          <th>お名前<span class="required">※</span></th>
          <td><input type="text" name="contact_name" class="copy_data"/></td>
          <th colspan="2">お名前カナ<span class="required">※</span></th>
          <td><input type="text" name="contact_name_ruby" class="copy_data"/></td>
          <th>続柄<span class="required">※</span></th>
          <td><input type="text" name="relationship"/></td>
        </tr>
        <tr>
          <th>電話番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" style="width: 20%;"/>（ハイフン不要）
            <span class="danger">※緊急時に連絡が取れる番号を入力してください。</span>
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
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th>失効日</th>
          <td>
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
{{--        <tr>
          <th colspan="2">ネット予約リンクID</th>
          <td colspan="6">
            <input type="text" class="venus_family"><p class="danger">※びいなす倶楽部会員の方は入力してください</p>
          </td>
        </tr>--}}
        </tbody>
      </table>
    </div>

      <?php $index++; ?>
    <div class="customer_details" id="no{{$index}}">
      <a name="no{{$index}}"></a>
      <div class="tab_button">
        <a href="#top">
          <button class="tab default">▲一覧トップへ</button>
        </a>
        <button class="default copy_userdata">ご乗船者様No.1の住所、電話番号、連絡先をコピーする</button>
      </div>
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">ご乗船者様No.{{$index}}</th>
          <td colspan="6" class="customer_name">NAKAGAWA YOUZI</td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th rowspan="2" class="vertical">お<br>名<br>前</th>
          <th>漢字<span class="required">※</span></th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="ja_familyname"/>
            (名)<input type="text" class="name_text" name="ja_firstname"/>
          </td>
        </tr>
        <tr>
          <th>カナ</th>
          <td colspan="6">
            (姓)<input type="text" class="name_text" name="kana_familyname"/>
            (名)<input type="text" class="name_text" name="kana_firstname"/>
          </td>
        </tr>
        <tr>
          <th width="16%" colspan="2">性別<span class="required">※</span></th>
          <td width="5%">
            <label><input type="radio" name="sex_{{$index}}" value="0" selected>男</label>
            <label><input type="radio" name="sex_{{$index}}" value="1">女</label>
          </td>
          <th width="13%" colspan="2">生年月日<span class="required">※</span></th>
          <td width="28%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th width="11%">結婚記念日</th>
          <td width="26%">
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
        <tr>
          <th rowspan="5" class="vertical">住<br>所<br></th>
          <th>郵便番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="zip_code" class="copy_data" style="width: 13%;"/>
            （半角数字、ハイフン不要）
            {{--<button class="default auto_zip_code">郵便番号から住所を自動入力する</button>--}}
            　わからない場合は
            <button class="add search_zip">郵便番号検索へ</button>
          </td>
        </tr>
        <tr>
          <th>都道府県<span class="required">※</span></th>
          <td colspan="6">
            <select style="width: 17%;" class="copy_data" name="prefectures">
              <option value="滋賀">滋賀</option>
              <option value="大阪">大阪</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>市区町村まで<span class="required">※</span></th>
          <td colspan="6">
            <input type="name" name="city" class="copy_data" style="width: 61%;" placeholder="例）大阪市北区梅田"/>
          </td>
        </tr>
        <tr>
          <th>番地以降<span class="required">※</span></th>
          <td colspan="6"><input type="text" name="lot_number" class="copy_data" style="width: 61%;"
                                 placeholder="例）２－５－２５"/>
          </td>
        </tr>
        <tr>
          <th>建物名</th>
          <td colspan="6"><input type="text" name="building" class="copy_data" style="width: 61%;"
                                 placeholder="例）ハービスOSAKA1502号室"/>
          </td>
        </tr>
        <tr>
          <th rowspan="2">電話<br>番号<br><span class="required">※</span></th>
          <th>携帯</th>
          <td colspan="6">
            <input name="mobile_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th>自宅</th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" value="" style="width: 20%;"/>（ハイフン不要）
          </td>
        </tr>
        <tr>
          <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
          <th>お名前<span class="required">※</span></th>
          <td><input type="text" name="contact_name" class="copy_data"/></td>
          <th colspan="2">お名前カナ<span class="required">※</span></th>
          <td><input type="text" name="contact_name_ruby" class="copy_data"/></td>
          <th>続柄<span class="required">※</span></th>
          <td><input type="text" name="relationship"/></td>
        </tr>
        <tr>
          <th>電話番号<span class="required">※</span></th>
          <td colspan="6">
            <input type="tel" name="home_phone" class="copy_data" style="width: 20%;"/>（ハイフン不要）
            <span class="danger">※緊急時に連絡が取れる番号を入力してください。</span>
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
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
          <th>失効日</th>
          <td>
            <select class="year" name="birth_year">
              @for($i=0; $i < 30; $i++)
                <option value="{{ $i }}">{{ 1980 + $i }}</option>
              @endfor
            </select>年
            <select class="month_day" name="birth_month">
              @for($i=1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>月
            <select class="month_day" name="birth_day">
              @for($i=1; $i <= 31; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>日
          </td>
        </tr>
{{--        <tr>
          <th colspan="2">ネット予約リンクID</th>
          <td colspan="6">
            <input type="text" class="venus_family"><p class="danger">※びいなす倶楽部会員の方は入力してください</p>
          </td>
        </tr>--}}
        </tbody>
      </table>
    </div>
    <form id="index" action="{{ url('search_zip_prefecture') }}" method="get" target="_blank">
      <input type="hidden" name="target_index">
    </form>
  </main>
@endsection
