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
          <?php
          $is_first = true;
          foreach ($errors as $error) {
              if (is_null($error)) {
                  continue;
              }
              foreach ($error as $messages) {
                  foreach ($messages as $message) {
                      echo e($message);
                  }
              }
          }
          ?>
      </h3>
    </div>
  </main>
  <div class="button_bar">
    <a href="javascript:history.back();">
      <button class="back" onclick="window.close();">
        <img src="{{  ext_asset('images/icon/return.png') }}">閉じる
      </button>
    </a>
  </div>
@endsection