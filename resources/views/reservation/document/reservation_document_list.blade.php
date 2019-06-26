@extends('layout.base')

@section('title', '提出書類一覧画面')

@section('style')
  <link href="{{ mix('css/reservation/document/reservation_document_list.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
  ['name' => 'マイページ','url' => ext_route('mypage')],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list')],
  ['name' => '予約照会','url'=>ext_route('reservation.detail',['reservation_number' => $item_info['reservation_number']])],
  ['name' =>'提出書類一覧']
]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="body">

    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I060-0101')])

    <div class="list">
      <table class="default">
        <thead>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 22%">お名前</th>
          <th style="width: 40%">書類一覧</th>
          <th style="width: 13%">入力・申込方法</th>
          <th style="width: 15%">返信</th>
          <th style="width: 5%">確認</th>
        </tr>
        </thead>


        <tbody>
        {{--旅行者向けサイト、または旅行者向けテストサイトの場合--}}
        @if($is_agent_site || $is_agent_test_site)
          @forelse($passengers as $key => $passenger)
            {{--乗船者ごとの提出書類枚数分for文で回す--}}
            @for($i=0; $i<$passenger['document_count']; $i++)
              <tr>
                {{--一回目のループだけNoとお名前の項目を表示する--}}
                @if($i ===0)
                  <td class="index" rowspan="{{$passenger['document_count']}}">{{$loop->iteration}}</td>
                  <td class="name left" rowspan="{{$passenger['document_count']}}">
                    {!! passenger_name($passenger[0]['passenger_last_eij'], $passenger[0]['passenger_first_eij']) !!}<br>
                    {!! passenger_name($passenger[0]['passenger_last_knj'], $passenger[0]['passenger_first_knj']) !!}
                  </td>
                @endif

                <td>{{$passenger[$i]['progress_manage_name']}}</td>

                <td>
                  {{config('const.document_get_type.name.'.$passenger[$i]['document_get_type'])}}
                  {{--PDF出力の場合はアイコンを表示する--}}
                  @if($passenger[$i]['document_get_type']==='1')
                    <a target="_blank"
                       href=" {{ext_route('pdf.document.download',[
                     'reservation_number' => $item_info['reservation_number'],
                     'passenger_line_number' => $passenger[$i]['passenger_line_number'],
                     'progress_manage_code' => $passenger[$i]['progress_manage_code']])}}">
                      <img src="{{ ext_asset('/images/pdf.png') }}">
                    </a>
                  @endif
                </td>

                <td>{{config('const.answer_format.name.'.$passenger[$i]['answer_format'])}}</td>

                <td>
                  {!! convert_check_finish_type($passenger[$i]['check_finish_date'],$passenger[$i]['document_check_type']) !!}
                </td>
              </tr>
            @endfor
          @empty
            <tr>
              <td class="list_empty"
                  colspan="6">提出書類はありません。
              </td>
            </tr>
          @endforelse


          {{--個人向けサイトの場合--}}
        @elseif($is_user_site)
          @foreach($passengers as $key => $passenger)
            {{--乗船者ごとの提出書類枚数分for文で回す--}}
            @for($i=0; $i<$passenger['document_count']; $i++)
              <tr>
                {{--一回目のループだけNoとお名前の項目を表示する--}}
                @if($i==0)
                  <td class="index" rowspan="{{$passenger['passenger_line_count']}}">{{$loop->iteration}}</td>
                  <td class="name left" rowspan="{{$passenger['passenger_line_count']}}">
                    {!! passenger_name_kana($passenger[0]['passenger_last_kana'], $passenger[0]['passenger_first_kana']) !!}
                  </td>
                @endif

                <td rowspan="{{$passenger[$i]['line_count']}}">{{$passenger[$i]['progress_manage_name']}}</td>

                {{--ネット入力区分が不可ならネット入力区分の行を省いて表示する--}}
                @if(empty($passenger[$i]['net_input_type']))
                  <td>
                    {{config('const.document_get_type.name.'.$passenger[$i]['document_get_type'])}}
                    {{--PDF出力の場合はアイコンを表示する--}}
                    @if($passenger[$i]['document_get_type']==='1')
                      <a target="_blank"
                         href=" {{ext_route('pdf.document.download',[
                     'reservation_number' => $item_info['reservation_number'],
                     'passenger_line_number' => $passenger[$i]['passenger_line_number'],
                     'progress_manage_code' => $passenger[$i]['progress_manage_code']])}}">
                        <img src="{{ ext_asset('/images/pdf.png') }}">
                      </a>
                    @endif
                  </td>

                  <td>
                    {!! convert_answer_upload(
                    $passenger[$i]['document_get_type'],
                    $passenger[$i]['answer_format'],
                    $passenger[$i]['upload_possible']) !!}
                  </td>
                @else
                  <td>
                    <button class="done">{{config('const.net_input_type.name.'.$passenger[$i]['net_input_type'])}}</button>
                  </td>

                  <td>{{config('const.answer_format.name.'.$passenger[$i]['answer_format'])}}</td>
                @endif

                <td rowspan="{{$passenger[$i]['line_count']}}">
                  {!! convert_check_finish_type($passenger[$i]['check_finish_date'],$passenger[$i]['document_check_type']) !!}
                </td>
              </tr>

              {{--行数が2ならもう一行表示する--}}
              @if($passenger[$i]['line_count']=='2')
                <tr>
                  <td>
                    {{config('const.document_get_type.name.'.$passenger[$i]['document_get_type'])}}
                    {{--PDF出力の場合はアイコンを表示する--}}
                    @if($passenger[$i]['document_get_type']==='1')
                      <a target="_blank"
                         href=" {{ext_route('pdf.document.download',[
                     'reservation_number' => $item_info['reservation_number'],
                     'passenger_line_number' => $passenger[$i]['passenger_line_number'],
                     'progress_manage_code' => $passenger[$i]['progress_manage_code']])}}">
                        <img src="{{ ext_asset('/images/pdf.png') }}">
                      </a>
                    @endif
                  </td>

                  <td>
                    {!! convert_answer_upload(
                    $passenger[$i]['document_get_type'],
                    $passenger[$i]['answer_format'],
                    $passenger[$i]['upload_possible']) !!}
                  </td>
                </tr>
              @endif
            @endfor
          @endforeach
        @endif
        </tbody>

      </table>
    </div>
    <p>※済マークは当社の確認後になりますので、回答後でもすぐには反映されません。</p>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]) }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>

  </main>
@endsection