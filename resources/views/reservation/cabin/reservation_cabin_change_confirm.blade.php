@extends('layout.base')

@section('title', '客室タイプ変更確認画面')

@section('style')
  <link href="{{ mix('css/reservation/cabin/reservation_cabin_change_confirm.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/cabin/reservation_cabin_change_confirm.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_cabin_change_confirm">
    @include('include/course', ['menu_display' => false, 'shipping_cruise_plan' => $shipping_cruise_plan])
    @include('include/information', ['info' => config('messages.info.I050-0104')])
    <div class="detail_area">
      <table rules="all" class="default price_list">
        <tbody>
        <tr>
          <th style="width:100%" colspan="4">{{ $cabin['cabin_type_knj'] }}
            @if($detail['min_count'] < $detail['max_count'])
              （{{$detail['min_count']}} ～ {{$detail['max_count']}}
            @else
              （{{$detail['min_count']}}
            @endif
            名定員）
          </th>
        </tr>
        <tr>
          <td class="cabin" style="width:27%">
            <div class="slider slide_lightbox">
              @for($i=1; $i<=3; $i++)
                @if($cabin['cabin_image' . $i])
                  <div><a href="{{ ext_asset($cabin['cabin_image' . $i]) }}"
                          data-lightbox="group01"><img
                              src="{{ ext_asset($cabin['cabin_image' . $i]) }}"
                              class="cabin_image"></a></div>
                @endif
              @endfor
            </div>
          </td>
          <td style="width:45%; padding: 0 10px" class="description" colspan="2">
            {!! $cabin['cabin_description'] !!}
          </td>
          <td style="width:28%">
            @foreach($detail['prices'] as $tariff_code => $tariff)
              {{--1名1室大人の料金がオールゼロの時は表示しない--}}
              @if($tariff['1']['adult'] != '000000000')
                @if(count($tariffs) != 1)
                  <dl style="margin-left: 17px;margin-top: 10px;">
                    [{{$tariffs[$tariff_code]['tariff_name']}}]
                  </dl>
                @endif
                @foreach($tariff as $room =>$price)
                  @foreach($price as $type =>$value)
                    @if((int)$value)
                      <dl class="price">
                        <dt class="cabin_rates">
                          {{$room}}名1室
                          @if($type === 'adult')大人@elseif($type === 'children')小人@endif
                        </dt>
                        <dd class="cabin_rates">{{ number_format($value) }}</dd>
                      </dl>
                    @endif
                  @endforeach
                @endforeach
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="zumen" style="width: 27%" rowspan="4">
            <div class="slider slide_lightbox">
              @for($i=1; $i<=2; $i++)
                @if($cabin['sketch_image' . $i])
                  <div><a href="{{ ext_asset($cabin['sketch_image' . $i]) }}" data-lightbox="group02"><img
                              src="{{ ext_asset($cabin['sketch_image' . $i]) }}"
                              class="sketch_image"></a></div>
                @endif
              @endfor
            </div>
          </td>
          <td style="width: 8%" class="center">フロア</td>
          <td style="width: 67%" colspan="2"
              class="description default_style">{{ $cabin['floar'].config('const.description_default_style.unit.floor') }}</td>
        </tr>

        <tr>
          <td style="width: 8%" class="center">広さ</td>
          <td style="width: 67%" colspan="2"
              class="description default_style">{{ $cabin['area'].config('const.description_default_style.unit.area')}}</td>
        </tr>

        <tr>
          <td style="width: 8%" class="center">設備</td>
          <td style="width: 67%" colspan="2" class="description default_style">{{ $cabin['facility'] }}</td>
        </tr>

        <tr>
          <td class="center">空室状況</td>
          <td colspan="3" class="select_cabin_number">
            {!! cabin_status($detail['vacancy_status']) !!}
          </td>
        </tr>

        </tbody>
      </table>

      <div class="member_area" style="margin-top: 10px">
        <table rules="all" class="default center">
          <tbody>
          <tr>
            <th style="width:7%">No.</th>
            <th style="width:13%">大小幼</th>
            <th style="width:35%">お名前</th>
            <th style="width:15%">性別</th>
            <th style="width:15%">年齢</th>
            <th style="width:15%">料金ﾀｲﾌﾟ</th>
          </tr>
          {{--ご乗船者--}}
          @foreach($passengers as $passenger)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{ config(('const.age_type.short_name.' . $passenger['age_type'] )) }}</td>
              <td class="name left">
                @if(!$passenger['passenger_last_eij'] || !$passenger['passenger_first_eij'])
                  <span class="danger">未入力</span>
                @else
                  {!! passenger_name($passenger['passenger_last_eij'],$passenger['passenger_first_eij'] ) !!}
                @endif
              </td>
              <td>{{$passenger['gender']? config('const.gender.name.' . $passenger['gender']) : ''}}</td>
              <td>{{ $passenger['birth_date'] ? $passenger['age'] : '' }}</td>
              <td>{{ $passenger['tariff_name'] }}<br/>{{config('const.fare_type.name.'. $passenger['fare_type'])}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.cabin.type_select', ['cabin_line_number' => request('cabin_line_number')])}}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <form id="reservation_change_done" method="post" action="{{ext_route('reservation.cabin.change_confirm')}}"
            style="display: inline-block;">
        <button type="submit" class="done">
          <img src="{{  ext_asset('images/icon/check.png') }}">確定
        </button>
        <input type="hidden" class="cabin_type" value="{{request('cabin_type')}}">
        <input type="hidden" class="cabin_line_number" value="{{request('cabin_line_number')}}">
      </form>
    </div>

  </main>
@endsection