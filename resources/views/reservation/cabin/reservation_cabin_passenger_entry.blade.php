@extends('layout.base')

@section('title', 'ご乗船者名入力画面')

@section('style')
  <link href="{{ mix('css/reservation/cabin/reservation_cabin_passenger_entry.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/cabin/reservation_cabin_passenger_entry.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="body">
    @include('include/course',['menu_display' => false, 'shipping_cruise_plan' => shipping_cruise_plan($item)])
    @include('include/information', ['info' => config('messages.info.I050-0201')])
    <div class="list">
      {{--客室タイプ--}}
        <?php $show_passenger_line_number = 1?>
      @foreach($cabins as $key=> $detail)
        <table class="default center passenger" data-show-cabin-line-number="{{$loop->iteration}}">
          <thead style="width: 100%">
          <tr>
            <th colspan="3">客室No.{{$loop->iteration}}</th>
            <td  colspan="2" class="left">{{$detail['cabin']['cabin_type_knj']}}
              {{ !$detail['cabin']['cabin_number'] ? $detail['cabin']['cabin_capacity']  : '' }}
            </td>

            <td>
              @if($detail['cabin']['reservation_type'] !== config('const.reservation_type.value.wait'))
                <form id="cabin_type_change" method="post"
                      action="{{ext_route('reservation.cabin.passenger_entry.cabin_change')}}">
                  <input type="hidden" class="cabin_line_number"
                         value="{{$detail['cabin']['cabin_line_number']}}">
                  <button type='submit' class="edit center">客室タイプ変更</button>
                </form>
              @endif
            </td>
            <td>
              <button class="delete table_delete cabin_cancel">取消</button>
            </td>
          </tr>
          </thead>
          <tbody>
          <tr class="head">
            <th style="width: 5%">No</th>
            <th style="width: 5%">代表</th>
            <th style="width: 5%">区分</th>
            <th style="width: 55%">お名前（英字）</th>
            <th style="width: 5%">ｽﾃｰﾀｽ</th>
            <th style="width: 17%">
              {{$user_site ? '登録済み一覧から選択' : '' }}</th>
            <th style="width: 8%"></th>
          </tr>

          <input id="cabins_count" type="hidden" value={{$cabins_count}}>
          {{--ご乗船者--}}
          @foreach($detail['passengers'] as  $passenger)
            <tr class="passenger_data">
              <td class="index"
                  data-cabin-line-number="{{$passenger['cabin_line_number']}}"
                  data-passenger-line-number="{{$passenger['passenger_line_number']}}"
                  data-show-passenger-line-number="{{$show_passenger_line_number}}">
                {{$show_passenger_line_number}}
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style boss" name="custom[boss_status]"
                          {{input_checked($passenger['boss_type'], config('const.boss_type.value.boss'))}}>
                  <span class="checkbox"></span>
                </label>
              </td>
              <td class="type" data-age-type="{{$passenger['age_type']}}">
                {{config('const.age_type.short_name.'.$passenger['age_type'])}}
              </td>
              <td class="name">
                （姓）<input class="first"
                          name="passengers[{{$show_passenger_line_number}}][passenger_last_eij]"
                          type="text"
                          value="{{$passenger['passenger_last_eij']}}"
                          placeholder="例）KYAKUSEN" maxlength="20">
                （名）<input class="last"
                          name="passengers[{{$show_passenger_line_number}}][passenger_first_eij]"
                          type="text"
                          value="{{$passenger['passenger_first_eij']}}"
                          placeholder="例）TARO" maxlength="20">
              </td>
              <td>
                {{$passenger['reservation_status']}}
              </td>
              <td class="pre_passenger">
                {{--TODO：フェーズ2--}}
                @if($user_site)
                  <select name="passengers[{{$show_passenger_line_number}}][registered]">
                    <option>選択してください</option>
                    @foreach($users as $user)
                      <option>{{ $user }}</option>
                      <option>
                        <span class="first">{{ $first }}</span>
                        <span class="last">{{ $last }}</span>
                      </option>
                    @endforeach
                  </select>
                @endif
              </td>
              <td>
                <button class="delete  row_delete passenger_delete">取消</button>
              </td>
            </tr>
            <?php $show_passenger_line_number++ ?>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th colspan="3">おひとり追加</th>
            <td colspan="4" class="left">
              <select name="age_type">
                @foreach (config('const.age_type.full_name') as $age_type => $name)
                  <option value="{{$age_type}}">{{$name}}</option>
                @endforeach
              </select>
              <button class="done passenger_add" style="width: 80px;">追加</button>
            </td>
          </tr>
          </tfoot>
        </table>
      @endforeach
    </div>

    <div class="button_bar">
      <div style="display: table-cell;width: auto; vertical-align: top;">
        @if(!$has_waiting)
          <form id="form_cabin_add" method="post" action="{{ext_route('reservation.cabin.passenger_entry.cabin_add')}}">
            <button type="submit" class="add cabin_add" style="margin-bottom: 5px;">＋客室追加</button>
          </form>
        @endif
        <a href="{{$redirect}}" class="reservation_cancel">
          <button type="submit" class="back mypage" style="vertical-align: middle;">
            {{$mode === 'new' ? '予約の取消' : '変更の取消'}}
          </button>
        </a>
      </div>
      <div style="display: table-cell; width: 88%;">
        <button type="submit" class="done done_reservation" style="{{ $has_waiting ? '' : 'height: 65px;' }} margin-left: 15px;">
          <img src="{{  ext_asset('images/icon/check.png') }}">{{$mode === 'new' ? '予約' : '決定'}}
        </button>
      </div>
    </div>

  </main>

  {{--画面遷移用のform--}}
  <form class="form_reservation_done" method="post"
        action="{{ ext_route('reservation.cabin.passenger_entry.reservation_done') }}"></form>
  <form class="form_passenger_add" method="post"
        action="{{ ext_route('reservation.cabin.passenger_entry.cabin_passenger_add') }}"></form>
  <form class="form_passenger_delete" method="post"
        action="{{ ext_route('reservation.cabin.passenger_entry.cabin_passenger_delete') }}"></form>
  <form class="form_cabin_delete" method="post"
        action="{{ ext_route('reservation.cabin.passenger_entry.cabin_delete') }}"></form>
@endsection
