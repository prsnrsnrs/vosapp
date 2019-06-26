@extends('layout.base')

@section('title', 'コース選択画面')

@section('style')
  <link href="{{ mix('css/choose_course.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('reservation/search_plan') }}">クルーズプラン検索</a>＞コース選択
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
  <main class="choose_course">

    @include('include/course',['menu_display' => false])
    @include('include/info', ['info' => 'コースを選択してください'])

    <div class="choose_area">
      <table rules="all" class="default">
        <tr>
          <td style="width: 70%">Aコース 2017年5月8日(月) ～ 5月18日(木) [神戸発着10泊11日]</td>
          <td style="width: 15%" class="center">
            <a href="{{ url('capture/select') }}">
              <button type="submit" class="done">一括取込</button>
            </a>
          </td>
          <td style="width: 15%" class="center">
            <a href="{{ url('reservation/choose_guestroom') }}">
              <button type="submit" class="done">通常予約</button>
            </a></td>
        </tr>
        <tr>
          <td style="width: 70%">Bコース 2017年5月9日(火) ～ 5月19日(金) [横浜発着10泊11日]</td>
          <td style="width: 15%" class="center">
            <a href="{{ url('capture/select') }}">
              <button type="submit" class="done">一括取込
              </button>
            </a>
          </td>
          <td style="width: 15%" class="center">
            <a href="{{ url('reservation/choose_guestroom') }}">
              <button type="submit" class="done">通常予約
              </button>
            </a>
          </td>
        </tr>
      </table>
    </div>
  </main>

  <div class="button_bar">
    <a href="{{ url('reservation/search_plan') }}">
      <button class="back">戻る</button>
    </a>
  </div>

@endsection