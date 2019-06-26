@extends('layout.base')

@section('title', 'メール登録')

@section('style')
  <link href="{{ mix('css/register_mail.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/register_mail.js') }}"></script>
@endsection

@section('content')
  <main class="register_mail">
    <div class="panel">
      <div class="center header">ネット予約利用者登録</div>
      <div class="body">
        <dl>
          <dt>インターネット予約の流れ</dt>
          <dd><p>・ネット予約利用者登録　⇒　ご乗船のお客様登録　⇒　ご予約　⇒　精算手続き　⇒　精算完了（予約完了）</p>
            ※インターネット予約をご利用いただくにはネット予約利用者登録をする必要があります。<br>
            ※ご登録にはパソコンメールまたはスマートフォンや携帯電話メールが必要です。
          </dd>
        </dl>
        <dl>
          <dt>ネット予約利用者登録の流れ</dt>
          <dd><p>・メール登録　⇒　登録メールに利用者登録リンクを送付　⇒　リンク先で利用者情報の入力　⇒　本登録</p>
            ※まず最初に登録したメールがご本人様の操作端末に届きますので、メール内のリンク先から本登録に進みます。
          </dd>
        </dl>
        <dl>
          <dt>ご乗船のお客様登録について</dt>
          <dd>ネット予約利用者登録後にマイページにて、実際にご乗船されるお客様の情報を別途登録する必要があります。<br>
            ネット予約利用者登録をされたご本人様も、乗船される場合は、お手数でも別途ご登録をお願いします。
          </dd>
        </dl>
        <dl>
          <dt>ネット予約のお客様情報とびいなす倶楽部会員番号との連携について</dt>
          <dd>びいなす倶楽部会員の方には「びいなす倶楽部リンクID」を別途送付いたしますので、ご乗船のお客様登録時に<br>
            「びいなす倶楽部リンクID」を一緒にご登録ください。リンクIDのご登録がない場合はびいなす倶楽部割引等の特典が受けられませんのでご注意ください
          </dd>
        </dl>
        <dl>
          <dt>ご予約について</dt>
        </dl>
        <dl>
          <dt>ご精算について</dt>
        </dl>
        <div class="agree_bar">
          <a href="{{ url('') }}">
            <button class="edit">インターネット予約ご利用規約</button>
          </a>
          <input id="agree" class="check_style" type="checkbox" name="agree">
          <label for="agree" class="checkbox">ご利用規約に同意する</label>
          <a href="{{ url('end_user/mail/register_mail_input') }}">
            <button class="default register_button">メール登録</button>
          </a>
        </div>
      </div>
    </div>
  </main>
@endsection