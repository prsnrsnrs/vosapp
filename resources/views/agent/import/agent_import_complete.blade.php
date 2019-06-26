@extends('layout.base')

@section('title', '販売店一括登録完了')

@section('style')
  <link href="{{ mix('css/agent/import/agent_import_complete.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
      ['name' => 'マイページ', 'url' => ext_route('mypage')],
      ['name' => '販売店一覧', 'url' => ext_route('list')],
      ['name' => '複数一括登録','url'=>ext_route('import.file_select')],
      ['name' => '複数一括完了']
    ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  @include('include/information', ['info' =>config('messages.info.I210-0103')])
  <main>
    <table class="default">
      <thead>
      <tr>
        <th colspan="3">複数登録結果</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th style="width: 50%">インポート件数</th>
        <th style="width: 50%">エラー件数</th>
      </tr>
      <tr>
        <td>{{isset($import_data_count)?$import_data_count : '0' }}件</td>
        <td>{{isset($import_error_count)?$import_error_count : '0' }}件</td>
      </tr>
      </tbody>
    </table>

    <div class="button_bar">
      <a href="{{ ext_route('list') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">販売店一覧に戻る
        </button>
      </a>
    </div>

  </main>
@endsection