<form id="group_setting_form" method="post" action="{{ ext_route('reservation.reception.group') }}">
  <input type="hidden" id="group_setting_mode" name="mode" value="update">
  <input type="hidden" name="travelwith_number"
         value="{{ $selected_reservation['travelwith_number'] ? $selected_reservation['travelwith_number'] : $selected_reservation['reservation_number'] }}"/>
  <input type="hidden" name="group_reservation_numbers[]" value="{{ $selected_reservation['reservation_number'] }}">

  <div class="modal_title">グループ設定
    <div class="close">×</div>
  </div>
  <table class="default">
    <tbody class="center">
    <tr>
      <th style="width: 11%">受付<br>日時</th>
      <th style="width: 12%">予約番号</th>
      <th style="width: 35%">クルーズ名（コース）</th>
      <th style="width: 14%">出発日</th>
      <th style="width: 20%">代表者名</th>
      <th style="width: 8%">ｽﾃｰﾀｽ</th>
    </tr>
    <tr>
      <td>
        <div>{{ convert_date_format($selected_reservation['new_created_date_time'], 'm/d') }}</div>
        <div>{{ convert_date_format($selected_reservation['new_created_date_time'], 'H:i') }}</div>
      </td>
      <td>{{ $selected_reservation['reservation_number'] }}</td>
      <td class="left">
        {!! str_concat($selected_reservation['item_name'], $selected_reservation['item_name2']) !!}
      </td>
      <td class="left">
        {{ $selected_reservation['departure_place_knj'] }}発<br>
        {{ convert_date_format($selected_reservation['item_departure_date'], 'Y年m月d日') }}
        ({{ get_youbi($selected_reservation['item_departure_date']) }})
      </td>
      <td class="left">
        <div>{!! passenger_name($selected_reservation['passenger_last_eij'], $selected_reservation['passenger_first_eij']) !!} </div>
        <div>{!! passenger_name($selected_reservation['passenger_last_knj'], $selected_reservation['passenger_first_knj']) !!}</div>
      </td>
      <td>{{ $selected_reservation['reservation_status'] }}</td>
    </tr>
    </tbody>
  </table>

  <div class="group_list">
    <table class="default" style="width: 835px">
      <thead class="center {{ $reservations ? '' : 'no_data' }}" style="width: 816px">
      <tr class="list_title">
        <th style="width: 25px">
          <label>
            <input name="all_check" type="checkbox" class="check_style"/>
            <span class="checkbox"></span>
          </label>
        </th>
        <th style="width: 50px">受付<br>日時</th>
        <th style="width: 90px">予約番号</th>
        <th style="width: 280px">クルーズ名（コース）</th>
        <th style="width: 105px">出発日</th>
        <th style="width: 150px">代表者名</th>
        <th style="width: 35px">ｽﾃｰﾀｽ</th>
      </tr>
      </thead>
      @if($reservations)
        <tbody class="center">
        @foreach($reservations as $reservation)
          <tr class="list_foot">
            <td style="width: 25px">
              <label>
                <input type="checkbox" class="check_style move_check" name="group_reservation_numbers[]"
                       value="{{ $reservation['reservation_number'] }}"
                        {{ $selected_reservation['travelwith_number'] ? input_checked($selected_reservation['travelwith_number'], $reservation['travelwith_number']) : '' }}/>
                <span class="checkbox"></span>
              </label>
            </td>

            <td style="width: 50px">
              <div>{{ convert_date_format($reservation['new_created_date_time'], 'm/d') }}</div>
              <div>{{ convert_date_format($reservation['new_created_date_time'], 'H:i') }}</div>
            </td>

            <td style="width: 90px">{{ $reservation['reservation_number'] }}</td>

            <td style="width: 280px"
                class="left">{!! str_concat($reservation['item_name'], $reservation['item_name2']) !!}</td>

            <td style="width: 105px" class="left">
              {{ $reservation['departure_place_knj'] }}発<br>
              {{ convert_date_format($reservation['item_departure_date'], 'Y年m月d日') }}
              ({{ get_youbi($reservation['item_departure_date']) }})
            </td>

            <td style="width: 150px" class="left">
              <div>{!! passenger_name($reservation['passenger_last_eij'], $reservation['passenger_first_eij']) !!}</div>
              <div>{!! passenger_name($reservation['passenger_last_knj'], $reservation['passenger_first_knj']) !!}</div>
            </td>

            <td style="width: 35px">{{ $reservation['reservation_status'] }}</td>
          </tr>
        @endforeach
        </tbody>
      @else
        <tfoot>
        <tr>
          <td class="list_empty" colspan="12" style="width: 1065px;">
            <p>グループ設定可能な予約情報がありません。</p>
          </td>
        </tr>
        </tfoot>
      @endif
    </table>

    <div class="button_bar_group">
      <button type="button" class="delete" id="cancel_button">キャンセル</button>
      <button type="submit" class="done" id="set_group">設定</button>
      @if ($selected_reservation['travelwith_number'])
        <button type="button" class="done" id="leave_group">グループを抜ける</button>
      @endif
    </div>
  </div>
</form>