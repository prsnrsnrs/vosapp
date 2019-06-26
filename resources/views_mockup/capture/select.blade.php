@extends('layout.base')

@section('title', '一括取込ファイル指定')

@section('style')
  <link href="{{ mix('css/select.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/select.js') }}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞<a href="{{ url('reservation/search_plan') }}">クルーズプラン検索</a>＞一括取込ファイル指定
@endsection


@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="body">
    @include('include/info', ['info' => '取り込めるファイル形式はCSV形式とExcel形式のみです。<br/>
          発売前のクルーズを新規で取込みした場合、予約保留状態になります。発売後に予約確定をする必要があります。<br/>
          同じ外部予約番号（旅行社様番号）で取込みした場合、既にその予約が確定予約であれば、変更とみなしてデータを上書きします。'])

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
          <td style="width: 83%">春の日本一周クルーズ　Aコース</td>
        </tr>
        <tr>
          <th>出発日</th>
          <td>神戸発　2017年5月8日(月)</td>
        </tr>
        <tr>
          <th>取込指定フォーマット</th>
          <td>
            <select name="format_name">
              <option value="0" selected>JCL標準予約データ取込</option>
              <option value="1">予約データ取込</option>
              <option value="2">テスト</option>
            </select>
            <a href="{{ url('capture\management') }}">
              <button class="edit">取込指定</button>
            </a>
          </td>
        </tr>
        <tr>
          <th>取込ファイル指定</th>
          <td>
            <input type="file" class="file_name">
            <button class="done" id="btn_result_list">取込</button>
          </td>
        </tbody>
      </table>
    </div>
      <?php
      $datas = [
          ['create_at' => '2017/10/11 10:25', 'faileName' => 'JCL標準予約データ取込', 'data_count' => '17', 'new' => [ 'count' => '15', 'done' => '15', 'error' => '0'], 'edit' => ['count' => '2', 'done' => '1', 'error' => '1']],
          ['create_at' => '2017/10/09 13:45', 'faileName' => '予約データ', 'data_count' => '20', 'new' => [ 'count' => '10', 'done' => '9', 'error' => '1'], 'edit' => ['count' => '10', 'done' => '5', 'error' => '5']],
          ['create_at' => '2017/10/06 17:59', 'faileName' => 'JCL標準予約データ取込', 'data_count' => '33', 'new' => [ 'count' => '18', 'done' => '13', 'error' => '5'], 'edit' => ['count' => '15', 'done' => '12', 'error' => '3']],
          ['create_at' => '2017/10/05 9:30', 'faileName' => 'テスト', 'data_count' => '24', 'new' => [ 'count' => '20', 'done' => '18', 'error' => '2'], 'edit' => ['count' => '4', 'done' => '2', 'error' => '2']],
      ]
      ?>
    <table class="default center history_list">
      <thead>
      <tr>
        <th colspan="7" class="left">過去取込履歴一覧</th>
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
      <?php $i = 1;?>
      @foreach($datas as $data)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $data['create_at'] }}</td>
          <td class="left">{{ $data['faileName'] }}</td>
          <td>{{ $data['data_count'] }}</td>
          <td>{{ $data['new']['count'] }}（{{ $data['new']['done'] }}／{{ $data['new']['error'] }}）</td>
          <td>{{ $data['edit']['count'] }}（{{ $data['edit']['done'] }}／{{ $data['edit']['error'] }}）</td>
          <td><a href="{{ url('capture\list') }}">
              <button class="edit">確認</button>
            </a></td>
        </tr>
        <?php $i++ ?>
      @endforeach
      </tbody>
    </table>
  </main>
  <div class="button_bar">
    <a href="{{ url('reservation/search_plan') }}">
      <button class="back">戻る</button>
    </a>
  </div>
@endsection