@extends('layout.base')

@section('title', '全面取消確認画面')

@section('style')
  <link href="{{ mix('css/cancel_front.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/cancel_front.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞予約取消
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
    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => '予約を削除します。よろしければ「確定」ボタンを押してください。'])

    <div class="headline">
      <table class="center default">
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
          <td style="width: 10%"></td>
          <td style="width: 12%"></td>
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
          <td class="left" colspan="3">12345</td>
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
        <tr class="cancel">
          <td class="index">1</td>
          <td>○</td>
          <td>大人</td>
          <td class="name left">NAKAGAWA YOSHIO</td>
          <td>男</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="cancel">
          <td class="index">2</td>
          <td></td>
          <td>大人</td>
          <td class="name left">NKAGAWA TAROU</td>
          <td>男</td>
          <td>15</td>
          <td>HK</td>
          <td>ツイン</td>
          <td></td>
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
          <td></td>
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
          <td class="left" colspan="3">67890</td>
        </tr>
        </thead>
        <tbody>
        <tr class="cancel">
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
        <tr class="cancel">
          <td class="index">4</td>
          <td></td>
          <td>大人</td>
          <td class="name left">NAKAGAWA HANAKO</td>
          <td>女</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="cancel">
          <td class="index">5</td>
          <td></td>
          <td>小人</td>
          <td class="name left">NAKAGAWA KOHANA</td>
          <td>女</td>
          <td>10</td>
          <td>HK</td>
          <td>ツイン</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="cancel">
          <td class="index">6</td>
          <td></td>
          <td>幼児</td>
          <td class="name left">NAKAGAWA YOUZI</td>
          <td>男</td>
          <td>1</td>
          <td>HK</td>
          <td>-</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/order_detail') }}"><button type="submit" class="back">戻る</button></a>
    <button type="submit" class="delete">確定</button>
  </div>
@endsection
