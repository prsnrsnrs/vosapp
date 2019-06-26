@extends('layout.base')

@section('title', 'ユーザーIDの変更確認')

@section('style')
  <link href="{{ mix('css/id_edit.css') }}" rel="stylesheet"/>
@endsection
@section('content')
  <main class="id_confirm">
    @include('include.info', ['info' => 'ご本人確認のため、パスワードを入力してください。'])
    <table class="default">
      <tbody>
      <tr>
        <th colspan="2" class="bold">ご本人確認</th>
      </tr>
      <tr>
        <th style="width: 20%">パスワード</th>
        <td style="width: 80%;"><input type="password"></td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/mypage') }}"><button class="done">確認</button></a>
  </div>
@endsection