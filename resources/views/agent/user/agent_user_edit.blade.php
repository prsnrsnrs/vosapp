@extends('layout.base')

@section('title', 'ユーザー作成画面')

@section('style')
  <link href="{{ mix('css/agent/user/agent_user_edit.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/agent/user/agent_user_edit.js') }}"></script>
@endsection

@section('breadcrumb')
  @if(\App\Libs\Voss\VossAccessManager::isJurisdictionAgent() && \App\Libs\Voss\VossAccessManager::isAgentAdmin())
    {{--管轄店管理者のみ販売店一覧を表示--}}
    @include('include/breadcrumbs',['breadcrumbs' => [
     ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
     ['name' => '販売店一覧', 'url' => ext_route('list'), 'confirm' => true],
     ['name' => '販売店ユーザー情報', 'url' => ext_route('detail',['agent_code' => request('agent_code')]), 'confirm' => true],
     ['name' => $agent_user_title]
   ]])
  @else
    {{--一般店管理者は販売店一覧を非表示--}}
    @include('include/breadcrumbs',['breadcrumbs' => [
       ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
       ['name' => '販売店ユーザー情報', 'url' => ext_route('detail',['agent_code' => request('agent_code')]), 'confirm' => true],
       ['name' => $agent_user_title]
     ]])
  @endif
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  @include('include/information', ['info' => ''])
  <main class="agent_user_edit">
    <form class="input_user" method="post" action="{{ ext_route('user.edit') }}">
      <input type="hidden" name="agent_code" value="{{ request('agent_code') }}">
      <input type="hidden" name="last_update_date_time"
             value="{{ $agent_user_data['0']['last_update_date_time'] or "" }}">
      <input type="hidden" name="agent_user_number" value="{{ request('agent_user_number')}}">
      @if(isset($agent_user_data))
        <input type="hidden" name="is_edit" value="1"/>
      @endif
      <div class="area">
        <table class="default">
          <thead>
          <tr>
            <th colspan="2">ユーザー作成</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th style="width: 15%">ユーザーID</th>
            <td style="width: 85%">
              @if(isset($agent_user_data))
                <label class="middle_text">{{$agent_user_data['0']['user_id']}}</label>
              @else
                <input type="text" name="user_id" class="middle_text" maxlength="12"
                       value="{{$agent_user_data['0']['user_id']  or "" }}">※半角英数6～12文字
              @endif
            </td>
          </tr>
          <tr>
            <th>ユーザー名称</th>
            <td>
              <input type="text" name="user_name" class="middle_text" maxlength="42"
                     value="{{ isset($agent_user_data)?$agent_user_data['0']['user_name'] : '' }}">※全角で２０文字まで、半角でも可
            </td>
          </tr>
          <tr>
            <th>ユーザー区分</th>
            <td>
              <label>
                <input class="radio" type="radio" name="user_type" value="1"
                        {{isset($agent_user_data)? $agent_user_data['0']['user_type'] ==="1"? 'checked' : '': '' }}>管理者</label>
              <label><input class="radio" type="radio" name="user_type" value="0"
                        {{isset($agent_user_data)? $agent_user_data['0']['user_type'] ==="0" ?'checked' : '' : ''}}>一般</label>
            </td>
          </tr>
          <tr>
            <th>ログイン</th>
            <td>
              <label>
                <input class="radio" type="radio" name="login_type" id="test"
                       value="1" {{isset($agent_user_data)? $agent_user_data['0']['login_type'] ==="1"? 'checked' : '' : '' }}>有効</label>
              <label>
                <input class="radio" type="radio" name="login_type"
                       value="0"{{isset($agent_user_data)? $agent_user_data['0']['login_type'] ==="0"? 'checked' : '' : '' }}>無効</label>
            </td>
          </tr>
          <tr>
            <th>パスワード</th>
            <td>
              @if(isset($agent_user_data))
                <label class="middle_text">**********</label>
              @else
                <input type="text" name="password" class="middle_text" maxlength="12"
                       value="">※半角英数8～12文字
              @endif
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </form>
    <div class="button_bar" style="margin-top: 10px">
      <a href="{{ ext_route('detail',['agent_code' => request('agent_code')])}}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      @if(isset($agent_user_data))
      @else
      @endif
      {{--新規--}}
      <button type="submit" class="done register">
        <img src="{{  ext_asset('images/icon/register.png') }}">{{isset($agent_user_data)?"決定":"ユーザー作成"}}
      </button>
      {{--変更--}}
      {{--<button type="submit" class="done register">決定</button>--}}
    </div>
  </main>
@endsection