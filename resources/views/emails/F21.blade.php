@include('emails.include.header')

平素は「びいなすクルーズ」をご販売いただき、誠にありがとうございます。
さて、本日付にて【{!! $item['item_name'] !!} {!! $item['item_name2'] !!}・{!! collect($close_cabins)->implode('cabin_type_knj', ', ') !!}】を早期手仕舞いとさせていただきますので、
アロット内外を問わず、すべてのお客様データ（漢字名・読み仮名・お部屋割り・生年月日・郵便番号・住所、電話番号もしくは携帯電話番号）を　
{!! convert_date_format($send_mail['reply_date'], 'Y/m') !!}({!! get_youbi($send_mail['reply_date']) !!})までにご入力ださいますようお願い申し上げます。

上記期日を過ぎましたら、自動的にアロットを回収させていただきます。

【手仕舞い後のご注意】
◆新規申込・変更・取消は都度ご連絡ください。
◆お客様の交代は、いったん取消後の新規申込となります。その場合、残室状況によりましては
お部屋をお取りできない場合もございます。

@foreach($free_format_texts as $free_format_text)
  {!! $free_format_text['mail_detail'] !!}
@endforeach

@include('emails.include.footer')