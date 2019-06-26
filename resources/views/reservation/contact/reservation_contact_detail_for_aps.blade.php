<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>i5専用ご連絡閲覧画面</title>
    <link href="{{ mix('css/vender.css') }}" rel="stylesheet"/>
    <link href="{{ mix('css/voss.css') }}" rel="stylesheet"/>
    <link href="{{ mix('css/reservation/contact/reservation_contact_detail_for_aps.css') }}" rel="stylesheet"/>
    <script src="{{ mix('js/vender.js')}}"></script>
    <script src="{{ mix('js/voss.js')}}"></script>
    <script src="{{ mix('js/voss_ajax.js')}}"></script>
    <script src="{{ mix('js/reservation/contact/reservation_contact_detail_for_aps.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-22118792-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-22118792-1');
    </script>
</head>
<body>
<div id="layer">
    <header>
        <div class="left_info"><img class="logo" src="{{ ext_asset('/images/logo.png') }}"/></div>
        <div class="right_info">
            <img class="logo" src="{{ ext_asset('/images/company_name.png') }}"/>
        </div>
        <div class="line"></div>
    </header>

    <div class="container">
        <div class="button_bar">
            <button class="back" id="close">
                <img src="{{  ext_asset('images/icon/close.png') }}">閉じる
            </button>
        </div>
        <main>
            <div class="reservation_contact_detail_for_aps">
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
                        <td>{{$contact_detail['passenger_first_eij']}}
                            &nbsp;{{$contact_detail['passenger_last_eij']}}</td>
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
        </main>
    </div>
    <footer>
        <p>Copyright © 2018日本クルーズ客船株式会社. All Rights Reserved.</p>
    </footer>
</div>
</body>
</html>