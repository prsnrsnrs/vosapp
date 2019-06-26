@extends('layout.base')

@section('title', '郵便番号検索')

@section('style')
  <link href="{{ mix('css/search_zip_city.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/search_zip_city.js') }}"></script>
@endsection

<?php
$city = [
    'ア行' => ['池田市' => 'イケダシ', '泉大津市' => 'イズミオオツシ', '泉佐野市' => 'イズミサノシ', '和泉市' => 'イズミシ', '茨城市' => 'イバラキシ'],
    'カ行' => [],
    'サ行' => [],
    'タ行' => [],
    'ナ行' => [],
    'ハ行' => ['羽曳野市' => 'ハビキノシ', '阪南市' => 'ハンナンシ', '東大阪市' => 'ヒガシオオサカシ'],
    'マ行' => ['松原市' => 'マツハラシ'],
    'ヤ行' => [],
    'ラ行' => [],
    'ワ行' => [],
];
?>
@section('content')
  <main>
    @include('include/info', ['info' => '市区群町村を選択してください。'])
    <div class="panel">
      {{--<div class="title">市区群町村の検索条件選択</div>--}}
      <div class="index">
        @foreach($city as $key => $data)
          <a href="#{{ $key }}">
            <button class="default">{{ $key }}</button>
          </a>
        @endforeach
      </div>
      <table rules="all" class="default">
        <tbody>
        @foreach($city as $key => $data)
          <tr id="{{ $key }}">
            <th colspan="2">{{ $key }}</th>
          </tr>
          @if(empty($data))
            <tr>
              <td colspan="2">該当する市区群町村が見つかりませんでした。</td>
            </tr>
          @else
            @foreach($data as $key => $value)
              <tr>
                <td><a href="javascript:void(0)" class="city_name">{{ $key }}</a></td>
                <td>{{ $value }}</td>
              </tr>
            @endforeach
          @endif
          <tr>
            <td colspan="2" style="text-align: right"><a href="#top">このページの先頭にもどる</a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <form id="city" action="{{ url('search_zip_town') }}" method="get">
      <input type="hidden" name="target_index">
      <input type="hidden" name="select_city">
    </form>
  </main>
  <div class="button_bar">
    <a href="{{ url('search_zip_prefecture') }}">
      <button class="back">戻る</button>
    </a>
  </div>
@endsection