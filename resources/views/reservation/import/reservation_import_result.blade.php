@extends('layout.base')

@section('title', '取込結果一覧')

@section('style')
  <link href="{{ mix('css/reservation/import/reservation_import_result.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage')],
    ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search')],
    ['name' => '一括取込ファイル指定', 'url' => ext_route('reservation.import.file_select')],
    ['name' => '取込結果一覧']
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="reservation_import_result">
    <div class="panel capture_result">
      <div class="title">取込結果</div>
      <div class="section">
        <p>
          {{ ext_number_format($import_management['import_count']) }}件のデータを取込みました。<br>
          {{ ext_number_format($import_management['new_import_count']) }}
          件が新規で{{ ext_number_format($import_management['change_import_count']) }}件が変更です。<br>
          {{ ext_number_format((int)$import_management['new_import_error_count'] + (int)$import_management['change_error_import_count']) }}
          件が内容チェックでエラーになりました。
        </p>
      </div>
    </div>
    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="10">取込予約一覧結果</th>
        </tr>
        <tr class="data_title">
          <th rowspan="2" style="width: 105px">旅行社管理番号</th>
          <th rowspan="2" style="width: 75px">処理</th>
          <th rowspan="2" style="width: 75px">ｽﾃｰﾀｽ</th>
          <th rowspan="2" style="width: 170px">代表者名</th>
          <th rowspan="2" style="width: 100px">電話番号</th>
          <th colspan="3">人数</th>
          <th rowspan="2" style="width: 100px">予約番号</th>
          <th rowspan="2" style="width: 250px">取込エラー内容</th>
        </tr>
        <tr class="data_title">
          <th style="width: 70px">大人</th>
          <th style="width: 70px">小人</th>
          <th style="width: 70px">幼児</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($import_headers as $import_header)
          <tr class="{{ $import_header['reservation_import_status'] }}">
            <td style="width: 105px">{{ $import_header['travel_company_manage_number'] }}</td>
            <td style="width: 75px">{{ config('const.reservation_import_process_type.name.'.$import_header['process_type']) }}</td>
            <td style="width: 75px">{{ config('const.reservation_import_status.name.'.$import_header['reservation_import_status']) }}</td>
            <td style="width: 170px">{{ $import_header['boss_name'] }}</td>
            <td style="width: 100px">{{ $import_header['boss_tel'] }}</td>
            <td style="width: 70px">{{ $import_header['adult_count'] }}</td>
            <td style="width: 70px">{{ $import_header['child_count'] }}</td>
            <td style="width: 70px">{{ $import_header['infant_count'] }}</td>
            <td style="width: 100px">{{ $import_header['reservation_number'] }}</td>
            <td style="width: 250px">{{ $import_header['import_error_content'] }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.import.file_select') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <a href="{{ ext_route('reservation.reception.list', ['return_name' => request()->route()->getName()]) }}">
        <button class="back">受付一覧へ</button>
      </a>
    </div>
  </main>
@endsection