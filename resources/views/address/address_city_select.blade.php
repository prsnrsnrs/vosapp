@extends('layout.base')

@section('title', '郵便番号検索')

@section('style')
  <link href="{{ mix('css/address/address_city_select.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => '郵便番号検索','url' => ext_route('address.prefecture_select', ['target' => $target])],
    ['name' => $select_prefecture]
  ]])
@endsection

@section('content')
  <main>
    @include('include/information', ['info' => config('messages.info.I030-0102')])
    <div class="panel">
      {{--<div class="title">市区群町村の検索条件選択</div>--}}
      @foreach($city as $key =>$date)
        <div class="index">
          <a href="#{{$key}}">
            <button class="default">{{$key}}</button>
          </a>
        </div>
      @endforeach
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
            @foreach($data as $key =>$value)
              <tr>
                <td>
                  <a href="{{ext_route('address.town_select', ['select_prefecture' => $select_prefecture, 'select_city' => $key, 'target' => $target])}}">{{ $key }}</a>
                </td>
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
    <div class="button_bar" style="margin-left: 0">
      <a href="{{ ext_route('address.prefecture_select', ['target' => $target]) }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>
  </main>
@endsection