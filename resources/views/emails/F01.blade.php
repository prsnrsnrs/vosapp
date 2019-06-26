@include('emails.include.header')

下記の通り、キャンセル待ちのご予約がＯＫとなりましたので、
お客様にご確認いただき、{!! convert_date_format($send_mail['reply_date'], 'Y/m') !!}({!! get_youbi($send_mail['reply_date']) !!})までに
ご回答くださいますようよろしくお願いいたします。

【出発日】{!! convert_date_format($item['item_departure_date'], 'Y/m') !!} {!! $item['item_name'] !!} {!! $item['item_name2'] !!}
【客室タイプ】{!! $reservation_cabin['cabin_type_knj'] !!}　※第{!! $send_mail['request_priority_order'] !!}希望
【お部屋割り】{!! $reservation_cabin['fare_type'] !!}利用
【代表者名】{!! $reservation['boss_name'] !!}

なお、期日までにご連絡なき場合は、次のお客様にご誘導させていただきますのでご了承くださいますようお願いいたします。

@include('emails.include.footer')