@extends('layout.base')

@section('title', '客室人数選択画面')

@section('style')
  <link href="{{ mix('css/reservation/cabin/reservation_cabin_passenger_select.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/cabin/reservation_cabin_passenger_select.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_cabin_passenger_select">
    @include('include/course',['menu_display' => false, 'shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => '人数を選択して下さい'])
    <div class="detail_area">
      <table rules="all" class="default price_list">
        <tbody>
        <tr>
          <th style="width:100%" colspan="3">{{ $cabin_detail['cabin_type_knj'] }}
            @if($cabin_by_type['min_count'] < $cabin_by_type['max_count'])
              （{{$cabin_by_type['min_count']}} ～ {{$cabin_by_type['max_count']}}
            @else
              （{{$cabin_by_type['min_count']}}
            @endif
            名定員）
          </th>
          <th>
            旅行代金 (お一人様あたり)
          </th>
        </tr>
        <tr>
          <td class="cabin" style="width:27%">
            <div class="slider slide_lightbox">
              @for($i=1; $i<=3; $i++)
                @if($cabin_detail['cabin_image' . $i])
                  <div><a href="{{ ext_asset($cabin_detail['cabin_image' . $i]) }}" data-lightbox="group01"><img
                              src="{{ ext_asset($cabin_detail['cabin_image' . $i]) }}" class="cabin_image"></a></div>
                @endif
              @endfor
            </div>
          </td>
          <td style="width:45%; padding: 0 10px" class="description"
              colspan="2">{!! $cabin_detail['cabin_description']  !!}</td>
          <td style="width:28%">
            @foreach($cabin_by_type['prices'] as $tariff_code => $tariff)
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
                        <dd class="cabin_rates">{{ number_format($value)}}</dd>
                      </dl>
                    @endif
                  @endforeach
                @endforeach
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="cabin" style="width:27%" rowspan="3">
            <div class="slider slide_lightbox">
              @for($i=1; $i<=2; $i++)
                @if($cabin_detail['sketch_image' . $i])
                  <div><a href="{{ ext_asset($cabin_detail['sketch_image' . $i]) }}" data-lightbox="group02">
                      <img src="{{ ext_asset($cabin_detail['sketch_image' . $i]) }}" class="sketch_image"></a>
                  </div>
                @endif
              @endfor
            </div>
          </td>
          <td style="width: 8%" class="center">フロア</td>
          <td style="width: 67%" colspan="2"
              class="description default_style">{{ $cabin_detail['floar'].config('const.description_default_style.unit.floor')}}</td>
        </tr>

        <tr>
          <td style="width: 8%" class="center">広さ</td>
          <td style="width: 67%" colspan="2"
              class="description default_style">{{ $cabin_detail['area'].config('const.description_default_style.unit.area')}}</td>
        </tr>
        <tr>
          <td style="width: 8%" class="center">設備</td>
          <td style="width: 67%" colspan="2" class="description default_style">{{ $cabin_detail['facility'] }}</td>
        </tr>

        <tr>
          <td class="center">空室状況</td>
          <td colspan="3" class="select_cabin_number">
            {!! cabin_status($cabin_by_type['vacancy_status']) !!}
          </td>
        </tr>

        <tr>
          <td class="center">客室数選択</td>
          <td colspan="3" class="select_cabin_number">
            <select class="select_cabin" name="select_cabin_number">
              @for($i = 1; $i <= 3; $i++)
                <option value="{{$i}}">{{$i}}</option>
              @endfor
            </select>
            <span class="danger">※選択された部屋数が確実に確保されるわけではございません。あらかじめご了承ください。</span>
          </td>
        </tr>
        <tr>
          <td style="width: 25%" class="center">人数選択</td>
          <td style="width: 75%" colspan="3" class="choose_number default_style">
            <table class="cabin_passenger">
              <tbody>
              <tr style="padding: 8px 0;">
                @for($i = 1; $i <= 3; $i++)
                  <td>
                    <div class="select_form_{{$i}} count_passenger_form" style="{{ $i != 1 ? 'display:none' : '' }}">
                      <span>客室{{$i}}</span>
                      <dl>
                        <dt class="choose_number">{{ config('const.age_type.full_name.A') }}</dt>
                        <dd class="choose_number">
                          <select name="select_number" class="adult">
                            @for($j = 0; $j <= $cabin_by_type['max_count']; $j++)
                              <option value="{{$j}}" class="select_{{$j}}">{{$j}}</option>
                            @endfor
                          </select>
                        </dd>
                      </dl>
                      <dl>
                        <dt class="choose_number">{{ config('const.age_type.full_name.C') }}</dt>
                        <dd class="choose_number">
                          <select name="select_number" class="children">
                            @for($j = 0; $j <= $cabin_by_type['max_count']; $j++)
                              <option value="{{$j}}" class="select_{{$j}}">{{$j}}</option>
                            @endfor
                          </select>
                        </dd>
                      </dl>
                      <dl>
                        <dt class="choose_number">{{ config('const.age_type.full_name.I') }}</dt>
                        <dd class="choose_number">
                          <select name="select_number" class="child">
                            @for($j = 0; $j <= $cabin_by_type['max_count']; $j++)
                              <option value="{{$j}}" class="select_{{$j}}">{{$j}}</option>
                            @endfor
                          </select>
                        </dd>
                      </dl>
                    </div>
                  </td>
                @endfor
              </tr>
              </tbody>
            </table>
            <p style="margin: 0 0 5px 7px;">※ご乗船時の年齢（就学状況）</p>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="button_bar">
      <a href="{{$mode ==='new' ? ext_route('reservation.cabin.type_select', ['item_code' => request('item_code')]) : ext_route('reservation.cabin.type_select') }}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" class="done">
        <img src="{{  ext_asset('images/icon/next.png') }}">次へ（ご乗船者入力）
      </button>
    </div>

  </main>

  {{--データ送信用form--}}
  <form class="form" action="{{ ext_route('reservation.cabin.passenger_select.cabin_create' ) }}" method="post">
    <input class="item_code" type="hidden" value="{{ request('item_code') }}">
    <input class="cabin_type" type="hidden" value="{{ request('cabin_type') }}">
  </form>
@endsection