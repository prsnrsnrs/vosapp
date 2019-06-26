<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>取消記録確認書</title>
  <style>
    body {
      page-break-after: auto;
      font-size: 17px;
      font-family: "游ゴシック Medium", "Yu Gothic Medium", "Yu Gothic", "メイリオ", "Meiryo", sans-serif;;
    }
    .block {
      page-break-inside: avoid;
    }
    .span {
      color: white;
    }
    header ul {
      padding: 0px;
      margin: 0px;
    }
    header li {
      list-style: none;
    }
    header .addressee {
      position: relative;
      top: 0px;
      left: 0px;
    }
    header .title {
      position: absolute;
      top: 80px;
      left: 330px;
      font-size: 2.2em;
      text-decoration: underline;
    }
    header .company_info {
      position: absolute;
      top: 0px;
      right: 0px;
      text-align: right;
      font-size: 0.9em;
    }
    div.container {
      margin-top: 140px;
    }
    div.container .greeting div {
      border: solid 1px;
    }
    .cruse table,
    .course table {
      width: 100%;
    }
    .cruse table th,
    .course table th {
      text-align: right;
    }
    table th,
    table td {
      padding: 0px;
      font-weight: normal;
    }
    table.info {
      border-collapse: collapse;
      border: 1px solid black;
      width: 100%;
      text-align: center;
    }
    table.info thead {
      border-bottom: 3px double black;
    }
    table.info th,
    table.info td {
      border-right: solid 1px;
      border-bottom: solid 1px;
    }
    table.info .dashed {
      border-bottom: dashed 1px;
    }
    .left {
      text-align: left;
      padding: 0px 0px 0px 5px;
    }
    .small {
      font-size: 0.8em;
    }
  </style>
</head>
<?php
$room1 = [
    ['No' => '015678989', 'groupNo' => '1', 'familyName' => 'NAKAGAWA', 'firstName' => 'YOSHIO', 'age' => '44', 'sex' => '男',
        'type' => '大', 'nameKnj' => '中川　善夫', 'roomType' => 'DX', 'roomMany' => 'ﾂｲﾝ', 'roomNo' => '', 'status' => 'CX',
        'entryDay' => '2017/04/11', 'other' => ''],
    ['No' => '015775498', 'groupNo' => '1', 'familyName' => 'KONDOH', 'firstName' => 'MASAYA', 'age' => '35', 'sex' => '男',
        'type' => '大', 'nameKnj' => '近藤　政也', 'roomType' => 'E', 'roomMany' => 'ｼﾝｸﾞﾙ', 'roomNo' => '', 'status' => 'CX',
        'entryDay' => '2017/04/11', 'other' => ''],
];
?>
<body>
<header>
  <div class="addressee">
    <ul>
      <li>株式会社PVトラベル</li>
      <li>大阪梅田支店　御中</li>
    </ul>
  </div>
  <div class="title">
    <span>取消記録確認書</span>
  </div>
  <div class="company_info">
    <ul>
      <li>2017年11月 9日</li>
      <li>（１／１）</li>
    </ul>
    <span>日本クルーズ客船株式会社<br>業務部予約課</span>
    <table>
      <tbody>
      <tr>
        <td>大阪</td>
        <td>TEL：06(6347)7521</td>
      </tr>
      <tr>
        <td></td>
        <td>FAX：06(6341)8980</td>
      </tr>
      <tr>
        <td>東京</td>
        <td>TEL：03(5532)2211</td>
      </tr>
      <tr>
        <td></td>
        <td>FAX：03(5532)2212</td>
      </tr>
      </tbody>
    </table>
  </div>
</header>
<div class="container">
  <div class="greeting">
    <p>いつもお引き立ていただき誠にありがとうございます。<br>
      下記のとおりキャンセルを承りましたのでご確認ください。</p>
  </div>
  <div class="cruse">
    <table>
      <colgroup style="width: 14%;">
      <colgroup style="width: 86%;">
      <tbody>
      <tr>
        <th>クルーズ名：</th>
        <td>悠久のオリエンタルクルーズ</td>
      </tr>
      </tbody>
    </table>
  </div>
  <div class="block">
    <div class="course">
      <table>
        <colgroup style="width: 14%;">
        <colgroup style="width: 56%;">
        <colgroup style="width: 30%;">
        <tbody>
        <tr>
          <th>商品名：</th>
          <td>悠久のオリエンタルクルーズ【横浜発着】</td>
          <td>早期【横浜発着】</td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">[商品名（2行目）]</td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">2018/01/11 横浜　～　2018/02/27 横浜</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="room">
      <table class="info small">
        <colgroup style="width: 10%;">
        <colgroup style="width: 5%;">
        <colgroup style="width: 14%;">
        <colgroup style="width: 6%;">
        <colgroup style="width: 4%;">
        <colgroup style="width: 17%;">
        <colgroup style="width: 9%;">
        <colgroup style="width: 5%;">
        <colgroup style="width: 10%;">
        <colgroup style="width: 20%;">
        <thead>
        <tr>
          <th rowspan="2">予約番号</th>
          <th rowspan="2">ｸﾞﾙｰﾌﾟ<br>No.</th>
          <th class="dashed">姓</th>
          <th class="dashed">年齢</th>
          <th rowspan="2" class="small">大<br>小<br>幼</th>
          <th rowspan="2">氏名</th>
          <th class="dashed">客室ﾀｲﾌﾟ</th>
          <th rowspan="2">客室<br>番号</th>
          <th class="dashed">ステータス</th>
          <th rowspan="2">備考</th>
        </tr>
        <tr>
          <th>名</th>
          <th>性別</th>
          <th>料金ﾀｲﾌﾟ</th>
          <th>受付日</th>
        </tr>
        </thead>
        <tbody>
        @foreach($room1 as $pass)
          <tr>
            <td rowspan="2">{{ $pass['No'] }}</td>
            <td rowspan="2">{{ $pass['groupNo'] }}</td>
            <td class="dashed left">{{ $pass['familyName'] }}</td>
            <td class="dashed">{{ $pass['age'] }}</td>
            <td rowspan="2">{{ $pass['type'] }}</td>
            <td rowspan="2" class="left">{{ $pass['nameKnj'] }}</td>
            <td rowspan="2">{{ $pass['roomType'] }}<br>{{ $pass['roomMany'] }}</td>
            <td rowspan="2">{{ $pass['roomNo'] }}</td>
            <td class="dashed">{{ $pass['status'] }}</td>
            <td rowspan="2" class="left">{{ $pass['other'] }}</td>
          </tr>
          <tr>
            <td class="left">{{ $pass['firstName'] }}</td>
            <td>{{ $pass['sex'] }}</td>
            <td>{{ $pass['entryDay'] }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <span class="span">a</span>
    </div>
  </div>
</div>
</body>
</html>