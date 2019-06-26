@extends('layout.base')

@section('title', '取込フォーマット設定')

@section('style')
  <link href="{{ mix('css/reservation/import/reservation_import_format_setting.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/import/reservation_import_format_setting.js')}}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
    ['name' => '取込ファイル指定', 'url' => ext_route('reservation.import.file_select'), 'confirm' => true],
    ['name' => '取込フォーマット管理', 'url' => ext_route('reservation.import.format_list'), 'confirm' => true],
    ['name' => '取込フォーマット設定']
  ]])
@endsection
@section('login_data')
  @include('include/login_data', ['confirm' => true])
@endsection

@section('content')
  <main class="capture_setting">
    @include('include/information', ['info' => ''])

    <form id="format_setting_form" method="post"
          action="{{ $is_edit ? ext_route('reservation.import.update_format') : ext_route('reservation.import.add_format')}}">
      <input type="hidden" name="last_update_date_time" value="{{ $format_header['last_update_date_time'] or '' }}"/>
      <input type="hidden" name="format_number" value="{{ $format_header['format_number'] or '' }}"/>
      <table class="default format_header">
        <thead>
        <tr>
          <th colspan="2">取込フォーマット設定</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th>フォーマット名<span class="required">※</span></th>
          <td><input type="text" class="format_name" name="format_name"
                     value="{{ $format_header['format_name'] or '' }}"/></td>
        </tr>
        <tr>
          <th>ファイル形式<span class="required">※</span></th>
          <td>
            @if ($is_edit)
              {{config('const.file_type.name.'.$format_header['file_type'])}}
            @else
              @foreach (config('const.file_type.name') as $value => $name)
                <label><input type="radio" name="file_type" value="{{ $value }}"/>{{ $name }}</label>
              @endforeach
            @endif
          </td>
        </tr>
        <tr>
          <th>列見出し行<span class="required">※</span></th>
          <td>
            @if ($is_edit)
              {{$format_header['header_line_number']}}行目
            @else
              <input type="text" class="col" name="header_line_number" value=""/>行目
            @endif
          </td>
        </tr>
        <tr>
          <th>取込開始行<span class="required">※</span></th>
          <td>
            @if ($is_edit)
              {{$format_header['import_start_line_number']}}行目
            @else
              <input type="text" class="col" name="import_start_line_number" value=""/>行目
            @endif
          </td>
        </tr>
        <tr>
          <th>取込ファイル<span class="required">※</span></th>
          <td>
            @if ($is_edit)
              設定済み
            @else
              <input type="file" class="file" name="import_file"/>
              (※取込フォーマットを設定する上では列見出しのみでも構いません)
            @endif
          </td>
        </tr>
        </tbody>
      </table>

      @if ($is_edit)
        <table class="default center format_detail">
          <thead>
          <tr>
            <th colspan="6">取込フォーマット</th>
          </tr>
          <tr class="title_th">
            <th>No</th>
            <th>項目</th>
            <th>属性</th>
            <th>取込情報</th>
            <th>区切文字</th>
            <th>説明</th>
          </tr>
          </thead>
          <tbody>
          @foreach($format_details as $format_detail)
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td>
                {{ $format_detail['group_point_name'] ? $format_detail['group_point_name'] : $format_detail['format_point_name'] }}
                <span class="danger">{{ $format_detail['format_require_type'] === 'Y'? '※': '' }}</span>
              </td>
              <td>
                {{ config('const.reservation_import_attribute_type.name.'.$format_detail['attribute_type']) }}
              </td>
              <td class="right">
                <input type="hidden"
                       name="format_details[{{$format_detail['format_point_manage_number']}}][format_require_type]"
                       value="{{$format_detail['format_require_type']}}">
                <input type="hidden"
                       name="format_details[{{$format_detail['format_point_manage_number']}}][display_row_number]"
                       value="{{$loop->iteration}}">
                <div>
                  {{ count($format_detail['group']) === 0 ? '' :$format_detail['format_point_name'] }}
                  <select name="format_details[{{$format_detail['format_point_manage_number']}}][travel_company_col_index]">
                    <option value="">----</option>
                    @foreach($file_header as $col_index => $col_name)
                      <option value="{{$col_index+1}}" {{ option_selected($col_index+1, $format_detail['travel_company_col_index']) }}>{{ $col_name }}</option>
                    @endforeach
                  </select>
                </div>
                {{-- グループのドロップダウン生成--}}
                @foreach ($format_detail['group'] as $group)
                  <input type="hidden"
                         name="format_details[{{$group['format_point_manage_number']}}][format_require_type]"
                         value="{{$group['format_require_type']}}">
                  <input type="hidden"
                         name="format_details[{{$group['format_point_manage_number']}}][display_row_number]"
                         value="{{$loop->parent->iteration}}">
                  <div>
                    {{ $group['format_point_name'] }}
                    <select name="format_details[{{$group['format_point_manage_number']}}][travel_company_col_index]">
                      <option value="">----</option>
                      @foreach($file_header as $col_index => $col_name)
                        <option value="{{$col_index+1}}" {{ option_selected($col_index+1, $group['travel_company_col_index']) }}>{{ $col_name }}</option>
                      @endforeach
                    </select>
                  </div>
                @endforeach
              </td>
              <td>
                @if($format_detail['delimit_type'] !== 'N')
                  <input type="text" class="delimit_type_group"
                         name="format_details[{{$format_detail['format_point_manage_number']}}][delimiter_char]"
                         value="{{ convert_i5db_delimiter_to_web($format_detail['delimiter_char']) }}" maxlength="1"/>
                  {{-- データ登録時に必要になるため、グループの隠し区切文字フィールド生成。 ↑の値と連動してjavascriptで自動的に値をセットする。 --}}
                  @foreach ($format_detail['group'] as $group)
                    <input type="hidden" class="delimit_type_group"
                           name="format_details[{{$group['format_point_manage_number']}}][delimiter_char]"
                           value="{{ convert_i5db_delimiter_to_web($group['delimiter_char']) }}"/>
                  @endforeach
                @endif
              </td>
              <td class="left">
                <div>{{ $format_detail['description'] }}</div>
                @foreach ($format_detail['group'] as $group)
                  <div>{{ $group['description'] }}</div>
                @endforeach
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      @endif

      <div class="button_bar">
        <a href="{{ ext_route('reservation.import.format_list') }}" class="prev_confirm">
          <button type="button" class="back">
            <img src="{{  ext_asset('images/icon/return.png') }}">戻る
          </button>
        </a>
        <button type="submit" class="done">
          <img src="{{  ext_asset('images/icon/register.png') }}">{{ $is_edit ? '保存' : '登録' }}
        </button>
      </div>
    </form>
  </main>
@endsection