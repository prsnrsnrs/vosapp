@extends('layout.base')

@section('title', '質問事項のチェック')

@section('style')
  <link href="{{ mix('css/check_question.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/check_question.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/order_detail') }}">予約照会</a>＞質問事項のチェック
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="check_question">
    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => '質問事項にチェックでお答え下さい'])
    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②ご乗船者リクエスト入力</li>
        <li>③客室リクエスト入力</li>
        <li>④割引情報入力</li>
        <li class="current">⑤質問事項のチェック</li>
      </ul>
    </div>
    <div class="check_area">
      <table class="default">
        <tbody>
        <tr>
          <th style="width:4%" rowspan="2">No.</th>
          <th style="width:8%" rowspan="2">大小幼</th>
          <th style="width:20%" rowspan="2">お名前</th>
          <th style="width:4%" rowspan="2">性別</th>
          <th style="width:4%" rowspan="2">年齢</th>
          <th style="width:8%">質問1</th>
          <th style="width:12%">質問2</th>
          <th style="width:8%">質問3</th>
          <th style="width:8%">質問4</th>
          <th style="width:8%">質問5</th>
          <th style="width:8%">質問6</th>
          <th style="width:8%">質問7</th>
        </tr>
        <tr>
          <th scope="col">
            <p class="question">乳幼児の方はおられますか？</p>
          </th>
          <th scope="col">
            <p class="question">食物アレルギーの方はおられますか？</p>
          </th>
          <th scope="col">
            <p class="question">妊婦の方はおられますか？</p>
          </th>
          <th scope="col">
            <p class="question">車いすの方はおられますか？</p>
          </th>
          <th scope="col">
            <p class="question">健康をがいしている方はおられますか？</p>
          </th>
          <th scope="col">
            <p class="question">特別な配慮が必要な方はおられますか？</p>
          </th>
          <th scope="col">
            <p class="question">特別な配慮が必要な方はおられますか？</p>
          </th>
        </tr>
        <?php
        $passengers = [
            ['no' => 1, 'person_type_name' => '大人', 'name' => 'NAKAGAWA YOSHIO', 'gender' => '男', 'age' => 44],
            ['no' => 2, 'person_type_name' => '大人', 'name' => 'NAKAGAWA TARO', 'gender' => '男', 'age' => 15],
            ['no' => 3, 'person_type_name' => '大人', 'name' => 'NAKAGAWA HANAKO', 'gender' => '女', 'age' => 44],
            ['no' => 4, 'person_type_name' => '小人', 'name' => 'NAKAGAWA KOHANA', 'gender' => '女', 'age' => 10],
            ['no' => 5, 'person_type_name' => '幼児', 'name' => 'NAKAGAWA YOJI', 'gender' => '男', 'age' => 1],
        ];
        ?>
        @foreach ($passengers as $passenger)
          <tr>
            <td>{{$passenger['no']}}</td>
            <td>{{$passenger['person_type_name']}}</td>
            <td class="tleft">{{$passenger['name']}}</td>
            <td>{{$passenger['gender']}}</td>
            <td>{{$passenger['age']}}</td>
            <td>
              <label>
                <input type="checkbox" class="check_style"><span class="checkbox"></span>
              </label>
            </td>
            <td>
              <label>
                <input type="radio" class="check_style" name={{$passenger['no']}} value="0">
                <span class="checkbox"></span>はい
              </label>

              <label>
                <input type="radio" class="check_style" name={{$passenger['no']}} value="1">
                <span class="checkbox"></span>いいえ
              </label>
            </td>
            <td>
              <label>
                <input type="checkbox" class="check_style"><span class="checkbox"></span>
              </label>
            </td>
            <td>
              <label>
                <input type="checkbox" class="check_style"><span class="checkbox"></span>
              </label>
            </td>
            <td>
              <label>
                <input type="checkbox" class="check_style"><span class="checkbox"></span>
              </label>
            </td>
            <td>
              <label>
                <input type="checkbox" class="check_style"><span class="checkbox"></span>
              </label>
            </td>
            <td>
              <label>
                <input type="checkbox" class="check_style"><span class="checkbox"></span>
              </label>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/input_ticket') }}">
      <button type="submit" class="back">戻る</button>
    </a>
    <a href="{{ url('reservation/order_detail') }}">
      <button type="submit" class="done">次へ（予約照会へ）</button>
    </a>
    <button type="submit" class="skip done">スキップ（照会へ）</button>
  </div>

@endsection