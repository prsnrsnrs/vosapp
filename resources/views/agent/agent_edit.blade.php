@extends('layout.base')

@section('title', $agent_title)

@section('style')
  <link href="{{ mix('css/agent/agent_edit.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/agent/agent_edit.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
    ['name' => '販売店一覧', 'url' => ext_route('list'), 'confirm' => true],
    ['name' => $agent_title]
  ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  {{--メッセージ領域--}}
  @include('include/information', ['info' => ''])
  <main class="agent_edit">
    <form class="input_shop" method="post" action="{{ ext_route('edit') }}">
      <input type="hidden" name="last_update_date_time" value="{{ $agent_data['last_update_date_time'] or "" }}">
      @if(isset($agent_data))
        <input type="hidden" name="is_edit" value="1"/>
      @endif
      <table rules="all" class="default">
        <thead>
        <tr>
          <th colspan="4">販売店情報</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 15%">販売店コード<span class="required">※</span></th>
          <td style="width: 35%">
            @if (isset($agent_data))
              {{--編集時：ラベル表示--}}
              <label name="agent_code"
                     class="short_text">{{ isset($agent_data)?$agent_data['agent_code'] : '' }}</label>
              <input type="hidden" name="agent_code" class="short_text"
                     value="{{ isset($agent_data)?$agent_data['agent_code'] : '' }}">
            @else
              <input type="text" name="agent_code" class="short_text" maxlength="7" value="">※半角英数3～7文字
            @endif
          </td>
          <th style="width: 12%">販売店名<span class="required">※</span></th>
          <td style="width: 35%">
            <input type="text" name="agent_name" class="middle_text" maxlength="72"
                   value="{{ isset($agent_data)?$agent_data['agent_name'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>郵便番号<span class="required">※</span></th>
          <td>
            <input type="text" name="zip_code" class="short_text" maxlength="7" placeholder="例）5300001"
                   value="{{ isset($agent_data)?$agent_data['zip_code'] : '' }}">※ハイフン不要<br>
            <span class="address_number_danger">※郵便番号を入力すると自動で住所が入力されます。</span>
          </td>
          <th>都道府県<span class="required">※</span></th>
          <td>
            <select name="prefecture_code" id="prefecture_code">
              <option value=""></option>
              @foreach($prefectures as $val)
                <option value="{{ $val['prefecture_code'] }}"{{option_selected($val['prefecture_code'],isset($agent_data) ? $agent_data['prefecture_code'] : '')}}>{{ $val['prefecture_name'] }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>住所1<span class="required">※</span></th>
          <td colspan="3">
            <input type="text" name="address1" class="long_text" maxlength="102" placeholder="例）大阪市北区梅田"
                   value="{{ isset($agent_data)?$agent_data['address1'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>住所2<span class="required">※</span></th>
          <td colspan="3">
            <input type="text" name="address2" class="long_text" maxlength="102" placeholder="例）２－２－２５"
                   value="{{ isset($agent_data)?$agent_data['address2'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>住所3（建物名）</th>
          <td colspan="3">
            <input type="text" name="address3" class="long_text" maxlength="102" placeholder="例）ハービスOSAKA1502室"
                   value="{{ isset($agent_data)?$agent_data['address3'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>TEL<span class="required">※</span>
          </th>
          <td>
            <input type="text" name="tel" class="short_text" maxlength="16" placeholder="例）066347752"
                   value="{{ isset($agent_data)?$agent_data['tel'] : '' }}">※ハイフン不要
          </td>
          <th>FAX<span class="required">※</span></th>
          <td>
            <input type="text" name="fax_number" class="short_text" maxlength="16"
                   value="{{ isset($agent_data)?$agent_data['fax_number'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>メールアドレス１<span class="required">※</span></th>
          <td>
            <input type="text" name="mail_address1" class="middle_text" maxlength="80"
                   value="{{ isset($agent_data)?$agent_data['mail_address1'] : '' }}">
          </td>
          <th>メールアドレス２</th>
          <td>
            <input type="text" name="mail_address2" class="middle_text" maxlength="80"
                   value="{{ isset($agent_data)?$agent_data['mail_address2'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>メールアドレス３</th>
          <td>
            <input type="text" name="mail_address3" class="middle_text" maxlength="80"
                   value="{{ isset($agent_data)?$agent_data['mail_address3'] : '' }}">
          </td>
          <th>メールアドレス４</th>
          <td>
            <input type="text" name="mail_address4" class="middle_text" maxlength="80"
                   value="{{ isset($agent_data)?$agent_data['mail_address4'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>メールアドレス５</th>
          <td>
            <input type="text" name="mail_address5" class="middle_text" maxlength="80"
                   value="{{ isset($agent_data)?$agent_data['mail_address5'] : '' }}">
          </td>
          <th>メールアドレス６</th>
          <td>
            <input type="text" name="mail_address6" class="middle_text" maxlength="80"
                   value="{{ isset($agent_data)?$agent_data['mail_address6'] : '' }}">
          </td>
        </tr>
        <tr>
          <th>販売店区分<span class="required">※</span></th>
          <td>
            <label>
              <input class="radio" type="radio" name="agent_type" value="1"
                      {{isset($agent_data)? $agent_data['agent_type'] ==="1"? 'checked' : '': '' }}>管轄店</label>
            <label>
              <input class="radio" type="radio" name="agent_type" value="0"
                      {{isset($agent_data)? $agent_data['agent_type'] ==="0" ?'checked' : '' : ''}}>一般店</label>
          </td>
          <th>ログイン<span class="required">※</span></th>
          <td>
            <label>
              <input class="radio" type="radio" name="login_type"
                     value="1" {{isset($agent_data)? $agent_data['login_type'] ==="1"? 'checked' : '' : '' }}>有効</label>
            <label>
              <input class="radio" type="radio" name="login_type"
                     value="0"{{isset($agent_data)? $agent_data['login_type'] ==="0"? 'checked' : '' : '' }}>無効</label>
          </td>
        </tr>
        </tbody>
      </table>
    </form>
    {{--郵便番号検索用form--}}
    <form id="address_form" action="{{ ext_route('address') }}" method="get"></form>

    <div class="button_bar">
      <a href="{{ ext_route('list') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <button type="submit" class="done register">
        <img src="{{  ext_asset('images/icon/register.png') }}">登録
      </button>
    </div>

  </main>
@endsection