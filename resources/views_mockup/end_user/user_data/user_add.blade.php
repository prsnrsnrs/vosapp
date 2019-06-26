@extends('layout.base')

@section('title', 'ネット予約利用者登録')

@section('style')
  <link href="{{ mix('css/user_add.css') }}" rel="stylesheet"/>
@endsection

@section('content')
  <main class="user_add">
    @include('include.info', ['info' => 'メールアドレスの確認が完了しました。ネット予約利用者情報を入力し、「確認」ボタンを押して下さい。<br>
　入力欄はすべて必須項目です。'])
    <table class="default">
      <tbody>
      <tr>
        <th colspan="2" class="bold">ネット予約利用者情報の新規登録</th>
      </tr>
      <tr>
        <th>お客様名(英字)</th>
        <td>
          (姓)<input type="text" class="name" placeholder="例）NAKAGAWA">
          (名)<input type="text" class="name" placeholder="例）YOSHIO">
        </td>
      </tr>
      <tr>
        <th>お客様名(漢字)</th>
        <td>
          (姓)<input type="text" class="name" placeholder="例）中川">
          (名)<input type="text" class="name" placeholder="例）善夫">
        </td>
      </tr>
      <tr>
        <th>性別</th>
        <td><label><input type="radio" name="gander">男</label><label><input type="radio" name="gander">女</label></td>
      </tr>
      <tr>
        <th>生年月日</th>
        <td>
          <select class="year" name="birth_year">
            <option value="0">1991</option>
            <option value="1">1992</option>
            <option value="2">1993</option>
          </select>年
          <select class="month_day" name="birth_month">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>月
          <select class="month_day" name="birth_day">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>日
        </td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><input type="tel" >（ハイフン不要）</td>
      </tr>
      <tr>
        <th rowspan="2">ユーザーID<br>(メールアドレス)</th>
        <td>nakagawa@snf.co.jp</td>
      </tr>
      <tr>
        <td>こちらのアドレスにご予約・お支払い・ご乗船等に関するご案内を送信させていただきます。</td>
      </tr>
      <tr>
        <th rowspan="2">パスワード</th>
        <td><input type="password">（4~12文字）</td>
      </tr>
      <tr>
        <td>4文字以上の半角英数字、および半角記号(#$%&()={}*:+_?.<-/@;>!|[])が使用できます。<br>
          パスワードには、ユーザIDと同じものは登録できません。<br>
          第三者による不正なアクセスを防止するためにも、できるだけ複雑なパスワードを設定することをお勧めします。
        </td>
      </tr>
      <tr>
        <th>パスワード確認</th>
        <td><input type="password"></td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    {{--<a href="{{ url('end_user/mypage') }}"><button class="back">戻る</button></a>--}}
    <button class="done">登録</button>
  </div>
@endsection