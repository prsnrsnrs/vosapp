@extends('layout.base')

@section('title', '質問事項のチェック')

@section('style')
  <link href="{{ mix('css/reservation/input/reservation_input_question.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/input/reservation_input_question.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
  ['name' => 'マイページ','url' => ext_route('mypage'), 'confirm' => true],
  ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
  ['name' => '予約照会','url'=>ext_route('reservation.detail',['reservation_number' => $item_info['reservation_number']]), 'confirm' => true],
  ['name' =>'質問事項のチェック']
]])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="reservation_input_question">

    @include('include/course',['shipping_cruise_plan' => shipping_cruise_plan($item_info)])
    @include('include/information', ['info' => config('messages.info.I050-0601')])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li class="current">⑤質問事項のチェック</li>
      </ul>
    </div>

    <div class="check_area">
      <table class="default">
        <tbody>
        <tr>
          <th style="width:4%" rowspan="2">No.</th>
          <th style="width:8%" rowspan="2">大小幼</th>
          <th style="width:20%" rowspan="2">お名前</th>
          <th style="width:4%" rowspan="2">性別</th>
          <th style="width:4%" rowspan="2">年齢</th>
          {{--質問Noを質問数分回す(回答形式がラジオボタンの場合は横幅を固定)--}}
          @foreach($questions as $question)
            @if($question['answer_format']==='R')
              <th style="width:16%">質問{{$loop->iteration}}</th>
            @else
              <th style="">質問{{$loop->iteration}}</th>
            @endif
          @endforeach
        </tr>
        <tr>
          @foreach($questions as $question)
            <th scope="col">
              <p class="question">{{$question['question_sentence']}}</p>
            </th>
          @endforeach
        </tr>

        {{--submit時に送るデータ--}}
        <form id="passenger_form" action="{{ext_route('reservation.input.question')}}" method="post">
          <input name="reservation_number" type="hidden" value={{$item_info['reservation_number']}}>
          <input name="last_update_date_time" type="hidden" value="{{ $item_info['last_update_date_time'] }}">
          <input type="hidden" name="questions" value="{{$questions_count}}">

          @foreach ($passengers as $passenger)
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

              {{--性別、年齢のうちどれかがブランクのデータ--}}
              @if(empty($passenger[0]['gender']) || empty($passenger[0]['birth_date']))
                <td colspan="{{$questions_count}}" class="danger">先にご乗船者詳細入力を完了して下さい</td>
                {{--質問数分、空のデータを送る--}}
                @for($i = 1; $i<=$questions_count; $i++)
                  <input type="hidden"
                         name="passengers[{{$loop->iteration}}][answers][{{$i}}]" value="">
                @endfor
                {{--ご乗船者名英字、性別、年齢が全て入力されているデータ--}}
              @else
                {{--表示されている質問分回す--}}
                @for($i = 1; $i<=$questions_count; $i++)
                  <td>
                    {{--乳幼児自動設定フラグ= ‘Y’ かつ、幼児の場合--}}
                    @if($questions[$i]['infants_auto_flag'] === 'Y' && $passenger[0]['age_type'] ==='I')
                      <label>
                        <input type="checkbox" class="check_style" disabled="disabled" checked="checked">
                        <span class="checkbox"></span>
                        <input type="hidden"
                               name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                               value="Y">
                      </label>
                      {{--乳幼児自動設定フラグ= ‘Y’の場合 または、女性回答フラグ = ‘Y’かつ、男性の場合 または、女性回答フラグ = ‘Y’かつ、大人でない場合--}}
                    @elseif($questions[$i]['infants_auto_flag'] === 'Y' ||
                       ($questions[$i]['female_answer_flag'] === 'Y' && $passenger[0]['gender'] ==='M') ||
                       ($questions[$i]['female_answer_flag'] === 'Y' && $passenger[0]['age_type'] !=='A'))
                      <input type="hidden"
                             name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                             value="">
                      {{--回答形式がチェックボックスの場合--}}
                    @elseif($questions[$i]['answer_format']==='C')
                      <input type="hidden"
                             name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                             value="">
                      <label>
                        <input type="checkbox" class="check_style"
                               name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                               value="Y"
                                {{ input_checked($passengers[$loop->iteration][$i-1]['answer'], "Y") }}>
                        <span class="checkbox"></span>
                      </label>
                      {{--回答形式がラジオボタンの場合--}}
                    @elseif($questions[$i]['answer_format']==='R')
                      <input type="hidden"
                             name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                             value="none">
                      <label>
                        <input type="radio" class="check_style"
                               name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                               value="Y"
                                {{ input_checked($passengers[$loop->iteration][$i-1]['answer'], "Y") }}>
                        <span class="checkbox"></span>はい
                      </label>
                      <label>
                        <input type="radio" class="check_style"
                               name="passengers[{{$loop->iteration}}][answers][{{$i}}]"
                               value="N"
                                {{ input_checked($passengers[$loop->iteration][$i-1]['answer'], "N") }}>
                        <span class="checkbox"></span>いいえ
                      </label>
                    @endif
                  </td>
                @endfor
              @endif
            </tr>
          @endforeach
        </form>
        </tbody>
      </table>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.input.discount', ['reservation_number' => $item_info['reservation_number']]) }}">
        <button type="submit" class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" id="next" class="done">
        <img src="{{  ext_asset('images/icon/next.png') }}">次へ(予約照会へ)
      </button>
      <button type="submit" id="skip" class="done"
              data-skip_url="{{ ext_route('reservation.detail', ['reservation_number' => $item_info['reservation_number']]) }}">
        <img src="{{  ext_asset('images/icon/skip.png') }}">スキップ（照会へ）
      </button>
    </div>
  </main>
@endsection