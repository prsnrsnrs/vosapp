@extends('layout.base')

@section('title', 'メール登録(入力画面)')
@section('style')
  <link href="{{ mix('css/register_mail_input.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/register_mail_input.js') }}"></script>
@endsection

@section('content')
  <main class="register_mail_input">

    @include('include/information', ['info' => 'メールアドレスを入力し、「送信」ボタンをクリックして下さい。'])

    <table class="default">
      <tbody>
      <tr>
        <th colspan="2">メールアドレスの登録</th>
      </tr>
      <tr>
        <th style="width: 20%">メールアドレス</th>
        <td style="width: 80%">
          <input type="text"><span class="text_warning">（半角）</span>
        </td>
      </tr>
      </tbody>
    </table>

    <div class="send_btn">
      <button class="default" id="send_btn">送信</button>
    </div>

    <div class="success_mail_input">

      @include('include/information_success', ['info' => '入力されたメールアドレスにメールが送信されましたので、ご確認ください。'])

      <table class="default">
        <tbody>
        <tr>
          <th colspan="2">メールアドレスの確認</th>
        </tr>
        <tr>
          <th style="width: 20%">メールアドレス</th>
          <td style="width: 80%" class="address">YOYAKU_TAROU@snf.co.jp</td>
        </tr>
        <tr>
          <td colspan="2">
            メールをご覧いただき、記載されたリンクをクリックし、表示された画面で利用者登録を行ってください。<br>
            記載されたリンクは30分を経過するとアクセスできなくなりますので、再度メールアドレスの送信をしてください。<br><br>

            しばらくしてもメールが届かない場合は「戻る」ボタンを押すと、入力されたメールアドレスを確認できます。<br>
            間違っていた場合は正しく入力して再度送信してください。<br>
            迷惑メールの設定をされている場合は、そちらも確認してください。<br><br>

            メールが確認できましたら「閉じる」ボタンをクリックしてください。<br>
            ボタンをクリックしても閉じられない場合は、ブラウザの閉じる「×」で閉じてください。
          </td>
        </tr>
        </tbody>
      </table>
      <div class="button_bar">
        <a href="{{ url('end_user/mail/register_mail') }}">
          <button class="back">戻る</button>
        </a>
          <button class="default" id="close_btn">閉じる</button>
      </div>
    </div>
  </main>
@endsection