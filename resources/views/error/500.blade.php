@extends('layout.base')
@section('title', 'エラー')
@section('style')
  <link href="{{ mix('css/error/error.css') }}" rel="stylesheet"/>
@endsection
@section('breadcrumb')
  エラー
@endsection
@section('content')
  <main>
    <div class="error">
      <h3 class="danger">
        {{$message}} <br/>
        日本クルーズ客船までお問い合わせください。
      </h3>
    </div>
    <div class="button_bar">
      <a href="javascript:history.back();">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>
  </main>
@endsection