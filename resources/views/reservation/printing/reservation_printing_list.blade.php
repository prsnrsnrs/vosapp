@extends('layout.base')

@section('title', '乗船券控えと各種確認書の印刷画面')

@section('style')
  <link href="{{ mix('css/reservation/printing/reservation_printing_list.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/printing/reservation_printing_list.js')}}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="reservation_printing_list">
    @include('include/information', ['info' => ''])

    @if($is_site['agent'] || $is_site['agent_test'])
      <form class="search_form" id="search_form" method="get" action="{{ ext_route('reservation.printing.list') }}">
        <table class="default">
          <thead>
          <tr>
            <th colspan="2">乗船券控えと各種確認書の印刷検索条件</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th style="width: 15%">出発日</th>
            <td style="width:80%" class="calendar">
              <label><input class="datepicker before_date" id="departure_date_from"
                            name="search_con[departure_date_from]"
                            data-default='{"default_departure":"{{ \App\Libs\DateUtil::now('Y/m/d') }}",
                            "min_calender":"{{ \App\Libs\DateUtil::getTwoMonthBefore('Y/m/d') }}"}'
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
              <select name="search_con[item_code]" id="item_code">
                <option value=""></option>
                @foreach($cruises as $cruise)
                  <option value="{{$cruise['item_code']}}"
                          data-item_departure_date="{{ $cruise['item_departure_date'] }}"
                          data-item_arrival_date="{{ $cruise['item_arrival_date'] }}"
                          {{ option_selected($cruise['item_code'], $search_con['item_code']) }}>{{$cruise['item_name']}}
                    &nbsp;{{$cruise['item_name2']}}
                  </option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr class="number">
            <th>予約番号</th>
            <td>
              <input class="text" id="reservation_number" name="search_con[reservation_number]" type="text"
                     value="{{$search_con["reservation_number"]}}" maxlength="9">
            </td>
          </tr>
          <tr class="passenger">
            <th>乗船者名</th>
            <td>
              <input class="text" name="search_con[passenger_name]" type="text"
                     value="{{$search_con["passenger_name"]}}" style="width: 19em" maxlength="10">（部分一致）
            </td>
          </tr>
          </tbody>
        </table>
        <div class="search_btn">
          <button class="back" type="button" onclick="location.href='{{ return_route() }}'">
            <img src="{{  ext_asset('images/icon/return.png') }}">戻る
          </button>
          <button class="done">
            <img src="{{  ext_asset('images/icon/search.png') }}">検索
          </button>
          <div style="float: right">
            <button type="button" id="PDFForm" class="clear_form back">
              <img src="{{  ext_asset('images/icon/clear.png') }}">検索内容をクリア
            </button>
          </div>
        </div>
      </form>
    @endif

    {{--検索結果一覧--}}
    <div class="result_list">
      <table class="default hover_rows_custom">
        <thead class="{{$reservations ? '': 'no_data' }}">
        <tr>
          <th colspan="12">乗船券控えと各種確認書の印刷検索一覧</th>
        </tr>
        <tr class="data_title">
          <th rowspan="2" style="width: 20px">
            <label>
              <input name="all_check" type="checkbox" class="check_style">
              <span class="checkbox"></span>
            </label>
          </th>
          <th rowspan="2" style="width: 110px">予約番号</th>
          <th rowspan="2" style="width: 60px">大小幼</th>
          <th rowspan="2" style="width: 230px">乗船者名</th>
          <th rowspan="2" style="width: 40px">性別</th>
          <th rowspan="2" style="width: 40px">年齢</th>
          <th rowspan="2" style="width: 104px">ｽﾃｰﾀｽ</th>
          <th colspan="4" style="width: 468px">印刷可能な乗船券控えと各種確認書</th>
        </tr>
        <tr class="data_title">
          <th style="width: 117px">乗船券控え</th>
          <th style="width: 117px">予約確認書</th>
          <th style="width: 117px">予約内容確認書</th>
          <th style="width: 117px">取消記録確認書</th>
        </tr>
        </thead>
        @if($reservations)
          <tbody>
          @foreach($reservations as $reservation_number => $passengers)
            @foreach($passengers as $key => $passenger)
              <tr class="index_{{$reservation_number}}_{{$key}}">
                <td style="width: 20px">
                  <label>
                    <input type="checkbox" class="check_style move_check"
                           data-reservation_number="{{$reservation_number}}"
                           data-passenger_line_number="{{$passenger['passenger_line_number']}}"/>
                    <span class="checkbox"></span>
                  </label>
                </td>
                <td style="width: 110px; border-bottom: none; {{ $loop->first ? '' : 'border-top: none;' }}">
                  @if($loop->first)
                    <a href="{{ ext_route('reservation.detail', ['reservation_number' => $reservation_number, 'return_param' => params_for_return($reservation_number)]) }}">{{ $reservation_number }}</a>
                  @endif
                </td>
                <td style="width: 60px">{{ config('const.age_type.name.' . $passenger['age_type']) }}</td>
                <td style="width: 230px; text-align: left">
                  {!! passenger_name($passenger['passenger_last_eij'], $passenger['passenger_first_eij']) !!}
                  <br>
                {!!  passenger_name($passenger['passenger_last_knj'], $passenger['passenger_first_knj']) !!}
                <td style="width: 40px">{{ config('const.gender.name.' . $passenger['gender']) }}</td>
                <td style="width: 40px; text-align: center">{{ $passenger['birth_date'] ? $passenger['age'] : '' }}</td>
                <td style="width: 104px">{{ $passenger['reservation_status'] }}</td>
                <td style="width: 117px"
                    class="ticket">{{ matched_circle_ticket($passenger['cancel_date_time'],$passenger['reservation_type'],$passenger['ticketing_flag'])}}
                </td>
                <td style="width: 117px" class="document">
                  {{ matched_circle_confirm($passenger['cancel_date_time'],$passenger['reservation_type'])}}
                </td>
                <td style="width: 117px" class="detail">
                  @if($is_site['agent'] || $is_site['agent_test'])
                    {{ matched_circle_detail_confirm($passenger['cancel_date_time'],$passenger['reservation_type'],$passenger['reservation_status']) }}
                  @endif
                </td>
                <td style="width: 117px" class="cancel">
                  @if($is_site['agent'] || $is_site['agent_test'])
                    {{ matched_circle_cancel($passenger['cancel_date_time'],$passenger['reservation_type']) }}
                  @endif
                </td>
              </tr>
            @endforeach
          @endforeach
          </tbody>
        @else
          <tfoot>
          <tr>
            <td class="list_empty" colspan="12" style="width: 1065px;">
              <p>検索条件に一致する印刷物がありません。</p>
            </td>
          </tr>
          </tfoot>
        @endif
      </table>
    </div>

    {{--フッダーボタン--}}
    <div class="button_bar">
      <button class="back" onclick="location.href='{{ return_route() }}'">
        <img src="{{  ext_asset('images/icon/return.png') }}">戻る
      </button>
      <form method="post" action="{{ ext_route('reservation.printing.ticket') }}" target="_blank">
        <button class="add" data-printing_type="ticket" data-csv="N" disabled>
          <img class="pdf" src="{{  ext_asset('images/icon/pdf.png') }}">乗船券控え
        </button>
      </form>
      <form method="post" action="{{ ext_route('reservation.printing.document') }}" target="_blank">
        <button class="add" data-printing_type="document" data-csv="N" disabled>
          <img class="pdf" src="{{  ext_asset('images/icon/pdf.png') }}">予約確認書
        </button>
      </form>
      @if($is_site['agent'] || $is_site['agent_test'])
        <form method="post" action="{{ ext_route('reservation.printing.detail') }}" target="_blank">
          <button class="add" data-printing_type="detail" data-csv="N" disabled>
            <img class="pdf" src="{{  ext_asset('images/icon/pdf.png') }}">予約内容確認書
          </button>
        </form>
        <form method="post" action="{{ ext_route('reservation.printing.cancel') }}" target="_blank">
          <button class="add" data-printing_type="cancel" data-csv="N" disabled>
            <img class="pdf" src="{{  ext_asset('images/icon/pdf.png') }}">取消記録確認書
          </button>
        </form>
        <form method="post" action="{{ ext_route('reservation.printing.csv') }}">
          <button class="add csv" data-printing_type="document" data-csv="Y" disabled>
            <img src="{{  ext_asset('images/icon/download.png') }}">予約内容CSV出力
          </button>
        </form>
      @endif
    </div>

  </main>
@endsection