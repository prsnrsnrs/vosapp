<!-- コース情報 -->

<div class="course">
  <img src="{{ asset('/images/boat.png') }}"/>
  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>
  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
</div>
@if ($menu_display)
  @if ($travel)
    <div class="course_menu">
      <a href="{{ asset('reservation/input_name') }}">
        <div>
          <img src="{{ asset('/images/bed.png') }}"/>
          <dl>
            <dt>客室数　2</dt>
            <dt>人　数　5</dt>
          </dl>
        </div>
      </a>
      <a href="{{ asset('reservation/boatmember') }}">
        <div>
          <img src="{{ asset('/images/search.png') }}"/>
          <dl class="danger">
            <dt>詳細入力済</dt>
          </dl>
        </div>
      </a>
      <a href="{{ asset('print/print_document') }}">
        <div>
          <img src="{{ asset('/images/print.png') }}" style="height: auto; width: 42px; margin: 4px 0;"/>
          <dl>
            <dt>予約確認書印刷可</dt>
          </dl>
        </div>
      </a>
      <a href="{{ asset('document/send_document') }}">
        <div class="button">
          <img src="{{ asset('/images/note.png') }}"/>
          <dl>
            <dt class="danger">ご提出書類があります</dt>
          </dl>
        </div>
      </a>
      <a href="{{ asset('print/print_document') }}">
        <div>
          <img src="{{ asset('/images/ticket.png') }}"/>
          <dl>
            <dt>乗船券印刷可</dt>
          </dl>
        </div>
      </a>
      <a href="{{ asset('contact/contact_list') }}">
        <div>
          <img src="{{ asset('/images/mail.png') }}"/>
          <dl>
            <dt>連絡があります</dt>
          </dl>
        </div>
      </a>
    </div>
  @else
    <div class="course_menu">
      <div>
        <img src="{{ asset('/images/bed.png') }}"/>
        <dl>
          <dt>客室数　2</dt>
          <dt>人　数　5</dt>
        </dl>
      </div>
      <div>
        <img src="{{ asset('/images/search.png') }}"/>
        <dl class="danger">
          <dt><a href="{{ asset('reservation/boatmember') }}">詳細入力済</a></dt>
        </dl>
      </div>
      <div>
        <img src="{{ asset('/images/pay.png') }}" style="height: auto; width: 42px; margin: 4px 0;"/>
        <dl>
          <dt><a href="{{ asset('print/print_document') }}">未精算があります</a></dt>
        </dl>
      </div>
      <div>
        <img src="{{ asset('/images/note.png') }}"/>
        <dl>
          <dt class="danger"><a href="{{ asset('document/send_document') }}">ご提出書類があります</a></dt>
        </dl>
      </div>
      <div>
        <img src="{{ asset('/images/ticket.png') }}"/>
        <dl>
          <dt><a href="{{ asset('print/print_document') }}">乗船券印刷可</a></dt>
        </dl>
      </div>
      <div>
        <img src="{{ asset('/images/mail.png') }}"/>
        <dl>
          <dt><a href="{{ asset('contact/contact_list') }}">連絡があります</a></dt>
        </dl>
      </div>
    </div>
  @endif
@endif