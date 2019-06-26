@extends('layout.base')

@section('title', '販売店情報・ユーザ情報')

@section('style')
  <link href="{{ mix('css/agent/agent_detail.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/agent/agent_detail.js') }}"></script>
@endsection

@section('breadcrumb')
  {{--パンくず制御--}}
  @if(\App\Libs\Voss\VossAccessManager::isJurisdictionAgent() && \App\Libs\Voss\VossAccessManager::isAgentAdmin())
    {{--管轄店管理者：マイページを表示--}}
    @include('include/breadcrumbs',['breadcrumbs' => [
      ['name' => 'マイページ', 'url' => ext_route('mypage')],
      ['name' => '販売店一覧', 'url' => ext_route('list')],
      ['name' => '販売店情報・ユーザ情報']
    ]])
  @else
    {{--管轄店管理者ではない：マイページを非表示--}}
    @include('include/breadcrumbs',['breadcrumbs' => [
        ['name' => 'マイページ', 'url' => ext_route('mypage')],
        ['name' => '販売店情報・ユーザ情報']
      ]])
  @endif

@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  @include('include/information', ['info' => ''])
  <main class="agent_detail">
    <input type="hidden" name="last_update_date_time"
           value="{{ $agent_data['last_update_date_time'] or "" }}">
    <div class="area">
      <table class="default shop_table">
        <thead>
        <tr>
          <th colspan="4">販売店情報
            <label class="folding">
              <a href="#" class="asc"></a>
            </label>
          </th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">販売店コード</th>
          <td style="width: 35%">{{ $agent_data['agent_code'] or '' }}</td>
          <th style="width: 15%">販売店名</th>
          <td style="width: 35%">{{ $agent_data['agent_name'] or '' }}</td>
        </tr>
        <tr>
          <th>郵便番号</th>
          <td>{{ $agent_data['zip_code'] or '' }}</td>
          <th>都道府県</th>
          <td>{{  $agent_data['prefecture_name'] or '' }}</td>
        </tr>
        <tr>
          <th>住所１</th>
          <td colspan="3">{{ $agent_data['address1'] or '' }}</td>
        </tr>
        <tr>
          <th>住所２</th>
          <td colspan="3">{{ $agent_data['address2'] or '' }}</td>
        </tr>
        <tr>
          <th>住所３</th>
          <td colspan="3">{{ $agent_data['address3'] or '' }}</td>
        </tr>
        <tr>
          <th>TEL</th>
          <td>{{ $agent_data['tel'] or '' }}</td>
          <th>FAX</th>
          <td>{{ $agent_data['fax_number'] or '' }}</td>
        </tr>
        <tr>
          <th>メールアドレス１</th>
          <td>{{ $agent_data['mail_address1'] or '' }}</td>
          <th>メールアドレス２</th>
          <td>{{ $agent_data['mail_address2'] or '' }}</td>
        </tr>
        <tr>
          <th>メールアドレス３</th>
          <td>{{ $agent_data['mail_address3'] or '' }}</td>
          <th>メールアドレス４</th>
          <td>{{ $agent_data['mail_address4'] or '' }}</td>
        </tr>
        <tr>
          <th>メールアドレス５</th>
          <td>{{ $agent_data['mail_address5'] or '' }}</td>
          <th>メールアドレス６</th>
          <td>{{ $agent_data['mail_address6'] or '' }}</td>
        </tr>
        <tr>
          <th>販売店区分</th>
          <td> {{ config('const.agent_type.name.'.$agent_data['agent_type']) }}
          </td>
          <th>ログイン</th>
          <td>{{ config('const.login_type.name.'.$agent_data['login_type']) }}
          </td>
        </tr>
        <tr>
          <th>販売店ログインID</th>
          <td>{{ $agent_data['agent_login_id'] }}</td>
          <th>ユーザー数</th>
          <td>{{ $count_admin + $count_user }}（管理者：{{ $count_admin }}　一般：{{ $count_user }})</td>
        </tr>
        </tbody>
      </table>
      <table class="default user_table hover_rows">
        <thead>
        <tr>
          <th colspan="10">販売店ユーザー情報</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 19%">ユーザーID</th>
          <th style="width: 19%">ユーザー名称</th>
          <th style="width: 7%">区分</th>
          <th style="width: 7%">ﾛｸﾞｲﾝ</th>
          <th style="width: 9%">最終ﾛｸﾞｲﾝ日</th>
          <th style="width: 9%">登録日</th>
          <th style="width: 9%">変更日</th>
          <th style="width: 11%">パスワード再設定</th>
          <th style="width: 5%">変更</th>
          <th style="width: 5%">削除</th>
        </tr>
        @if(isset($agent_user_data))
          @foreach($agent_user_data as $val)
            <tr>
              <td>{{ $val['user_id'] }}</td>
              <td>{{ $val['user_name'] }}</td>
              <td>
                {{ config('const.user_type.name.'.$val['user_type']) }}
              </td>
              <td>
                {{ config('const.login_type.name.'.$val['login_type']) }}
              </td>
              <td>
                @if($val['last_login_date_time'])
                  {{ convert_date_format($val['last_login_date_time'], 'Y/m/d') }}<br>
                  {{ convert_date_format($val['last_login_date_time'], 'H:i') }}
                @endif
              </td>
              <td>
                @if($val['new_register_date_time'])
                  {{ convert_date_format($val['new_register_date_time'], 'Y/m/d') }}<br>
                  {{ convert_date_format($val['new_register_date_time'], 'H:i') }}
                @endif
              </td>
              <td>
                @if($val['last_update_date_time'])
                  {{ convert_date_format($val['last_update_date_time'], 'Y/m/d') }}<br>
              {{ convert_date_format($val['last_update_date_time'], 'H:i') }}
              @endif
              <td>
                <form class="pw_reset" method="post"
                      action="{{ ext_route('user.password_reset_mail') }}">
                  <input type="hidden" name="agent_user_number"
                         value="{{ $val['agent_user_number'] }}">
                  <input type="hidden" name="agent_code" value="{{ $val['agent_code'] }}">
                  <button class="edit reset">
                    <img src="{{  ext_asset('images/icon/pass.png') }}">
                  </button>
                </form>
              </td>
              <td>
                <a href="{{ ext_route('user.edit', ['agent_code' => $agent_data['agent_code'], 'agent_user_number'=>$val['agent_user_number']]) }}">
                  <button class="edit">
                    <img src="{{  ext_asset('images/icon/register.png') }}">
                  </button>
                </a>
              </td>
              <td>
                <form class="delete_form" method="post" action="{{ ext_route('user.delete') }}">
                  <input type="hidden" name="agent_user_number"
                         value="{{ $val['agent_user_number'] }}">
                  <input type="hidden" name="last_update_date_time"
                         value="{{ $val['last_update_date_time'] }}">
                  <input type="hidden" name="agent_code" value="{{ $val['agent_code'] }}">
                  <button class="delete">
                    <img src="{{  ext_asset('images/icon/delete.png') }}">
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        @endif
        </tbody>
      </table>
    </div>

    <div class="button_bar">
      {{--ログインユーザーの利用権限により戻るボタンの遷移先を制御--}}
      <a href="{{\App\Libs\Voss\VossAccessManager::isJurisdictionAgent() &&
        \App\Libs\Voss\VossAccessManager::isAgentAdmin() ? ext_route('list'):ext_route('mypage')}}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <a href="{{ ext_route('user.edit', ['agent_code' => $agent_data['agent_code']])}}">
        <button class="add">
          <img src="{{  ext_asset('images/icon/add.png') }}">ユーザー追加
        </button>
      </a>
    </div>

  </main>
@endsection