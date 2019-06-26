@extends('layout.base')

@section('title', 'ご乗船のお客様登録一覧')

@section('style')
  <link href="{{ mix('css/boatmenber_list.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/boatmenber_list.js') }}"></script>
@endsection
@section('breadcrumb')
  <a href='{{ url("end_user/mypage") }}'>マイページ</a>＞ご乗船のお客様登録一覧
@endsection

@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('end_user/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('end_user/login/login') }}">ログアウト</a></li>
  </ul>
@endsection
@section('content')
  <main class="list">
    @include('include.info', ['info' => 'ご乗船されるお客様情報の一覧です。追加する場合は新規追加ボタンを押してください。'])
    <div class="add_button_bar">
      <a href="{{ url('end_user/boatmenber/add') }}"><button class="add">新規追加</button></a>
    </div>

    <?php
      $datas = [
          ['no' => '1', 'name' => 'ナカガワ　ヨシオ', 'gander' => '男', 'birthday' => '1972年06月24日', 'tel' => '090-0000-0000', 'club_flg' => 1],
          ['no' => '2', 'name' => 'ナカガワ　ハナコ', 'gander' => '女', 'birthday' => '1972年06月30日', 'tel' => '090-0000-0000', 'club_flg' => 1],
          ['no' => '3', 'name' => 'ナカガワ　タロウ', 'gander' => '男', 'birthday' => '2003年01月15日', 'tel' => '080-0000-0000', 'club_flg' => 0],
      ]
    ?>
    <table class="default center">
      <thead>
        <tr>
          <th colspan="7">ご乗船のお客様登録一覧</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 30%">お名前</th>
          <th style="width: 5%">性別</th>
          <th style="width: 15%">生年月日</th>
          <th style="width: 15%">電話番号</th>
          <th style="width: 17%">会員情報</th>
          <th style="width: 13%"></th>
        </tr>
        @foreach($datas as $data)
        <tr>
          <td>{{ $data['no'] }}</td>
          <td class="left">{{ $data['name'] }}</td>
          <td>{{ $data['gander'] }}</td>
          <td>{{ $data['birthday'] }}</td>
          <td>{{ $data['tel'] }}</td>
          @if ($data['club_flg'])
          <td><label class="icon success">びいなす倶楽部会員</label></td>
          @else
          <td></td>
          @endif
          <td>
            <a href="{{ url('end_user/boatmenber/confirm') }}"><button class="edit">変更</button></a>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('end_user/mypage') }}"><button class="back">戻る</button></a>
  </div>
@endsection


