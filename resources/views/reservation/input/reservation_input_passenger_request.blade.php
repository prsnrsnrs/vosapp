@extends('layout.base')

@section('title', 'ご乗船者リクエスト入力')

@section('style')
  <link href="{{ mix('css/reservation/input/reservation_input_passenger_request.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/input/reservation_input_passenger_request.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
  ['name' => 'マイページ','url' => ext_route('mypage'), 'confirm' => true],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
  ['name' => '予約照会','url'=>ext_route('reservation.detail',['reservation_number' => $item_info['reservation_number']]), 'confirm' => true],
  ['name' =>'ご乗船者リクエスト']
]])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_input_passenger_request">

    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I050-0701')])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li class="current">②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

    <form id="passenger_form" action="{{ext_route('reservation.input.passenger_request')}}" method="post">
      {{--submit時に送る用のデータ--}}
      <input name="reservation_number" type="hidden" value={{$item_info['reservation_number']}}>
      <input name="last_update_date_time" type="hidden" value="{{ $item_info['last_update_date_time'] }}">

      <table class="default meal_request">
        <tbody>
        <th style="width: 12%">食事希望</th>
        <td style="width: 88%">
          <select style="width: 100px" name="meal_request">
            @if($seating ==="1")
              <option value="1" {{ option_selected($item_info['seating_request'], "1") }}>
                {{config('const.meal_request.name.1')}}</option>
            @elseif($seating === "2")
              <option value="2" {{ option_selected($item_info['seating_request'], "2")}}>
                {{config('const.meal_request.name.2')}}</option>
            @else
              <option value="0" {{ option_selected($item_info['seating_request'], "0" )}}>
                {{config('const.meal_request.name.0')}}</option>
              <option value="1" {{ option_selected($item_info['seating_request'], "1" )}}>
                {{config('const.meal_request.name.1')}}</option>
              <option value="2" {{ option_selected($item_info['seating_request'], "2")}}>
                {{config('const.meal_request.name.2')}}</option>
            @endif
          </select>
          &nbsp;&nbsp;&nbsp;1回目/17:30　2回目/19:30　※時間は目安です。クルーズや日によって異なります。また、ご希望に添えない場合もありますので予めご了承下さい。
        </td>
        </tbody>
      </table>

      <table class="default center">
        <tbody>
        <tr>
          <th style="width:4%">No.</th>
          <th style="width:5%">大小幼</th>
          <th style="width:18%">お名前</th>
          <th style="width:4%">性別</th>
          <th style="width:4%">年齢</th>
          <th style="width:15%">子供食<a href="javascript:void(0);" class="kids_menu">（？）</a></th>
          <th style="width:15%">記念日等</th>
          <th style="width:35%">備考</th>
        </tr>
        </tbody>

        @foreach($passengers as $passenger)
          <tr>
            {{--submit時に送る用のデータ--}}
            <input type="hidden" name="passengers[{{$loop->iteration}}][passenger_line_number]"
                   value="{{$passenger['passenger_line_number']}}">
            <input type="hidden" name="passengers[{{$loop->iteration}}][display_line_number]"
                   value="{{$loop->iteration}}">

            <td>{{$loop->iteration}}</td>

            <td>{{ config('const.age_type.name.'.$passenger['age_type']) }}</td>

            <td class="name left">{!! passenger_name($passenger['passenger_last_eij'], $passenger['passenger_first_eij']) !!}</td>

            <td>{{ config('const.gender.name.'.$passenger['gender']) }}</td>

            <td>{{ $passenger['birth_date'] ? $passenger['age'] : '' }}</td>

            {{--デフォルトで子供食区分と幼児食区分に空をセット--}}
            <td>
              <input name="passengers[{{$loop->iteration}}][child_meal_type]" type="hidden" value="">
              <input name="passengers[{{$loop->iteration}}][infant_meal_type]" type="hidden" value="">
              @if($passenger['age_type']===config('const.age_type.value.child'))
                <select name="passengers[{{$loop->iteration}}][child_meal_type]">
                  <option value="none" {{ option_selected($passenger['child_meal_type'], "") }}></option>
                  @foreach( config('const.child_meal_type.name') as $type=>$name)
                    <option value="{{$type}}" {{ option_selected($passenger['child_meal_type'], $type)}}>{{$name}}</option>
                  @endforeach
                </select>
              @elseif($passenger['age_type']===config('const.age_type.value.infant'))
                <select name="passengers[{{$loop->iteration}}][infant_meal_type]">
                  @foreach( config('const.infant_meal_type.name') as $type=>$name)
                    <option value="{{$type}}" {{ option_selected($passenger['infant_meal_type'], $type)}}>{{$name}}</option>
                  @endforeach
                </select>
              @endif
            </td>

            {{--記念日--}}
            <td>
              @if($passenger['age_type'] === config('const.age_type.value.adult'))
                <select name="passengers[{{$loop->iteration}}][anniversary_type]">
                  <option value="">無し</option>
                  @foreach($anniversaries as $type =>$anniversary)
                    <option value="{{$anniversary['anniversary_type']}}" {{ option_selected($passenger['anniversary'], $anniversary['anniversary_type']) }}>
                      {{$anniversary['anniversary']}}
                    </option>
                  @endforeach
                </select>
              @else
                <input name="passengers[{{$loop->iteration}}][anniversary_type]" type="hidden" value="">
              @endif
            </td>

            <td class="net_remark">
              <input name="passengers[{{$loop->iteration}}][net_remark]" type="text" style="width: 98%"
                     placeholder="" maxlength="302" value="{{$passenger['net_remark']}}">
            </td>
          </tr>
        @endforeach
      </table>
    </form>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.input.passenger', ['reservation_number' => $item_info['reservation_number']]) }}">
        <button type="button" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" id="next" class="done">
        <img src="{{  ext_asset('images/icon/next.png') }}">次へ(客室リクエスト入力)
      </button>
      <button type="submit" id="skip" class="done"
              data-skip_url="{{ ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]) }}">
        <img src="{{  ext_asset('images/icon/skip.png') }}">スキップ（照会へ）
      </button>
    </div>
  </main>

  <div class="kids_menu_img" style="display: none">
    <img src="{{ ext_asset('/images/kids_menu.jpg') }}" style="max-width: 459px;">
    <p>子供食のイメージ画像です。</p>
  </div>
@endsection