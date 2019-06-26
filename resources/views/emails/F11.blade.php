@include('emails.include.header')

【{!! $item['item_name'] !!}&nbsp;{!! $item['item_name2'] !!}】の乗船券が発行可能となりましたので出力の上、乗船日当日ご持参くださいますよう宜しくお願いいたします。
お部屋番号は、「乗船券」に記載しておりますのでご確認ください。
また、今クルーズのご夕食は【{!! $item['seating'] !!}】回制となります。

※外航クルーズは「海外旅保険についてのお伺い」が必要となりますのであわせてご出力の上、乗船日当日ご持参ください。

@foreach($free_format_texts as $free_format_text)
  {!! $free_format_text['mail_detail'] !!}
@endforeach

@include('emails.include.footer')