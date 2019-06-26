@extends('layout.base')

@section('title', 'キャンセル待ち確認画面')

@section('style')
  <link href="{{ mix('css/wait_cancel.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/wait_cancel.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/search_plan') }}">クルーズプラン検索</a>
  ＞<a href="{{ url('reservation/choose_course') }}">コース選択</a>＞<a href="{{ url('reservation/choose_guestroom') }}">客室タイプ選択</a>＞キャンセル待ち登録

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
  <main class="wait_cancel">
      @include('include/course',['menu_display' => false])
      @include('include/info', ['info' => '<span class="danger">ご希望の客室タイプは空きがないため、予約をお取りできません。<br />
キャンセル待ちを希望される場合は「キャンセル待ち登録をして詳細入力へ進む」ボタンをクリックしてください。'])
    <table class="default">
      <thead style="width: 100%">
      <th colspan="3">客室No.1</th>
      <td class="left">デラックスルーム（２名店員）</td>
      <td class="center">
        <a href="{{ url('reservation/choose_guestroom') }}">
          <button class="edit">客室タイプ変更</button>
        </a>
      </td>
      <td>
        <button class="delete table_delete">取消</button>
      </td>
      </thead>
      <tbody>
      <tr>
        <th style="width: 5%">No</th>
        <th style="width: 5%">代表</th>
        <th style="width: 6%">区分</th>
        <th style="width: 64%">お名前（ローマ字）</th>
        <th style="width: 14%"></th>
        <th style="width: 6%"></th>
      </tr>
      <tr>
        <td class="index">1</td>
        <td>
          <label>
            <input type="radio" class="check_style" name="leader" checked/>
            <span class="checkbox"></span>
          </label>
        </td>
        <td>
          <select>
            <option value="A">A：大人(中学生以上)</option>
            <option value="B">B：1歳以上小学生以下</option>
            <option value="C">C：6ヶ月月以上1歳未満</option>
          </select>
        </td>
        <td class="name">（姓）<input type="text" value="NAKAGAWA" placeholder="例)YOYAKU">（名）<input type="text" value="YOSHIO" placeholder="例)TAROU"></td>
        <td></td>
        <td class="center">
          <button class="delete  row_delete">削除</button>
        </td>
      </tr>
      <tr>
        <td class="index">2</td>
        <td>
          <label>
            <input type="radio" class="check_style" name="leader"/>
            <span class="checkbox"></span>
          </label>
        </td>
        <td>
          <select>
            <option value="A">A：大人(中学生以上)</option>
            <option value="B">B：1歳以上小学生以下</option>
            <option value="C">C：6ヶ月月以上1歳未満</option>
          </select>
        </td>
        <td class="name">（姓）<input type="text" value="NAKAGAWA" placeholder="例)YOYAKU">（名）<input type="text" value="TATOU" placeholder="例)HANAKO"></td>
        <td></td>
        <td class="center">
          <button class="delete row_delete">削除</button>
        </td>
      </tr>
      </tbody>
    </table>
    <table class="default" style="display: none">
      <thead style="width: 100%">
      <tr>
        <th colspan="3" style="width: 30%; co">客室No.2</th>
        <td colspan="3" style="width: 70%" class="left">ステートルームF3（３名定員）</td>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th style="width: 5%">No</th>
        <th style="width: 5%">代表</th>
        <th style="width: 5%">区分</th>
        <th style="width: 65%">お名前（ローマ字）</th>
        <th style="width: 14%"></th>
        <th style="width: 6%"></th>
      </tr>
      <tr>
        <td class="index">3</td>
        <td>
          <label>
            <input type="radio" class="check_style" name="leader"/>
            <span class="checkbox"></span>
          </label>
        </td>
        <td>
          <select>
            <option value="A">A：大人(中学生以上)</option>
            <option value="B">B：1歳以上小学生以下</option>
            <option value="C">C：6ヶ月月以上1歳未満</option>
          </select>
        </td>
        <td class="name">（姓）<input type="text" value="NAKAGAWA">（名）<input type="text" value="HANAKO"></td>
        <td></td>
        <td class="center">
          <button class="delete row_delete">削除</button>
        </td>
      </tr>
      <tr>
        <td class="index">4</td>
        <td>
          <label>
            <input type="radio" class="check_style" name="leader"/>
            <span class="checkbox"></span>
          </label>
        </td>
        <td>
          <select>
            <option value="A">A：大人(中学生以上)</option>
            <option value="B">B：1歳以上小学生以下</option>
            <option value="C">C：6ヶ月月以上1歳未満</option>
          </select>
        </td>
        <td class="name">（姓）<input type="text" value="NAKAGAWA">（名）<input type="text" value="KOHANA"></td>
        <td></td>
        <td class="center">
          <button class="delete row_delete">削除</button>
        </td>
      </tr>
      <tr>
        <td class="index">5</td>
        <td>
          <label>
            <input type="radio" class="check_style" name="leader"/>
            <span class="checkbox"></span>
          </label>
        </td>
        <td>C</td>
        <td class="name">（姓）<input type="text" value="NAKAGAWA">（名）<input type="text" value="YOUZI"></td>
        <td></td>
        <td class="center">
          <button class="delete row_delete">削除</button>
        </td>
      </tr>
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <button type="submit" class="delete suspension">中止する</button>
    <a href="{{ url('reservation/choose_guestnumber') }}">
      <button type="submit" class="done detail">
        キャンセル待ち登録をして詳細入力へ進む
      </button>
    </a>
  </div>
@endsection
