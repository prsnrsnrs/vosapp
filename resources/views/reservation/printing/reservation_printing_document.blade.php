<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>予約確認書</title>
  @include('reservation.printing.jquery')
  <script>
    var breakPointHeight = 1350;
    var height = 0;
    /**
     * 処理を行います
     */
    $(document).ready(function () {
      $.each($('.pointer'), function () {
        var $elm = $(this);
        // 改ページタグ
        if ($elm.hasClass('page_break')) {
          height = 0;
          return;
        }

        var elemHeight = $elm.outerHeight(true);
        height += elemHeight;
        if (breakPointHeight < height) {
          // ページの高さが改ページ位置を超えていたら、改ページタグと一覧ヘッダーを挿入する
          $elm.before('<div style="page-break-before: always !important"> </div>');
          height = elemHeight;

          if ($elm.hasClass('passenger_info')) {
            // 乗船者情報の場合は、テーブルのヘッダーを前に追加する。
            var $passenger_header = $('body .passenger_header:first');
            $elm.before($passenger_header.prop('outerHTML'));
            // 自分自身と一覧ヘッダータグの高さを格納する
            height += $passenger_header.outerHeight(true);
          }
        }
      });
    });
  </script>
  <style>
    /* ページ内共通 */
    body {
      page-break-after: auto;
      font-size: 16px;
      font-family: 'ＭＳ 明朝', 'MS Mincho';
      width: 930px;
    }

    li {
      list-style: none;
      display: inline-block;
    }

    ul {
      margin: 0;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
    }

    table, th, td {
      border-collapse: collapse !important;
      border-spacing: 0 !important;
      padding: 0;
      font-weight: normal;
    }

    td, tr, ul, li {
      page-break-inside: avoid !important;
    }

    td, div {
      height: 100%;
      word-break: break-all;
    }

    p {
      margin: 5px;
    }

    hr {
      height: 1px;
      width: 100%;
      margin: 0;
      border: none;
      border-bottom: dashed 1px;
    }

    .left {
      text-align: left;
    }

    .center {
      text-align: center;
    }

    /* ヘッダー部 */
    .page_header {
      font-size: 18px;
      list-style: none;
      margin: 0;
      padding: 0;
      display: table;
      width: 100%;
      margin-bottom: 30px;
    }

    .page_header li {
      display: table-cell;
    }

    .page_header .address {
      width: 30%;
    }

    .page_header .title {
      font-size: 2em;
      text-decoration: underline;
      width: 40%;
      text-align: center;
      vertical-align: middle;
    }

    .page_header .company_info {
      text-align: right;
      width: 30%;
    }

    .count_list {
      border: solid 1px;
    }

    .company_tel {
      width: 100%
    }

    .company_tel ul {
      width: 100%;
      padding: 0;
    }

    .company_tel li {
      text-align: right;
      display: inline-block;
    }

    /* 挨拶 */
    .greeting {
      font-size: 18px;
      margin: 20px 0;
    }

    /* クルーズ情報 */
    .course, .cruise {

    }

    .cruise table,
    .course table {
      width: 100%;
    }

    .cruise table th,
    .course table th {
      text-align: right;
    }

    /* 一覧：ヘッダー */
    .passenger_header table tr {
      border: solid 1px;
    }

    .passenger_header table td {
      border-top: none;
      border-right: solid 1px #000000;
      border-bottom: solid 1px #000000;
      border-left: solid 1px #000000;
    }

    /* ご乗船者 */
    .passenger_info table td {
      border-top: none;
      border-right: solid 1px #000000;
      border-bottom: solid 1px #000000;
      border-left: none;
    }

    /* ご乗船者：結合する部分のレイアウト */
    .passenger_info table td:nth-child(1),
    .passenger_info table td:nth-child(7) {
      border-bottom: none;
    }

    .passenger_info table tbody:first-child td:first-child,
    .passenger_info table tbody:first-child td:nth-child(6) {
      border-top: solid 1px #000000;
    }

    .passengers table td:nth-child(1),
    .passengers table td:nth-child(6),
    .passengers table td:nth-child(7) {
      border-top: none;
    }

    .passenger_info table td:first-child {
      border-left: solid 1px #000000;
    }

    .passenger_info table tbody td.top_solid {
      border-top: solid 1px #000000 !important;
    }

    .passenger_info table tbody td.bottom_solid {
      border-bottom: solid 1px #000000 !important;
    }

    /* 最新予約数 */
    .all_count div.list,
    .latest_count div.list {
      width: 30%;
    }

    .all_count,
    .latest_count,
    .cruise_count {
      text-align: right;
      margin: 8px 0;
    }

    .all_count div,
    .latest_count div {
      display: inline-block;
      vertical-align: top;
      text-align: right;
    }

    .count_list ul {
      display: table;
      width: 100%;
    }

    .count_list li {
      display: table-cell;
    }

  </style>
