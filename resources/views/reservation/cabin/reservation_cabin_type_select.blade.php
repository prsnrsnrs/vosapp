@extends('layout.base')

@section('title', '客室タイプ選択画面')

@section('style')
  <link href="{{ mix('css/reservation/cabin/reservation_cabin_type_select.css') }}" rel="stylesheet"/>
@endsection
@section('js')
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="reservation_cabin_type_select">
    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => $info_message])

    <div class="confirm_time">
      <label id="time">{{ $inquiry_date_time }}現在</label>
    </div>
    <div class="cabin_area">
      <table class="default price_list">
        <tbody>
        <tr>
          <th style="width:25%">客室タイプ</th>
          <th style="width:42%">説明</th>
          <th style="width:17%">旅行代金(大人おひとり様)</th>
          <th style="width:8%">空室状況</th>
          <th style="width:8%">選択</th>
        </tr>
        @foreach($cabins as $row)
          <tr>

            {{--客室タイプ--}}
            <td>
              {{ $row['cabin']['cabin_type_knj'] }}<br>
              <img src="{{ ext_asset($row['cabin']['cabin_image1']) }}" class="suite_cabin">
            </td>

            {{--説明--}}
            <td class="description"><br>
              {!! nl2br($row['cabin']['cabin_description']) !!}
            </td>

            {{--金額--}}
            <td class="price">
              @if(count($tariffs) != 1)
                <dl style="text-align: left">[通常代金]</dl>
              @endif
              @if($row['cabin_member_three'])
                <dl>
                  <dt class="cabin_rates">3名1室</dt>
                  <dd class="cabin_rates">{{ number_format($row['cabin_member_three'])}}</dd>
                </dl>
              @endif
              @if($row['cabin_member_two'])
                <dl>
                  <dt class="cabin_rates">2名1室</dt>
                  <dd class="cabin_rates">{{ number_format($row['cabin_member_two'])}}</dd>
                </dl>
              @endif
              @if($row['cabin_member_one'])
                <dl>
                  <dt class="cabin_rates">1名1室</dt>
                  <dd class="cabin_rates">{{ number_format($row['cabin_member_one']) }}</dd>
                </dl>
              @endif
            </td>

            {{--空室状況--}}
            <td class="status">
              {!! cabin_status($row['status'], true) !!}
            </td>

            {{--選択ボタン--}}
            <td>
              <form method="get" action="{{ ext_route($next_route_name) }}">
                <input type="hidden" name="cabin_type" value="{{ $row['cabin_type'] }}"/>
                @if ($mode === 'new')
                  <input type="hidden" name="item_code" value="{{ $item_code }}"/>
                @else
                  <input type="hidden" name="cabin_line_number" value="{{request('cabin_line_number')}}"/>
                @endif
                {!! cabin_select_next_btn($row['status'], $mode) !!}
              </form>
            </td>
          </tr>
        @endforeach

        </tbody>
      </table>
      <table class="default" style="border: none">
        <tr>
          <td colspan="13" class="right" style="border-top: none">
            〇…空室あり、△…空室わずか、×…満室(キャンセル待ち)
          </td>
        </tr>
      </table>
    </div>

    <div class="button_bar">
      <a href="{{$mode ==='new' ? ext_route('cruise_plan.search') : ext_route('reservation.cabin.passenger_entry') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>

  </main>
@endsection