@extends('layout.base')

@section('title', '郵便番号検索')

@section('style')
  <link href="{{ mix('css/address/address_town_select.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/address/address_town_select.js') }}"></script>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => '郵便番号検索','url' => ext_route('address.prefecture_select', ['target' => $target])],
    ['name' => $select_prefecture,'url' => ext_route('address.city_select', ['target' => $target, 'select_prefecture' => $select_prefecture])],
    ['name' => $select_city]
  ]])
@endsection

@section('content')
  <main>
    @include('include/information', ['info' => config('messages.info.I030-0102')])
    <div class="panel">
      <div class="index">
        @foreach($town as $key => $data)
          <a href="#{{ $key }}">
            <button class="default">{{ $key }}</button>
          </a>
        @endforeach
      </div>
      <table rules="all" class="default">
        <tbody>
        @if($not_posting)
          <tr>
            <td><a href="javascript:void(0);" class="no_town zip_code"
                   data-zip_code="{{ $not_posting['zip_code'] }}">{{ $not_posting['name'] }}</a>
            </td>
            <td class="zip">{{ $not_posting['zip_code']  }}</td>
          </tr>
        @endif
        @foreach($town as $key => $data)
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
                <td>
                  <a href="javascript:void(0);" class="zip_code" data-zip_code="{{ $value }}">{{ $key }}</a></td>
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
    <div class="button_bar">
      <a href="{{ ext_route('address.city_select',['select_prefecture' =>$select_prefecture, 'select_city' => $select_city, 'target' => $target]) }}">
        <button class="back">
          <img src="{{  ext_asset('images/icon/return.png') }}">戻る
        </button>
      </a>
    </div>
  </main>

  <input type="hidden" id="parent_target" value="{{ $target }}"/>
@endsection