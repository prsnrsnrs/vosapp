@extends('layout.base')

@section('title', '販売店一覧')

@section('style')
  <link href="{{ mix('css/agent/agent_list.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/agent/agent_list.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage')],
    ['name' => '販売店一覧']
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  {{--メッセージ領域--}}
  @include('include/information', ['info' => ''])

  <main class="agent_list body">
    <form class="search_form" method="get" action="{{ ext_route('list') }}">
      <input type="hidden" name="search_con[page]" value="1">
      <table class="default">
        <thead>
        <tr>
          <th colspan="2">販売店一覧検索条件</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 10%">区分</th>
          <td style="width: 90%">
            <input type="hidden" name="search_con[agent_jurisdiction]" value="">
            <label>
              <input type="checkbox" name="search_con[agent_jurisdiction]" class="check_style"
                     value="{{ config('const.agent_type.value.jurisdiction_agent')}}"
                      {{input_checked($search_con['agent_jurisdiction'],"1")}}>
              <span class="checkbox"></span>管轄店
            </label>
            <input type="hidden" name="search_con[agent_general]" value="">
            <label>
              <input type="checkbox" name="search_con[agent_general]" class="check_style"
                     value="{{ config('const.agent_type.value.agent')}}"
                      {{input_checked($search_con['agent_general'],"0")}}>
              <span class="checkbox"></span>一般店
            </label>
          </td>
        </tr>
        <tr>
          <th>販売店名</th>
          <td>
            <input type="text" name="search_con[agent_name]" value="{{ $search_con["agent_name"] }}"
                   class="shop_name">(部分一致)
          </td>
        </tr>
        </tbody>
      </table>
      <div class="middle_button">
        <a href="{{ ext_route('mypage') }}" style="text-decoration: none">
          <button type="button" class="back">
            <img src="{{  ext_asset('images/icon/return.png') }}">戻る
          </button>
        </a>
        <button type="submit" class="done">
          <img src="{{  ext_asset('images/icon/search.png') }}">検索
        </button>
        <div style="float: right">
          <button type="button" id="clearForm" class="back">
            <img src="{{  ext_asset('images/icon/clear.png') }}">検索内容をクリア
          </button>
        </div>
      </div>
    </form>
    <div class="button_menu">
      <a href="{{ ext_route('edit') }}">
        <button class="add">
          <img src="{{  ext_asset('images/icon/add.png') }}">販売店追加
        </button>
      </a>
      <a href="{{ ext_route('import.file_select') }}">
        <button class="add" style="float: right">
          <img src="{{  ext_asset('images/icon/import.png') }}">複数一括登録
        </button>
      </a>
    </div>

    {{-- 件数表示 --}}
    @if($list_count_all !== "0")
      <div class="count_from_to">
        <label>{{$list_count_all}}件中&nbsp;{{$search_con['page']*10-9}}
          件～{{ count_from_to($search_con['page']*10,$list_count_all)}}件目を表示</label>
      </div>
    @endif

    <div class="result_list">
      <table class="default hover_rows">
        <thead>
        <tr>
          <th colspan="10">販売店一覧</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width:10%">販売店コード</th>
          <th style="width:20%">販売店名</th>
          <th style="width:7%">TEL</th>
          <th style="width:6%">区分</th>
          <th style="width:6%">ログイン</th>
          <th style="width:15%">販売店ログインID</th>
          <th style="width:7%">ユーザ数</th>
          <th style="width:8%">ユーザー管理</th>
          <th style="width:7%">変更</th>
          <th style="width:7%">削除</th>
        </tr>
        @forelse($list as $val)
          <tr>
            <td>{{ isset($val)?$val['agent_code']:''}}</td>
            <td>{{ isset($val)?$val['agent_name']:''}}</td>
            <td>{{ isset($val)?$val['tel']:''}}</td>
            <td>{{isset($val)? $val['agent_type']==="1"?config('const.agent_type.name.1'): config('const.agent_type.name.0'): ''}}</td>
            <td>{{ isset($val)?$val['login_type']==="1"?config('const.login_type.name.1'): config('const.login_type.name.0'): ''}}</td>
            <td>{{isset($val)? $val['agent_login_id']:''}}</td>
            <td>{{ isset($val)?$val['number_of_user']:'' }}</td>
            <td>
              <a href="{{ ext_route('detail', ['agent_code' => $val['agent_code']]) }}">
                <button type="button" class="show add"><img class="add_img"
                                                            src="{{  ext_asset('images/icon/team.png') }}"></button>
              </a>
            </td>
            <td>
              <a href="{{ ext_route('edit', ['agent_code' => $val['agent_code']]) }}">
                <button type="button" class="edit"><img
                          src="{{  ext_asset('images/icon/register.png') }}"></button>
              </a>
            </td>
            <td>
              <form class="delete_form" method="post" action="{{ ext_route('delete') }}">
                <input type="hidden" name="agent_code" value="{{ $val['agent_code'] }}">
                <input type="hidden" name="last_update_date_time"
                       value="{{ $val['last_update_date_time'] }}">
                <button type="submit" class="delete delete_agent"><img
                          src="{{  ext_asset('images/icon/delete.png') }}"></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td class="list_empty" colspan="10">検索条件に一致する販売店がありません。</td>
          </tr>
        @endforelse
        </tbody>
      </table>
      {{ $paginator }}
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('mypage') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>

  </main>
@endsection