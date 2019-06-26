@extends('layout.base')

@section('title', '取込フォーマット管理画面')

@section('style')
  <link href="{{ mix('css/reservation/import/reservation_import_format_list.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/import/reservation_import_format_list.js')}}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage')],
    ['name' => '取込ファイル指定', 'url' => ext_route('reservation.import.file_select')],
    ['name' => '取込フォーマット管理'],
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="reservation_import_format_list">
    @include('include/information', ['info' => ''])

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
        @foreach ($formats as $format)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="left">{{ $format['format_name'] }}</td>
            <td>{{ config('const.file_type.name.'.$format['file_type']) }}</td>
            <td>
              @if ($format['default_type'])
                既定
              @else
                <button type="button" class="default format_default" data-format_number="{{ $format['format_number'] }}"
                        data-last_update_date_time="{{ $format['last_update_date_time'] }}">設定
                </button>
              @endif
            </td>
            <td>{{ convert_date_format($format['new_register_date_time'], 'Y/m/d') }}</td>
            <td>{{ convert_date_format($format['last_update_date_time'], 'Y/m/d') }}</td>
            <td>{{ $format['user_name'] }}</td>
            <td>
              @if ((int)$format['edit_flag'] <= config('const.format_edit_flag.value.all'))
                <a href="{{ ext_route('reservation.import.format_setting', ['format_number' => $format['format_number']]) }}">
                  <button type="button" class="edit">変更</button>
                </a>
              @endif
            </td>
            <td>
              @if ((int)$format['edit_flag'] <= config('const.format_edit_flag.value.all'))
                <button type="button" class="delete format_delete" data-format_number="{{ $format['format_number'] }}"
                        data-last_update_date_time="{{ $format['last_update_date_time'] }}">削除
                </button>
              @endif
            </td>
            <td>
              @if ((int)$format['edit_flag'] <= config('const.format_edit_flag.value.copy'))
                <button type="button" class="default format_copy" data-format_number="{{ $format['format_number'] }}">複製
                </button>
              @endif
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <a href="{{ ext_route('reservation.import.format_setting') }}">
        <button class="add add_btn">
          <img src="{{  ext_asset('images/icon/add.png') }}">フォーマット追加
        </button>
      </a>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('reservation.import.file_select') }}">
        <button class="back back_btn">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>
  </main>

  <form id="default_form" method="post" action="{{ext_route('reservation.import.default_format')}}"></form>
  <form id="delete_form" method="post" action="{{ext_route('reservation.import.delete_format')}}"></form>
  <form id="copy_form" method="post" action="{{ ext_route('reservation.import.copy_format') }}"></form>
@endsection