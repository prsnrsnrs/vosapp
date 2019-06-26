@extends('layout.base')

@section('title', '予約照会画面')

@section('style')
  <link href="{{ mix('css/reservation/reservation_detail.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/reservation_detail.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => [

  ['name' => 'マイページ', 'url' => ext_route('mypage')],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list')],
  ['name' => '予約照会']]

  ])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => false])
@endsection

@section('content')
  <main class="body">
    @include('include/course',['menu_display' => true, 'shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => $info_message])

    <div class="course_menu">
      {{--客室数・人数--}}
      <a href="javascript:void(0);" class="cabin_edit {{ is_canceled_reservation($item_info) }}"
         data-reservation_number="{{$item_info['reservation_number']}}"
         data-last_update_date_time="{{ $item_info['last_update_date_time'] }}">
        <div>
          <img src="{{ ext_asset('/images/bed.png') }}"/>
          <dl>
            <dt>客室数　{{$counts['cabin']}}</dt>
            <dt>人　数　{{$counts['passenger']}}</dt>
          </dl>
        </div>
      </a>

      {{--詳細入力--}}
      <a href="{{ ext_route('reservation.input.passenger', ['reservation_number' => $item_info['reservation_number']]) }}"
         class="{{ is_canceled_reservation($item_info) }}">
        <div>
          <img src="{{ ext_asset('/images/search.png') }}"/>
          <dl>
            @if($item_info['detail_input_flag'])
              <dt>詳細入力済</dt>
            @else
              <dt class="danger">詳細入力が未完了です</dt>
            @endif
          </dl>
        </div>
      </a>

      {{--予約確認書印刷--}}
      <a href="{{ ext_route('reservation.printing.list', ['search_con' => array_merge(
      config('const.search_con.reservation_printing_list'), ['reservation_number' => request('reservation_number')])]) }}"
              {{$is_site['user'] && $item_info['detail_input_flag'] === 0 ? 'class=disabled' : '' }}>
        <div>
          <img src="{{ ext_asset('/images/print.png') }}"/>
          <dl>
            <dt>
              @if($is_site['agent'] || $is_site['agent_test'])
                予約確認書印刷可
              @elseif($item_info['detail_input_flag'] === config('const.detail_input_flag.value.yet'))
                先に詳細を入力してください
              @elseif($item_info['detail_input_flag'] ===  config('const.detail_input_flag.value.fin'))
                {{ config('const.pay_state.name.' . $item_info['pay_state_flag']) }}
              @endif
            </dt>
          </dl>
        </div>
      </a>

      {{--提出書類--}}
      <a href="{{ ext_route('reservation.document.list', ['reservation_number' => $item_info['reservation_number']]) }}"
         class="{{ is_canceled_reservation($item_info) }} ">
        <div class="button">
          <img src="{{ ext_asset('/images/note.png') }}"/>
          <dl>
            @if($item_info['submit_document_flag'] === config('const.submit_document.value.question')or
            $item_info['submit_document_flag'] === config('const.submit_document.value.yet'))
              <dt class="danger">
            @else
              <dt>
                @endif
                {{config('const.submit_document.name.'.$item_info['submit_document_flag'])}}
              </dt>
          </dl>
        </div>
      </a>

      {{--乗船券印刷--}}
      <a href="{{ ext_route('reservation.printing.list', ['search_con' => array_merge(
      config('const.search_con.reservation_printing_list'), ['reservation_number' => request('reservation_number')])]) }}"
         class="{{$item_info['detail_input_flag'] === config('const.ticketing.value.disabled') ? 'disabled' : ''}}
         {{ is_canceled_reservation($item_info) }}">
        <div>
          <img src="{{ ext_asset('/images/ticket.png') }}"/>
          <dl>
            <dt>
              @if($item_info['ticketing_flag'] === config('const.ticketing.value.disabled'))
                発券できません
              @elseif($item_info['ticketing_flag'] === config('const.ticketing.value.possible'))
                {{config('const.ticket_state.name.'.$item_info['ticket_state_flag'])}}
              @endif
            </dt>
          </dl>
        </div>
      </a>

      {{--ご連絡--}}
      <a href="{{ ext_route('reservation.contact.list', ['search_con' => array_merge(config('const.search_con.reservation_contact_list'), [
                'reservation_number' => request('reservation_number')])],
                ['return_param' => ['route_name' => request()->route()->getName(), 'reservation_number' => request('reservation_number')]]) }}">
        <div>
          <img src="{{ ext_asset('/images/mail.png') }}"/>
          <dl>
            @if($item_info['contact_mail_count'] > 0)
              <dt class="danger">ご連絡があります</dt>
            @else
              <dt>ご連絡はありません</dt>
            @endif
          </dl>
        </div>
      </a>
    </div>

    <div class="headline">
      <table class="default">
        <thead>
        <tr>
          <th style="width: 12%">予約番号</th>
          <th style="width: 12%">受付日時</th>
          <th style="width: 12%">取消日時</th>
          <th style="width: 12%">{{$is_site['user'] ? 'ステータス' : ''}}</th>
          <th style="width: 10%">旅行代金 合計</th>
          <th style="width: 12%">割引券金額 合計</th>
          <th style="width: 10%">{{$is_site['user'] ? '取消料等':''}}</th>
          <th style="width: 10%">{{$is_site['user'] ? 'ご請求額合計':''}}</th>
          <th style="width: 10%"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td style="width: 12%" class="bold">{{$item_info['reservation_number']}}</td>
          <td style="width: 12%">
            {{date('Y/m/d', strtotime($item_info['new_created_date_time']))}}
            <br>{{date('H:i', strtotime($item_info['new_created_date_time']))}}
          </td>
          <td style="width: 12%">
            @if($item_info['cancel_date_time'])
              {{date('Y/m/d', strtotime($item_info['cancel_date_time']))}}
              <br>{{date('H:i', strtotime($item_info['cancel_date_time']))}}</td>
          @endif
          <td style="width: 12%">
            @if($is_site['user'])
              @if($is_site['state_flag'] === config('const.state.value.active'))
                {{config('const.reservation_type.value.general'. $item_info['reservation_type'])}}
              @elseif($is_site['state_flag'] === config('const.state.value.delete'))
                取消
              @endif
            @endif
          </td>
          <td style="width: 10%"
              class="right">{{$charger['travel'] != '0' ?  number_format($charger['travel']).'円':''}}
          </td>
          <td style="width: 12%"
              class="right">{{$charger['discount'] != '0' ? number_format($charger['discount']).'円':''}}
          </td>
          <td style="width: 10%">{{$is_site['user'] ? number_format($charger['cancel']) .'円' : ''}}</td>
          <td style="width: 10%">{{$is_site['user'] ? number_format($charger['total']) .'円' : ''}}</td>
          <td style="width: 10%"></td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="list">
      {{--客室タイプ--}}
      @foreach($cabins as $cabin_line_number => $cabin)
        <table class="center default">
          <thead style="width: 100%">
          <tr>
            <th colspan="3">客室No.{{$loop->iteration}}</th>
            <td colspan="5" class="left">
              {{$cabin['cabin_type_knj']}}
              {{ $cabin['cabin_number'] ? '' : '（' . $cabin['cabin_capacity'] .'）' }}
            </td>
            <th>客室番号</th>
            <td class="left">{{$cabin['cabin_number']?$cabin['cabin_number']:'未定'}}</td>
            <td colspan="2"></td>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th style="width: 4%">No</th>
            <th style="width: 6%">代表者</th>
            <th style="width: 6%">大小幼</th>
            <th style="width: 20%">お名前</th>
            <th style="width: 4%">性別</th>
            <th style="width: 4%">年齢</th>
            <th style="width: 11%">ステータス</th>
            <th style="width: 9%">料金タイプ</th>
            <th style="width: 9%">旅行代金</th>
            <th style="width: 9%">割引券金額</th>
            <th style="width: 9%">{{$is_site['user'] ? '取消料等' : '' }}</th>
            <th style="width: 9%">{{$is_site['user'] ? '精算額' : '' }}</th>
          </tr>
          {{--ご乗船者--}}
          <?php $show_passenger_line_number = 1?>
          @foreach($cabin['passengers'] as $index =>$passenger)
            <tr class="{{ $passenger['reservation_status'] === config('const.reservation_status.value.cancel') ? 'cancel' : '' }}">
              <td class="index">{{ $show_passenger_line_number }}</td>
              <td>{{ config('const.boss_type.name.' . $passenger['boss_type']) }}</td>
              <td>{{ config('const.age_type.name.'.$passenger['age_type'] )}}</td>
              <td class="name left">
                {!! passenger_name($passenger['passenger_last_eij'],$passenger['passenger_first_eij']) !!}
              </td>
              <td>{{ $passenger['gender'] ? config('const.gender.name.' . $passenger['gender']) : '' }}</td>
              <td>{{ $passenger['birth_date'] ? $passenger['age'] : '' }}</td>
              <td>{{$passenger['reservation_status']}}</td>
              <td>{{ $passenger['tariff_name'] }}<br/>{{config('const.fare_type.name.'.$passenger['fare_type'])}}</td>
              <td class="right">
                {!! passenger_travel_charge($passenger['age_type'],$passenger['reservation_status'],number_format($passenger['total_travel_charge'])) !!}
              </td>
              <td class="right">
                {{ $passenger['age_type'] && $passenger['total_discount_charge'] ? number_format($passenger['total_discount_charge']).'円' : '' }}
              </td>
              <td class="danger">
                {{$passenger['total_cancel_charge'] != '0' ? '取消料あり' : ''}}
              </td>
              <td class="right">
                {{ $is_site['user'] && $passenger['age_type'] ? number_format(total_charger($passenger)).'円' : '' }}
              </td>
            </tr>
            <?php $show_passenger_line_number++ ?>
          @endforeach
          @endforeach
          </tbody>
        </table>
    </div>

    <div class="list_button_bar">
      <button id="rooming" type="button" class="edit  {{$expired}}"
              onclick="location.href='{{ ext_route('reservation.rooming', ['reservation_number' => $item_info['reservation_number']]) }}'"
              {{ is_canceled_reservation($item_info) }}>
        ルーミング変更
      </button>
      <button type="button" class="cabin_edit edit {{$expired}}"
              data-reservation_number="{{$item_info['reservation_number']}}"
              data-last_update_date_time="{{ $item_info['last_update_date_time'] }}"
              {{ is_canceled_reservation($item_info) }}>
        客室追加・変更
      </button>
      <button type="button" class="edit {{$expired}}"
              onclick="location.href='{{ ext_route('reservation.input.passenger', ['reservation_number' => $item_info['reservation_number']]) }}'"
              {{ is_canceled_reservation($item_info) }}>
        ご乗船者詳細入力
      </button>
      <button type="button" class="edit {{$expired}}"
              onclick="location.href='{{ ext_route('reservation.input.passenger_request', ['reservation_number' => $item_info['reservation_number']]) }}'"
              {{ is_canceled_reservation($item_info) }}>
        ご乗船者リクエスト入力
      </button>
      <button type="button" class="edit {{$expired}}"
              onclick="location.href='{{ ext_route('reservation.input.cabin_request', ['reservation_number' => $item_info['reservation_number']]) }}'"
              {{ is_canceled_reservation($item_info) }}>
        客室リクエスト入力
      </button>
      <button type="button" class="edit {{$expired}}"
              onclick="location.href='{{ ext_route('reservation.input.discount', ['reservation_number' => $item_info['reservation_number']]) }}'"
              {{ is_canceled_reservation($item_info) }}>
        割引情報入力
      </button>
      <button type="button" class="edit {{$expired}}"
              onclick="location.href='{{ ext_route('reservation.input.question', ['reservation_number' => $item_info['reservation_number']]) }}'"
              {{ is_canceled_reservation($item_info) }}>
        質問事項のチェック
      </button>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.reception.list') }}">
        <button class="back">受付一覧へ</button>
      </a>
      <button type="button" class="delete {{$expired}} cabin_cancel"
              data-reservation_number="{{$item_info['reservation_number']}}"
              data-last_update_date_time="{{ $item_info['last_update_date_time'] }}"
              {{ is_canceled_reservation($item_info) }}>予約取消
      </button>
    </div>
  </main>
  {{--送信用form領域--}}
  <form id="before_cabin_edit_form"
        action="{{ ext_route('reservation.before_cabin_edit', ['reservation_number' => $item_info['reservation_number']]) }}"
        method="post"></form>
  <form id="before_cabin_cancel_form" action="{{ ext_route('reservation.before_cabin_cancel') }}"
        method="post"></form>
@endsection
