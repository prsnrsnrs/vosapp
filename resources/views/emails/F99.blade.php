@include('emails.include.header')

@foreach($free_format_texts as $free_format_text)
  {!! $free_format_text['mail_detail'] !!}
@endforeach

@include('emails.include.footer')