</head>
<body>
<p id="sample"></p>
@foreach($cruises as $cruise_id)
  <div class="page-break">
    <ul class="page_header pointer">
      <li class="address">
        @if($is_agent)
          {{ $travel_company_name }}<br>{{ $agent_name }}　御中
        @endif
      </li>
      <li class="title">
        <span>予約確認書</span>
      </li>
      <li class="company_info">
        <p style="margin: 10px 0;">{{ date('Y年m月d日')}}</p>
        <p style="margin: 10px 0;">日本クルーズ客船株式会社<br>営業部予約課</p>

        <div class="company_tel">
          <ul>
            <li style="width: 28%">大阪</li>
            <li style="width: 68%">TEL：{{ config('const.tel_osaka.name.tel') }}</li>
          </ul>
          <ul>
            <li style="width: 100%">FAX：{{ config('const.tel_osaka.name.fax') }}</li>
          </ul>
          <ul>
            <li style="width: 28%">東京</li>
            <li style="width: 68%">TEL：{{ config('const.tel_tokyo.name.tel') }}</li>
          </ul>
          <ul>
            <li style="width: 100%">FAX：{{ config('const.tel_tokyo.name.fax') }}</li>
          </ul>
        </div>
      </li>
    </ul>
    <div class="container">
      {{--挨拶--}}
      <div class="greeting pointer">
        <p>
          @foreach($cruise_id['greeting'] as $key => $greeting)
            {{ collect($greeting)->first() }}<br>
          @endforeach
        </p>
      </div>
      {{--クルーズ情報--}}
      <div class="cruise pointer">
        <table>
          <colgroup style="width: 14%;">
          <colgroup style="width: 86%;">
          <tbody>
          <tr>
            <th>クルーズ名：</th>
            <td>{{ $cruise_id['cruise_name'] }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      @foreach($cruise_id['items'] as $item_code => $items)
        {{--商品情報--}}
        <div class="course pointer" style="margin-top: 10px">
          <table>
            <colgroup style="width: 14%;">
            <colgroup style="width: 56%;">
            <colgroup style="width: 30%;">
            <tbody>
            <tr>
              <th>商品名：</th>
              <td class="str_name">{{ $items[0]['item_name'] }}</td>
              <td class="str_port">@if($is_agent){{ $items[0]['item_port'] ? '('.$items[0]['item_port'].')' : '' }}@endif</td>
            </tr>
            <tr>
              <th></th>
              <td colspan="2" class="str_name_sub">{{ $items[0]['item_name2'] }}</td>
            </tr>
            <tr>
              <th></th>
              <td colspan="2">{{ date('Y/m/d', strtotime($items[0]['item_departure_date'])) }} {{$items[0]['departure_place_knj']}}
                　～　
                {{date('Y/m/d', strtotime($items[0]['item_arrival_date']))}} {{$items[0]['arrival_place_knj']}}</td>
            </tr>
            </tbody>
          </table>
        </div>
        {{--乗船者情報--}}
        <div class="cabin passenger_header pointer" style="margin-top: 8px; width: 100%">
          <table class="center" style="border: none;">
            <colgroup style="width: 7%;">
            <colgroup style="width: 19%;">
            <colgroup style="width: 5%;">
            <colgroup style="width: 4%;">
            <colgroup style="width: 19%;">
            <colgroup style="width: 9%;">
            <colgroup style="width: 9%;">
            <colgroup style="width: 10%;">
            <colgroup style="width: 18%;">
            <tbody>
            <tr>
              <td>予約番号</td>
              <td>
                <div>
                  <p>姓</p>
                  <hr>
                  <p>名</p>
                </div>
              </td>
              <td>
                <div>
                  <p>年齢</p>
                  <hr>
                  <p>性別</p>
                </div>
              </td>
              <td>大<br>小<br>幼</td>
              <td>氏名</td>
              <td>料金ﾀｲﾌﾟ</td>
              <td>
                <div>
                  <p>客室ﾀｲﾌﾟ</p>
                  <hr>
                  <p>客室番号</p>
                </div>
              </td>
              <td>
                <div>
                  <p>ステータス</p>
                  <hr>
                  <p>受付日</p>
                </div>
              </td>
              <td>備考</td>
            </tr>
            </tbody>
          </table>
        </div>
        @foreach($items['passengers'] as $reservation_number => $passengers)
          @foreach($passengers as $key => $passenger)
            <div class="passenger_info pointer">
              <table class="center" style="border: none;">
                <colgroup style="width: 7%;">
                <colgroup style="width: 19%;">
                <colgroup style="width: 5%;">
                <colgroup style="width: 4%;">
                <colgroup style="width: 19%;">
                <colgroup style="width: 9%;">
                <colgroup style="width: 9%;">
                <colgroup style="width: 10%;">
                <colgroup style="width: 18%;">
                <tbody>
                <tr>
                  <td rowspan="2" class="{{ $loop->last ? 'bottom_solid' : '' }}">
                    <div>
                      @if($loop->first)
                        {{ array_get($passenger, 'reservation_number') }}
                      @endif
                    </div>
                  </td>
                  <td rowspan="2" class="left">
                    <div>
                      <p>{{ array_get($passenger, 'passenger_last_eij') ?: '　' }}</p>
                      <hr>
                      <p>{{ array_get($passenger, 'passenger_first_eij') ?: '　' }}</p>
                    </div>
                  </td>
                  <td rowspan="2">
                    <p>{{ array_get($passenger, 'age') ?: '　' }}</p>
                    <hr>
                    <p>{{ array_get($passenger, 'gender') ? config('const.gender.name.' . array_get($passenger, 'gender')) : '　'}}</p>
                  </td>
                  <td rowspan="2">
                    {{ config('const.age_type.short_name.' . array_get($passenger, 'age_type')) }}
                  </td>
                  <td rowspan="2" class="left">
                    <p>{{ array_get($passenger, 'passenger_last_knj') }} {{ array_get($passenger, 'passenger_first_knj') }}</p>
                  </td>
                  <td rowspan="2">
                    @if(isset($tariff_by_item_code[$passenger['item_code']]) && (int)$tariff_by_item_code[$passenger['item_code']] > 1)
                      <p>{{array_get($passenger, 'tariff_short_name') }}</p>
                    @endif
                    <p>{{config('const.fare_type.name.' . array_get($passenger, 'fare_type')) }}</p>
                  </td>
                  <td rowspan="2"
                      class="{{ !next_much( array_get($passenger, 'cabin_line_number'), $passengers, $key, 'cabin_line_number') ? 'bottom_solid' : '' }}">
                    <div>
                      @if(!prev_much( array_get($passenger, 'cabin_line_number'), $passengers, $key, 'cabin_line_number'))
                        <p>{{ array_get($passenger, 'cabin_type') }}</p>
                        <p>{{ array_get($passenger, 'cabin_number')}}</p>
                      @endif
                    </div>
                  </td>
                  <td rowspan="2">
                    <p>{{ array_get($passenger, 'reservation_status') }}</p>
                    <hr>
                    <p>{{ date('Y/m/d', strtotime( array_get($passenger, 'new_created_date_time')))}}</p>
                  </td>
                  <td rowspan="2" class="left">
                    <p>{{ array_get($passenger, 'remark') }}</p>
                  </td>
                </tr>
                <tr></tr>
                </tbody>
              </table>
            </div>
          @endforeach
        @endforeach
        {{--アクセス可能な予約数--}}
        @if($is_agent)
          <div class="latest_count pointer">
            <div class="title">最新予約数（客室数／人数）</div>
            <div class="list count_list" style="text-align:center; padding: 0 10px">
              <div style="width: 100%;">
                @foreach($items['total'] as $counts)
                  <ul class="all latest_count">
                    <li>{{ array_get($counts, 'cabin_type') }}:</li>
                    <li>
                      <span style="display: inline-block; width: 6em">{{ array_get($counts, 'cabin_count') }}室</span>
                      <span style="width: 1em">／</span>
                      <span style="display: inline-block; width: 5em">{{ array_get($counts ,'passenger_count') }}
                        名</span>
                    </li>
                  </ul>
                @endforeach
              </div>
            </div>
          </div>
        @endif
    </div>
  </div>
  @if(!$loop->last)
    <div class="pointer page_break" style="page-break-before: always !important;"></div>
  @endif
@endforeach

{{--クルーズ全体の予約数--}}
@if($is_agent)
  <div class="all_count pointer">
    <div id="title" class="title">合計最新予約数（客室数／人数）</div>
    <div class="list count_list" style="text-align: center;  padding: 0 10px">
      <div style="width: 100%;">
        @foreach($cruise_id['total'] as $counts)
          <ul class="all cruise_count">
            <li>{{ array_get($counts, 'cabin_type') }}:</li>
            <li>
              <span style="display: inline-block; width: 6em">{{ array_get($counts, 'cabin_count')}}室</span>
              <span style="width: 1em">／</span>
              <span style="display: inline-block; width: 5em">{{ array_get($counts ,'passenger_count') }}名</span>
            </li>
          </ul>
        @endforeach
      </div>
    </div>
  </div>
@endif
@if(!$loop->last)
  <div class="pointer page_break" style="page-break-before: always !important;"></div>
@endif
@endforeach
</body>
</html>
<?php //exit; ?>