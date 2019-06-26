<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>予約内容確認書</title>
  <style>
    body {
      page-break-after: auto;
      font-size: 20px;
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
      left: 380px;
      font-size: 2em;
      text-decoration: underline;
    }
    header .company_info {
      position: absolute;
      top: 0px;
      right: 0px;
      text-align: right;
    }
    div.container {
      margin-top: 220px;
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
    table.passenger_date {
      border: 1px solid black;
      float: left;
      text-align: center;
      margin-bottom: 15px;
      font-size: 0.9em;
      width: 1038px;
      border-collapse: collapse;
      border-spacing:0px;

    }
    table.passenger_date thead {
      border-bottom: 3px double black;
    }
    table.passenger_date th,
    table.passenger_date td {
      border-bottom: 1px dashed black;
      border-right: 1px solid black;
      height: 27px;
    }
    .separate {
      text-align: center;
      width: 48%;
      display: inline-block;
    }
    .border {
      border-right: 1px dashed black;
    }
    .left {
      text-align: left;
      padding: 0px 0px 0px 5px;
    }
    .other {
      border-top: 1px solid black!important;
    }
    .passenger {
      border-top: 2px solid black !important;
    }
  </style>
</head>
<?php
  $room1 = [
      ['No' => '123456788', 'leader' => '○', 'nameKnj' => '中川　善太郎', 'birth' => '1942/06/06', 'type' => '大', 'contry' => 'JAPAN',
          'address' => '東京都千代田区内幸町１－１－７', 'address2' => 'びいなすハイツ2201',
          'roomType' => 'H', 'roomNo' => '', 'familyName' => 'NAKAGAWA', 'firstName' => 'YOSHITARO', 'age' => '75', 'sex' => '男',
          'food' => '', 'PPTNo' => 'TH9999999', 'roomMany' => 'ﾂｲﾝ', 'venus' => '1234556', 'seet' => '1', 'date' => '2015/06/06',
          'tel1' => '09099999999', 'tel2' => '', 'question' => '健康アンケート[未]、診療情報提供書[未]、食物アレルギー[済]', 'other' => ''],
      ['No' => '123456788', 'leader' => '', 'nameKnj' => '中川　はなえ', 'birth' => '1942/06/07', 'type' => '大', 'contry' => 'JAPAN',
          'address' => '東京都千代田区内幸町１－１－７', 'address2' => 'びいなすハイツ2201',
          'roomType' => 'H', 'roomNo' => '', 'familyName' => 'NAKAGAWA', 'firstName' => 'HANAKE', 'age' => '75', 'sex' => '女',
          'food' => '', 'PPTNo' => 'TH9999999', 'roomMany' => 'ﾂｲﾝ', 'venus' => '1234556', 'seet' => '1', 'date' => '2015/06/06',
          'tel1' => '09099999999', 'tel2' => '', 'question' => '健康アンケート[未]', 'other' => ''],
      ];

  $room2 = [
      ['No' => '015671533', 'leader' => '○', 'nameKnj' => '中川　花子', 'birth' => '1975/12/24', 'type' => '大', 'contry' => 'JAPAN',
          'address' => '滋賀県高島市今津町今津１６３９－３', 'address2' => 'びわこハイツ301',
          'roomType' => 'J', 'roomNo' => '552', 'familyName' => 'NAKAGAWA', 'firstName' => 'HANAKO', 'age' => '44', 'sex' => '女',
          'food' => '', 'PPTNo' => 'TH9999999', 'roomMany' => 'ﾂｲﾝ', 'venus' => '1234556', 'seet' => '2', 'date' => '2015/06/06',
          'tel1' => '09099999999', 'tel2' => '', 'question' => '食物アレルギー[済]', 'other' => ''],
      ['No' => '015671533', 'leader' => '', 'nameKnj' => '中川　小花', 'birth' => '2007/12/25', 'type' => '小', 'contry' => 'JAPAN',
          'address' => '滋賀県高島市今津町今津１６３９－３', 'address2' => 'びわこハイツ301',
          'roomType' => 'J', 'roomNo' => '552', 'familyName' => 'NAKAGAWA', 'firstName' => 'KOHANA', 'age' => '10', 'sex' => '女',
          'food' => '○', 'PPTNo' => 'TH9999999', 'roomMany' => 'ﾂｲﾝ', 'venus' => '1234556', 'seet' => '2', 'date' => '2015/06/06',
          'tel1' => '09099999999', 'tel2' => '', 'question' => '', 'other' => ''],
      ['No' => '015671533', 'leader' => '', 'nameKnj' => '中川　洋二', 'birth' => '2017/10/15', 'type' => '幼', 'contry' => 'JAPAN',
          'address' => '滋賀県高島市今津町今津１６３９－３', 'address2' => 'びわこハイツ301',
          'roomType' => 'J', 'roomNo' => '552', 'familyName' => 'NAKAGAWA', 'firstName' => 'YOHJI', 'age' => '0', 'sex' => '男',
          'food' => '○', 'PPTNo' => 'TH9999999', 'roomMany' => 'ﾂｲﾝ', 'venus' => '1234556', 'seet' => '2', 'date' => '2015/06/06',
          'tel1' => '09099999999', 'tel2' => '', 'question' => '健康ｱﾝｹｰﾄ[未]、診療情報提供書[未]、食物ｱﾚﾙｷﾞｰ[未]、（乳）承諾書[未]、（乳）診断書[未]', 'other' => ''],
      ['No' => '015671533', 'leader' => '', 'nameKnj' => '中川　洋二', 'birth' => '2017/10/15', 'type' => '幼', 'contry' => 'JAPAN',
      'address' => '滋賀県高島市今津町今津１６３９－３', 'address2' => 'びわこハイツ301',
      'roomType' => 'J', 'roomNo' => '552', 'familyName' => 'NAKAGAWA', 'firstName' => 'YOHJI', 'age' => '0', 'sex' => '男',
      'food' => '○', 'PPTNo' => 'TH9999999', 'roomMany' => 'ﾂｲﾝ', 'venus' => '1234556', 'seet' => '2', 'date' => '2015/06/06',
      'tel1' => '09099999999', 'tel2' => '', 'question' => '健康ｱﾝｹｰﾄ[未]、診療情報提供書[未]、食物ｱﾚﾙｷﾞｰ[未]、（乳）承諾書[未]、（乳）診断書[未]', 'other' => ''],
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
      <span>予約内容確認書</span>
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
      <div class="customer_data">
        <table class="passenger_date">
          <colgroup style="width: 160px">
          <colgroup style="width: 40px">
          <colgroup style="width: 160px">
          <colgroup style="width: 160px">
          <colgroup style="width: 100px">
          <colgroup style="width: 110px">
          <colgroup style="width: 308px">
          <thead>
          <tr>
            <th>予約番号</th>
            <th rowspan="3">代<br>表<br>者</th>
            <th>氏名</th>
            <th>生年月日</th>
            <th>大小幼</th>
            <th>国籍</th>
            <th rowspan="2">住所</th>
          </tr>
          <tr>
            <th>客室ﾀｲﾌﾟ・番号</th>
            <th rowspan="2">氏名（英字）</th>
            <th>
              <div class="separate border">年齢</div>
              <div class="separate">性別</div>
            </th>
            <th>子供食</th>
            <th>PPT No</th>
          </tr>
          <tr>
            <th>料金ﾀｲﾌﾟ</th>
            <th>会員番号</th>
            <th>確定ｼｰﾃｨﾝｸﾞ</th>
            <th>発行日</th>
            <th>
              <div class="separate border">TEL①</div>
              <div class="separate">TEL②</div>
            </th>
          </tr>
          </thead>
          <tbody>
          @foreach($room1 as $pass)
          <tr class="passenger">
            <td>{{ $pass['No'] }}</td>
            <td rowspan="3">{{ $pass['leader'] }}</td>
            <td class="left">{{ $pass['nameKnj'] }}</td>
            <td>{{ $pass['birth'] }}</td>
            <td>{{ $pass['type'] }}</td>
            <td>{{ $pass['contry'] }}</td>
            <td rowspan="2" class="left">{{ $pass['address'] }}　{{ $pass['address2'] }}</td>
          </tr>
          <tr>
            <td>
              <div class="separate border">{{ $pass['roomType'] }}</div>
              <div class="separate">{{ $pass['roomNo'] }}</div>
            </td>
            <td rowspan="2" class="left">{{ $pass['familyName'] }} {{ $pass['firstName'] }}</td>
            <td>
              <div class="separate border">{{ $pass['age'] }}</div>
              <div class="separate">{{ $pass['sex'] }}</div>
            </td>
            <td>{{ $pass['food'] }}</td>
            <td>{{ $pass['PPTNo'] }}</td>
          </tr>
          <tr>
            <td>{{ $pass['roomMany'] }}</td>
            <td>{{ $pass['venus'] }}</td>
            <td>{{ $pass['seet'] }}</td>
            <td>{{ $pass['date'] }}</td>
            <td>
              <div class="separate border">{{ $pass['tel1'] }}</div>
              <div class="separate">{{ $pass['tel2'] }}</div>
            </td>
          </tr>
          <tr>
            <th class="other">提出書類</th>
            <td colspan="6" class="other left">{{ $pass['question'] }}</td>
          </tr>
          <tr>
            <th>備考</th>
            <td colspan="6">{{ $pass['other'] }}</td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <span class="span">a</span>
      </div>
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
      <div class="customer_data">
        <table class="passenger_date">
          <colgroup style="width: 160px">
          <colgroup style="width: 40px">
          <colgroup style="width: 160px">
          <colgroup style="width: 160px">
          <colgroup style="width: 100px">
          <colgroup style="width: 110px">
          <colgroup style="width: 308px">
          <thead>
          <tr>
            <th>予約番号</th>
            <th rowspan="3">代<br>表<br>者</th>
            <th>氏名</th>
            <th>生年月日</th>
            <th>大小幼</th>
            <th>国籍</th>
            <th rowspan="2">住所</th>
          </tr>
          <tr>
            <th>客室ﾀｲﾌﾟ・番号</th>
            <th rowspan="2">氏名（英字）</th>
            <th>
              <div class="separate border">年齢</div>
              <div class="separate">性別</div>
            </th>
            <th>子供食</th>
            <th>PPT No</th>
          </tr>
          <tr>
            <th>料金ﾀｲﾌﾟ</th>
            <th>会員番号</th>
            <th>確定ｼｰﾃｨﾝｸﾞ</th>
            <th>発行日</th>
            <th>
              <div class="separate border">TEL①</div>
              <div class="separate">TEL②</div>
            </th>
          </tr>
          </thead>
          <tbody>
          @foreach($room2 as $pass)
            <tr class="passenger">
              <td>{{ $pass['No'] }}</td>
              <td rowspan="3">{{ $pass['leader'] }}</td>
              <td class="left">{{ $pass['nameKnj'] }}</td>
              <td>{{ $pass['birth'] }}</td>
              <td>{{ $pass['type'] }}</td>
              <td>{{ $pass['contry'] }}</td>
              <td rowspan="2" class="left">{{ $pass['address'] }}　{{ $pass['address2'] }}</td>
            </tr>
            <tr>
              <td>
                <div class="separate border">{{ $pass['roomType'] }}</div>
                <div class="separate">{{ $pass['roomNo'] }}</div>
              </td>
              <td rowspan="2" class="left">{{ $pass['familyName'] }} {{ $pass['firstName'] }}</td>
              <td>
                <div class="separate border">{{ $pass['age'] }}</div>
                <div class="separate">{{ $pass['sex'] }}</div>
              </td>
              <td>{{ $pass['food'] }}</td>
              <td>{{ $pass['PPTNo'] }}</td>
            </tr>
            <tr>
              <td>{{ $pass['roomMany'] }}</td>
              <td>{{ $pass['venus'] }}</td>
              <td>{{ $pass['seet'] }}</td>
              <td>{{ $pass['date'] }}</td>
              <td>
                <div class="separate border">{{ $pass['tel1'] }}</div>
                <div class="separate">{{ $pass['tel2'] }}</div>
              </td>
            </tr>
            <tr>
              <th class="other">提出書類</th>
              <td colspan="6" class="other left">{{ $pass['question'] }}</td>
            </tr>
            <tr>
              <th>備考</th>
              <td colspan="6">{{ $pass['other'] }}</td>
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