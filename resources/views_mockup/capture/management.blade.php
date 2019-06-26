@extends('layout.base')

@section('title', '取込フォーマット管理画面')

@section('style')
  <link href="{{ mix('css/management.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/management.js')}}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞<a href="{{ url('capture/select') }}">取込ファイル指定</a>＞取込フォーマット管理
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('mypage/') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
<main class="capture_management">
  <div class="main">
    <table class="default hover_rows">
      <thead>
      <tr>
        <th colspan="10" class="left"><span class="bold">取込フォーマット一覧</span></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th width="5%">No.</th>
        <th width="20%">フォーマット名</th>
        <th width="10%">ファイル形式</th>
        <th width="9%">既定</th>
        <th width="9%">登録日</th>
        <th width="9%">変更日</th>
        <th width="14%">変更ユーザー名称</th>
        <th width="8%"></th>
        <th width="8%"></th>
        <th width="8%"></th>
      </tr>
      <tr>
        <td>1</td>
        <td class="left">JCL標準予約データ取込</td>
        <td>EXCEL</td>
        <td>既定</td>
        <td>2017/03/25</td>
        <td></td>
        <td></td>
        <td>
          {{--<a href="{{ url('capture/setting') }}"><button type="submit" class="edit">変更</button></a>--}}
        </td>
        <td>
          {{--<button type="submit" class="delete">削除</button>--}}
        </td>
        <td>
          <button class="default">複製</button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td class="left">予約データ取込</td>
        <td>CSV</td>
        <td><button type="submit" class="default setting">設定</button></td>
        <td>2017/06/05</td>
        <td>2017/06/07</td>
        <td>テスト　太郎</td>
        <td><a href="{{ url('capture/setting') }}"><button type="submit" class="edit">変更</button></a></td>
        <td><button type="submit" class="delete">削除</button></td>
        <td>
          <button class="default">複製</button>
        </td>
      </tr>
      <tr>
        <td>3</td>
        <td class="left">テスト</td>
        <td>EXCEL</td>
        <td><button type="submit" class="default setting">設定</button></td>
        <td>2017/04/25</td>
        <td>2017/04/24</td>
        <td>テスト　梅子</td>
        <td><a href="{{ url('capture/setting') }}"><button type="submit" class="edit">変更</button></a></td>
        <td><button type="submit" class="delete">削除</button></td>
        <td>
          <button class="default">複製</button>
        </td>
      </tr>
      </tbody>
    </table>
    <a href="{{ url('capture/setting') }}"><button class="add add_btn">フォーマット追加</button></a>
  </div>
</main>
<div class="button_bar">
  <a href="{{ url('capture/select') }}"><button class="back back_btn">戻る</button></a>
</div>
@endsection