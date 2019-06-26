@extends('layout.base')

@section('title', '全面取消確認画面')

@section('style')
  <link href="{{ mix('css/reservation/reservation_cancel.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/reservation_cancel.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => [
  ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
  ['name' => '予約照会', 'url' => ext_route('reservation.detail', ['reservation_number' => VossSessionManager::get('reservation_cancel.reservation_number'), 'confirm' => true])],
  ['name' => '予約取消']]])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="body">
    @include('include/course',['menu_display' => true, 'shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I050-0901')])

    <div class="headline">
      <table class="center default">
        <thead>
        <tr>
          <th style="width: 12%">予約番号</th>
          <th style="width: 12%">受付日時</th>
          <th style="width: 12%"></th>
          <th style="width: 12%"></th>
          <th style="width: 10%">旅行代金 合計</th>
          <th style="width: 12%">割引券金額 合計</th>
          <th style="width: 10%">{{$is_user_site ? '取消料等':''}}</th>
          <th style="width: 10%">{{$is_user_site ? 'ご請求額合計':''}}</th>
          <th style="width: 10%"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td style="width: 12%" class="bold">{{$item_info['original_reservation_number']}}</td>
          <td style="width: 12%">
            {{ date('Y/m/d', strtotime($item_info['new_created_date_time'])) }}
            <br>{{ date('H:i', strtotime($item_info['new_created_date_time'])) }}
          </td>
          <td style="width: 12%"></td>
          <td style="width: 12%"></td>
          <td style="width: 10%"
              class="right">{{$charger['travel'] != '0' ?  number_format($charger['travel']).'円':''}}
          </td>
          <td style="width: 12%"
              class="right">{{$charger['discount'] != '0' ? number_format($charger['discount']).'円':''}}
          </td>
          <td style="width: 10%">{{$is_user_site ? number_format($charger['cancel']) .'円' : ''}}</td>
          <td style="width: 10%">{{$is_user_site ? number_format($charger['total']) .'円' : ''}}</td>
          <td style="width: 10%"></td>
        </tr>
        </tbody>
        <tbody>
        </tbody>
      </table>
    </div>

    <div class="list">
      {{--インチャージ予約か判定するためのデータ--}}
      <input id="in_charge" type="hidden" value="{{$in_charge}}">
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
            <td class="left">{{$cabin['cabin_number'] or '未定'}}</td>
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
            <th style="width: 9%">{{$is_user_site ? '取消料等' : '' }}</th>
            <th style="width: 9%">{{$is_user_site ? '精算額' : '' }}</th>
          </tr>
          {{--ご乗船者--}}
          <?php $show_passenger_line_number = 1?>
          @foreach($cabin['passengers'] as $index =>$passenger)
            <tr class="cancel passenger_data">
              <td class="index"
                  data-cabin-line-number="{{$passenger['cabin_line_number']}}"
                  data-passenger-line-number="{{$passenger['passenger_line_number']}}"
                  data-show-passenger-line-number="{{$show_passenger_line_number}}">
                {{$show_passenger_line_number}}
              </td>
              <td class="boss_type" data-boss_status="{{$passenger['boss_type']}}">
                {{$passenger['boss_type'] ? '○' : '' }}
              </td>
              <td class="type" data-age_type="{{$passenger['age_type']}}">
                {{config('const.age_type.name.'.$passenger['age_type'])}}
              </td>
              <td class="name left">
                {!! passenger_name($passenger['passenger_last_eij'], $passenger['passenger_first_eij'])!!}
              </td>
              <td>{{config('const.gender.name.' . $passenger['gender'])}}</td>
              <td>{{$passenger['birth_date'] ? $passenger['age'] : ''}}</td>
              <td>{{$cabin['reservation_status']}}</td>
              <td>{{ $passenger['tariff_name'] }}<br/>{{config('const.fare_type.name.'.$passenger['fare_type'])}}</td>
              <td class="right">
                {!! passenger_travel_charge($passenger['age_type'],$passenger['reservation_status'],number_format($passenger['total_travel_charge'])) !!}
              </td>
              <td class="right">
                {{ $passenger['age_type'] && $passenger['total_discount_charge'] ? number_format($passenger['total_discount_charge']).'円' : '' }}
              </td>
              <td class="right">
                {{ $is_user_site && $passenger['age_type'] ? number_format($passenger['total_cancel_charge']).'円' : '' }}
              </td>
              <td class="right">
                {{ $is_user_site && $passenger['age_type'] ? number_format(total_charger($passenger)).'円' : '' }}
              </td>
            </tr>
            <?php $show_passenger_line_number++ ?>
          @endforeach
          </tbody>
        </table>
      @endforeach
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.detail', ['reservation_number' => VossSessionManager::get('reservation_cancel.reservation_number')]) }}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" class="delete reservation_cancel">
        <img src="{{  ext_asset('images/icon/check.png') }}">確定
      </button>
    </div>
  </main>
  {{--データ送信用form領域--}}
  <form id="reservation_cancel_form" action="{{ ext_route('reservation.cancel') }}" method="post"
        data-last_update_date_time="{{$item_info['last_update_date_time']}}"></form>
@endsection
