@extends('layout.base')

@section('title', 'ご連絡閲覧画面')

@section('style')
  <link href="{{ mix('css/reservation/contact/reservation_contact_detail.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ','url' => ext_route('mypage')],
    ['name' => 'ご連絡一覧','url' => ext_route('reservation.contact.list')],
    ['name' => 'ご連絡閲覧']
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main>
    <div class="reservation_contact_detail">
      <table class="left default search">
        <thead>
        <tr>
          <th colspan="2">日本クルーズ客船からのご連絡</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">送信日時</th>
          <td style="width: 85%">
            {{date('Y/m/d',  strtotime($contact_detail['mail_send_date_time']))}}&nbsp;
          {{date('H:i',  strtotime($contact_detail['mail_send_date_time']))}}
        </tr>
        <tr>
          <th>クルーズ名（コース）</th>
          <td>{{$contact_detail['item_name']}}&nbsp;{{$contact_detail['item_name2']}}</td>
        </tr>
        <tr>
          <th>出発日</th>
          <td>{{$contact_detail['departure_place_knj']}}発&nbsp;
            {{date('Y年m月d日',  strtotime($contact_detail['item_departure_date']))}}
            ({{get_youbi($contact_detail['item_departure_date'])}})
          </td>
        </tr>
        <tr>
          <th>予約番号</th>
          <td>{{$contact_detail['reservation_number']}}</td>
        </tr>
        <tr>
          <th>代表者お名前</th>
          <td>{{$contact_detail['passenger_first_eij']}}&nbsp;{{$contact_detail['passenger_last_eij']}}</td>
        </tr>
        <tr>
          <th>送信先メールアドレス</th>
          <td>{{$send_mail_addresses}}</td>
        </tr>
        <tr>
          <th>件名</th>
          <td>{!! $contact_detail['mail_subject'] !!}</td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="panel">
      <div class="title">日本クルーズ客船からのご連絡内容</div>
      <div class="body ">
        {{--メール形式によって改行タグを入れるか入れないかの判別--}}
        @if($contact_detail['mail_format'] === "H")
          <p>{!! $contact_detail['mail_text'] !!}</p>
        @elseif($contact_detail['mail_format'] === "T")
          <p>{!! nl2br($contact_detail['mail_text']) !!}</p>
        @endif
      </div>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.contact.list') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>

  </main>
@endsection