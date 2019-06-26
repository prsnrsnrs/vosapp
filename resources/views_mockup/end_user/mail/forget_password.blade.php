@extends('layout.base')

@section('title', 'パスワード忘れメール入力送信')

@section('style')
  <link href="{{ mix('css/forget_password.css') }}" rel="stylesheet"/>
@endsection

@section('content')
  <main class="forget_password">

    @include('include/info', ['info' => '新しいパスワードを設定するためＵＲＬをお送りします。メールアドレスを入力し、「送信」ボタンをクリックしてください。'])

    <table class="default">
      <tbody>
      <tr>
        <th colspan="2">メールアドレスの登録</th>
      </tr>
      <tr>
        <th style="width: 20%">メールアドレス</th>
        <td style="width: 80%">
          <input type="text" style="width: 800px">
        </td>
      </tr>
      </tbody>
      </thead>
    </table>
    <div class="send_btn">
      <button class="default">送信</button>
    </div>
  </main>

  <div class="button_bar">
    <a href="{{ url('end_user/login/login') }}" >
      <button class="back">戻る</button>
    </a>
  </div>
@endsection