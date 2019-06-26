@include('emails.include.header')

下記のとおりキャビンリクエストの繰上げをさせていただきます。
ご確認のうえ、{!! convert_date_format($send_mail['reply_date'], 'Y/m') !!}({!! get_youbi($send_mail['reply_date']) !!})までに
ご回答くださいますようよろしくお願いいたします。

【出発日】{!! convert_date_format($item['item_departure_date'], 'Y/m') !!} {!! $item['item_name'] !!} {!! $item['item_name2'] !!}
【客室タイプ】{!! $reservation_cabin['cabin_type_knj'] !!}
【部屋番号】{!! $reservation_cabin['cabin_number'] !!}　→　変更先：{!! $send_mail['after_cabin_number'] !!}
【お部屋割り】{!! $reservation_cabin['fare_type'] !!}利用
【代表者名】{!! $reservation['boss_name'] !!}

変更ＯＫのご回答および引き続きキャビンリクエストをされる場合は、その旨もご連絡ください。
なお、期日までにご連絡なき場合は、キャビンリクエストをお待ちの次のお客様にご誘導させていただきますのでご了承くださいますようお願いいたします。

@include('emails.include.footer')