@extends('layout.base')

@section('title', 'ご乗船者詳細入力')

@section('style')
  <link href="{{ mix('css/reservation/input/reservation_input_passenger.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/reservation/input/reservation_input_passenger.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
    ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
    ['name' => '予約照会', 'url' => ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]), 'confirm' => true],
    ['name' => 'ご乗船者詳細入力'],
  ]])
@endsection
@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_input_passenger" id="top">

    {{-- ヘッダー部 --}}
    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => $info_message])
    <div class="wizard">
      <ul>
        <li class="current">①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>


    {{-- ご乗船者一覧 --}}
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
      @foreach ($passengers as $passenger)
        <tr>
          <td><a href="#no{{$loop->iteration}}">▼</a></td>
          <td>{{$loop->iteration}}</td>
          <td>{{ config('const.boss_type.name.'.$passenger['boss_type']) }}</td>
          <td>{{ config('const.age_type.name.'.$passenger['age_type']) }}</td>
          <td>{!! passenger_name($passenger['passenger_last_eij'], $passenger['passenger_first_eij']) !!}</td>
          <td>{!! passenger_name($passenger['passenger_last_knj'], $passenger['passenger_first_knj']) !!}</td>
          <td>{{ config('const.gender.name.'.$passenger['gender']) }}</td>
          <td>{{ $passenger['birth_date'] ? $passenger['age'] : '' }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>

    <div class="button_bar middle">
      <button type="submit" id="next" class="done">
        <img src="{{  ext_asset('images/icon/next.png') }}">次へ（ご乗船者リクエスト入力）
      </button>
      <button type="submit" id="skip" class="done"
              data-skip_url="{{ ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]) }}">
        <img src="{{  ext_asset('images/icon/skip.png') }}">スキップ（照会へ）
      </button>
    </div>


    {{-- ご乗船者詳細 --}}
    <form id="passenger_form" method="post" action="{{ext_route('reservation.input.passenger')}}">
      <input type="hidden" name="reservation_number" value="{{ $item_info['reservation_number'] }}"/>
      <input type="hidden" name="last_update_date_time" value="{{ $item_info['last_update_date_time'] }}"/>
      @foreach ($passengers as $passenger)
        <input type="hidden" name="passengers[{{$loop->iteration}}][passenger_line_number]"
               value="{{$passenger['passenger_line_number']}}"/>

        <div class="customer_details" id="no{{$loop->iteration}}">
          <div class="tab_button">
            <a href="#top">
              <button type="button" class="tab default">▲一覧トップへ</button>
            </a>
            @if (!$loop->first)
              <button type="button" class="default copy_userdata">
                <img class="copy_img" src="{{  ext_asset('images/icon/copy.png') }}">ご乗船者様No.1の住所、電話番号、連絡先をコピーする
              </button>
            @endif
          </div>

          <table class="default">
            <thead>
            <tr>
              <th colspan="2">ご乗船者様No.{{$loop->iteration}}</th>
              <td colspan="6" class="customer_name">
                {{ config('const.age_type.name.'.$passenger['age_type']) }}
              </td>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th rowspan="3" class="vertical">お<br>名<br>前</th>
              <th>英字<span class="required">※</span></th>
              <td colspan="6">
                (姓)<input type="text" class="name_text"
                          name="passengers[{{$loop->iteration}}][passenger_last_eij]"
                          value="{{$passenger['passenger_last_eij']}}" maxlength="20"/>
                (名)<input type="text" class="name_text"
                          name="passengers[{{$loop->iteration}}][passenger_first_eij]"
                          value="{{$passenger['passenger_first_eij']}}" maxlength="20"/>
              </td>
            </tr>
            <tr>
              <th>漢字<span class="required">※</span></th>
              <td colspan="6">
                (姓)<input type="text" class="name_text"
                          name="passengers[{{$loop->iteration}}][passenger_last_knj]"
                          value="{{$passenger['passenger_last_knj']}}" maxlength="22"/>
                (名)<input type="text" class="name_text"
                          name="passengers[{{$loop->iteration}}][passenger_first_knj]"
                          value="{{$passenger['passenger_first_knj']}}" maxlength="22"/>
              </td>
            </tr>
            <tr>
              <th>カナ</th>
              <td colspan="6">
                (姓)<input type="text" class="name_text"
                          name="passengers[{{$loop->iteration}}][passenger_last_kana]"
                          value="{{convert_zenkaku_kana($passenger['passenger_last_kana'])}}"
                          maxlength="20"/>
                (名)<input type="text" class="name_text"
                          name="passengers[{{$loop->iteration}}][passenger_first_kana]"
                          value="{{convert_zenkaku_kana($passenger['passenger_first_kana'])}}"
                          maxlength="20"/>
              </td>
            </tr>
            <tr>
              <th width="16%" colspan="2">性別<span class="required">※</span></th>
              <td width="5%">
                <input type="hidden" name="passengers[{{$loop->iteration}}][gender]" value=""/>
                <label><input type="radio" name="passengers[{{$loop->iteration}}][gender]"
                              value="{{config('const.gender.value.male')}}" {{input_checked(config('const.gender.value.male'), $passenger['gender'])}}>男</label>
                <label><input type="radio" name="passengers[{{$loop->iteration}}][gender]"
                              value="{{config('const.gender.value.female')}}" {{input_checked(config('const.gender.value.female'), $passenger['gender'])}}>女</label>
              </td>
              <th width="13%" colspan="2">生年月日<span class="required">※</span></th>
              <td width="28%">
                <select class="year" name="passengers[{{$loop->iteration}}][birth_year]">
                  <option value="">----</option>
                  {!! option_year($passenger['birth_date']) !!}
                </select>年
                <select class="month_day" name="passengers[{{$loop->iteration}}][birth_month]">
                  <option value="">--</option>
                  {!! option_month($passenger['birth_date']) !!}
                </select>月
                <select class="month_day" name="passengers[{{$loop->iteration}}][birth_day]">
                  <option value="">--</option>
                  {!! option_day($passenger['birth_date']) !!}
                </select>日
              </td>
              <th width="11%">結婚記念日</th>
              <td width="26%">
                <select class="year" name="passengers[{{$loop->iteration}}][wedding_year]">
                  <option value="">----</option>
                  {!! option_year($passenger['wedding_anniversary']) !!}
                </select>年
                <select class="month_day" name="passengers[{{$loop->iteration}}][wedding_month]">
                  <option value="">--</option>
                  {!! option_month($passenger['wedding_anniversary']) !!}
                </select>月
                <select class="month_day" name="passengers[{{$loop->iteration}}][wedding_day]">
                  <option value="">--</option>
                  {!! option_day($passenger['wedding_anniversary']) !!}
                </select>日
              </td>
            </tr>
            <tr>
              <th rowspan="5" class="vertical">住<br>所<br></th>
              <th>郵便番号<span class="required">※</span></th>
              <td colspan="6">
                <input type="text" name="passengers[{{$loop->iteration}}][zip_code]"
                       class="copy_data zip_code"
                       data-index="{{$loop->iteration}}"
                       value="{{ $passenger['zip_code'] }}" maxlength="7" style="width: 13%;"/>
                （半角数字、ハイフン不要）
                　わからない場合は
                <button type="button" class="add search_zip"
                        data-target="[name='passengers[{{$loop->iteration}}][zip_code]']"
                        data-url="{{ ext_route('address.prefecture_select')}}">郵便番号検索へ
                </button>
              </td>
            </tr>
            <tr>
              <th>都道府県<span class="required">※</span></th>
              <td colspan="6">
                <select style="width: 17%;" class="copy_data"
                        name="passengers[{{$loop->iteration}}][prefecture_code]">
                  <option value=""></option>
                  @foreach ($prefectures as $prefecture)
                    <option value="{{$prefecture['prefecture_code']}}" {{option_selected($prefecture['prefecture_code'], $passenger['prefecture_code'])}}>{{$prefecture['prefecture_name']}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <th>市区町村まで<span class="required">※</span></th>
              <td colspan="6">
                <input type="text" name="passengers[{{$loop->iteration}}][address1]" class="copy_data"
                       value="{{$passenger['address1']}}" style="width: 61%;"
                       placeholder="例）大阪市北区梅田" maxlength="102"/>
              </td>
            </tr>
            <tr>
              <th>番地以降<span class="required">※</span></th>
              <td colspan="6"><input type="text" name="passengers[{{$loop->iteration}}][address2]"
                                     class="copy_data"
                                     value="{{$passenger['address2']}}" style="width: 61%;"
                                     placeholder="例）２－５－２５" maxlength="102"/>
              </td>
            </tr>
            <tr>
              <th>建物名</th>
              <td colspan="6"><input type="text" name="passengers[{{$loop->iteration}}][address3]"
                                     class="copy_data"
                                     value="{{$passenger['address3']}}" style="width: 61%;"
                                     placeholder="例）ハービスOSAKA1502号室" maxlength="102"/>
              </td>
            </tr>
            <tr>
              <th rowspan="2">電話<br>番号<br><span class="required">※</span></th>
              <th>携帯</th>
              <td colspan="6">
                <input type="text" name="passengers[{{$loop->iteration}}][tel1]"
                       value="{{$passenger['tel1']}}" maxlength="16"
                       style="width: 20%;"/>（ハイフン不要）
                <span class="required">※携帯電話をお持ちの方は携帯電話番号を入力してください。</span>
              </td>
            </tr>
            <tr>
              <th>自宅</th>
              <td colspan="6">
                <input type="text" name="passengers[{{$loop->iteration}}][tel2]" class="copy_data"
                       value="{{$passenger['tel2']}}" maxlength="16"
                       style="width: 20%;"/>（ハイフン不要）
              </td>
            </tr>
            <tr>
              <th rowspan="2" style="font-size: 0.9em;">緊急<br>連絡先</th>
              <th>お名前<span class="required">※</span></th>
              <td><input type="text" name="passengers[{{$loop->iteration}}][emergency_contact_name]"
                         class="copy_data"
                         value="{{$passenger['emergency_contact_name']}}" maxlength="42"/></td>
              <th colspan="2">お名前カナ<span class="required">※</span></th>
              <td><input type="text" name="passengers[{{$loop->iteration}}][emergency_contact_kana]"
                         class="copy_data"
                         value="{{convert_zenkaku_kana($passenger['emergency_contact_kana'])}}"
                         maxlength="42"/></td>
              <th>続柄<span class="required">※</span></th>
              <td><input type="text"
                         name="passengers[{{$loop->iteration}}][emergency_contact_relationship]"
                         value="{{$passenger['emergency_contact_relationship']}}" maxlength="12"/></td>
            </tr>
            <tr>
              <th>電話番号<span class="required">※</span></th>
              <td colspan="6">
                <input type="text" name="passengers[{{$loop->iteration}}][emergency_contact_tel]"
                       class="copy_data"
                       value="{{$passenger['emergency_contact_tel']}}" maxlength="16"
                       style="width: 20%;"/>（ハイフン不要）
                <span class="danger">※緊急時に連絡が取れる番号を入力してください。</span>
              </td>
            </tr>
            @if($is_overseas_cruise)
              <tr>
                <th colspan="2">国籍<span class="required">※</span></th>
                <td>
                  <select class="copy_data" name="passengers[{{$loop->iteration}}][country_code]"
                          id="nationality"
                          data-index="{{$loop->iteration}}">
                    @foreach ($countries as $country)
                      <option value="{{$country['country_code']}}" {{option_selected($country['country_code'], $passenger['country_code'])}}>{{$country['country_name_knj']}}</option>
                    @endforeach
                  </select>
                </td>
                <th rowspan="2" style="width: 4%; padding: 0 9px;">旅<br>券<span class="required">※</span>
                </th>
                <th>番号</th>
                <td><input type="text" name="passengers[{{$loop->iteration}}][passport_number]"
                           value="{{$passenger['passport_number']}}" maxlength="12"/></td>
                <th>発給地</th>
                <td>
                  <select name="passengers[{{$loop->iteration}}][passport_issued_place]">
                    @foreach ($countries as $country)
                      <option value="{{$country['country_code']}}" {{option_selected($country['country_code'], $passenger['passport_issued_place'])}}>{{$country['country_name_knj']}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th colspan="2">居住国</th>
                <td>
                  <select class="copy_data" name="passengers[{{$loop->iteration}}][residence_code]"
                          id="residence{{$loop->iteration}}">
                    @foreach ($countries as $country)
                      <option value="{{$country['country_code']}}" {{option_selected($country['country_code'], $passenger['residence_code'])}}>{{$country['country_name_knj']}}</option>
                    @endforeach
                  </select>
                </td>
                <th>発給日</th>
                <td>
                  <select class="year" name="passengers[{{$loop->iteration}}][passport_issued_year]">
                    <option value="">----</option>
                    {!! option_year($passenger['passport_issued_date']) !!}
                  </select>年
                  <select class="month_day"
                          name="passengers[{{$loop->iteration}}][passport_issued_month]">
                    <option value="">--</option>
                    {!! option_month($passenger['passport_issued_date']) !!}
                  </select>月
                  <select class="month_day"
                          name="passengers[{{$loop->iteration}}][passport_issued_day]">
                    <option value="">--</option>
                    {!! option_day($passenger['passport_issued_date']) !!}
                  </select>日
                </td>
                <th>失効日</th>
                <td>
                  <select class="year" name="passengers[{{$loop->iteration}}][passport_lose_year]">
                    <option value="">----</option>
                    {!! option_year($passenger['passport_lose_date'], 11, 10) !!}
                  </select>年
                  <select class="month_day"
                          name="passengers[{{$loop->iteration}}][passport_lose_month]">
                    <option value="">--</option>
                    {!! option_month($passenger['passport_lose_date']) !!}
                  </select>月
                  <select class="month_day"
                          name="passengers[{{$loop->iteration}}][passport_lose_day]">
                    <option value="">--</option>
                    {!! option_day($passenger['passport_lose_date']) !!}
                  </select>日
                </td>
              </tr>
            @else
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_number]" value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_issued_place]"
                     value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_issued_year]" value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_issued_month]"
                     value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_issued_day]" value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_lose_year]" value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_lose_month]" value="">
              <input type="hidden" name="passengers[{{$loop->iteration}}][passport_lose_day]" value="">


              <tr>
                <th colspan="2">国籍<span class="required">※</span></th>
                <td>
                  <select class="copy_data" name="passengers[{{$loop->iteration}}][country_code]"
                          id="nationality"
                          data-index="{{$loop->iteration}}">
                    @foreach ($countries as $country)
                      <option value="{{$country['country_code']}}" {{option_selected($country['country_code'], $passenger['country_code'])}}>{{$country['country_name_knj']}}</option>
                    @endforeach
                  </select>
                </td>
                <th colspan="2">居住国</th>
                <td colspan="3">
                  <select class="copy_data" name="passengers[{{$loop->iteration}}][residence_code]"
                          id="residence{{$loop->iteration}}">
                    @foreach ($countries as $country)
                      <option value="{{$country['country_code']}}" {{option_selected($country['country_code'], $passenger['residence_code'])}}>{{$country['country_name_knj']}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      @endforeach
    </form>
    <form id="address_form" action="{{ ext_route('address') }}" method="get"></form>
  </main>
@endsection
