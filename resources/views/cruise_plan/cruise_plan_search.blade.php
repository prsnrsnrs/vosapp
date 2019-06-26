@extends('layout.base')

@section('title', 'クルーズプラン検索')

@section('style')
  <link href="{{ mix('css/cruise_plan/cruise_plan_search.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/cruise_plan/cruise_plan_search.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage')],
    ['name' => 'クルーズプラン検索'],
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="body">

    @include('include/information', ['info' => ''])

    {{-- 検索条件 --}}
    <form class="search_form" action="{{ ext_route('cruise_plan.search') }}" method="get">
      <input type="hidden" name="search_con[page]" value="1"/>
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">クルーズプラン検索条件</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th>出発日</th>
          <td class="calendar">
            <label><input type="text" class="datepicker before_date" id="departure_date_from"
                          name="search_con[departure_date_from]"
                          data-default="{{ \App\Libs\DateUtil::getTomorrow('Y/m/d') }}"
                          value="{{ convert_date_format($search_con["departure_date_from"], 'Y/m/d') }}"></label>
            <p style="display: inline-block; margin: 0 10px">～</p>
            <label><input type="text" class="datepicker after_date" id="departure_date_to"
                          name="search_con[departure_date_to]"
                          value="{{ convert_date_format($search_con["departure_date_to"], 'Y/m/d') }}"></label>
          </td>
        </tr>
        <tr>
          <th style="width: 17%">クルーズ名</th>
          <td style="width: 83%">
            <select id="cruise_id" name="search_con[cruise_id]">
              <option value=""></option>
              @foreach ($cruises as $row)
                <option value="{{ $row['curise_id'] }}" data-start_date="{{ $row['start_date'] }}"
                        data-end_date="{{ $row['finish_date'] }}" {{ option_selected($row['curise_id'], $search_con['cruise_id']) }}>{{ $row['cruise_name'] }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>出発地</th>
          <td>
            <select name="search_con[departure_port_code]">
              <option value=""></option>
              @foreach ($departures as $row)
                <option value="{{ $row['port_code'] }}" {{ option_selected($row['port_code'], $search_con['departure_port_code']) }}>{{ $row['port_knj'] }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        </tbody>
      </table>
      <div>
        <a href="{{ ext_route('mypage') }}" style="text-decoration: none">
          <button type="button" class="back">
            <img src="{{  ext_asset('images/icon/return.png') }}">戻る
          </button>
        </a>
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

    {{-- 照会日時 --}}
    <div class="confirm_time">
      <label id="time">{{ convert_date_format($search_result['inquiry_date_time'], 'Y/m/d H:i').'現在' }}</label>
    </div>

    {{-- 検索結果 --}}
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="16">クルーズプラン検索結果一覧</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th>クルーズ名（コース）</th>
          <th style="width:12%">出発日</th>
          @foreach ($search_result['cabin_types'] as $cabin_type)
            <th style="width:4.5%;">{!! cabin_type_for_cruise_plan_search($cabin_type) !!}</th>
          @endforeach
          <th style="width:4%">予約<br>件数</th>
          <th style="width:6%">処理</th>
        </tr>

        {{-- 空席状況ラベル --}}
        <tr>
          <td colspan="14" class="right">
            〇…空席あり、△…空席わずか、×…満席(キャンセル待ち)、－…受付不可
          </td>
        </tr>

        @forelse ($search_result['results'] as $result)
          <tr>
            <td>{!! str_concat($result['item']['item_name'], $result['item']['item_name2']) !!}</td>
            <td>
              {{ $result['item']['departure_place_knj']}}発<br/>
              {{ convert_date_format($result['item']['item_departure_date'], 'Y/m/d') }}
              ({{ get_youbi($result['item']['item_departure_date']) }})
            </td>
            @foreach ($result['vacancies'] as $vacancy)
              <td>{{ config('const.vacancy.name.'.$vacancy) }}</td>
            @endforeach

            <td>
              <a href="{{ ext_route('reservation.reception.list', [
              'search_con' => array_merge(config('const.search_con.reservation_reception_list'), ['item_code' => $result['item_code']]),
               'return_param' => params_for_return() ]) }}">
                {{ $result['reservation_count']}}</a>
            </td>
            <td>
              <div>
                <button class="add btn_reservation" data-item_code="{{ $result['item_code'] }}">予約</button>
              </div>
              <div>
                <a href="{{ ext_route('reservation.import.file_select', ['item_code' => $result['item_code']]) }}">
                  <button class="add">取込</button>
                </a>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="list_empty"
                colspan="{{ 4 + count($search_result['cabin_types']) }}">検索条件に一致するクルーズプランがありません。
            </td>
          </tr>
        @endforelse

        </tbody>
      </table>


      {{-- ページジャー --}}
      @if($item_count != "0")
        {{ $paginator }}
      @endif

    </div>

    {{-- フッターボタン --}}
    <div class="button_bar">
      <a href="{{ ext_route('mypage') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>

  </main>

  {{-- 予約初期化処理のフォーム --}}
  <form id="before_reservation_form" action="{{ ext_route('cruise_plan.before_reservation') }}" method="post"></form>
@endsection