@extends('layout.base')

@section('title', '割引情報入力画面')

@section('style')
  <link href="{{ mix('css/reservation/input/reservation_input_discount.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/input/reservation_input_discount.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
  ['name' => 'マイページ','url' => ext_route('mypage'), 'confirm' => true],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
  ['name' => '予約照会','url'=>ext_route('reservation.detail',['reservation_number' => $item_info['reservation_number']]), 'confirm' => true],
  ['name' =>'割引情報入力']
]])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_input_discount">

    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I050-0501')])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li class="current">④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

    <div class="input_area">
      <table rules="all" class="default">
        <tbody>
        <tr>
          <th style="width:4%">No.</th>
          <th style="width:8%">大小幼</th>
          <th style="width:20%">お名前</th>
          <th style="width:4%">性別</th>
          <th style="width:4%">年齢</th>
          <th style="width:15%">料金タイプ</th>
          <th style="width:35%">割引券番号</th>
          <th style="width:10%">割引券額</th>
        </tr>

        <form id="passenger_form" action="{{ext_route('reservation.input.discount')}}" method="post">
          {{--submit時に送る用のデータ--}}
          <input name="reservation_number" type="hidden" value={{$item_info['reservation_number']}}>
          <input name="last_update_date_time" type="hidden" value="{{ $item_info['last_update_date_time'] }}">
          @foreach($passengers as $passenger)
            {{--submit時に送る用のデータ--}}
            <input type="hidden" name="passengers[{{$loop->iteration}}][passenger_line_number]"
                   value="{{$passenger[0]['passenger_line_number']}}">
            <input type="hidden" name="passengers[{{$loop->iteration}}][display_line_number]"
                   value="{{$loop->iteration}}">
            <tr>
              <td>{{$loop->iteration}}</td>

              <td>{{ config('const.age_type.name.'.$passenger[0]['age_type']) }}</td>

              <td class="name left">{!! passenger_name($passenger[0]['passenger_last_eij'], $passenger[0]['passenger_first_eij']) !!}</td>

              <td>{{ config('const.gender.name.'.$passenger[0]['gender']) }}</td>

              <td>{{ $passenger[0]['birth_date'] ? $passenger[0]['age'] : '' }}</td>

              <td>
                <select style="width: 90%" name="passengers[{{$loop->iteration}}][tariff_code]">
                  @foreach($tariffs as $tariff)
                    <option value="{{$tariff['tariff_code']}}" {{option_selected($passenger[0]['tariff_code'],$tariff['tariff_code'])}}>{{$tariff['tariff_name']}}</option>
                  @endforeach
                </select>
              </td>

              @if(empty($passenger[0]['passenger_last_eij']) || empty($passenger[0]['passenger_first_eij']) ||
              empty($passenger[0]['gender']) || empty($passenger[0]['birth_date']))
                <td colspan="3" class="danger">先にご乗船者詳細入力を完了して下さい</td>
                @for ($i = 1; $i <= 5; $i++)
                  <input type="hidden" name="passengers[{{$loop->iteration}}][discount_number][{{$i}}]"
                         maxlength="11" value="">
                @endfor
              @else
                <td>
                  @for ($i = 1; $i <= 5; $i++)
                    <input type="text" name="passengers[{{$loop->iteration}}][discount_number][{{$i}}]"
                           maxlength="11"
                           value="{{ $passenger[$i-1]['discount_number'] or '' }}">
                  @endfor
                </td>
                <td>
                  <label class="ticket_fee right">
                    {{$passenger[0]['total_discount_charge'] != "0" ? number_format($passenger[0]['total_discount_charge']).'円':''}}
                  </label>
                </td>
              @endif
            </tr>
          @endforeach
        </form>
        </tbody>
      </table>

      <div class="button_ticket">

        <button type="submit" id="discount_confirm" class="done">
          <img class="discount_img" src="{{  ext_asset('images/icon/ticket.png') }}">
          割引券使用確定
        </button>
      </div>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.input.cabin_request', ['reservation_number' => $item_info['reservation_number']]) }}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" id="next" class="done">
        <img src="{{  ext_asset('images/icon/next.png') }}">次へ(質問事項のチェック)
      </button>
      <button type="submit" id="skip" class="done"
              data-skip_url="{{ ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]) }}">
        <img src="{{  ext_asset('images/icon/skip.png') }}">スキップ（照会へ）
      </button>
    </div>
  </main>
@endsection