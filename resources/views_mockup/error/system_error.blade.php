@extends('layout.base')
@section('title', 'エラー')
@section('style')
  <link href="{{ mix('css/error.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  エラー
@endsection
@section('content')
  <main>
    <div class="error">
      <h3 class="danger">
        システムエラーが発生しました。<br />
        日本クルーズ客船までお問い合わせください。
      </h3>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('/') }}">
      <button class="back">戻る</button>
    </a>
  </div>
@endsection