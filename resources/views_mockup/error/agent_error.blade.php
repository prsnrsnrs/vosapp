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
        お使いのブラウザはサポートしておりません。<br />
        InternetExplorer (※バージョン11以上)、FireFox、Chrome、Microsoft Edgeをご利用ください。
      </h3>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('/') }}">
      <button class="back">戻る</button>
    </a>
  </div>
@endsection