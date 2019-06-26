@extends('layout.base')

@section('title', '郵便番号検索')

@section('style')
  <link href="{{ mix('css/search_zip_town.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/search_zip_town.js') }}"></script>
@endsection
<?php
$city = [
    'ア行' => ['旭丘' => '1234561', '綾羽' => '1234562', '井口堂' => '1234563', '石橋' => '1234564', '上池田' => '1234565', '宇保町' => '1234566'],
    'カ行' => ['木部町' => '1234567', '空港' => '1234567', '呉服町' => '1234567', '神田' => '1234567'],
    'サ行' => ['栄本町' => '1234567', '栄町' => '1234567', '五月丘' => '1234567', '渋谷' => '1234567', '城山' => '1234567'],
    'タ行' => [],
    'ナ行' => [],
    'ハ行' => [],
    'マ行' => ['溝寿美町' => '1234567', '緑丘' => '1234567', '室町' => '1234567', '桃園' => '1234567'],
    'ヤ行' => ['吉田町' => '1234567'],
    'ラ行' => [],
    'ワ行' => []
];
?>
@section('content')
  <main>
    @include('include/info', ['info' => '町名を選択してください。'])
    <div class="panel">
      {{--<div class="title">町名の検索条件選択</div>--}}
      <div class="index">
        @foreach($city as $key => $data)
          <a href="#{{ $key }}">
            <button class="default">{{ $key }}</button>
          </a>
        @endforeach
      </div>
      <table rules="all" class="default">
        <tbody>
        <tr>
          <td><a href="javascript:void(0)" class="town_name">以下に掲載がない場合</a></td>
          <td>1234567</td>
        </tr>
        @foreach($city as $key => $data)
          <tr id="{{ $key }}">
            <th colspan="2">{{ $key }}</th>
          </tr>
          @if(empty($data))
            <tr>
              <td colspan="2">該当する町名が見つかりませんでした。</td>
            </tr>
          @else
            @foreach($data as $key => $value)
              <tr>
                <td><a href="javascript:void(0)" class="town_name">{{ $key }}</a></td>
                <td class="zip">{{ $value }}</td>
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
  </main>
  <div class="button_bar">
    <a href="{{ url('search_zip_city') }}">
      <button class="back">戻る</button>
    </a>
  </div>
@endsection