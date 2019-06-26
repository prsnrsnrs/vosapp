<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{$progress_manage_info['progress_manage_short_name']}}</title>
  <style>

    body {
      font-family: 'ＭＳ 明朝', 'MS Mincho';
    }

    div.page {
      position: relative;
    }

    div.page.page_break {
      page-break-after: always;
    }

    .item {
      font-size: 15px;
      line-height: 15px;
      height: 40px;
    }

    .data {
      position: absolute;
      top: 0px;
      left: 50px;
    }

    .unit span {
      float: right;
      padding-right: 15px;
    }

    .date span {
      padding-left: 2px;
    }

    .data table {
      border: 1px solid #000;
      border-collapse: collapse;
    }

    table td {
      height: 30px;
      padding: 0px 0px 0px 5px;
      word-break: break-all;
    }

    td.small {
      height: 25px;
      padding: 0px 5px 0px;
      font-size: 0.8em;
    }

    td.large {
      font-size: 1em;
    }

    .sex {
      padding-left: 0px;
    }

    .center {
      text-align: center;
    }

    .right_border {
      border-right: 1px solid #000;
    }

    .customer, .old {
      border-top: none !important;
    }

    .old td {
      height: 30px;
    }

    img {
      width: 100%;
    }
  </style>
</head>
<body>
@foreach($files as $file)
  <div class="page {{ !$loop->last ? 'page_break' : '' }}">
    @if((int)$progress_manage_info['net_header_print'] == $loop->iteration)
      <div class="header">
        <div class="data">
          <table class="cruise">
            <colgroup style="width: 145px"></colgroup>
            <colgroup style="width: 350px"></colgroup>
            <tbody>
            <tr>
              <td class="small">ご参加クルーズ</td>
              <td class="date">
                <span>{{date('n月j日', strtotime($header_info['departure_date']))}}</span>
                <span>～</span>
                <span>{{date('n月j日', strtotime($header_info['arrival_date']))}}</span>
              </td>
            </tr>
            <tr>
              <td class="item" colspan="2">{{$header_info['item_name']}}<br/>{{$header_info['item_name2']}}</td>
            </tr>
            </tbody>
          </table>

          <table class="customer">
            <colgroup style="width: 95px"></colgroup>
            <colgroup style="width: 400px"></colgroup>
            <tbody>
            <tr>
              <td class="small"></td>
              <td class="right_border small">
                {{$header_info['passenger_last_eij']}}&nbsp;{{$header_info['passenger_first_eij']}}
              </td>
            </tr>
            <tr>
              <td class="small">お名前</td>
              <td class="unit right_border large">
                {{$header_info['passenger_last_knj']}}&nbsp;{{$header_info['passenger_first_knj']}}<span>様</span>
              </td>
            </tr>
            </tbody>
          </table>

          <table class="old">
            <colgroup style="width: 95px"></colgroup>
            <colgroup style="width: 200px"></colgroup>
            <colgroup style="width: 100px"></colgroup>
            <colgroup style="width: 100px"></colgroup>
            <tbody>
            <tr>
              <td class="small">生年月日</td>
              <td class="right_border">
                {{date('Y年　n月　j日', strtotime($header_info['birth_date']))}}
              </td>
              <td class="center right_border">{{$header_info['age']}}&nbsp;歳</td>
              <td
                      class="center sex">{{config('const.gender.name.'.$header_info['gender'])}}</td>
            </tr>
            </tbody>
          </table>

          <table class="customer">
            <colgroup style="width: 95px"></colgroup>
            <colgroup style="width: 400px"></colgroup>
            <tbody>
            <tr>
              <td class="small">取扱旅行会社</td>
              <td class="">{{$header_info['travel_company_name']}}</td>
            </tr>
            </tbody>
          </table>

        </div>
      </div>
    @endif

    <img class="doc_image" src="{{ $file->getRealPath() }}"/>
  </div>
@endforeach
</body>
</html>