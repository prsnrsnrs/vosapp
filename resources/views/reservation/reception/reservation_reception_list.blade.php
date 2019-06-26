@extends('layout.base')

@section('title', '受付一覧')

@section('style')
  <link href="{{ mix('css/reservation/reception/reservation_reception_list.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/reception/reservation_reception_list.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main>
    @include('include/information', ['info' => ''])

    @if($is_agent_site || $is_agent_test_site)
      <form class="search_form" id="search_form" method="get" action="{{ ext_route('reservation.reception.list') }}">
        <input name="search_con[page]" value="1" type="hidden">
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
              <label><input class="datepicker before_date" id="departure_date_from"
                            name="search_con[departure_date_from]"
                            data-default='{"default_departure":"{{ \App\Libs\DateUtil::now('Y/m/d') }}",
                            "min_calender":"{{ \App\Libs\DateUtil::getThreeMonthBefore('Y/m/d') }}"}'
                            value="{{ convert_date_format($search_con["departure_date_from"], 'Y/m/d') }}"></label>
              <p style="display: inline-block; margin: 0 10px">～</p>
              <label><input class="datepicker after_date" id="departure_date_to"
                            name="search_con[departure_date_to]"
                            value="{{ convert_date_format($search_con["departure_date_to"], 'Y/m/d') }}"></label>
            </td>
          </tr>
          <tr>
            <th>クルーズ名（コース）</th>
            <td>
              <select name="search_con[item_code]" id="cruise_id">
                <option value=""></option>
                @foreach($cruises as $cruise)
                  <option value="{{$cruise['item_code']}}"
                          data-item_departure_date="{{ $cruise['item_departure_date'] }}"
                          data-item_arrival_date="{{ $cruise['item_arrival_date'] }}"
                          {{ option_selected($cruise['item_code'], $search_con['item_code']) }}>{{$cruise['item_name']}}
                    &nbsp;{{$cruise['item_name2']}}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr class="number">
            <th>予約番号</th>
            <td><input type="text" name="search_con[reservation_number]"
                       value="{{$search_con["reservation_number"]}}" class="text"
                       maxlength="9"></td>
          </tr>
          <tr>
            <th>代表者名</th>
            <td>
              <input class="text" name="search_con[boss_name]" type="text"
                     value="{{$search_con["boss_name"]}}" style="width: 19em"
                     maxlength="20">（部分一致）
            </td>
          </tr>
          <tr>
            <th>ステータス</th>
            <td>
              <input type="hidden" name="search_con[status_hk]" value="">
              <input type="hidden" name="search_con[status_wt]" value="">
              <input type="hidden" name="search_con[status_cx]" value="">
              <label>
                <input type="checkbox" name="search_con[status_hk]"
                       value="HK" class="check_style" {{ input_checked($search_con['status_hk'], "HK") }}>
                <span class="checkbox"></span>
                HK
              </label>
              <label>
                <input type="checkbox" id="wt" name="search_con[status_wt]"
                       value="WT" class="check_style" {{ input_checked($search_con['status_wt'], "WT") }}>
                <span class="checkbox"></span>
                WT
              </label>
              <label style="width: auto">
                <input type="checkbox" id="cx" name="search_con[status_cx]"
                       value="CX" class="check_style" {{ input_checked($search_con['status_cx'], "CX") }}>
                <span class="checkbox"></span>
                CX
              </label>
            </td>
          </tr>
          <tr>
            <th>詳細入力</th>
            <td>
              <input type="hidden" name="search_con[detail_input_flag_yet]" value="">
              <input type="hidden" name="search_con[detail_input_flag_fin]" value="">
              <label>
                <input type="checkbox" value="0" name="search_con[detail_input_flag_yet]"
                       class="check_style" {{ input_checked($search_con['detail_input_flag_yet'], "0") }}>
                <span class="checkbox"></span>
                未
              </label>
              <label>
                <input type="checkbox" value="1" name="search_con[detail_input_flag_fin]"
                       class="check_style" {{ input_checked($search_con['detail_input_flag_fin'], "1") }}>
                <span class="checkbox"></span>
                済
              </label>
            </td>
          </tr>
          <tr>
            <th>提出書類</th>
            <td>
              <input type="hidden" name="search_con[submit_document_flag_yet]" value="">
              <input type="hidden" name="search_con[submit_document_flag_fin]" value="">
              <label>
                <input type="checkbox" value="1" name="search_con[submit_document_flag_yet]"
                       class="check_style" {{ input_checked($search_con['submit_document_flag_yet'], "1") }}>
                <span class="checkbox"></span>
                未
              </label>
              <label>
                <input type="checkbox" value="3" name="search_con[submit_document_flag_fin]"
                       class="check_style" {{ input_checked($search_con['submit_document_flag_fin'], "3") }}>
                <span class="checkbox"></span>
                済
              </label>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="search_btn">
          <button class="back" type="button" onclick="location.href='{{ ext_route('mypage') }}'">
            <img src="{{  ext_asset('images/icon/return.png') }}">戻る
          </button>
          <button type="submit" class="done search">
            <img src="{{  ext_asset('images/icon/search.png') }}">検索
          </button>
          <div style="float: right">
            <button type="button" id="clearForm" class="back">
              <img src="{{  ext_asset('images/icon/clear.png') }}">検索内容をクリア
            </button>
          </div>
        </div>
      </form>
    @endif

    {{-- 件数表示 --}}
    @if($reception_count_all !== "0")
      <div class="count_from_to">
        <label>{{$reception_count_all}}件中&nbsp;{{$search_con['page']*10-9}}
          件～{{ count_from_to($search_con['page']*10,$reception_count_all)}}件目を表示</label>
      </div>
    @endif


    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="11">{{$travel_company_name}}／{{$agent_name}}　様の受付一覧</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 5%">受付<br>日時</th>
          <th style="width: 7%">予約番号</th>
          <th style="width: 28%">クルーズ名（コース）</th>
          <th style="width: 12%">出発日</th>
          <th style="width: 17%">代表者名</th>
          <th style="width: 5%">ｽﾃｰﾀｽ</th>
          <th style="width: 5%">詳細<br>入力</th>
          <th style="width: 5%">提出<br>書類</th>
          <th style="width: 5%">ご連絡</th>
          <th style="width: 5%">印刷</th>
          <th style="width: 6%">ｸﾞﾙｰﾌﾟ</th>
        </tr>

        @forelse($reservations as $reservation)
          @if($reservation['reservation_status']==='HK')
            <tr class="search_result">
          @elseif($reservation['reservation_status']==='WT')
            <tr class="waiting search_result">
          @elseif($reservation['reservation_status']==='CX')
            <tr class="cancel search_result">
              @endif
              <td>
                <div>{{date('m/d',  strtotime($reservation['new_created_date_time']))}}</div>
                <div>{{date('H:i',  strtotime($reservation['new_created_date_time']))}}</div>
              </td>

              <td>
                <a href="{{ ext_route('reservation.detail',['reservation_number'=>$reservation['reservation_number']])}}">{{$reservation['reservation_number']}}</a>
              </td>
              <td>
                {!! str_concat($reservation['item_name'], $reservation['item_name2']) !!}
              </td>

              <td>
                {{$reservation['departure_place_knj']}}発<br>
                {{date('Y年m月d日',  strtotime($reservation['item_departure_date']))}}
                ({{get_youbi($reservation['item_departure_date'])}})
              </td>

              <td>
                <div>{!! passenger_name($reservation['passenger_last_eij'],$reservation['passenger_first_eij']) !!}</div>
                <div>{{$reservation['passenger_last_knj']}}&nbsp;{{$reservation['passenger_first_knj']}}</div>
              </td>

              <td>{{$reservation['reservation_status']}}</td>

              <td>
                {{-- 取消予約はクリック不可 --}}
                @if ($reservation['reservation_status']==='CX')
                  {{config('const.detail_input_flag.name.'.$reservation['detail_input_flag'])}}
                @else
                  <a href="{{ ext_route('reservation.input.passenger', ['reservation_number' => $reservation['reservation_number'], 'return_name' => request()->route()->getName()]) }}"
                     class="danger">
                    {{config('const.detail_input_flag.name.'.$reservation['detail_input_flag'])}}
                  </a>
                @endif
              </td>

              <td>
                {{--提出書類Flagによって黒字の"-"か赤文字の未,済を表示するか判定--}}
                {{-- 取消予約はクリック不可 --}}
                @if ($reservation['reservation_status']==='CX')
                  {{config('const.submit_document_flag.name.'.$reservation['submit_document_flag'])}}
                @elseif($reservation['submit_document_flag'] == config('const.submit_document_flag.value.unanswered') ||
                    $reservation['submit_document_flag'] == config('const.submit_document_flag.value.none'))
                  <a href="{{ ext_route('reservation.document.list', ['reservation_number' => $reservation['reservation_number'], 'return_name' => request()->route()->getName()]) }}">
                    {{config('const.submit_document_flag.name.'.$reservation['submit_document_flag'])}}
                  </a>
                @else
                  <a href="{{ ext_route('reservation.document.list', ['reservation_number' => $reservation['reservation_number'], 'return_name' => request()->route()->getName()]) }}"
                     class="danger">
                    {{config('const.submit_document_flag.name.'.$reservation['submit_document_flag'])}}
                  </a>
                @endif
              </td>

              <td>
                <a href="{{ ext_route('reservation.contact.list',
                  ['search_con' => array_merge(config('const.search_con.reservation_contact_list'),[
                  'reservation_number'=>$reservation['reservation_number']]), 'return_param' => params_for_return()]) }}">
                  {{$reservation['contact_mail_count']}}
                </a>
              </td>

              <td>
                <a href="{{ ext_route('reservation.printing.list',
                  ['search_con' => array_merge(config('const.search_con.reservation_printing_list'),[
                  'reservation_number'=>$reservation['reservation_number'],
                  'item_code'=>$reservation['item_code']]), 'return_param' => params_for_return()] ) }}">
                  <button class="add">印刷</button>
                </a>
              </td>

              {{--取消予約はグループ設定ボタンを表示しない--}}
              @if($reservation['reservation_status'] == "CX")
                <td></td>
              @else
                <td>
                  <form class="group_setting_form" action="{{ ext_route('reservation.reception.group') }}" method="get">
                    <input type="hidden" name="cruise_id" value="{{ $reservation['cruise_id'] }}">
                    <input type="hidden" name="reservation_number" value="{{ $reservation['reservation_number'] }}">
                    @if($reservation['travelwith_number'])
                      <button type="submit" class="success edit_group" data-cruise_id="{{ $reservation['cruise_id'] }}"
                              data-reservation_number="{{ $reservation['reservation_number'] }}">設定済
                      </button>
                    @else
                      <button type="submit" class="back new_group" style="border: 1px solid #A9A9A9;!important;">未設定
                      </button>
                    @endif
                  </form>
                </td>
              @endif
            </tr>
            @empty
              <tr>
                <td class="list_empty" colspan="11">検索条件に一致する予約情報がありません。</td>
              </tr>
            @endforelse
        </tbody>
      </table>

      {{--ページジャー --}}
      @if($reception_count_all !== "0")
        {{ $paginator }}
      @endif
    </div>

    <div class="button_bar">
      <button class="back" onclick="location.href='{{ ext_route('mypage') }}'">
        <img src="{{  ext_asset('images/icon/return.png') }}">戻る
      </button>
    </div>

  </main>

  {{-- モーダル部分 --}}
  <div id="modal_contents" style="width: 835px">

  </div>

@endsection