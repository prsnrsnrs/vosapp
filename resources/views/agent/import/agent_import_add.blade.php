@extends('layout.base')

@section('title', '販売店一括登録')

@section('style')
  <link href="{{ mix('css/agent/import/agent_import_add.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/agent/import/agent_import_add.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
      ['name' => 'マイページ', 'url' => ext_route('mypage')],
      ['name' => '販売店一覧', 'url' => ext_route('list')],
      ['name' => '販売店一括登録']
    ]])
@endsection
@section('login_data')
  @include('include/login_data')
@endsection
@section('content')
  <main class="agent_import_add">
    @include('include/information', ['info' => config('messages.info.I210-0101')])
    <div class="step1 panel">
      <div class="title">
        販売店一括取込条件設定
      </div>
      <div class="body">
        <form id="import_file" action="{{ext_route('import.file_import')}}" method="post">

          <h3 style="margin-top:0;">Step１：CSVファイルを選択してください。</h3>
          <div class="step_form">
            <p>
              追加データのみ登録いただけます。編集・削除はご利用いただけません。<br/>
              CSVファイルは「,」区切りで最後尾改行して１販売店１行のデータにしてください。<br/>
              １行目のデータはヘッダー行として扱うため、取込みされません。<br/>
              ファイルを選択し、Step2に進んでください。(まだデータは登録されません。)<br/>
              1回3000件まで。これを超える場合は分割してください。3000件で約5分かかります。
            </p>
            <table class="default">
              <tbody>
              <tr>
                <th style="width: 15%">CSVファイル名指定</th>
                <td style="width: 85%">
                  <input type="file" name="import_csv_file" id="import_csv_file"/>
                </td>
              </tr>
              </tbody>
            </table>
          </div>

          <div class="step2" style="display: none">
            <h3>Step２：各項目に1列目の列名を指定してください。</h3>
            <div class="step_form">
              <p>
                各項目に選択したCSVファイルの1行目の項目を設定してください。<br/>
                ※印は必須項目です。必ず選択してください。<br/>
                販売店区分とログイン区分は、カッコ書きの通り「0」「1」で登録してください。
              </p>
              <table class="default">
                <tbody>
                <tr>
                  <th style="width: 30%">項目</th>
                  <th style="width: 20%">1行目列名</th>
                  <th style="width: 30%">項目</th>
                  <th style="width: 20%">1行目列名</th>
                </tr>
                <tr>
                  <td>
                    販売店コード
                    <span class="required">※</span>(半角英数字3～7文字)
                  </td>
                  <td>
                    <select class="option_data" name="agent_code">

                    </select>
                  </td>
                  <td>
                    販売店名
                    <span class="required">※</span>
                    (全角36字以内)
                  </td>
                  <td>
                    <select class="option_data" name="agent_name"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    郵便番号
                    <span class="required">※</span>
                    ハイフンなし(7文字)
                  </td>
                  <td>
                    <select class="option_data" name="zip_code"></select>
                  </td>
                  <td>
                    都道府県
                    <span class="required">※</span>
                  </td>
                  <td>
                    <select class="option_data" name="prefecture_code"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    住所１
                    <span class="required">※</span>
                    (市区町村)
                  </td>
                  <td>
                    <select class="option_data" name="address1"></select>
                  </td>
                  <td>住所2
                    <span class="required">※</span>
                    (番地)
                  </td>
                  <td>
                    <select class="option_data" name="address2"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    住所3 (建物名)
                  </td>
                  <td>
                    <select class="option_data" name="address3"></select>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>
                    TEL
                    <span class="required">※</span>
                    (ハイフンなし16文字)
                  </td>
                  <td>
                    <select class="option_data" name="tel"></select>
                  </td>
                  <td>
                    FAX
                    <span class="required">※</span>
                    (ハイフンなし16文字)
                  </td>
                  <td>
                    <select class="option_data" name="fax_number"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    メールアドレス1
                    <span class="required">※</span>
                  </td>
                  <td>
                    <select class="option_data" name="mail_address1"></select>
                  </td>
                  <td>
                    メールアドレス2
                  </td>
                  <td>
                    <select class="option_data" name="mail_address2"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    メールアドレス3
                  </td>
                  <td>
                    <select class="option_data" name="mail_address3"></select>
                  </td>
                  <td>
                    メールアドレス4
                  </td>
                  <td>
                    <select class="option_data" name="mail_address4"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    メールアドレス5
                  </td>
                  <td>
                    <select class="option_data" name="mail_address5"></select>
                  </td>
                  <td>
                    メールアドレス6
                  </td>
                  <td>
                    <select class="option_data" name="mail_address6"></select>
                  </td>
                </tr>
                <tr>
                  <td>
                    販売店区分
                    <span class="required">※</span>
                    (管轄店:1、一般店:0)
                  </td>
                  <td>
                    <select class="option_data" name="agent_type"></select>
                  </td>
                  <td>
                    ログイン区分
                    <span class="required">※</span>
                    (有効:1、無効:0)
                  </td>
                  <td>
                    <select class="option_data" name="login_type"></select>
                  </td>
                </tr>
                <tr>
                  <td>ユーザーID
                    <span class="required">※</span>
                    (半角英数字6～12文字)
                  </td>
                  <td>
                    <select class="option_data" name="user_id"></select>
                  </td>
                  <td>
                    パスワード
                    <span class="required">※</span>
                    (8文字以上12文字以内)
                  </td>
                  <td>
                    <select class="option_data" name="password"></select>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>

            <h3>Step３：確認ボタンをクリックしてください。</h3>
            <div class="step_form">
              <p>
                確認ボタンをクリックし、次の画面で登録内容を確認してください。<br>
                <span class="danger">この時点ではデータは登録されません。</span>
              </p>
              <div class="step_btn">
                <button id="done" class="add">
                  <img src="{{  ext_asset('images/icon/check.png') }}">確認
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="button_bar">
      <a href="{{ ext_route('list') }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>
  </main>
  {{--取り込みファイル変更イベント Step1--}}
  <form id="agent_import" action="{{ext_route('import.file_select')}}" method="post"></form>
@endsection