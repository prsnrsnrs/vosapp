@extends('layout.base')

@section('title', '取込フォーマット設定')

@section('style')
  <link href="{{ mix('css/setting.css') }}" rel="stylesheet"/>
@endsection

@section('js')
  <script src="{{ mix('js/setting.js')}}"></script>
@endsection

@section('breadcrumb')
  <a href="{{ url('/mypage') }}">マイページ</a>＞<a href="{{ url('capture/select') }}">取込ファイル指定</a>＞<a href="{{ url('capture/management') }}">取込フォーマット管理</a>＞取込フォーマット設定
@endsection
@section('login_data')
  <ul class="user">
    <li>株式会社PVトラベル</li>
    <li class="name">東京支店</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('mypage/') }}">マイページ</a></li>
    <li><a href="{{ url('/') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="capture_setting">
    <table class="default set_table">
      <thead>
      <tr>
        <th colspan="2">取込フォーマット設定</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th>フォーマット名<span class="required">※</span></th>
        <td><input type="text" class="format_name" name="format_name" value="JTBフォーマット" /></td>
      </tr>
      <tr>
        <th>ファイル形式<span class="required">※</span></th>
        <td>
          <label><input type="radio" name="file_type"/>CSV</label>
          <label><input type="radio" name="file_type" selected/>EXCEL</label>
        </td>
      </tr>
      <tr>
        <th>列見出し行<span class="required">※</span></th>
        <td><input type="text" class="col" name="row_title" value="3"/>行目</td>
      </tr>
      <tr>
        <th>取込開始行<span class="required">※</span></th>
        <td><input type="text" class="row" name="start_col" value="6"/>行目</td>
      </tr>
      <tr>
        <th>取込ファイル<span class="required">※</span></th>
        <td>
          <input type="file" class="file" name="file"/>
          (※取込フォーマットを設定する上では列見出しのみでも構いません)
        </td>
      </tr>
      </tbody>
    </table>
      <?php
      // type[属性]　0:客室タイプ、1:文字、2:日付形式
      // require[必須]　0:任意、1:必須
      $datas = [
          ['input' => 2, 'count' => 0, 'group' => '', 'name' => '管理番号', 'type' => 1, 'require' => 1, 'text' => ['管理番号', '枝番号'], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '受付日', 'type' => 2, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '変更日', 'type' => 2, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '取消日', 'type' => 2, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '客室タイプ', 'type' => 0, 'require' => 1, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '部屋割番号', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '代表者区分', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => ''],
          ['input' => 2, 'count' => 3, 'group' => 'お名前', 'name' => '英字', 'type' => 1, 'require' => 1, 'text' => ['(姓)', '(名)'], 'advice' => '',
              'child' => [
                  ['input' => 2, 'name' => '漢字', 'type' => 1, 'require' => 1, 'text' => ['(姓)', '(名)'], 'advice' => ''],
                  ['input' => 2, 'name' => 'カナ', 'type' => 1, 'require' => 0, 'text' => ['(姓)', '(名)'], 'advice' => '']
              ]
          ],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '性別', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => 'M/Fで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '生年月日', 'type' => 2, 'require' => 1, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '結婚記念日', 'type' => 2, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '国籍', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '郵便番号', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => 'ハイフンなしで記載してください'],
          ['input' => 4, 'count' => 0, 'group' => '', 'name' => '住所', 'type' => 1, 'require' => 1, 'text' => ['都道府県', '住所１', '住所２', '住所３'], 'advice' => '住所が分かれていない場合は、住所１に指定してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '電話番号１', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => 'ハイフンなしで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '電話番号２', 'type' => 1, 'require' => 0, 'text' => [''], 'advice' => 'ハイフンなしで記載してください'],
          ['input' => 2, 'count' => 4, 'group' => '緊急連絡先', 'name' => '漢字', 'type' => 1, 'require' => 1, 'text' => ['(姓)', '(名)'], 'advice' => '',
              'child' => [
                  ['input' => 2, 'name' => 'カナ', 'type' => 1, 'require' => 1, 'text' => ['(姓)', '(名)'], 'advice' => ''],
                  ['input' => 1, 'name' => '続柄', 'type' => 1, 'require' => 1, 'text' => [''], 'advice' => ''],
                  ['input' => 1, 'name' => '電話番号', 'type' => 1, 'require' => 0, 'text' => [''], 'advice' => 'ハイフンなしで記載してください']
              ]
          ],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '旅券番号', 'type' => 1, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '旅券発給地', 'type' => 1, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '旅券発給日', 'type' => 2, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '旅券失効日', 'type' => 2, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '客室タイプリクエスト', 'type' => 1, 'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => 'キャビンリクエスト', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => 'キャビンリクエスト備考', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '食事希望何回目', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => '回数を数字で記載してください※"回目"不要'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '子供食', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '食事アレルギー有無', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => '有/無で記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '食事備考', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '割引券番号１', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '割引券番号２', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '割引券番号３', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '備考', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => ''],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '質問１(乳幼児)', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => 'はい/いいえで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '質問２(食物アレルギー)', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => 'はい/いいえで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '質問３(妊婦)', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => 'はい/いいえで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '質問４(車いす)', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => 'はい/いいえで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '質問５(健康)', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => 'はい/いいえで記載してください'],
          ['input' => 1, 'count' => 0, 'group' => '', 'name' => '質問６(特別な配慮)', 'type' => 1,  'require' => 0, 'text' => [''], 'advice' => 'はい/いいえで記載してください']
      ];

      $i = 0;

      function excel_dump($path)
      {
          $excel = PHPExcel_IOFactory::createReader('Excel2007');
          $book = $excel->load($path);
//          $sheet = $book->getActiveSheet();
//          $fin_col = $sheet->getHighestColumn();
//          $val = $sheet->rangeToArray('A'.'3'.':'. $fin_col.'3');
//          return $val;

          $sheet = $book->getActiveSheet()->toArray(null,true,false,true);
          return $sheet[3];

      }

      $excels = excel_dump('./JTBリストサンプル.xlsx');
      $title[] = ['val' => 0, 'name' => ''];
      $x = 0;
      $y = 1;
      foreach ($excels as $col => $name) {
          if(!is_null($name)) {
              if($x == 0) {
                  $val = 1;
              } elseif($x == 1) {
                  $val = 2;
              } elseif($x == 2) {
                  $val = 3;
              } elseif($x == 3) {
                  $val = 4;
              } elseif($x == 4) {
                  $val = 5;
              } elseif($x == 6) {
                  $val = 6;
              } elseif($x == 7) {
                  $val = 28;
              } elseif($x == 8) {
                  $val = 9;
              } elseif ($x == 20) {
                  $val = 19;
              } elseif ($x == 17) {
                  $val = 23;
              } elseif ($x == 23) {
                  $val = 34;
              } elseif ($x == 24) {
                  $val = 30;
              } elseif ($x == 25) {
                  $val = 13;
              } elseif ($x == 40) {
                  $val = 37;
              } elseif ($x == 27) {
                  $val = 40;
              } elseif ($x == 26) {
                  $val = 32;
              } else {
                  $val = 0;
              }
            $title[] = ['val' => $val, 'name' => $y.':'.$name];
          } else {
              if($x == 9) {
                  $val = 8;
              } elseif ($x == 11) {
                  $val = 11;
              } elseif ($x == 12) {
                  $val = 12;
              } elseif ($x == 14) {
                  $val = 15;
              } elseif ($x == 15) {
                  $val = 16;
              } elseif ($x == 16) {
                  $val = 17;
              } elseif ($x == 21) {
                  $val = 21;
              } elseif ($x == 22) {
                  $val = 22;
              } elseif ($x == 18) {
                  $val = 25;
              } elseif ($x == 19) {
                  $val = 26;
              } else {
                  $val = 0;
              }
            $title[] = ['val' => $val, 'name' => $y.':'.$col.'列'];
          }
          $x++;
          $y++;
      }
      ?>
    <div class="file_setting" style="display: none">

      <table class="default center" style="width: 1215px">
        <thead style="width: 1196px">
          <tr>
            <th colspan="9">取込フォーマット</th>
          </tr>
          <tr class="title_th">
            <th style="width: 40px">No</th>
            <th style="width: 152px">項目</th>
            <th style="width: 70px">属性</th>
            <th style="width: 340px">取込情報</th>
            <th style="width: 61px">区切文字</th>
            <th style="width: 402px">説明</th>
          </tr>
        </thead>
        <tbody>
        @foreach($datas as $val)
            <?php $i++ ?>
            @if($val['count'])
              {{--複数列データ（rowspan有り）--}}
              <tr>
                <td>{{ $i }}</td>
                <td rowspan="{{ $val['count'] }}" style="width: 70px">{{ $val['group'] }}</td>
                <td style="width: 100px">{{ $val['name'] }}<span class="danger">{{ $val['require']? '*': '' }}</span></td>
                <td>
                  @if($val['type'] == 0)
                    客室タイプ
                  @elseif($val['type'] == 1)
                    文字
                  @else
                    日付
                  @endif
                </td>
                <td class="right">
                  @for($j=0; $j < $val['input'];$j++)
                    <label>{{ $val['text'][$j] }}</label>
                    <select>
                      @foreach($title as $int => $option)
                        <option {{ $option['val'] == $i? 'selected': '' }}>{{ $option['name'] }}</option>
                      @endforeach
                    </select><br>
                  @endfor
                </td>
                <td>
                  @if($val['input'] > 1)
                    <input type="text" value="　">
                  @endif
                </td>
                <td class="left">{{ $val['advice'] }}</td>
              </tr>
              @foreach($val['child'] as $chi)
                <?php $i++; ?>
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $chi['name'] }}<span class="danger">{{ $chi['require']? '*': '' }}</span></td>
                  <td>
                    @if($chi['type'] == 0)
                      客室タイプ
                    @elseif($chi['type'] == 1)
                      文字
                    @else
                      日付
                    @endif
                  </td>
                  <td class="right">
                    @for($j=0; $j < $chi['input'];$j++)
                      <label>{{ $chi['text'][$j] }}</label>
                      <select>
                        @foreach($title as $int => $option)
                          <option {{ $option['val'] == $i? 'selected': '' }}>{{ $option['name'] }}</option>
                        @endforeach
                      </select><br>
                    @endfor
                  </td>
                  <td>
                    @if($val['input'] > 1)
                      <input type="text" value="　">
                    @endif
                  </td>
                  <td class="left">{{ $chi['advice'] }}</td>
                </tr>
              @endforeach
            @else
              {{--一列データ（rowspan無し）--}}
              <tr>
                <td style="width: 60px">{{ $i }}</td>
                <td colspan="2" style="width: 172px">{{ $val['name'] }}<span class="danger">{{ $val['require']? '*': '' }}</span></td>
                <td style="width: 90px">
                  @if($val['type'] == 0)
                    客室タイプ
                  @elseif($val['type'] == 1)
                    文字
                  @else
                    日付
                  @endif
                </td>
                <td style="width: 360px" class="right">
                  @for($j=0; $j < $val['input'];$j++)
                    <label>{{ $val['text'][$j] }}</label>
                    <select>
                      @foreach($title as $int => $option)
                        <option {{ $option['val'] == $i? 'selected': '' }}>{{ $option['name'] }}</option>
                      @endforeach
                    </select><br>
                  @endfor
                </td>
                <td style="width: 81px">
                  @if($val['input'] > 1)
                    <input type="text" value="　">
                  @endif
                </td>
                <td style="width: 422px" class="left">{{ $val['advice'] }}</td>
              </tr>
            @endif
        @endforeach
        </tbody>
      </table>
    </div>
  </main>
  <div class="button_bar">
    <a href="{{ url('capture/management') }}"><button class="back">戻る</button></a>
    <a href="{{ url('capture/management') }}"><button class="done">保存</button></a>
  </div>

@endsection