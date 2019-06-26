@extends('layout.base')

@section('title', 'パスワード再設定（リセット）')

@section('style')
  <link href="{{ mix('css/reset_password.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/reset_password.js') }}"></script>
@endsection


@section('content')
  <main class="reset_password">

      @include('include.info', ['info' => '新しいパスワードを入力し、「変更」ボタンをクリックして下さい。'])

      <table class="default">
        <thead>
          <tr>
            <th colspan="2">パスワード再設定</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 25%">新しいパスワード</th>
          <td style="width: 75%">
            <input type="password">
            <br>
            <label class="password_warning">
              4文字以上の半角英数字、および半角記号(#$%&()={}*:+_?.<-/@;>!|[])が使用できます。<br>
              パスワードには、ユーザIDと同じものは登録できません。<br>
              第三者による不正なアクセスを防止するためにも、できるだけ複雑なパスワードを設定することをお勧めします。
            </label>
          </td>
        </tr>
        <tr>
          <th>新しいパスワード再入力</th>
          <td>
            <input type="password">
          </td>
        </tr>
        </tbody>
      </table>
  </main>
  <div class="button_bar">
    <button class="done">変更</button>
  </div>

@endsection