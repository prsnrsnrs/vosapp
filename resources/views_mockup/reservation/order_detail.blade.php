@extends('layout.base')

@section('title', '予約照会画面')

@section('style')
  <link href="{{ mix('css/order_detail.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞予約照会
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
  <main>
    <div class="body">
      @include('include.course', ['menu_display' => true] , ['travel' => true])
    @include('include/info', ['info' => 'お申込みの内容は以下の通りです。内容に変更や取消がある場合は該当する下のボタンよりお進みください。<br>また、ご精算やご提出書類の入力を行う場合は上のアイコンボタンよりお進みください。'])

    <div class="headline">
      <table class="default">
        <thead>
        <tr>
          <th style="width: 12%">予約番号</th>
          <th style="width: 12%">受付日時</th>
          <th style="width: 12%">取消日時</th>
          <th style="width: 12%"></th>
          <th style="width: 10%">旅行代金 合計</th>
          <th style="width: 12%">割引券金額 合計</th>
          <th style="width: 10%"></th>
          <th style="width: 10%"></th>
          <th style="width: 10%"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td style="width: 12%" class="bold">123456789</td>
          <td style="width: 12%">2017/02/23<br>12:34</td>
          <td style="width: 12%"></td>
          <td style="width: 12%"></td>
          <td style="width: 10%" class="right">1,995,000円</td>
          <td style="width: 12%" class="right">-15,000円</td>
          <td style="width: 10%"></td>
          <td style="width: 10%"></td>
          <td style="width: 10%"></td>
        </tr>
        </tbody>
        <tbody>

        </tbody>
      </table>
    </div>
    <div class="list">
      <table class="center default">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.1</th>
          <td colspan="5" class="left">デラックスルーム（定員2名）</td>
          <th>客室番号</th>
          <td class="left">未定</td>
          <td colspan="2">
            {{--<a href="{{ url('reservation/choose_guestroom') }}">--}}
              {{--<button class="edit">客室タイプ変更</button>--}}
            {{--</a>--}}
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
          <td class="name left">NAKAGAWA YOSHIO</td>
          <td>男</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">1,120,000円</td>
          <td class="right">-15,000円</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="index">2</td>
          <td></td>
          <td>大人</td>
          <td class="name left">NKAGAWA TAROU</td>
          <td>男</td>
          <td>15</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">700,000円</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="cancel">
          <td class="index">3</td>
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
          <td colspan="5" class="left">ステートルームF（定員2～3名）</td>
          <th>客室番号</th>
          <td class="left">未定</td>
          <td colspan="2">
            {{--<a href="{{ url('reservation/choose_guestroom') }}">--}}
              {{--<button class="edit">客室タイプ変更</button>--}}
            {{--</a>--}}
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
          <td class="index">4</td>
          <td></td>
          <td>大人</td>
          <td class="name left">NAKAGAWA HANAKO</td>
          <td>女</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">500,000円</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="index">5</td>
          <td></td>
          <td>小人</td>
          <td class="name left">NAKAGAWA KOHANA</td>
          <td>女</td>
          <td>10</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">375,000円</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="index">6</td>
          <td></td>
          <td>幼児</td>
          <td class="name left">NAKAGAWA YOUZI</td>
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
    </div>
    <div class="list_button_bar">
      <a href="{{ url('reservation/change_rooming') }}">
        <button id="rooming" type="submit" class="edit">ルーミング変更</button>
      </a>
      <a href="{{ url('reservation/input_name') }}">
        <button type="submit" class="edit">客室追加・変更</button>
      </a>
      <a href="{{ url('reservation/boatmember') }}">
        <button type="submit" class="edit">ご乗船者詳細入力</button>
      </a>
      <a href="{{ url('reservation/input_remarks') }}">
        <button type="submit" class="edit">ご乗船者リクエスト入力</button>
      </a>
      <a href="{{ url('reservation/input_request') }}">
        <button type="submit" class="edit">客室リクエスト入力</button>
      </a>
      <a href="{{ url('reservation/input_ticket') }}">
        <button type="submit" class="edit">割引情報入力</button>
      </a>
      <a href="{{ url('reservation/check_question') }}">
        <button type="submit" class="edit">質問事項のチェック</button>
      </a>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/cancel_front') }}">
      <button type="submit" class="delete">予約取消</button>
    </a>
  </div>
@endsection
