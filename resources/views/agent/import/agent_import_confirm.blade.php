@extends('layout.base')

@section('title', '販売店一括登録確認')

@section('style')
  <link href="{{ mix('css/agent/import/agent_import_confirm.css') }}" rel="stylesheet"/>
@endsection
@section('js')
  <script src="{{ mix('js/agent/import/agent_import_confirm.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
          ['name' => 'マイページ', 'url' => ext_route('mypage')],
          ['name' => '販売店一覧', 'url' => ext_route('list')],
          ['name' => '複数一括登録', 'url' => ext_route('import.file_select')],
          ['name' => '複数一括登録確認']
        ]])
@endsection

@section('login_data')
  @include('include/login_data')
@endsection

@section('content')
  <main class="agent_import_confirm">
    @if($import_count>0)
      @include('include/information', ['info' => config('messages.info.I210-0102')])
    @endif
    <div class="result">
      <table class="default">
        <thead>
        <tr>
          <th colspan="3">複数登録結果</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th style="width: 50%">インポート件数</th>
          <th style="width: 50%">インポートエラー件数</th>
        </tr>
        <tr>
          <td>{{isset($import_count)?$import_count:'0'}}件</td>
          <td>{{isset($import_error_count)?$import_error_count:'0'}}件</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="panel list">
      <div class="title">データ一覧</div>
      <div class="result_list">
        <table class="default hover_rows" style="width: 3640px">
          <thead class="data_title">
          <tr>
            <th style="width: 50px">No.</th>
            <th style="width: 100px">販売店コード</th>
            <th style="width: 140px">販売店名</th>
            <th style="width: 80px">郵便番号</th>
            <th style="width: 80px">都道府県</th>
            <th style="width: 210px">住所１</th>
            <th style="width: 210px">住所２</th>
            <th style="width: 210px">住所３</th>
            <th style="width: 100px">TEL</th>
            <th style="width: 100px">FAX</th>
            <th style="width: 240px">メールアドレス１</th>
            <th style="width: 240px">メールアドレス２</th>
            <th style="width: 240px">メールアドレス３</th>
            <th style="width: 240px">メールアドレス４</th>
            <th style="width: 240px">メールアドレス５</th>
            <th style="width: 240px">メールアドレス６</th>
            <th style="width: 100px">販売店区分</th>
            <th style="width: 100px">ユーザーID</th>
            <th style="width: 100px">パスワード</th>
            <th style="width: 300px">取込エラー内容</th>
          </tr>
          </thead>
          <tbody>
          @if(isset($import_data))
            @foreach($import_data as $key => $data)
              @if (!empty($data['error_message']))
                <tr class="error">
              @else
                <tr>
                  @endif
                  <td style="width: 50px">{{$key}}</td>
                  <td style="width: 100px">{{isset($data[0])?$data[0]:''}}</td>
                  <td style="width: 140px">{{isset($data[1])?$data[1]:''}}</td>
                  <td style="width: 80px">{{isset($data[2])?$data[2]:''}}</td>
                  <td style="width: 80px">{{isset($data[3])?$data[3]:''}}</td>
                  <td style="width: 210px">{{isset($data[4])?$data[4]:''}}</td>
                  <td style="width: 210px">{{isset($data[5])?$data[5]:''}}</td>
                  <td style="width: 210px">{{isset($data[6])?$data[6]:''}}</td>
                  <td style="width: 100px">{{isset($data[7])?$data[7]:''}}</td>
                  <td style="width: 100px">{{isset($data[8])?$data[8]:''}}</td>
                  <td style="width: 240px">{{isset($data[9])?$data[9]:''}}</td>
                  <td style="width: 240px">{{isset($data[10])?$data[10]:''}}</td>
                  <td style="width: 240px">{{isset($data[11])?$data[11]:''}}</td>
                  <td style="width: 240px">{{isset($data[12])?$data[12]:''}}</td>
                  <td style="width: 240px">{{isset($data[13])?$data[13]:''}}</td>
                  <td style="width: 240px">{{isset($data[14])?$data[14]:''}}</td>
                  <td style="width: 100px">{{isset($data[15])? config('const.agent_type.name.'.$data[15]):''}}</td>
                  <td style="width: 100px">{{isset($data[17])?$data[17]:''}}</td>
                  <td style="width: 100px">{{isset($data[18])?$data[18]:''}}</td>
                  <td style="width: 300px">{{isset($data['error_message'])?$data['error_message']:''}}</td>
                </tr>
                @endforeach
              @endif
          </tbody>
        </table>
      </div>
    </div>

    <div class="button_bar" style="display: inline-flex;">
      <a href="{{ ext_route('import.file_select')}}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
      <form class="agent_import_form" style="margin-left: 5px;" method="post"
            action="{{ ext_route('import.file_confirm') }}">
        <input type="hidden" name="import_management_number" value="{{ $import_management_number }}">
        <input type="hidden" name="import_count" value="{{ $import_count }}">
        <input type="hidden" name="import_error_count" value="{{ $import_error_count }}">
        <button id="done_btn" class="done">
          <img src="{{  ext_asset('images/icon/check.png') }}">登録処理実行
        </button>
      </form>
    </div>
  </main>
@endsection