@extends('layout.base')

@section('title', '予約詳細')

@section('style')
  <link href="{{ mix('css/last_modified.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/last_modified.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/search_plan') }}">新規予約</a>＞予約詳細
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
  <main class="body">
    @include('include.course', ['menu_display' => true])
    @include('include/info', ['info' => '入力内容を確認し、間違いがなければ「次へ（確認）」ボタンを押してください。<br>変更する場合は、各項目の「変更・取消」ボタンを押してください。'])

    <div class="wizard">
      <ul>
        <li>①ご乗船者詳細入力</li>
        <li>②リクエスト入力</li>
        <li>③割引情報入力</li>
        <li>④質問事項のチェック</li>
        <li>⑤備考欄の入力</li>
        <li class="current">⑥確認</li>
      </ul>
    </div>
    <div class="list">
      <table class="center default">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.1</th>
          <td colspan="5" class="left">デラックスルーム（２名店員）</td>
          <th>客室番号</th>
          <td class="left" colspan="3">未定</td>
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 4%">No</th>
          <th style="width: 6%">代表者</th>
          <th style="width: 6%">大小幼</th>
          <th style="width: 20%">お名前</th>
          <th style="width: 4%">性別</th>
          <th style="width: 4%">年齢</th>
          <th style="width: 11%">ステータス</th>
          <th style="width: 9%">料金タイプ</th>
          <th style="width: 9%">旅行代金</th>
          <th style="width: 9%">割引券金額</th>
          <th style="width: 9%"></th>
          <th style="width: 9%"></th>
        </tr>
        <tr>
          <td class="index">1</td>
          <td>○</td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA YOSHIO</span></td>
          <td>男</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">1,120,000円</td>
          <td class="right">-15,000円</td>
          <td></td>
          <td>
          </td>
        </tr>
        <tr>
          <td class="index">2</td>
          <td></td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA TAROU</span></td>
          <td>男</td>
          <td>15</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">700,000円</td>
          <td></td>
          <td></td>
          <td>
          </td>
        </tr>
        <tr class="cancel">
          <td class="index">2</td>
          <td></td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA SABUROU</span></td>
          <td>男</td>
          <td>68</td>
          <td>CX</td>
          <td>ツイン</td>
          <td class="right">1,120,000円</td>
          <td></td>
          <td></td>
          <td>
          </td>
        </tr>
        </tbody>
      </table>

      <table class="center default">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.2</th>
          <td colspan="5" class="left">ステートルームF（3名店員）</td>
          <th>客室番号</th>
          <td class="left" colspan="3">未定</td>
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 4%">No</th>
          <th style="width: 6%">代表者</th>
          <th style="width: 6%">大小幼</th>
          <th style="width: 20%">お名前</th>
          <th style="width: 4%">性別</th>
          <th style="width: 4%">年齢</th>
          <th style="width: 11%">ステータス</th>
          <th style="width: 9%">料金タイプ</th>
          <th style="width: 9%">旅行代金</th>
          <th style="width: 9%">割引券金額</th>
          <th style="width: 9%"></th>
          <th style="width: 9%"></th>
        </tr>
        <tr>
          <td class="index">3</td>
          <td></td>
          <td>大人</td>
          <td class="name left"><span>NAKAGAWA HANAKO</span></td>
          <td>女</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">500,000円</td>
          <td></td>
          <td></td>
          <td>
          </td>
        </tr>
        <tr>
          <td class="index">4</td>
          <td></td>
          <td>小人</td>
          <td class="name left"><span>NAKAGAWA KOHANA</span></td>
          <td>女</td>
          <td>10</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">375,000円</td>
          <td></td>
          <td></td>
          <td>
          </td>
        </tr>
        <tr>
          <td class="index">5</td>
          <td></td>
          <td>幼児</td>
          <td class="name left"><span>NAKAGAWA YOUZI</span></td>
          <td>男</td>
          <td>1</td>
          <td>HK</td>
          <td>-</td>
          <td class="right">0円</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        </tbody>
      </table>
      <div class="list_button_bar">
        <a href="{{ url('reservation/input_name') }}">
          <button type="submit" class="add">客室変更・追加</button>
        </a>
        <a href="{{ url('reservation/boatmember') }}">
          <button type="submit" class="edit">ご乗船者詳細入力</button>
        </a>
        <a href="{{ url('reservation/input_request') }}">
          <button type="submit" class="edit">リクエスト入力</button>
        </a>
        <a href="{{ url('reservation/input_ticket') }}">
          <button type="submit" class="edit">割引情報入力</button>
        </a>
        <a href="{{ url('reservation/check_question') }}">
          <button type="submit" class="edit">質問事項のチェック</button>
        </a>
        <a href="{{ url('reservation/input_remarks') }}">
          <button type="submit" class="edit">備考入力</button>
        </a>
      </div>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/input_remarks') }}">
      <button type="submit" class="back">戻る</button>
    </a>
    <a href="{{ url('reservation/order_detail') }}">
      <button type="submit" class="done" style="padding: 0 5em;">
        次へ（確認）
      </button>
    </a>
  </div>
@endsection
