@extends('layout.base')

@section('title', 'パスワード再設定')

@section('style')
  <link href="{{ mix('css/user/user_password_reset.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/user/user_password_reset.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'パスワード再設定']
  ]])
@endsection

@section('content')
  <main class="reset_password">

    @include('include/information', ['info' => config('messages.info.I320-0101')])

    <form id="password_reset_form" method="post" action="{{ ext_route('user.password_reset') }}">
      <input type="hidden" name="auth_key" value="{{ $mail_auth['mail_auth_key'] }}">

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
            <input type="password" name="password" maxlength="12"><span class="input_warning">(８～１２文字)</span>
          </td>
        </tr>
        <tr>
          <td>8文字以上の半角英数字、および半角記号(#$%&()={}*:+_?.<-/@;>!|[])が使用できます。<br>
            パスワードには、ユーザIDと同じものは登録できません。<br>
            第三者による不正なアクセスを防止するためにも、できるだけ複雑なパスワードを設定することをお勧めします。
          </td>
        </tr>
        <tr>
          <th>新しいパスワード再入力</th>
          <td>
            <input type="password" name="password_confirm" maxlength="12">
          </td>
        </tr>
        @if (\App\Libs\Voss\VossAccessManager::isUserSite())
          <tr>
            <th>登録された電話番号</th>
            <td>
              <input type="text" name="tel" maxlength="16">
            </td>
          </tr>
        @endif
        </tbody>
      </table>

      <div class="change_btn">
        <button type="submit" class="done"><img src="{{  ext_asset('images/icon/register.png') }}">変更</button>
      </div>
    </form>
  </main>
@endsection