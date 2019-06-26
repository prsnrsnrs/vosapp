@extends('layout.base')

@section('title', '特別な配慮が必要な方へのアンケート入力画面')

@section('style')
  <link href="{{ mix('css/upload.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞新規予約
@endsection

@section('js')
  <script src="{{ mix('js/upload.js') }}"></script>
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
  <main class="upload">
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
            <td class="left">ナカガワ　ヨシオ　様</td>
            <td>男</td>
            <td>44</td>
            <td>食物アレルギーや食事制限の方へのアンケート</td>
            <td class="danger">未</td>
          </tr>
          <tr>
            <td colspan="7" class="left">
              <p>
                <span class="under_line">クルーズ出発の３週間</span>までに、ご回答ください。<br>
                対応出来る内容や食数には限りがありますので、ご希望に添えない場合がございます。あらかじめご了承ください。<br>
                なお、このアンケートはお食事ご提供の参考資料とさせていただくことを目的とし、それ以外の目的には使用いたしません。
              </p>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="file_select panel">
        <div class="title">
          <p>送信（アップロード）ファイルの選択</p>
        </div>
        <div class="body">
          <ul>
            <li style="margin-right: 27px;">
              <input class="file" type="file">
              <button class="delete">削除</button>
            </li>
            <li><span class="danger">送信（アップロード）済</span></li>
          </ul>
        </div>
      </div>

      <div class="file_upload">
        <ul>
          <li style="vertical-align: top;">
            <button class="default file_upload">送信（アップロード）</button>
          </li>
          <li>
            <p>※済マークは当社の確認後になりますので、送信後でもすぐには反映されません。</p>
            <p>※読み取りファイルが不鮮明等の理由で再送信をお願いする場合がございます。
            </p>
          </li>
        </ul>
      </div>
    </div>
  </main>

  <div class="button_bar">
    <button type="submit" class="back">戻る</button>
  </div>
@endsection
