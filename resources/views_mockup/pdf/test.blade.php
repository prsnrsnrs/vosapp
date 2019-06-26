<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アンケート想定</title>
    <style>
      body {
        page-break-after: auto;
      }
      .data{
        position: fixed;
        top: 0px;
        left: 50px;
      }
      .unit span {
        float: right;
        padding-right: 15px;
      }
      .date span {
        padding-left: 3px;
      }
      .data table {
        border: 1px solid #000;
        border-collapse: collapse;
      }
      table td {
        height: 45px;
        padding: 0px 0px 0px 5px;
      }
      td.small {
        height: 25px;
        padding: 0px 5px 0px ;
        font-size: 0.8em;
      }
      td.large {
        font-size: 1.3em;
      }
      .sex {
        padding-left: 0px;
      }
      .center {
        text-align: center;
      }
      .birth span {
        padding-left: 40px;
      }
      .right_border {
        border-right: 1px solid #000;
      }
      .customer, .old {
        border-top: none!important;
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
    <div class="header">
      <div class="data">
        <table class="cruise">
          <colgroup style="width: 150px"></colgroup>
          <colgroup style="width: 350px"></colgroup>
          <tbody>
          <tr>
            <td class="small">ご参加クルーズ</td>
            <td rowspan="2">憧れのタヒチ・ハワイ・ブルーラグーン【Ｂコース】<br>神戸発着</td>
          </tr>
          <tr>
            <td class="date">
              <span>０５/０８</span><span>～</span><span>０５/１８</span>
            </td>
          </tr>
          </tbody>
        </table>
        <table class="customer">
          <colgroup style="width: 70px"></colgroup>
          <colgroup style="width: 200px"></colgroup>
          <colgroup style="width: 30px"></colgroup>
          <colgroup style="width: 200px"></colgroup>
          <tbody>
            <tr>
              <td></td>
              <td class="right_border">KYAKUSEN TARO</td>
              <td rowspan="2" class="center right_border sex">男</td>
              <td class="small">取扱旅行会社</td>
            </tr>
            <tr>
              <td>お名前</td>
              <td class="unit right_border large">客船　太郎<span>様</span></td>
              <td class="center">日本クルーズ客船（株）</td>
            </tr>
          </tbody>
        </table>
        <table class="old">
          <colgroup style="width: 400px"></colgroup>
          <colgroup style="width: 100px"></colgroup>
          <tbody>
            <tr>
              <td rowspan="2" class="birth right_border">
                生年月日<span>１９８５年</span><span>１０月</span><span>１０日</span>
              </td>
              <td rowspan="2" class="unit"><span>４０歳</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <img src="{{ asset('/images/WS000035.JPG') }}"/>
  </body>
</html>