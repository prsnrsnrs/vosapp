<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>乗船券控え</title>
  <style>
    body {
      font-family: "游ゴシック Medium", "Yu Gothic Medium", "Yu Gothic", sans-serif;
      font-size: 20px;
      width: 95%;
      page-break-after: auto;
    }
    .block {
      page-break-inside: avoid;
    }
    .header {
      width: 100%;
      border-top:double 5px #000;
      border-bottom:double 5px #000;
      font-weight: bold;
      text-align: center;
    }
    .header .title {
      font-size: 2em;
    }
    .header .En_title {
      font-size: 1.2em;
      margin-top: 0px;
      margin-bottom: 5px;
    }
    .header .info {
      font-size: 1.2em;
    }
    hr {
      border:0;
      border-bottom: 5px double #000;
    }
    table {
      width: 100%;
    }
    th {
      text-align: left;
    }
    .en {
      font-size: 0.8em;
      margin-left: 20px;
    }
    .order_date {
      text-align: right;
      font-size: 0.8em;
    }
    .order_date span {
      padding-left: 20px;
    }
    .large {
      font-size: 1.5em;
    }
    .weight * {
      font-weight: lighter!important;
      font-size:1.3em;
    }
    .cose_data,
    .customer_data {
      margin: 15px 0px;
    }
    .cose_data,
    .customer_data {
      font-weight: bold;
      font-size: 1.2em;
    }
    .cose_data table td,
    .customer_data table td {
      height: 40px;
    }
    .company_date .info {
      border: 2px solid #000;
      width: 80%;
      margin: 120px auto 20px;
      padding: 10px;
      text-align: center;
    }
    .footer table {
      text-align: center!important;
      width: 60%;
      margin: 0px auto;
    }
    .footer table th {
      text-align: center!important;
    }
    .attention,
    .print_day {
      font-size: 0.8em;
      font-weight: lighter!important;
    }
    .print_day {
      text-align: right;
    }
  </style>
</head>
  <body>
  <div class="block">
    <table class="header">
      <tbody>
        <tr>
          <td>
            <img src="{{ asset('/images/VenusCruise.jpg') }}" width="150" height="140">
          </td>
          <td>
            <laber class="title">乗船券（Eチケット）</laber>
            <p class="En_title">M/S PACIFIC VENUS Passage Ticket</p>
            <label class="info">乗船受付の際、ご提示ください</label>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="cose_data">
      <table>
        <tbody>
          <tr>
            <th style="width:30%;">船名</th>
            <td style="width:70%;"><img src="{{ asset('/images/VenusName.jpg') }}" width="300"><label class="order_date"
                                                                                                      style="float: right;">Voy
                ID:2017015</label></td>
          </tr>
          <tr>
            <th>クルーズ名</th>
            <td>秋の日本一周探訪クルーズ</td>
          </tr>
          <tr>
            <th>乗船日/乗船港<br><span class="en">Date / From</span></th>
            <td>
              <table>
                <tr>
                  <td style="width: 45%;">2017年10月10日</td>
                  <td style="width: 55%;">神戸</td>
                </tr>
                <tr>
                  <td class="en">10 OCT.2017</td>
                  <td class="en">KOBE</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <th>下船日/下船港<br><span class="en">Date / To</span></th>
            <td>
              <table>
                <tr>
                  <td style="width: 45%;">2017年10月20日</td>
                  <td style="width: 55%;">神戸</td>
                </tr>
                <tr>
                  <td class="en">10 OCT.2017</td>
                  <td class="en">KOBE</td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <hr>
    <div class="customer_data">
      <table>
        <tbody>
        <tr>
          <th style="width: 30%;"><span class="large">乗船者名</span><br><span>Passenger</span></th>
          <td style="width: 70%;"><span class="large">客船　太郎　様</span><br><span>MR.KYAKUSEN TARO</span></td>
        </tr>
        <tr>
          <th class="large">部屋番号</th>
          <td class="large">６階　６０１号室</td>
        </tr>
        <tr class="weight">
          <th>客室タイプ</th>
          <td>ステートH</td>
        </tr>
        <tr class="weight">
          <th>食事</th>
          <td>メインダイニング　夕食　２回目</td>
        </tr>
        <tr>
          <td colspan="2" class="order_date">REF:0192676 <span>ID NO:05881</span></td>
        </tr>
        </tbody>
      </table>
    </div>
    <hr>
    <div class="company_date">
      <label>取扱旅行会社：JTBクルーズ事業部</label>
      <div class="info">
        受付場所および乗船受付時間等の詳細はクルーズ日程表をご参照ください。
      </div>
    </div>
    <div class="footer">
      <table>
        <tr>
          <th>発行者</th>
          <td><img src="{{ asset('/images/company_name.png') }}" width="350"></td>
        </tr>
        <tr>
          <th>ISSUED BY</th>
          <td><i>Japan Cruise Line Inc.</i></td>
        </tr>
      </table>
    </div>
    <hr>
    <div class="attention">※この乗船券による運送は、当初の旅客運送約款によります。
      <br>　ISSUED SUBJECT TO THE CONDITIONS OF CARRIAGE
    </div>
    <div class="print_day">
      Date of Issue: 30 OCT.2017
    </div>
  </div>
  </body>
</html>