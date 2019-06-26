@extends('layout.base')

@section('title', '健康アンケート入力画面')

@section('style')
  <link href="{{ mix('css/health.css') }}" rel="stylesheet"/>
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
  <main class="health">
    <div class="body">
      @include('include/course', ['menu_display' => false])
      @include('include/information', ['info' => '以下のアンケートの内容と対象となるお客様の名前を確認後、アンケートにご回答をお願いします。'])
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
            <td>健康アンケート</td>
            <td class="danger">未</td>
          </tr>
          <tr>
            <td colspan="7" class="left">
              <p>
                ご参加されるお客様の快適な旅行、そして円滑なクルーズ実施のためにご記入をお願い致します。<br>
                なお、この健康アンケートは皆様の健康管理の参考資料とさせていただくことを目的とし、それ以外の目的には使用いたしません。
              </p>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="question_sheet">
          <?php
          $years = ['2016', '2015', '2014'];
          $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
          $question = array(
              'no' => 1,
              'index' => ['①', '②', '③']
          );
          ?>
        <table class="default">
          <tbody>
          <tr>
            <th colspan="3">
              <p>{{ $question['no'] }}．現在、医師の治療を受けていらっしゃいますか？「はい」と答えた場合は引き続き病名といつからかをご記入下さい。</p>
            </th>
          </tr>
          <tr>
            <td colspan="3">
              <div class="answer">
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['no'] }}"/>
                  <span class="checkbox"></span>はい
                </label>
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['no'] }}"/>
                  <span class="checkbox"></span>いいえ
                </label>
              </div>
            </td>
          </tr>
          <tr class="detail">
            <th style="width: 5%"></th>
            <th style="width: 55%">病名</th>
            <th style="width: 40%">いつから</th>
          </tr>
          @for($i=0; $i<3; $i++)
            <tr class="detail center">
              <td>{{ $question['index'][$i] }}</td>
              <td><input type="text"></td>
              <td>
                <select style="width: 90px">
                  @foreach( $years as $key)
                    <option value="{{ $key }}">{{ $key }}</option>
                  @endforeach
                </select>
                年　
                <select style="width: 70px">
                  @foreach( $month as $key)
                    <option value="{{ $key }}">{{ $key }}</option>
                  @endforeach
                </select>
                月
              </td>
            </tr>
          @endfor
          </tbody>
        </table>

          <?php $question['no']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th><p>{{ $question['no'] }}．上記で｢はい｣とお答えの方のみご記入ください。<br>
                現在、医師からの投薬を受けていらっしゃる場合は、その処方箋の写しあるいは薬品名と数量をお知らせください。</p>
            </th>
          </tr>
          <tr>
            <td>
              <p>※クルーズ期間中を通して必要な薬は、ご自身にてご持参いただけますようお願いいたします。</p>
              <textarea></textarea>
            </td>
          </tr>
          </tbody>
        </table>

          <?php $question['no']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th colspan="3">
              <p>{{ $question['no'] }}．過去５年間に大きな病気やケガで、医師の治療を受けたことがありますか？<br>
                （入院・手術をしたことがあればあわせてご記入ください。）</p>
            </th>
          </tr>
          <tr>
            <td colspan="3">
              <div class="answer">
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['no'] }}"/>
                  <span class="checkbox"></span>はい
                </label>
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['no'] }}"/>
                  <span class="checkbox"></span>いいえ
                </label>
              </div>
            </td>
          </tr>
          <tr class="detail">
            <th style="width: 5%"></th>
            <th style="width: 55%">病名</th>
            <th style="width: 40%">いつから</th>
          </tr>
          @for($i=0; $i<3; $i++)
            <tr class="detail center">
              <td>{{ $question['index'][$i] }}</td>
              <td><input type="text"></td>
              <td>
                <select style="width: 90px">
                  @foreach( $years as $key)
                    <option value="{{ $key }}">{{ $key }}</option>
                  @endforeach
                </select>
                年　
                <select style="width: 70px">
                  @foreach( $month as $key)
                    <option value="{{ $key }}">{{ $key }}</option>
                  @endforeach
                </select>
                月
              </td>
            </tr>
          @endfor
          </tbody>
        </table>

          <?php $question['no']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th>
              <p>{{ $question['no'] }}． 現在、病気（食物アレルギーを除く）で、医師より特別に食事についての指導を受けていらっしゃる場合は、その理由と内
                容を具体的にお知らせください。対応可能な範囲で対応させていただきます。<br>
                ※食物アレルギー対応をご希望の方は別紙「食物アレルギーをお持ちのお客様へのアンケート」にご記入をお願いいたします。</p>
            </th>
          </tr>
          <tr>
            <td>
              <div class="answer">
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['no'] }}"/>
                  <span class="checkbox"></span>はい
                </label>
                <label>
                  <input type="radio" class="check_style" name="question_{{ $question['no'] }}"/>
                  <span class="checkbox"></span>
                  いいえ
                </label>
              </div>
              <textarea></textarea>
            </td>
          </tr>
          </tbody>
        </table>

          <?php $question['no']++ ?>
        <table class="default">
          <tbody>
          <tr>
            <th>
              <p>{{ $question['no'] }}．その他、健康上不安なことや、私どもがあらかじめ知っておいたほうがよいことなどございましたら、具体的に<br>
                お知らせください。</p>
            </th>
          </tr>
          <tr>
            <td>
              <p>※クルーズ期間中を通して必要な薬は、ご自身にてご持参いただけますようお願いいたします。</p>
              <textarea></textarea>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="agreement">
        <div class="panel">
          <div class="title">
            健康アンケートご入力のお客様へ注意事項 ： 必ずご一読ください
          </div>
          <div class="body">
            <ol>
              <li>クルーズ中の健康管理のため、本紙の内容によりましては、個別に聞き取り調査をさせていただく場合もございます。
              </li>
              <li>
                本紙をご提出いただいた後、クルーズの出発日までにご自身の健康状態に大きな変化があった場合には、すみやかに主治医の指示を仰いだうえで、弊社宛ご連絡をお願いいたします。ご連絡の内容によっては、診療情報等のご提供をお願いすることがございます。
              </li>
              <li>本紙の内容や聞き取り調査の内容によりましては、旅行条件書にも記載させていただいておりますとおり、ご参加のお断りあるいは同伴者の同行をご参加の条件とさせていただくことがございます。
              </li>
              <li>本紙にご記入されていない事実に起因し、クルーズ中に疾病が発生した場合、下船をお願いすることがございます。その場合、以降のご旅行代金相当額の返金はいたしません。
              </li>
            </ol>
          </div>
          <div class="footer">
            <label>
              <input type="checkbox" class="check_style" />
              <span class="checkbox"></span>同意する（必須）
            </label>
          </div>
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
