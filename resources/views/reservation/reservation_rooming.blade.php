@extends('layout.base')

@section('title', 'ルーミング変更画面')

@section('style')
  <link href="{{ mix('css/reservation/reservation_rooming.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/reservation_rooming.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => [
  ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
  ['name' => '予約照会', 'url' => ext_route('reservation.detail', ['reservation_number' => request('reservation_number')]), 'confirm' => true],
  ['name' => 'ルーミング変更']]])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="body">
    @include('include/course',['menu_display' => true, 'shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I050-1001')])
    <div class="list">
      {{--客室タイプ  --}}
      @foreach($cabins as $cabin_line_number => $cabin)
        <table class="center default">
          <thead style="width: 100%">
          <tr>
            <th colspan="3">客室No.{{$loop->iteration}}</th>
            <td colspan="5" class="left">
              {{$cabin['cabin_type_knj']}}
              {{ $cabin['cabin_number'] ? '' : '（'. $cabin['cabin_capacity'] .'）'}}
            </td>
            <th>客室番号</th>
            <td class="left" colspan="2">{{$cabin['cabin_number']?$cabin['cabin_number']:'未定'}}</td>
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
            <th style="width: 18%" colspan="2">入替先</th>
          </tr>
          {{--ご乗船者--}}
          <?php $show_passenger_line_number = 1?>
          @foreach($cabin['passengers'] as $key =>$passenger)
            <tr class="passenger_data">
              <td class="index"
                  data-show_passenger_line_number="{{ $show_passenger_line_number }}"
                  data-passenger_line_number="{{ $passenger['passenger_line_number'] }}">
                {{ $show_passenger_line_number }}
              </td>
              <td>{{$passenger['boss_type'] ? '○' : '' }}</td>
              <td>{{config('const.age_type.name.'.$passenger['age_type'])}}</td>
              <td class="name left">
                {!! passenger_name($passenger['passenger_last_eij'], $passenger['passenger_first_eij'])!!}
              </td>
              <td>{{config('const.gender.name.' . $passenger['gender'])}}</td>
              <td>{{ $passenger['birth_date'] ? $passenger['age'] : '' }}</td>
              <td>{{$cabin['reservation_status']}}</td>
              <td>{{ $passenger['tariff_name'] }}<br/>{{config('const.fare_type.name.'.$passenger['fare_type'])}}</td>
              <td class="right">{{ $passenger['total_travel_charge'] ? number_format($passenger['total_travel_charge']) . '円' : ''}}</td>
              <td class="right">{{ $passenger['total_cancel_charge'] ? number_format($passenger['total_cancel_charge']) . '円' : '' }}</td>
              <td class="right">
                <select name="select_cabin_line_number">
                  @foreach($cabins as $cabin_line_number => $cabin)
                    <option value="{{ $cabin_line_number }}" {{ (int)$cabin_line_number === (int)$passenger['cabin_line_number'] ? 'selected' : '' }}>
                      客室No.{{$loop->iteration}}
                    </option>
                  @endforeach
                </select>
              </td>
            </tr>
            <?php $show_passenger_line_number++ ?>
          @endforeach
          @endforeach
          </tbody>
        </table>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.detail', ['reservation_number' => request('reservation_number')]) }}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" class="delete change_reservation">
        <img src="{{  ext_asset('images/icon/check.png') }}">確定
      </button>
    </div>
  </main>
  {{--データ送信用form領域--}}
  <form id="change_reservation_form" method="post" action="{{ext_route('reservation.rooming')}}">
    <input type="hidden" class="last_update_date_time" value="{{$item_info['last_update_date_time']}}">
    <input type="hidden" class="reservation_number" value="{{ request('reservation_number') }}">
  </form>
@endsection
