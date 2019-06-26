@extends('layout.base')

@section('title', 'ご乗船のお客様新規登録')

@section('style')
  <link href="{{ mix('css/boatmenber_add.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/agent_import_add.js') }}"></script>
@endsection
@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞<a href="{{ url('end_user/boatmenber/list') }}">ご乗船のお客様登録一覧</a>
  ＞ご乗船のお客様新規登録
@endsection

@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('end_user/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('end_user/login/login') }}">ログアウト</a></li>
  </ul>
@endsection
@section('content')
  <main class="add">
    @include('include.info', ['info' => 'ご乗船されるお客様情報の情報を入力してください。<br/><strong>TODO:(フェーズ2で対応) びいなす倶楽部会員の場合、リンクIDと名前(英字)、生年月日を入力するだけでよい。また、びいなす会員の登録内容は変更できない。</strong>'])
    <table class="default">
      <thead>
        <tr>
          <th colspan="8">ご乗船者のお客様情報(No.1)</th>
        </tr>
      </thead>
      <tbody>
      <tr>
        <th colspan="2">びいなす倶楽部会員</th>
        <td colspan="6">
          <label><input type="radio" name="club_member" value="general" checked>一般</label>
          <label><input type="radio" name="club_member" value="member">びいなす倶楽部会員</label>
        </td>
      </tr>
      <tr>
        <th colspan="2">ネット予約リンクID</th>
        <td colspan="6"><input type="text" class="club_id">※びいなす倶楽部会員の方はこちらから送付しておりますリンクIDを入力してください</td>
      </tr>
      <tr>
        <th rowspan="3" class="vertical">お<br>名<br>前</th>
        <th>英字<span class="required">※</span></th>
        <td colspan="6">
          (姓)<input type="text" class="name_text" name="en_familyname" value="NAKAGAWA"/>
          (名)<input type="text" class="name_text" name="en_firstname" value="YOSHIO"/>
        </td>
      </tr>
      <tr class="general">
        <th>漢字<span class="required">※</span></th>
        <td colspan="6">
          (姓)<input type="text" class="name_text" name="ja_familyname" value="中川"/>
          (名)<input type="text" class="name_text" name="ja_firstname" value="善夫"/>
        </td>
      </tr>
      <tr class="general">
        <th>カナ</th>
        <td colspan="6">
          (姓)<input type="text" class="name_text" name="kana_familyname" value="ナカガワ"/>
          (名)<input type="text" class="name_text" name="kana_firstname" value="ヨシオ"/>
        </td>
      </tr>
      <tr class="member">
        <th colspan="2">性別<span class="required">※</span></th>
        <td>
          <label><input type="radio" name="sex" value="0" checked>男</label>
          <label><input type="radio" name="sex" value="1">女</label>
        </td>
        <th colspan="2">生年月日<span class="required">※</span></th>
        <td>
          <select class="year" name="birth_year">
              @for($i=0; $i < 10; $i++)
                <option value="201{{ $i }}">201{{ $i }}</option>
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
        <th>結婚記念日</th>
        <td>
          <select class="year" name="marry_year">
            @for($i=0; $i < 10; $i++)
              <option value="201{{ $i }}">201{{ $i }}</option>
            @endfor
          </select>年
          <select class="month_day" name="marry_month">
            @for($i=1; $i <= 12; $i++)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>月
          <select class="month_day" name="marry_day">
            @for($i=1; $i <= 31; $i++)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>日
        </td>
      </tr>
      <tr class="general">
        <th rowspan="5" class="vertical">住<br>所<br></th>
        <th>郵便番号<span class="required">※</span></th>
        <td colspan="6">
          <input type="number" name="post_number" value="5201621" />
          （半角数字、ハイフン不要）
          <button class="default auto_post_number">郵便番号から住所を自動入力する</button>
          　わからない場合は
          <button class="default search_zip">郵便番号検索へ</button>
        </td>
      </tr>
      <tr class="general">
        <th>都道府県</th>
        <td colspan="6">
          <select class="copy_data" name="prefectures">
            <option value="滋賀">滋賀</option>
            <option value="大阪">大阪</option>
          </select>
        </td>
      </tr>
      <tr class="general">
        <th>市区町村まで</th>
        <td colspan="6">
          <input type="text" name="city" value="高島市今津町今津" placeholder="例）大阪市北区梅田"/>
        </td>
      </tr>
      <tr class="general">
        <th>番地以降</th>
        <td colspan="6"><input type="text" name="lot_number" value="１ー２３４－５" placeholder="例）２－５－２５"/>
        </td>
      </tr>
      <tr class="general">
        <th>建物名</th>
        <td colspan="6">
          <input type="text" name="building" value="びわこハイツ301" placeholder="例）ハービスOSAKA1502号室"/>
        </td>
      </tr>
      <tr class="general">
        <th colspan="2">電話番号1<span class="required">※</span></th>
        <td colspan="6">
          <input name="tel_1" class="copy_data" value="09000000000" style="width: 20%;"/>（ハイフン不要）
          <label><input type="radio" name="radio_tel_1">携帯</label>
          <label><input type="radio" name="radio_tel_1">自宅</label>
          <p class="danger">※携帯電話をお持ちの方は携帯電話番号を入力してください</p>
        </td>
      </tr>
      <tr class="general">
        <th colspan="2">電話番号2</th>
        <td colspan="6">
          <input type="tel" name="tel_2" value="08000000000" />（ハイフン不要）
          <label><input type="radio" name="radio_tel_2">携帯</label>
          <label><input type="radio" name="radio_tel_2">自宅</label>
        </td>
      </tr>
      <tr class="general">
        <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
        <th>お名前<span class="required">※</span></th>
        <td style="width: 15%"><input type="text" name="contact_name" value="中川　小太郎"/></td>
        <th colspan="2">お名前カナ<span class="required">※</span></th>
        <td><input type="text" name="contact_name_ruby" value="ナカガワ　ショウタロウ"/></td>
        <th>続柄<span class="required">※</span></th>
        <td><input type="text" name="relationship"/></td>
      </tr>
      <tr class="general">
        <th>電話番号<span class="required">※</span></th>
        <td colspan="6">
          <input type="tel" name="tel_2" value="08000000000" />（ハイフン不要）
          <label><input type="radio" name="radio_urgency">携帯</label>
          <label><input type="radio" name="radio_urgency">自宅</label>
          <p class="danger">※緊急時に連絡が取れる番号を入力してください。</p>
        </td>
      </tr>
      <tr class="general">
        <th colspan="2" style="width: 14%">国籍<span class="required">※</span></th>
        <td  style="width: 16%">
          <select name="cuntory">
            <option value="0" selected>日本</option>
            <option value="1">アメリカ</option>
            <option value="2">フランス</option>
          </select>
        </td>
        <th rowspan="2"  style="width: 4%; padding: 0 9px;">旅<br>券</th>
        <th  style="width: 10%">番号</th>
        <td  style="width: 23%"><input type="text" name="contact_no"/></td>
        <th  style="width: 10%">発給地</th>
        <td  style="width: 23%">
          <select>
            <option>日本</option>
          </select>
        </td>
      </tr>
      <tr class="general">
        <th colspan="2">居住国</th>
        <td>
          <select name="cuntory">
            <option value="0" selected>日本</option>
            <option value="1">アメリカ</option>
            <option value="2">フランス</option>
          </select>
        </td>
        <th>発給日</th>
        <td>
          <select class="year" name="birth_year">
            @for($i=0; $i < 10; $i++)
              <option value="201{{ $i }}">201{{ $i }}</option>
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
          <select class="year">
            @for($i=0; $i < 10; $i++)
              <option value="201{{ $i }}">201{{ $i }}</option>
            @endfor
          </select>年
          <select class="month_day">
            @for($i=1; $i <= 12; $i++)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>月
          <select class="month_day">
            @for($i=1; $i <= 31; $i++)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>日
        </td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/boatmenber/list') }}"><button class="back">戻る</button></a>
    <a href="{{ url('end_user/boatmenber/list') }}"><button class="done">登録</button></a>
  </div>
@endsection