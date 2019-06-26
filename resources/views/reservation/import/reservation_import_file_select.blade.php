@extends('layout.base')

@section('title', '一括取込ファイル指定')

@section('style')
  <link href="{{ mix('css/reservation/import/reservation_import_file_select.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/reservation/import/reservation_import_file_select.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage')],
    ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search')],
    ['name' => '一括取込ファイル指定'],
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="body">
    @include('include/information', ['info' => config('messages.info.I100-0101')])

    <form id="reservation_import_form" action="{{ext_route('reservation.import.import')}}" method="post">
      <input type="hidden" name="item_code" value="{{$item_info['item_code']}}"/>
      <div class="search_form">
        <table class="default left">
          <thead>
          <tr>
            <th colspan="2">予約データの取込</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th style="width: 17%">クルーズ名（コース）</th>
            <td style="width: 83%">{!! str_concat($item_info['item_name'], $item_info['item_name2'], ' ') !!}</td>
          </tr>
          <tr>
            <th>出発日</th>
            <td>
              {{ $item_info['departure_place_knj']}}発&nbsp;&nbsp;
              {{ convert_date_format($item_info['item_departure_date'], 'Y/m/d') }}
              ({{ get_youbi($item_info['item_departure_date']) }})
            </td>
          </tr>
          <tr>
            <th>取込指定フォーマット</th>
            <td>
              <select id="format_number" name="format_number">
                @foreach ($formats as $format)
                  <option value="{{$format['format_number']}}" {{ option_selected($format['default_type'], '1') }}>{{$format['format_name']}}</option>
                @endforeach
              </select>
              <button type="button" class="edit" id="download_format">
                <img src="{{  ext_asset('images/icon/download.png') }}">ダウンロード
              </button>
              @if (\App\Libs\Voss\VossAccessManager::isJurisdictionAgent() && \App\Libs\Voss\VossAccessManager::isAgentAdmin())
                <a href="{{ ext_route('reservation.import.format_list') }}">
                  <button type="button" class="edit">
                    <img src="{{  ext_asset('images/icon/setting.png') }}">フォーマット設定
                  </button>
                </a>
              @endif
            </td>
          </tr>
          <tr>
            <th>取込ファイル指定</th>
            <td>
              <input type="file" name="import_file" class="file_name">
              <button type="submit" class="done" id="btn_result_list">
                <img src="{{  ext_asset('images/icon/import.png') }}">取込
              </button>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <dl style="margin:0 5px">
                <dt><strong class="required">※取込ファイルの注意事項</strong></dt>
                <dd>
                  <ul style="margin:0">
                    <li>パスワードで保護されたファイルは取込できません。</li>
                    <li>
                      日付データの取り扱いについて、セルの書式設定と値が正しく設定されていない場合は間違った日付で登録されることがあります。<br/>
                      <dl style="margin: 0;">
                        <dt><label class="icon success">〇 正常</label></dt>
                        <dd>
                          例) セルの書式設定：標準書式　値：{{now()->format('Ymd')}}、 セルの書式設定：日付書式　値：{{now()->format('Y/m/d')}}
                        </dd>
                        <dt><label class="icon delete">× NG</label></dt>
                        <dd>
                          例) セルの書式設定：日付書式　値：{{now()->format('Ymd')}}
                        </dd>
                      </dl>
                    </li>
                  </ul>
                </dd>
              </dl>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </form>

    <table class="default center history_list">
      <thead>
      <tr>
        <th colspan="7" class="left">取込履歴一覧</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th style="width: 5%">No</th>
        <th style="width: 12%">取込日時</th>
        <th style="width: 26%">取込フォーマット名</th>
        <th style="width: 8%">取込件数</th>
        <th style="width: 20%">新規件数（成功数／エラー数）</th>
        <th style="width: 20%">編集件数（成功数／エラー数）</th>
        <th style="width: 9%"></th>
      </tr>
      @forelse ($histories as $history)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ convert_date_format($history['new_created_date_time'], 'Y/m/d H:i') }}</td>
          <td class="left">{{ $history['format_name'] }}</td>
          <td>{{ $history['import_count'] }}</td>
          <td>{{ $history['new_import_count'] }}（{{ $history['new_success_import_count'] }}
            ／{{ $history['new_import_error_count'] }}）
          </td>
          <td>{{ $history['change_import_count'] }}（{{ $history['change_success_import_count'] }}
            ／{{ $history['change_error_import_count'] }}）
          </td>
          <td>
            <a href="{{ ext_route('reservation.import.result', ['import_management_number' => $history['import_management_number']]) }}"
               s>
              <button class="edit">確認</button>
            </a></td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="left">取込履歴情報がありません。</td>
        </tr>
      @endforelse
      </tbody>
    </table>

    <div class="button_bar">
      <a href="{{ ext_route('cruise_plan.search') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>
  </main>

  <form id="download_form" action="{{ ext_route('reservation.import.format_download') }}" method="get">
    <input type="hidden" id="download_format_number" name="format_number">
  </form>
@endsection