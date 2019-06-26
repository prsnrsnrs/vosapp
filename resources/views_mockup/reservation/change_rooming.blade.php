@extends('layout.base')

@section('title', 'ルーミング変更画面')

@section('style')
  <link href="{{ mix('css/change_rooming.css') }}" rel="stylesheet"/>
  {{--<meta http-equiv="Content-Script-Type" content="text/javascript">--}}
@endsection

@section('js')
  <script src="{{ mix('js/change_rooming.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/input_name') }}">新規予約</a>＞ルーミング変更
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
    @include('include/course', ['menu_display' => false])
    @include('include/info', ['info' => '入れ替えたい乗船者の客室No.を指定して「決定」ボタンを押してください。'])
    <div class="list">
      <table class="default">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.1</th>
          <td colspan="5" class="left">デラックスルーム（定員3名）</td>
          <th>客室番号</th>
          <td colspan="2" class="left">12345</td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 6%">代表者</th>
          <th style="width: 6%">大小幼</th>
          <th style="width: 20%">お名前</th>
          <th style="width: 6%">性別</th>
          <th style="width: 6%">年齢</th>
          <th style="width: 9%">ステータス</th>
          <th style="width: 10%">料金タイプ</th>
          <th style="width: 10%">旅行代金</th>
          <th style="width: 10%">割引券金額</th>
          <th style="width: 12%">入替先</th>
        </tr>
        <tr>
          <td class="index">1</td>
          <td>○</td>
          <td>大人</td>
          <td class="name"><span>NAKAGAWA YOSHIO</span></td>
          <td>男</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">1,120,000円</td>
          <td class="right">-150,000円</td>
          <td>
            <select onchange="test(this);">
              <option selected>客室No.1</option>
              <option>客室No.2</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="index">2</td>
          <td></td>
          <td>大人</td>
          <td class="name"><span>NAKAGAWA TAROU</span></td>
          <td>男</td>
          <td>15</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">700,000円</td>
          <td class="right"></td>
          <td>
            <select onchange="test(this);">
              <option selected>客室No.1</option>
              <option>客室No.2</option>
            </select>
          </td>
        </tr>
        </tbody>
      </table>

      <table class="default">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.2</th>
          <td colspan="5" class="left">ステートルームF（定員2～3名）</td>
          <th>客室番号</th>
          <td colspan="2" class="left">67890</td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 6%">代表者</th>
          <th style="width: 6%">大小幼</th>
          <th style="width: 20%">お名前</th>
          <th style="width: 6%">性別</th>
          <th style="width: 6%">年齢</th>
          <th style="width: 9%">ステータス</th>
          <th style="width: 10%">料金タイプ</th>
          <th style="width: 10%">旅行代金</th>
          <th style="width: 10%">割引券金額</th>
          <th style="width: 12%">入替先</th>
        </tr>
        <tr>
          <td class="index">3</td>
          <td></td>
          <td>大人</td>
          <td class="name"><span>NAKAGAWA HANAKO</span></td>
          <td>女</td>
          <td>44</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">500,000円</td>
          <td></td>
          <td>
            <select onchange="test(this);">
              <option>客室No.1</option>
              <option selected>客室No.2</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="index">4</td>
          <td></td>
          <td>小人</td>
          <td class="name"><span>NAKAGAWA KOHANA</span></td>
          <td>女</td>
          <td>10</td>
          <td>HK</td>
          <td>ツイン</td>
          <td class="right">375,000円</td>
          <td></td>
          <td>
            <select onchange="test(this);">
              <option>客室No.1</option>
              <option selected>客室No.2</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="index">5</td>
          <td></td>
          <td>幼児</td>
          <td class="name"><span>NAKAGAWA YOUZI</span></td>
          <td>男</td>
          <td>1</td>
          <td>HK</td>
          <td>-</td>
          <td class="right">0円</td>
          <td></td>
          <td>
            <select onchange="test(this);">
              <option>客室No.1</option>
              <option selected>客室No.2</option>
            </select>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/order_detail') }}">
      <button class="back">戻る</button>
    </a>
    <button class="done" style="padding: 0 60px;">決定
    </button>
  </div>
  <script type="text/javascript">
      function test(obj) {
          var me = obj.parentNode.parentNode;
          var style = me.style['backgroundColor'];
          console.log(style);
          if (style == 'rgb(170, 170, 170)') {
              obj.parentNode.parentNode.style.backgroundColor = '#fff';
          } else {
              obj.parentNode.parentNode.style.backgroundColor = '#aaa';
          }
      }
  </script>

@endsection
