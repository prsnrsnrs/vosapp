@extends('layout.base')

@section('title', 'パスワード忘れ再設定(リセット)')

@section('style')
  <link href="{{ mix('css/user_reset_password.css') }}" rel="stylesheet"/>
@endsection

@section('content')
  <main class="reset_password">

    @include('include/info', ['info' => '新しいパスワードを入力し、「変更」ボタンをクリックして下さい。'])

    <table class="default">
      <thead>
      <tr>
        <th colspan="2" class="left">パスワードの再設定</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th rowspan="2">新しいパスワード</th>
        <td>
          <input type="text"><span class="input_warning">(４～１２文字)</span>
        </td>
      </tr>
      <tr>
        <td>4文字以上の半角英数字、および半角記号(#$%&()={}*:+_?.<-/@;>!|[])が使用できます。<br>
          パスワードには、ユーザIDと同じものは登録できません。<br>
          第三者による不正なアクセスを防止するためにも、できるだけ複雑なパスワードを設定することをお勧めします。
        </td>
      </tr>
      <tr>
        <th>新しいパスワード再入力</th>
        <td>
          <input type="text">
        </td>
      </tr>
      <tr>
        <th>登録された電話番号</th>
        <td>
          <input type="text">
        </td>
      </tr>
      </tbody>
    </table>

    <div class="change_btn">
      <button class="default">変更</button>
    </div>

  </main>
@endsection