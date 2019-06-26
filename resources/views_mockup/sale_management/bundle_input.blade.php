@extends('layout.base')

@section('title', '販売店一括登録')

@section('style')
  <link href="{{ mix('css/bundle_input.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/bundle_input.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('mypage') }}">マイページ</a>＞<a href="{{ url('sale_management/list_shop') }}">販売店一覧</a>＞販売店一括登録
@endsection

@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">大阪本社</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="bundle_input">
    @include('include.info', ['info' => 'CSVファイルをインポートすることで販売店の複数追加登録ができます。'])
      <?php
      $colmns = [
          ['title1' => '販売店コード', 'title2' => '販売店名', 'require1' => 'require', 'require2' => 'require',
              'info1' => '半角英数字7文字以内', 'info2' => '全角36文字以内'],
          ['title1' => '郵便番号', 'title2' => '都道府県', 'require1' => 'require', 'require2' => 'require',
              'info1' => 'ハイフン無し7文字', 'info2' => ''],
          ['title1' => '住所１', 'title2' => '住所２', 'require1' => 'require', 'require2' => 'require',
              'info1' => '市区町村', 'info2' => '番地'],
          ['title1' => '住所３', 'title2' => '', 'require1' => '', 'require2' => '',
              'info1' => '建物名', 'info2' => ''],
          ['title1' => 'TEL', 'title2' => 'FAX', 'require1' => 'require', 'require2' => 'require',
              'info1' => 'ハイフン無し16文字以内', 'info2' => 'ハイフン無し16文字以内'],
          ['title1' => 'メールアドレス１', 'title2' => 'メールアドレス２', 'require1' => 'require', 'require2' => '',
              'info1' => '', 'info2' => ''],
          ['title1' => 'メールアドレス３', 'title2' => 'メールアドレス４', 'require1' => '', 'require2' => '',
              'info1' => '', 'info2' => ''],
          ['title1' => 'メールアドレス５', 'title2' => 'メールアドレス６', 'require1' => '', 'require2' => '',
              'info1' => '', 'info2' => ''],
          ['title1' => '販売店区分', 'title2' => 'ログイン区分', 'require1' => 'require', 'require2' => 'require',
              'info1' => '管轄店：1、一般店：0', 'info2' => '有効：１、無効：0'],
          ['title1' => 'ユーザーID', 'title2' => 'パスワード', 'require1' => 'require', 'require2' => 'require',
              'info1' => '半角英数字7文字以内', 'info2' => '8文字以上12文字以内']
      ];
      $option = [
          ['value' => '', 'text' => '-----------'],
          ['value' => '0', 'text' => '販売店コード'], ['value' => '1', 'text' => '販売店名'], ['value' => '2', 'text' => '郵便番号'],
          ['value' => '3', 'text' => '都道府県'], ['value' => '4', 'text' => '住所１'], ['value' => '5', 'text' => '住所２'],
          ['value' => '6', 'text' => '住所３'], ['value' => '7', 'text' => 'TEL'],
          ['value' => '8', 'text' => 'FAX'], ['value' => '9', 'text' => 'メールアドレス１'],
          ['value' => '10', 'text' => 'メールアドレス２'], ['value' => '11', 'text' => 'メールアドレス３'],
          ['value' => '12', 'text' => 'メールアドレス４'], ['value' => '13', 'text' => 'メールアドレス５'],
          ['value' => '14', 'text' => 'メールアドレス６'], ['value' => '15', 'text' => '販売店区分'], ['value' => '16', 'text' => 'ログイン'],
          ['value' => '17', 'text' => 'ユーザーID'], ['value' => '18', 'text' => 'パスワード']
      ];
      ?>
    <div class="step1 panel">
      <div class="title">
        販売店一括取込条件設定
      </div>
      <div class="body">
        <label>
          追加データのみ登録いただけます。編集・削除はご利用いただけません。<br>
          必要項目をカンマ「,」区切りで最後尾改行して一箇所一行にしてください。<br>
          最初の1行目には列名(項目名)を同じくカンマ「,」区切りにしてください。<br>
          1回3000件まで。これを超える場合は分割してください。3000件で約5分かかります。
        </label>
        <h3>Step１</h3>
        <label>CSVファイルを選択してください。</label>
        <table class="default">
          <tbody>
          <tr>
            <th style="width: 15%">CSVファイル名指定</th>
            <td style="width: 85%"><input type="file" name="csv_file"/></td>
          </tr>
          </tbody>
        </table>
        <div class="step2" style="display: none">
          <h3>Step２</h3>
          <label>各項目に1列目の列名を指定してください。</label>
          <table class="default">
            <tbody>
            <tr>
              <th style="width: 30%">項目</th>
              <th style="width: 20%">1行目列名</th>
              <th style="width: 30%">項目</th>
              <th style="width: 20%">1行目列名</th>
            </tr>
            @foreach($colmns as $col)
              <tr>
                <td>
                  {{ $col['title1'] }} @if($col['require1']) <span class="required">※</span> @endif
                  @if($col['info1']) ({{ $col['info1'] }}) @endif
                </td>
                <td>
                  <select name="sale_code">
                    @foreach($option as $val)
                      <option value="{{ $val['value'] }}">{{ $val['text'] }}</option>
                    @endforeach
                  </select>
                </td>
                <td>
                  {{ $col['title2'] }} @if($col['require2']) <span class="required">※</span> @endif
                  @if($col['info2']) ({{ $col['info2'] }}) @endif
                </td>
                <td>
                  @if($col['title2'])
                    <select name="sale_name">
                      @foreach($option as $val)
                        <option value="{{ $val['value'] }}">{{ $val['text'] }}</option>
                      @endforeach
                    </select>
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          <div class="step_btn">
            <button id="done" class="add">確認</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('sale_management/list_shop') }}"><button class="back">戻る</button></a>
  </div>
@endsection