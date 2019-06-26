@extends('layout.base')

@section('title', '郵便番号検索')

@section('style')
  <link href="{{ mix('css/address/address_prefecture_select.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
  @include('include/breadcrumbs',['breadcrumbs' => [
    ['name' => '郵便番号検索'],
  ]])
@endsection

@section('content')
  <main>
    @include('include/information', ['info' => config('messages.info.I030-0101')])
    <div class="panel">
      <div class="title">郵便番号検索</div>
      <table class="default">
        <tbody>
        <tr>
          <td>北海道</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '北海道', 'target' => $target])}}">北海道</a>
          </td>
        </tr>
        <tr>
          <td>東北</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '青森県', 'target' => $target])}}">青森</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '岩手県', 'target' => $target])}}">岩手</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '秋田県', 'target' => $target])}}">秋田</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '宮城県', 'target' => $target])}}">宮城</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '山形県', 'target' => $target])}}">山形</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '福島県', 'target' => $target])}}">福島</a>
          </td>
        </tr>
        <tr>
          <td>関東</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '茨城県', 'target' => $target])}}">茨城</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '栃木県', 'target' => $target])}}">栃木</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '群馬県', 'target' => $target])}}">群馬</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '埼玉県', 'target' => $target])}}">埼玉</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '千葉県', 'target' => $target])}}">千葉</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '東京都', 'target' => $target])}}">東京</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '神奈川県', 'target' => $target])}}">神奈川</a>
          </td>
        </tr>
        <tr>
          <td>中部</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '新潟県', 'target' => $target])}}">新潟</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '富山県', 'target' => $target])}}">富山</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '石川県', 'target' => $target])}}">石川</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '福井県', 'target' => $target])}}">福井</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '山梨県', 'target' => $target])}}">山梨</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '長野県', 'target' => $target])}}">長野</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '岐阜県', 'target' => $target])}}">岐阜</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '静岡県', 'target' => $target])}}">静岡</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '愛知県', 'target' => $target])}}">愛知</a>
          </td>
        </tr>
        <tr>
          <td>近畿</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '三重県', 'target' => $target])}}">三重</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '滋賀県', 'target' => $target])}}">滋賀</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '奈良県', 'target' => $target])}}">奈良</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '和歌山県', 'target' => $target])}}">和歌山</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '京都府', 'target' => $target])}}">京都</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '大阪府', 'target' => $target])}}">大阪</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '兵庫県', 'target' => $target])}}">兵庫</a>
          </td>
        </tr>
        <tr>
          <td>中国</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '岡山県','target' => $target])}}">岡山</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '広島県','target' => $target])}}">広島</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '鳥取県','target' => $target])}}">鳥取</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '島根県','target' => $target])}}">島根</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '山口県','target' => $target])}}">山口</a>
          </td>
        </tr>
        <tr>
          <td>四国</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '香川県','target' => $target])}}">香川</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '徳島県','target' => $target])}}">徳島</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '愛媛県','target' => $target])}}">愛媛</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '高知県','target' => $target])}}">高知</a>
          </td>
        </tr>
        <tr>
          <td>九州</td>
          <td>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '福岡県','target' => $target])}}">福岡</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '佐賀県','target' => $target])}}">佐賀</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '長崎県','target' => $target])}}">長崎</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '大分県','target' => $target])}}">大分</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '熊本県','target' => $target])}}">熊本</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '宮崎県','target' => $target])}}">宮崎</a>
            <a href="{{ext_route('address.city_select', ['select_prefecture' => '沖縄県','target' => $target])}}">沖縄</a>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>
@endsection