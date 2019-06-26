@include('emails.include.header')

下記の通り、キャンセル待ちのご予約がＯＫとなりましたので、
お客様にご確認いただき、{!!$send_mail['reply_date']!!}({!!get_youbi($send_mail['reply_date'])!!})までに
ご回答くださいますようよろしくお願いいたします。

【出発日・クルーズ名】{!! convert_date_format($item['item_departure_date'], 'Y/m') !!} {!! $item['item_name'] !!} {!! $item['item_name2'] !!}
【お部屋】
@foreach ($hk_cabins as $cabins)
  {{ $cabins[0]['cabin_type_knj'] }} {{ config('const.fare_type.name.'.$cabins[0]['fare_type']) }} {{ count($cabins) }}室
@endforeach
【代表者名】{!! $reservation['boss_name'] !!}

なお、期日までにご連絡なき場合は、次のお客様にご誘導させていただきますのでご了承くださいますようお願いいたします。

@include('emails.include.footer')