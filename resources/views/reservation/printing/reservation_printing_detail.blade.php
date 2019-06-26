<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=990,initial-scale=1">
  <title>予約内容確認書</title>
  @include('reservation.printing.jquery')
  <script>
    var pageHeight = 1350;
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

        var elmHeight = $elm.outerHeight(true);
        height += elmHeight;

        // ページの高さを超えていたら改ページタグと一覧ヘッダーを挿入する
        if (height > pageHeight) {
          $elm.before('<div style="page-break-before: always !important"> </div>');
          $elm.before($('body .passenger_header:first').prop('outerHTML'));
          // 自分自身と一覧ヘッダータグの高さを格納する
          height = Number(elmHeight + $elm.prev().outerHeight(true));
        }
      });
    });
  </script>
  <style>

    /* ページ内共通 */
    body {
      width: 930px; /* 横幅をpx指定しないと高さが取得できない */
      page-break-after: auto;
      font-size: 18px;
      font-family: 'ＭＳ 明朝', 'MS Mincho';
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
      word-break: break-all;
    }

    table p {
      margin: 5px;
    }

    .dashed {
      border-bottom: dashed 1px !important;
    }

    .solid {
      border-bottom: solid 1px #000000 !important;
    }

    .left {
      text-align: left;
    }

    .small {
      font-size: 16px;
    }

    .center {
      text-align: center;
    }

    .page_header {
      list-style: none;
      margin: 0 0 30px 0;
      padding: 0;
      display: table;
      width: 100%;
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

    /* クルーズ情報 */
    .cruise table,
    .item table {
      width: 100%;
    }

    .cruise table th,
    .item table th {
      text-align: right;
    }

    /* 一覧：ヘッダー */

    .passenger_header table {
      border-collapse: collapse;
      border: 1px solid black;
      width: 100%;
      text-align: center;
    }

    .passenger_header table th {
      border-top: solid 1px #000000;
      border-right: solid 1px #000000;
      border-bottom: none;
      border-left: solid 1px #000000;
    }

    .passenger_header table th div.table {
      display: table;
      width: 100%;
    }

    .passenger_header table th p.table_cell {
      vertical-align: middle;
      display: table-cell;
      width: 100%;
    }

    /* 一覧 */

    .passenger_info table td {
      border-top: none;
      border-right: solid 1px #000000;
      border-bottom: none;
      border-left: solid 1px #000000;
    }

    td.separate,
    th.separate {
      border-bottom: dashed 1px !important;
    }

    td.separate ul,
    th.separate ul {
      width: 100%;
      display: table;
    }

    td.separate ul li:first-child,
    th.separate ul li:first-child {
      border-right: dashed 1px !important;
    }

    td.separate ul li,
    th.separate ul li {
      width: 50%;
      vertical-align: middle;
      display: table-cell;
    }

    td.separate div {
      width: 100% !important;
    }

    .passenger_info table td div {
      padding: 3px 0;
    }

    /* ご乗船者 */
    .passenger_header table td {
      border-top: none;
      border-right: solid 1px #000000;
      border-bottom: solid 1px #000000;
      border-left: none;
    }

    .passenger_header table td:first-child {
      border-left: solid 1px #000000;
    }

  </style>
</head>
<body>
@foreach($cruises as $cruise_id)
  <ul class="page_header pointer {{ $loop->first ? 'first': '' }}">
    <li class="address">
      @if($is_agent)
        {{ $travel_company_name }}<br>{{ $agent_name }}　御中
      @endif
    </li>
    <li class="title">
      <span>予約内容確認書</span>
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
    {{--クルーズ--}}
    <div class="cruise pointer small">
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
      <div class="item pointer small {{ $loop->first ? 'first': '' }}" style="margin-top: 10px">
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
      <div class="passenger_header pointer small" style="margin-top: 8px;">
        <table class="center" style="border: none;">
          <colgroup style="width: 174px">
          <colgroup style="width: 28px">
          <colgroup style="width: 190px">
          <colgroup style="width: 45px">
          <colgroup style="width: 45px">
          <colgroup style="width: 76px">
          <colgroup style="width: 94px">
          <colgroup style="width: 139px">
          <colgroup style="width: 139px">
          <tbody>
          <tr style="border-top: solid 1px #000000">
            <th><p>予約番号</p></th>
            <th rowspan="3" class="solid"><p>代<br>表<br>者</p></th>
            <th class="dashed"><p>氏名</p></th>
            <th colspan="2"><p>生年月日</p></th>
            <th class="dashed"><p>大小幼</p></th>
            <th class="dashed"><p>国籍</p></th>
            <th rowspan="2" colspan="2"><p>住所</p></th>
          </tr>
          <tr>
            <th style="border-top: dashed 1px; border-bottom: dashed 1px"><p>客室タイプ・番号</p></th>
            <th rowspan="2" class="solid" style="border-top: none"><p>氏名（英字）</p></th>
            <th style="border-right: dashed 1px; border-top: dashed 1px; border-bottom: dashed 1px;"><p>年齢</p></th>
            <th style="border-left: none; border-bottom: none; border-top: none"><p>性別</p></th>
            <th class="dashed" style="border-top: none"><p>子供食</p></th>
            <th class="dashed" style="border-top: none"><p>PPT No</p></th>
          </tr>
          <tr class="solid">
            <th style="border-top: none"><p>料金タイプ</p></th>
            <th colspan="2" style="border-top: none"><p>会員番号</p></th>
            <th style="border-top: none"><p>食事回数</p></th>
            <th style="border-top: none"><p>発行日</p></th>
            <th style="border-right: dashed 1px; border-top: dashed 1px"><p>TEL①</p></th>
            <th style="border-left: none; border-top: none"><p>TEL②</p></th>
          </tr>
          </tbody>
        </table>
      </div>
      @foreach($items['passengers'] as $reservation_number => $passengers)
        @foreach($passengers as $passenger)
          <div class="passenger_info pointer small">
            <table class="center" style="border: none;">
              <colgroup style="width: 87px;">
              <colgroup style="width: 87px;">
              <colgroup style="width: 28px;">
              <colgroup style="width: 190px;">
              <colgroup style="width: 45px;">
              <colgroup style="width: 45px;">
              <colgroup style="width: 76px;">
              <colgroup style="width: 94px;">
              <colgroup style="width: 139px;">
              <colgroup style="width: 139px;">
              <tbody>
              <tr style="border-top: solid 1px #000000">
                <td colspan="2">
                  <div>{{ $passenger['reservation_number'] }}</div>
                </td>
                <td rowspan="3" class="solid">
                  <div>{{ config('const.boss_type.name.'.$passenger['boss_type']) }}</div>
                </td>
                <td class="dashed">
                  <div class="str_passenger_knj left">
                    <p>{{ mb_convert_kana($passenger['passenger_last_knj'], "KVa") . '　'. mb_convert_kana($passenger['passenger_first_knj'], "KVa") }}</p>
                  </div>
                </td>
                <td colspan="2">
                  @if($passenger['birth_date'])
                    <div>{{ date('Y/m/d', strtotime($passenger['birth_date'])) }}</div>
                  @endif
                </td>
                <td class="dashed">
                  <div>{{ config('const.age_type.short_name.' . $passenger['age_type']) }}</div>
                </td>
                <td class="dashed">
                  <div>{{ $passenger['country_name_port'] ?: '　' }}</div>
                </td>
                <td rowspan="2" colspan="2" class="left">
                  <p>
                    {{ $passenger['zip_code'] ? '〒'.zip_cd($passenger['zip_code']) : '' }}&nbsp;
                    {{ $passenger['prefecture_name'] . mb_convert_kana($passenger['address1'], "KVa") . mb_convert_kana($passenger['address2'], "KVa") . mb_convert_kana($passenger['address3'], "KVa") }}
                  </p>
                </td>
              </tr>
              <tr>
                <td style="border-right: dashed 1px; border-top: dashed 1px">
                  <div>{{ $passenger['cabin_type'] }}</div>
                </td>
                <td style="border-left: none;">
                  <div>{{ $passenger['cabin_number'] ?: '　' }}</div>
                </td>
                <td rowspan="2" class="solid left">
                  <p>{{ mb_convert_kana($passenger['passenger_last_eij'], "KVa") }}</p>
                  <p>{{  mb_convert_kana($passenger['passenger_first_eij'], "KVa") }}</p>
                </td>
                <td style="border-right: dashed 1px; border-top: dashed 1px; border-bottom: dashed 1px;">
                  <div>{{ $passenger['age'] ?: '　' }}</div>
                <td style="border-left: none;  border-bottom: none">
                  <div>{{ config('const.gender.name.' . array_get($passenger, 'gender')) }}</div>
                </td>
                <td class="dashed">
                  <div>{{ $passenger['child_meal_type'] ?: '　'}}</div>
                </td>
                <td class="dashed">
                  <div>{{ $passenger['passport_number'] ?: '　' }}</div>
                </td>
              </tr>
              <tr class="solid">
                @if(isset($tariff_by_item_code[$passenger['item_code']]) && (int)$tariff_by_item_code[$passenger['item_code']] > 1)
                  <td style="border-right: dashed 1px; border-top: dashed 1px; border-bottom: dashed 1px">
                    <div>{{ $passenger['tariff_short_name'] }}</div>
                  </td>
                  <td style="border-left: none;border-top: dashed 1px">
                    <div>{{ config('const.fare_type.name.' . $passenger['fare_type']) }}</div>
                  </td>
                @else
                  <td colspan="2" style="border-top: dashed 1px">
                    <div>{{ config('const.fare_type.name.' . $passenger['fare_type']) }}</div>
                  </td>
                @endif
                <td colspan="2" style="border-top: none">
                  <div>{{ $passenger['venus_club_number'] ?: '　'}}</div>
                </td>
                <td>
                  <div>{{ $passenger['fixed_seating'] ?: '　' }}</div>
                </td>
                <td>
                  <div>{{ $passenger['passport_issue'] ? date('Y/m/d', strtotime($passenger['passport_issue'])) : '　' }}</div>
                </td>
                <td style="border-right: dashed 1px; border-top: dashed 1px">
                  <div>{{ $passenger['tel1'] ?: '　'}}</div>
                </td>
                <td style="border-left: none;">
                  <div>{{ $passenger['tel2'] ?: '　' }}</div>
                </td>
              </tr>
              <tr class="solid">
                <td colspan="2">
                  <div>提出書類</div>
                </td>
                <td colspan="8" class="left">
                  <p>
                    @foreach($passenger['document'] as $document)
                      @if($document['progress_manage_short_name'])
                        {{ $document['progress_manage_short_name'] }}{{ $document['check_finish_date'] ? '[済]' : '[未]' }}
                      @else
                        {{ '　' }}
                      @endif
                    @endforeach
                  </p>
                </td>
              </tr>
              <tr class="solid">
                <td colspan="2">
                  <div>備考</div>
                </td>
                <td colspan="8">
                  <div class="str_remark">
                    {{ mb_convert_kana($passenger['remark'], "KVa") ?: '　' }}</div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        @endforeach
      @endforeach
  </div>
  @if(!$loop->last)
    <div class="page_break pointer" style="page-break-before: always !important;"></div>
  @endif
@endforeach
@if(!$loop->last)
  <div class="page_break pointer" style="page-break-before: always !important;"></div>
@endif
@endforeach
</body>
</html>

<?php //exit; ?>