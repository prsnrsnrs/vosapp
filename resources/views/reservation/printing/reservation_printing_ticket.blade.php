<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>乗船券控え</title>
    <style>
        body {
            font-family: "游ゴシック Medium", "Yu Gothic Medium", "Yu Gothic", sans-serif;
            font-size: 20px;
            width: 95%;
            page-break-after: auto;
        }

        .page-break {
            page-break-after: always;
        }

        .page-break:last-child {
            page-break-after: avoid;
        }

        .block {
            page-break-inside: avoid;
        }

        .header {
            width: 100%;
            border-top: double 5px #000;
            border-bottom: double 5px #000;
            font-weight: bold;
            text-align: center;
        }

        .header .title {
            font-size: 2em;
        }

        .header .En_title {
            font-size: 1.2em;
            margin-top: 0px;
            margin-bottom: 5px;
        }

        .header .info {
            font-size: 1.2em;
        }

        hr {
            border: 0;
            border-bottom: 5px double #000;
        }

        table {
            width: 100%;
        }

        th {
            text-align: left;
        }

        .item_name_col {
            margin: 0 0 1px;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: -moz-flex;
            display: flex;
            -webkit-box-lines: multiple;
            -moz-box-lines: multiple;
            -webkit-flex-wrap: wrap;
            -moz-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            width: 100%;
        }

        .item_name {
            margin:0 0 0;
            padding:1px;
            width:100%;
            list-style:none;
        }

        .en {
            font-size: 0.8em;
            margin-left: 20px;
        }

        .order_date {
            text-align: right;
            font-size: 0.8em;
        }

        .order_date span {
            padding-left: 20px;
        }

        .large {
            font-size: 1.5em;
        }

        .weight * {
            font-weight: lighter !important;
            font-size: 1.3em;
        }

        .cose_data,
        .customer_data {
            margin: 15px 0px;
        }

        .cose_data,
        .customer_data {
            font-weight: bold;
            font-size: 1.2em;
        }

        .cose_data table td,
        .cose_data table th,
        .customer_data table td,
        .customer_data table th {
            padding-bottom: 20px;
        }

        table.innter_table th,
        table.innter_table td {
            padding-bottom: 0px;
        }

        .company_date .info {
            border: 2px solid #000;
          width: 65%;
            margin: 20px auto 20px;
            padding: 10px;
            text-align: center;
        }

        .footer table {
            text-align: center !important;
            width: 60%;
            margin: 0px auto;
        }

        .footer table th {
            text-align: center !important;
        }

        .attention,
        .print_day {
            font-size: 0.8em;
            font-weight: lighter !important;
        }

        .print_day {
            text-align: right;
        }
    </style>
</head>
<body>
@foreach($reservations as $reservation)
    @foreach($reservation as $passengers => $passenger)
        <div class="page-break">
            <table class="header">
                <tbody>
                <tr>
                    <td>
                      <img height="140"
                           src="data:image/png;base64,{!! $images['logo'] !!}}"
                           alt="image"/>
                    </td>
                    <td>
                      <label class="title">乗船券</label>
                        <p class="En_title">M/S PACIFIC VENUS Passage Ticket</p>
                        <label class="info">乗船受付の際、ご提示ください</label>
                    </td>
                    <td width="100"></td>
                </tr>
                </tbody>
            </table>
            <div class="cose_data">
                <table>
                    <tbody>
                    <tr>
                        <th style="width:25%;">船名</th>
                        <td style="width:75%;">
                            <img width="300"
                                 src="data:image/png;base64,{!! $images['ship_name'] !!}}"
                                 alt="image"/>
                            <label class="order_date" style="float: right;">Voy ID:{{$passenger['voyage_id']}}</label>
                        </td>
                    </tr>
                    <tr>
                        <th class="item_name_col">クルーズ名</th>
                        <td class="item_name"
                            style="font-size: 0.9em;">{!! str_concat($passenger['item_name'],$passenger['item_name2']) !!}</td>
                    </tr>
                    <tr>
                        <th>乗船日/乗船港<br><span class="en">Date / From</span></th>
                        <td>
                            <table class="innter_table">
                                <tr>
                                    <td style="width: 45%;">{{date('Y年n月j日', strtotime($passenger['boarding_date']))}}</td>
                                    <td style="width: 55%;">{{$passenger['departure_port_knj']}}</td>
                                </tr>
                                <tr>
                                    <td class="en">{{date('d M.Y', strtotime($passenger['boarding_date']))}}</td>
                                    <td class="en">{{$passenger['departure_port_eij']}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-bottom:0px">下船日/下船港<br><span class="en">Date / To</span></th>
                        <td style="padding-bottom:0px">
                            <table class="innter_table">
                                <tr>
                                    <td style="width: 45%;">{{date('Y年n月j日', strtotime($passenger['disembark_date']))}}</td>
                                    <td style="width: 55%;">{{$passenger['arrival_place_knj']}}</td>
                                </tr>
                                <tr>
                                    <td class="en">{{date('d M.Y', strtotime($passenger['disembark_date']))}}</td>
                                    <td class="en">{{$passenger['arrival_place_eij']}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="customer_data">
                <table>
                    <tbody>
                    <tr>
                        <th style="width: 25%;">
                            <span class="large" style="font-size:1.3em">乗船者名</span><br>
                            <span>Passenger</span>
                        </th>
                        <td style="width: 75%;">
                            <span class="large" style="font-size:1.3em">{{$passenger['passenger_last_knj'] .' '. $passenger['passenger_first_knj']}}
                                　様</span>
                            <br><span style="font-size:0.9em">{{config('const.gender.name_eij.'. $passenger['gender'])}}
                            . {{$passenger['passenger_last_eij']}} {{$passenger['passenger_first_eij']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="large">部屋番号</th>
                        <td class="large">{{$passenger['deck_number']}}階　{{$passenger['cabin_number']}}号室</td>
                    </tr>
                    <tr class="weight">
                        <th>客室タイプ</th>
                        <td>{{$passenger['cabin_type_knj']}}</td>
                    </tr>
                    <tr class="weight">
                        <th>食事</th>
                        <td>
                            {{ $passenger['meal_location'] ? config('const.meal_location.name.' . $passenger['meal_location']) : '' }}
                            {{$passenger['fixed_seating']=="0" ?'':$passenger['fixed_seating'].' 回目'}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="order_date" style="padding-bottom:0px">
                            REF:{{$passenger['reservation_number']}}
                            <span>{{ $passenger['pax_id'] ? 'ID NO:' . sprintf('%05d', $passenger['pax_id'].$passenger['check_digit']) : '' }}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="company_date">
                <label>取扱旅行会社：{{$passenger['ticket_output_name']}}</label>
                <div class="info">
                  乗船受付場所・時間等の詳細はクルーズ日程表をご参照ください。
                </div>
            </div>
            <div class="footer">
                <table>
                    <tr>
                        <th>発行者</th>
                        <td>
                            <img
                                    src="data:image/png;base64,{!! $images['company_name'] !!}}"
                                    alt="image"/>
                        </td>
                    </tr>
                    <tr>
                        <th>ISSUED BY</th>
                        <td><i>Japan Cruise Line Inc.</i></td>
                    </tr>
                </table>
            </div>
            <hr>
          <div class="attention">※この乗船券による運送は、当社の旅客運送約款によります。
                <br>　ISSUED SUBJECT TO THE CONDITIONS OF CARRIAGE
            </div>
            <div class="print_day">
                Date of Issue: {{\App\Libs\DateUtil::now('d M.Y')}}
            </div>
        </div>
    @endforeach
@endforeach
</body>
</html>