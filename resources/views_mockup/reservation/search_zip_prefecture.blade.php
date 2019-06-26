@extends('layout.base')

@section('title', '郵便番号検索')

@section('style')
  <link href="{{ mix('css/search_zip_prefecture.css') }}" rel="stylesheet"/>
@endsection

@section('js')
<script src="{{ mix('js/search_zip_prefecture.js') }}"></script>
@endsection

<?php
$prefecture = [
    '北海道' => ['北海道'],
    '東北' => ['青森', '岩手', '宮崎', '秋田県', '山形県', '福島県'],
    '関東' => ['東京都', '神奈川県', '埼玉県', '千葉県', '茨城県', '栃木県', '群馬県', '山梨県'],
    '信越' => ['新潟県', '長野県'],
    '北陸' => ['富山県', '石川県', '福井県']
];
?>
@section('content')
  <main>
    @include('include/info', ['info' => '都道府県を選択してください。'])
    <div class="panel">
      <div class="title">郵便番号検索</div>
      <table class="default">
        <tbody>
        @foreach($prefecture as $key => $values)
          <tr>
            <td>{{ $key }}</td>
            <td>
              @foreach($values as $value)
                <a href="javascript:void(0)" class="prefecture_name">{{ $value }}</a>
              @endforeach
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <form id="prefecture" action="{{ url('search_zip_city') }}" method="get">
      <input type="hidden" name="target_index">
      <input type="hidden" name="select_prefecture">
    </form>
  </main>
@endsection