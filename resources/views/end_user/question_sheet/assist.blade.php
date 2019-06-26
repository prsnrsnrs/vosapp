@extends('layout.base')

@section('title', '特別な配慮が必要な方へのアンケート入力画面')

@section('style')
  <link href="{{ mix('css/assist.css') }}" rel="stylesheet"/>
@endsection


@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞新規予約
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
  <main class="assist">
    <div class="body">
      @include('include/course', ['menu_display' => false])
      @include('include/information', ['info' => '以下のアンケートの内容と対象となるお客様の名前を確認後、アンケートにご回答をお願いします。'])
      <div class="user_info">
        <table class="default center">
          <tbody>
          <tr>
            <th style="width: 7%">No</th>
            <th style="width: 7%">料金区分</th>
            <th style="width: 30%">お名前</th>
            <th style="width: 7%">性別</th>
            <th style="width: 7%">年齢</th>
            <th style="width: 35%">入力アンケートの内容</th>
            <th style="width: 7%">提出</th>
          </tr>
          <tr>
            <td>1</td>
            <td>小人</td>
            <td class="left">ナカガワ　コハナ　様</td>
            <td>女</td>
            <td>10</td>
            <td>特別な配慮が必要な方へのアンケート</td>
            <td class="danger">未</td>
          </tr>
          <tr>
            <td colspan="7" class="left">
              <p>
                ご参加されるお客様の快適な旅行、そして円滑なクルーズ実施のためにご記入をお願い致します。<br>
                なお、この健康アンケートは皆様の健康管理の参考資料とさせていただくことを目的とし、それ以外の目的には使用いたしません。
              </p>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="question_sheet">
        <table class="default">
          <tbody>
          <tr>
            <th class="left">
              <p>私どもにお伝えしたいことがございましたら、ご記入ください。</p>
            </th>
          </tr>
          <tr>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <div class="button_bar">
    <button type="submit" class="delete">戻る</button>
    <a href="">
      <button type="submit" class="done">
        回答
      </button>
    </a>
  </div>
@endsection
