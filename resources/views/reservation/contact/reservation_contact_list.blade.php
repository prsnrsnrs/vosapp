@extends('layout.base')

@section('title', 'ご連絡一覧')

@section('style')
  <link href="{{ mix('css/reservation/contact/reservation_contact_list.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/contact/reservation_contact_list.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="reservation_contact_list">

    @include('include/information', ['info' => ''])

    @if($is_agent_site || $is_agent_test_site)
      <form class="search_form" method="get" action="{{ext_route('reservation.contact.list')}}">
        <input type="hidden" name="search_con[page]" value="1">
        <table class="default">
          <thead>
          <tr>
            <th colspan="2">日本クルーズ客船からのご連絡一覧検索条件</th>
          </tr>
          </thead>

          <tbody>
          <tr>
            <th style="width: 20%">分類</th>
            <td style="width: 80%">
              <input type="hidden" name="search_con[status_need_answer]" value="">
              <input type="hidden" name="search_con[status_not_need_answer]" value="">
              <input type="hidden" name="search_con[status_information]" value="">
              <label>
                <input class="check_style" name="search_con[status_need_answer]"
                       value="1" type="checkbox" {{input_checked($search_con['status_need_answer'],"1")}}>
                <span class="checkbox"></span>回答要
              </label>
              <label>
                <input class="check_style" name="search_con[status_not_need_answer]"
                       value="2" type="checkbox" {{input_checked($search_con['status_not_need_answer'],"2")}}>
                <span class="checkbox"></span>回答不要
              </label>
              <label>
                <input class="check_style" name="search_con[status_information]"
                       type="checkbox" value="3" {{input_checked($search_con['status_information'],"3")}}>
                <span class="checkbox"></span>ご案内
              </label>
            </td>
          </tr>

          <tr>
            <th>出発日</th>
            <td style="width:80%" class="calendar">
              <label>
                <input class="datepicker before_date" id="departure_date_from"
                       name="search_con[departure_date_from]"
                       data-default='{"default_departure":"{{ \App\Libs\DateUtil::now('Y/m/d') }}",
                            "min_calender":"{{ \App\Libs\DateUtil::getOneMonthBefore('Y/m/d') }}"}'
                       value="{{ convert_date_format($search_con["departure_date_from"], 'Y/m/d') }}">
              </label>
              <p style="display: inline-block; margin: 0 10px">～</p>
              <label>
                <input class="datepicker after_date" id="departure_date_to"
                       name="search_con[departure_date_to]"
                       value="{{ convert_date_format($search_con["departure_date_to"], 'Y/m/d') }}">
              </label>
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

          <tr>
            <th>予約番号</th>
            <td>
              <input class="text" name="search_con[reservation_number]" type="text"
                     value="{{$search_con["reservation_number"]}}" maxlength="9">
            </td>
          </tr>

          <tr>
            <th>代表者お名前</th>
            <td>
              <input class="text" name="search_con[boss_name]" type="text"
                     value="{{$search_con["boss_name"]}}" style="width: 19em" maxlength="10">（部分一致）

            </td>
          </tr>

          @if($is_jurisdiction_agent)
            <tr>
              <th>販売店区分</th>
              <td>
                <input type="hidden" name="search_con[agent_type]" value="">
                <label>
                  <input class="check_style" name="search_con[agent_type]" value="all"
                         type="radio" {{input_checked($search_con['agent_type'],"all")}}>
                  <span class="checkbox"></span>すべての販売店
                </label>
                <label>
                  <input class="check_style" name="search_con[agent_type]" value="own"
                         type="radio" {{input_checked($search_con['agent_type'],"own")}}>
                  <span class="checkbox"></span>自販売店のみ
                </label>
              </td>
            </tr>
          @endif
          </tbody>
        </table>

        <div class="search_btn">
          <button class="back" type="button" onclick="location.href='{{ return_route() }}'">
            <img src="{{  ext_asset('images/icon/return.png') }}">戻る
          </button>
          <button type="submit" class="done search">
            <img src="{{  ext_asset('images/icon/search.png') }}">検索
          </button>
          <label>※保存期間はクルーズ終了後１ヶ月です。それを過ぎると自動的に削除されます。</label>
          <div style="float: right">
            <button type="button" id="clearForm" class="back">
              <img src="{{  ext_asset('images/icon/clear.png') }}">検索内容をクリア
            </button>
          </div>
        </div>
      </form>
    @endif

    {{-- 件数表示 --}}
    @if($contact_all_count !== "0")
      <div class="count_from_to">
        <label>{{$contact_all_count}}件中&nbsp;{{$search_con['page']*10-9}}
          件～{{ count_from_to($search_con['page']*10,$contact_all_count)}}件目を表示</label>
      </div>
    @endif

    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="8">日本クルーズ客船からのご連絡一覧</th>
        </tr>
        </thead>

        <tbody>
        <tr>
          <th style="width:7%" rowspan="2">分類</th>
          <th style="width:10%" rowspan="2" class="dothesort">
            @if($search_con['contact_sort'] == 'contact_date_desc')
              <a href="{{ ext_route('reservation.contact.list',[
              'search_con[contact_sort]' => 'contact_date_asc',
              'search_con[departure_sort]' => '',
              'search_con[page]' => 1
              ]) }}"
                 class="sort {{config('const.contact_sort_class.name.'.$search_con['contact_sort'])}}">ご連絡日時
              </a>
            @else
              <a href="{{ ext_route('reservation.contact.list',[
              'search_con[contact_sort]' => 'contact_date_desc',
              'search_con[departure_sort]' => '',
              'search_con[page]' => 1
              ]) }}"
                 class="sort {{config('const.contact_sort_class.name.'.$search_con['contact_sort'])}}">ご連絡日時
              </a>
            @endif
          </th>
          <th colspan="4">ご連絡対象</th>
          <th style="width:25%" rowspan="2" class="subject">件名</th>
        </tr>
        <tr>
          <th style="width:27%">クルーズ名（コース）</th>
          <th style="width:12%" class="dothesort">
            @if($search_con['departure_sort'] == 'departure_date_desc')
              <a href="{{ ext_route('reservation.contact.list',[
              'search_con[departure_sort]' => 'departure_date_asc',
              'search_con[contact_sort]' => '',
              'search_con[page]' => 1
              ]) }}"
                 class="sort {{config('const.contact_sort_class.name.'.$search_con['departure_sort'])}}">出発日
              </a>
            @else
              <a href="{{ ext_route('reservation.contact.list',[
              'search_con[departure_sort]' => 'departure_date_desc',
              'search_con[contact_sort]' => '',
              'search_con[page]' => 1
              ]) }}"
                 class="sort {{config('const.contact_sort_class.name.'.$search_con['departure_sort'])}}">出発日
              </a>
            @endif
          </th>
          <th style="width:7%">予約番号</th>
          <th style="width:15%">代表者お名前</th>
        </tr>

        @forelse($contacts as $contact)
          <tr class="sort_item">
            <td>
              <label class="icon {{config('const.answer_type.class.'.$contact['mail_category'])}}">
                {{config('const.answer_type.name.'.$contact['mail_category'])}}
              </label>
            </td>

            <td>
              {{date('m/d',  strtotime($contact['mail_send_date_time']))}}&nbsp;
              {{date('H：i',  strtotime($contact['mail_send_date_time']))}}
            </td>

            <td>{!! str_concat($contact['item_name'], $contact['item_name2']) !!}</td>

            <td>
              {{$contact['departure_place_knj']}}発<br>{{date('Y年m月d日',  strtotime($contact['item_departure_date']))}}
              ({{get_youbi($contact['item_departure_date'])}})
            </td>

            <td>
              <a href="{{ ext_route('reservation.detail', params_for_return($contact['reservation_number']))}}">
                {{$contact['reservation_number']}}
              </a>
            </td>

            <td>
              <div>{!!passenger_name($contact['passenger_last_eij'],$contact['passenger_first_eij'])!!}</div>
              <div>{!!passenger_name($contact['passenger_last_knj'],$contact['passenger_first_knj'])!!}</div>
            </td>

            <td>
              <a href="{{ ext_route('reservation.contact.detail',['mail_send_instruction_number'=>$contact['mail_send_instruction_number']])}}">
                {{$contact['mail_subject']}}
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td class="list_empty"
                colspan="7">検索条件に一致する日本クルーズ客船からのご連絡はありません。
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>

      {{--ページジャー --}}
      @if($contact_all_count !== "0")
        {{ $paginator }}
      @endif
    </div>

    <div class="button_bar">
      <button class="back" onclick="location.href='{{ return_route() }}'">
        <img src="{{  ext_asset('images/icon/return.png') }}">戻る
      </button>
    </div>
  </main>
@endsection