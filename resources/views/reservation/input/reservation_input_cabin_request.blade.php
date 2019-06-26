@extends('layout.base')

@section('title', '客室リクエスト入力')

@section('style')
  <link href="{{ mix('css/reservation/input/reservation_input_cabin_request.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/input/reservation_input_cabin_request.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
  ['name' => 'マイページ','url' => ext_route('mypage'), 'confirm' => true],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
  ['name' => '予約照会','url'=>ext_route('reservation.detail',['reservation_number' => $item_info['reservation_number']]), 'confirm' => true],
  ['name' =>'客室リクエスト入力']
]])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_input_cabin_request">

    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I050-0401')])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li class="current">③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li>⑤質問事項のチェック</li>
      </ul>
    </div>

    <form id="cabin_form" action="{{ext_route('reservation.input.cabin_request')}}" method="post">
      {{--submit時に送る用のデータ--}}
      <input type="hidden" name="reservation_number" value={{$item_info['reservation_number']}}>
      <input type="hidden" name="last_update_date_time" value="{{$item_info['last_update_date_time']}}">
      <table rules="all" class="default request">
        <tbody>
        <tr>
          <th style="width:8%">客室No.</th>
          <th style="width:20%">タイプ</th>
          <th style="width:24%">客室タイプリクエスト</th>
          <th style="width:48%">キャビンリクエスト</th>
        </tr>

        @foreach($passengers as $passenger)
          {{--submit時に送る用のデータ--}}
          <input type="hidden" name="passengers[{{$loop->iteration}}][cabin_line_number]"
                 value="{{$passenger['cabin_line_number']}}">
          <input type="hidden" name="passengers[{{$loop->iteration}}][display_line_number]"
                 value="{{$loop->iteration}}">

          <tr>
            <td>{{$loop->iteration}}</td>

            <td>{{$passenger['cabin_type_knj']}}</td>

            <td>
              <select style="width: 90%" name="passengers[{{$loop->iteration}}][cabin_type_request]">
                <option value=""></option>
                @foreach($cabins as $cabin)
                  <option value="{{$cabin['cabin_type']}}" {{option_selected($passenger['cabin_type_request'],$cabin['cabin_type'])}}>{{$cabin['cabin_type_knj']}}</option>
                @endforeach
              </select>
            </td>

            <td>
              <input type="text" value="{{$passenger['cabin_request_free']}}"
                     name="passengers[{{$loop->iteration}}][cabin_request_free]" style="width: 95%"
                     placeholder="例)660～680の左舷" maxlength="52">
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </form>

    <div class="button_deck">
      <a href="http://www.venus-cruise.co.jp/intro/floor.html" target=”_blank”>
        <button class="add">
          デッキプランを見る
        </button>
      </a>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.input.passenger_request', ['reservation_number' => $item_info['reservation_number']]) }}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" id="next" class="done">
        <img src="{{  ext_asset('images/icon/next.png') }}">次へ（割引情報入力）
      </button>
      <button type="submit" id="skip" class="done"
              data-skip_url="{{ ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]) }}">
        <img src="{{  ext_asset('images/icon/skip.png') }}">スキップ（照会へ）
      </button>
    </div>
  </main>
@endsection