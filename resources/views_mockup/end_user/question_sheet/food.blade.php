@extends('layout.base')

@section('title', '食物アレルギーや食事制限の方へのアンケート入力画面')

@section('style')
  <link href="{{ mix('css/food.css') }}" rel="stylesheet"/>
@endsection


@section('breadcrumb')
  <a href="{{ url('end_user/mypage') }}">マイページ</a>＞新規予約
@endsection

@section('login_data')
  <ul class="user">
    <li class="name">中川　善夫</li>
  </ul>
  <ul class="links">
    <li><a href="{{ url('end_user/mypage') }}">マイページ</a></li>
    <li><a href="{{ url('end_user/login/login') }}">ログアウト</a></li>
  </ul>
@endsection

@section('content')
  <main class="food">
    <div class="body">
      @include('include/course', ['menu_display' => false])
      @include('include/info', ['info' => '以下のアンケートの内容と対象となるお客様の名前を確認後、アンケートにご回答をお願いします。'])
      <div class="user_info">
        <table class="default center">
          <tbody>
          <tr>
            <th style="width: 7%">No</th>
            <th style="width: 7%">料金区分</th>
            <th style="width: 30%">お名前</th>
            <th style="width: 7%">性別</th>
            <th style="width: 7%">年齢</th>
            <th style="width: 35%">入力アンケートの内容</th>
            <th style="width: 7%">提出</th>
          </tr>
          <tr>
            <td>1</td>
            <td>大人</td>
            <td class="left">ナカガワ　ヨシオ　様</td>
            <td>男</td>
            <td>44</td>
            <td>食物アレルギーや食事制限の方へのアンケート</td>
            <td class="danger">未</td>
          </tr>
          <tr>
            <td colspan="7" class="left">
              <p>
                <span class="under_line">クルーズ出発の３週間</span>までに、ご回答ください。<br>
                対応出来る内容や食数には限りがありますので、ご希望に添えない場合がございます。あらかじめご了承ください。<br>
                なお、このアンケートはお食事ご提供の参考資料とさせていただくことを目的とし、それ以外の目的には使用いたしません。
              </p>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
        <?php
        $question = array(
            'index' => 1,
            'row_no' => ['①', '②']
        );
        $item = array(
            '1' => ['卵', '乳（乳製品）', 'えび', 'かに', '小麦', 'そば', '落花生'],
            '2' => ['牛肉', '豚肉', '鶏肉', 'さば', 'さけ', 'いか', 'あわび', 'いくら', '大豆', 'やまいも', 'ごま', 'まつたけ', 'りんご', 'もも', 'オレンジ', 'バナナ', 'キウイフルーツ', 'カシューナッツ', 'くるみ', 'ゼラチン']
        )
        ?>
      <div class="question_sheet">
        <table class="default">
          <tbody>
          <tr>
            <th colspan="6">
              <p>{{ $question['index'] }}．以下の特定原材料７品目についてアレルゲンとして除去が必要な場合は該当箇所に◉やチェック ☑をご入力ください。</p>
            </th>
          </tr>
          <tr>
            <td colspan="6">
              <p>特定原材料 ７品目</p>
            </td>
          </tr>
          <tr class="detail">
            <th style="width: 20%"></th>
            <th style="width: 10%">アレルゲン</th>
            <th style="width: 10%">出汁・エキス</th>
            <th style="width: 10%">加工品</th>
            <th style="width: 25%">症状</th>
            <th style="width: 25%">その他症状</th>
          </tr>
          @for($i = 0; $i < count($item[$question['index']]); $i++)
            <tr class="detail center">
              <td>{{ $item[$question['index']][$i] }}</td>
              <td>
                <label>
                  <input type="checkbox" class="check_style" name="allergen_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>有
                </label>
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style" name="liquid_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>可
                </label>
                <label>
                  <input type="radio" class="check_style" name="liquid_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>不可
                </label>
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style" name="processing_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>可
                </label>
                <label>
                  <input type="radio" class="check_style" name="processing_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>不可
                </label>
              </td>
              <td class="symptom left">
                <div>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>蕁麻疹
                  </label>
                  <label style="width: 95px">
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>呼吸困難
                  </label>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>吐き気
                  </label>
                  <br>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>下痢
                  </label>
                  <label style="width: auto">
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>その他（右欄記入）
                  </label>
                </div>
              </td>
              <td><input type="text"></td>
            </tr>
          @endfor
          </tbody>
        </table>

          <?php $question['index']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th colspan="6">
              <p>{{ $question['index'] }}．以下の特定原材料に準ずる２０品目についてアレルゲンとして除去が必要な場合は該当箇所に◉やチェック ☑をご記入ください。</p>
            </th>
          </tr>
          <tr>
            <td colspan="6">
              <p>特定原材料に準ずる２０品目</p>
            </td>
          </tr>
          <tr class="detail">
            <th style="width: 20%"></th>
            <th style="width: 10%">アレルギー</th>
            <th style="width: 10%">出汁・エキス</th>
            <th style="width: 10%">加工品</th>
            <th style="width: 25%">症状</th>
            <th style="width: 25%">その他症状</th>
          </tr>
          @for($i = 0; $i < count($item[$question['index']]); $i++)
            <tr class="detail center">
              <td>{{ $item[$question['index']][$i] }}</td>
              <td>
                <label>
                  <input type="checkbox" class="check_style" name="allergen_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>有
                </label>
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style" name="liquid_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>可
                </label>
                <label>
                  <input type="radio" class="check_style" name="liquid_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>不可
                </label>
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style" name="processing_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>可
                </label>
                <label>
                  <input type="radio" class="check_style" name="processing_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>不可
                </label>
              </td>
              <td class="symptom left">
                <div>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>蕁麻疹
                  </label>
                  <label style="width: 95px">
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>呼吸困難
                  </label>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>吐き気
                  </label>
                  <br>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>下痢
                  </label>
                  <label style="width: auto">
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>その他（右欄記入）
                  </label>
                </div>
              </td>
              <td><input type="text"></td>
            </tr>
          @endfor
          </tbody>
        </table>


          <?php $question['index']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th colspan="6">
              <p>{{ $question['index'] }}
                ．その他除去が必要なアレルゲン食品がございましたら下記にご記入ください。但し、こちらにご記入いただいた食品については対応できない場合がございますので、ご了承ください。</p>
            </th>
          </tr>
          <tr>
            <td colspan="6">
              <p>上記記載のアレルゲン特定原材料７品目およびアレルゲン特定原材料に準ずる２０品目以外</p>
            </td>
          </tr>
          <tr class="detail center">
            <th style="width: 5%"></th>
            <th style="width: 25%">食品名</th>
            <th style="width: 10%">出汁・エキス</th>
            <th style="width: 10%">加工品</th>
            <th style="width: 25%">症状</th>
            <th style="width: 25%">その他症状</th>
          </tr>
          @for($i = 0; $i < count($question['row_no']); $i++)
            <tr class="detail center">
              <td>{{ $question['row_no'][$i] }}</td>
              <td>
                <input type="text">
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style" name="liquid_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>可
                </label>
                <label>
                  <input type="radio" class="check_style" name="liquid_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>不可
                </label>
              </td>
              <td>
                <label>
                  <input type="radio" class="check_style" name="processing_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>可
                </label>
                <label>
                  <input type="radio" class="check_style" name="processing_{{ $question['index'].'_'.$i }}"/>
                  <span class="checkbox"></span>不可
                </label>
              </td>
              <td class="symptom left">
                <div>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>蕁麻疹
                  </label>
                  <label style="width: 95px">
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>呼吸困難
                  </label>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>吐き気
                  </label>
                  <br>
                  <label>
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>下痢
                  </label>
                  <label style="width: auto">
                    <input type="checkbox" class="check_style" name="symptom_{{ $question['index'].'_'.$i }}"/>
                    <span class="checkbox"></span>その他（右欄記入）
                  </label>
                </div>
              </td>
              <td><input type="text"></td>
            </tr>
          @endfor
          </tbody>
        </table>


          <?php $question['index']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th colspan="6">
              <p>{{ $question['index'] }}．食物アレルギーに関して医師より食事または薬剤の使用について指導を受けていますか？</p>
            </th>
          </tr>
          <tr>
            <td colspan="2">
              <div class="answer">
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['index'] }}"/>
                  <span class="checkbox"></span>はい
                </label>
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['index'] }}"/>
                  <span class="checkbox"></span>
                  いいえ
                </label>
              </div>
          </tr>
          <tr class="detail">
            <th></th>
            <th style="text-align: left">「はい」と答えた場合はこちらに内容をご記入ください。</th>
          </tr>
          <tr class="detail">
            <td class="center">内容</td>
            <td><input type="text"></td>
          </tr>
          </tbody>
        </table>


          <?php $question['index']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th colspan="6">
              <p>{{ $question['index'] }}．アレルギー症状がでた場合の対処法</p>
            </th>
          </tr>
          <tr>
            <td colspan="2">
              <div class="answer">
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['index'] }}"/>
                  <span class="checkbox"></span>薬をもっている
                </label>
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['index'] }}"/>
                  <span class="checkbox"></span>薬をもっていない
                </label>
              </div>
            </td>
          </tr>
          <tr class="detail">
            <th style="width: 40%"></th>
            <th style="width: 60%; text-align: left">
              薬を持っている場合は①薬剤名を、持っていない場合は②投薬以外の処置方法を以下に入力して下さい
            </th>
          </tr>
          <tr>
            <td>①　薬剤名（※乗船時は必ずお持ちください）</td>
            <td><input type="text"></td>
          </tr>
          <tr>
            <td>②　投薬以外の具体的な処置方法</td>
            <td><input type="text"></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="agreement">
      <div class="panel">
        <div class="title">
          健康アンケートご入力のお客様へ注意事項 ： 必ずご一読ください
        </div>
        <div class="body">
          <ol>
            <li>
              下記理由により、提供するお食事は、<span class="under_line">アレルゲンが完全に除去されたものではなく、又アレルギー症状がでないことをお約束するものではないこと</span>をご理解ください。<br>
              　１） すべて同一の調理場で調理しているため、アレルゲンが微量に混入する可能性があります。<br>
              　２） 食器・調理器具なども洗浄過程でアレルゲンが完全に除去されず、一部残留することもあります。<br>
            </li>
            <li>
              食品表示法にもとづく<span class="bold">アレルゲン特定原材料 ７品目</span>及び、消費者庁通達にもとづく<span
                      class="bold">アレルゲン特定原材料に準ずる２０品目</span>のうちお申し出のあったアレルゲンを可能な限り除去したお食事を提供させて頂きます。これ以外のアレルゲンについては対応できない場合がございますのでご相談ください。（<span
                      class="bold">昼食および夕食時</span>の対応とさせて頂きます。朝食はフードバーもご用意しておりますので、ご自身でご対応ください。）
            </li>
            <li>
              使用する食材については製造元からの情報をもとにアレルゲンの有無を確認しています。
            </li>
            <li>
              以上のことから食物アレルギー症状が重篤なお客様については、やむをえずご乗船をお断わりする場合がございます。
            </li>
            <li>
              本紙の内容によりましては、個別に聞き取りさせていただき、場合によっては医師の診断及び薬の携行をお願いする場合もございます。
            </li>
          </ol>
        </div>
        <div class="footer">
          <label>
            <input type="checkbox" class="check_style"/>
            <span class="checkbox"></span>同意する（必須）
          </label>
        </div>
      </div>
    </div>

  </main>

  <div class="button_bar">
    <button type="submit" class="delete">戻る</button>
    <a href="">
      <button type="submit" class="done">
        回答
      </button>
    </a>
  </div>
@endsection
