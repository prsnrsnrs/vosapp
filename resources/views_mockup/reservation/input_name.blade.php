@extends('layout.base')

@section('title', 'ご乗船者名入力画面')

@section('style')
  <link href="{{ mix('css/input_name.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/input_name.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞新規予約
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
<?php
  $users = [
      '選択してください', 'No.1 NAKAGAWA YOSHIO', 'No.2 NAKAGAWA HANAKO', 'No.3 NAKAGAWA TARO'
  ]
?>
@section('content')
  <main class="body">
      @include('include/course', ['menu_display' => false])
      @include('include/info', ['info' => 'ご乗船されるお客様のお名前を入力して下さい。（客室を追加する場合は「＋客室追加」ボタンをクリックして下さい。）<br><span class="danger">※まだ客室は確保されていません。客室を確保するには、予約ボタンを押してください。</span>'])
    <div class="list">
      <table class="default center">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.1</th>
          <td class="left">デラックスルーム（定員2名）</td>
          <td>
            <a href="{{ url('reservation/choose_guestroom') }}">
              <button class="edit center">客室タイプ変更</button>
            </a>
          </td>
          <td>
            <button class="delete table_delete">取消</button>
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 5%">代表</th>
          <th style="width: 5%">区分</th>
          <th style="width: 60%">お名前（英字）</th>
          <th style="width: 17%">登録済み一覧から選択</th>
          <th style="width: 8%"></th>
        </tr>
        <tr>
          <td class="index">1</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative" checked="checked" />
              <span class="checkbox"></span>
            </label>
          </td>
          <td class="type">大</td>
          <td class="name">
            （姓）<input type="text" value="NAKAGAWA" placeholder="例）YOYAKU">
            （名）<input type="text" value="YOSHIO" placeholder="例）TAROU"></td>
          <td>
            <select >
              @foreach($users as $user)
                <option>{{ $user }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button class="delete  row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td class="index">2</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative"/>
              <span class="checkbox"></span>
            </label>
          </td>
          <td class="type">大</td>
          <td class="name">（姓）<input type="text" placeholder="例）YOYAKU">
            （名）<input type="text" placeholder="例）HANAKO">
          </td>
          <td>
            <select >
              @foreach($users as $user)
                <option>{{ $user }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr class="add_row">
          <td class="index">1</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative" />
              <span class="checkbox"></span>
            </label>
          </td>
          <td class="type"></td>
          <td class="name">（姓）<input type="text">（名）<input type="text"> 様</td>
          <td></td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
          <th colspan="3">おひとり追加</th>
          <td class="index left">
            <select name="type">
              <option value="大">大人（中学生以上）</option>
              <option value="小">１２歳（小学生）</option>
              <option value="小" selected>２歳～１１歳</option>
              <option value="幼">１歳～２歳</option>
              <option value="幼">６カ月～１歳</option>
            </select>
            {{--<span class="arrow"><img src="{{ asset('/images/arrow.png') }}"></span>--}}
            <button class="done deluxe_room_add" style="width: 74px;">追加</button>
          </td>
          <td></td>
          <td></td>
        </tr>
        </tfoot>
      </table>

      <table class="default center">
        <thead style="width: 100%">
        <tr>
          <th colspan="3">客室No.2</th>
          <td class="left">デラックスルーム（定員2～3名）</td>
          <td>
            <a href="{{ url('reservation/choose_guestroom') }}">
              <button class="edit">客室タイプ変更</button>
            </a>
          </td>
          <td>
            <button class="delete table_delete">取消</button>
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 5%">代表</th>
          <th style="width: 5%">区分</th>
          <th style="width: 60%">お名前（英字）</th>
          <th style="width: 17%">登録済み一覧から選択</th>
          <th style="width: 8%"></th>
        </tr>
        <tr>
          <td class="index">3</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative"/>
              <span class="checkbox"></span>
            </label>
          </td>
          <td class="type">大</td>
          <td class="name">（姓）<input type="text" value="NAKAGAWA" placeholder="例）YOYAKU">
            （名）<input type="text" value="HANAKO" placeholder="例）TAROU">
          </td>
          <td>
            <select >
              @foreach($users as $user)
                <option>{{ $user }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td class="index">4</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative"/>
              <span class="checkbox"></span>
            </label>
          </td>
          <td>大</td>
          <td class="name">（姓）<input type="text" placeholder="例）YOYAKU">（名）<input type="text" placeholder="例）HANAKO">
          </td>
          <td>
            <select >
              @foreach($users as $user)
                <option>{{ $user }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr>
          <td class="index">5</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative"/>
              <span class="checkbox"></span>
            </label>
          </td>
          <td class="type">幼</td>
          <td class="name">（姓）<input type="text" placeholder="例）YOYAKU">（名）<input type="text" placeholder="例）JIROU">
          </td>
          <td>
            <select >
              @foreach($users as $user)
                <option>{{ $user }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        <tr class="add_row">
          <td class="index">1</td>
          <td>
            <label>
              <input type="radio" class="check_style" name="representative"/>
              <span class="checkbox"></span>
            </label>
          </td>
          <td class="type"></td>
          <td class="name">（姓）<input type="text">（名）<input type="text"></td>
          <td>
            <select >
              @foreach($users as $user)
                <option>{{ $user }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button class="delete row_delete">削除</button>
          </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
          <th colspan="3">おひとり追加</th>
          <td class="left">
            <select name="type">
              <option value="大">大人（中学生以上）</option>
              <option value="小">１２歳（小学生）</option>
              <option value="小" selected>２歳～１１歳</option>
              <option value="幼">１歳～２歳</option>
              <option value="幼">６カ月～１歳</option>
            </select>
            {{--<span class="arrow"><img src="{{ asset('/images/arrow.png') }}"></span>--}}
            <button class="done state_room_add" style="width: 74px;">追加</button>
          </td>
          <td></td>
          <td></td>
        </tr>
        </tfoot>
      </table>
    </div>
  </main>
  <?php
    $new_flg = true;
  ?>
  <!-- TODO:ボタンのレイアウト変更の要望で予約ボタンを大きくするため一時的にコメントアウト。レイアウト確認していただいてから再度調整する -->
  {{--<div class="button_bar">--}}
    {{--<a href="{{ url('reservation/choose_guestroom') }}">--}}
      {{--<button type="submit" class="add">＋客室追加</button>--}}
    {{--</a>--}}
  {{--</div>--}}

  {{--<div class="button_bar">--}}
    {{--@if($new_flg)--}}
      {{--<button type="submit" class="back mypage">予約の取消</button>--}}
      {{--<button type="submit" class="done detail">予約</button>--}}
    {{--@else--}}
      {{--<a href="{{ url('reservation/order_detail') }}">--}}
        {{--<button type="submit" class="back">入力の取消</button>--}}
      {{--</a>--}}
      {{--<button type="submit" class="done edit_fix">決定</button>--}}
    {{--@endif--}}
  {{--</div>--}}

  <div class="button_bar">
    <a href="{{ url('reservation/choose_guestroom') }}">
      <button type="submit" class="add">＋客室追加</button>
    </a>
    @if($new_flg)
      <button type="submit" class="done detail" style="height: 57px; position: absolute; margin-left: 15px;">予約</button>
    @else
      <button type="submit" class="done edit_fix" style="height: 57px; position: absolute; margin-left: 15px;">決定</button>
    @endif
  </div>

  <div class="button_bar">
    @if($new_flg)
      <button type="submit" class="back mypage">予約の取消</button>
    @else
      <a href="{{ url('reservation/order_detail') }}">
        <button type="submit" class="back">入力の取消</button>
      </a>
    @endif
  </div>

@endsection
