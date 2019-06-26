<?php

namespace App\Console\WindowsServices;

use App\Libs\StringUtil;
use App\Queries\MailQuery;


/**
 * メールの実行クラスです
 *
 * Class Mail
 * @package App\Console\WindowsServices
 */
class Mail extends WindowsService
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voss:mail {home} {service_name}';
    /**
     * @var MailQuery
     */
    private $mail_query;
    /**
     * @var string
     */
    private $host_name;


    /**
     * サービスクラスの初期化時に呼び出されます。
     */
    protected function onInit()
    {
        parent::onInit();
        $this->mail_query = new MailQuery();
        $this->host_name = $this->config[$this->service_name]['host_name'];
    }

    /**
     * サービス開始時に呼び出されます。
     */
    protected function onStart()
    {
    }

    /**
     * 指定間隔ごとに呼び出されます。
     */
    protected function onTick()
    {
        //送信対象メール情報の取得
        $send_mails = $this->mail_query->getSendMails();
        if (!$send_mails) {
            return;
        }

        //送信対象メール情報が取得できた場合は、以降の処理に移る
        foreach ($send_mails as $send_mail) {
            // メール送信
            $view_params = $this->createViewParams($send_mail);
            $options = [
                'view' => 'emails.' . $send_mail['send_instruction_code'],
                'view_params' => $view_params,
                'subject' => $view_params['subject'],
                'type' => 'text',
                'attachments' => $send_mail['attachment_file_path'],
            ];
            $voss_mail = new \App\Mail\VossMail($options);
            $is_send_mail = false;
            try {
                $to = $this->createTo($send_mail);
                \Mail::to($to)->send($voss_mail);
                //送信不可のメールアドレスの場合
                if (!\Mail::failures()) {
                    $is_send_mail = true;
                }
            } catch (\Exception $e) {
                $this->logger->error('メール送信失敗', ['$send_mail' => $send_mail, '$options' => $options]);
                $this->logger->error($e->getMessage());
            }

            // データ更新
            try {
                \DB::beginTransaction();
                //メール送信ファイルの更新
                $prop_update = [
                    'NME150' => $this->host_name,
                    'NME160' => date("YmdHis") . substr(microtime(true)[1], 0, 3),
                    'NME170' => $this->getSendCon($is_send_mail, $send_mail['retry_count']),
                    'NME200' => $send_mail['retry_count'] + 1
                ];
                \DB::table(config('database.libs.voss') . '.VOSNMEP')
                    ->where('NME010', $send_mail['send_instruction_number'])
                    ->update(StringUtil::utf8ToSjis($prop_update));

                //メール送信記録ファイルの登録
                if ($is_send_mail && $send_mail['mail_category'] !== "9") {
                    $prop_insert = [
                        'NMIL010' => $send_mail['send_instruction_number'],
                        'NMIL020' => $send_mail['reservation_number'],
                        'NMIL030' => $send_mail['mail_category'],
                        'NMIL040' => $options['subject'],
                        'NMIL050' => $voss_mail->getBodyText(),
                        'NMIL060' => date("YmdHis") . substr(microtime(true)[1], 0, 3),
                        'NMIL070' => $send_mail['mail_address1'],
                        'NMIL071' => $send_mail['mail_address2'],
                        'NMIL072' => $send_mail['mail_address3'],
                        'NMIL073' => $send_mail['mail_address4'],
                        'NMIL074' => $send_mail['mail_address5'],
                        'NMIL075' => $send_mail['mail_address6'],
                        'NMIL080' => $send_mail['mail_format'],
                        'NMIL090' => $send_mail['net_user_number'],
                        'NMIL100' => $send_mail['travel_company_code'],
                        'NMIL110' => $send_mail['agent_code'],
                        'NMIL120' => $send_mail['agent_user_number'],
                        'NMIL130' => $send_mail['item_code'],
                    ];
                    \DB::table(config('database.libs.voss') . '.VOSNMILU')
                        ->insert(StringUtil::utf8ToSjis($prop_insert));
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                $this->logger->error('DB更新失敗');
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * メール本文用パラメータ作成処理
     * @param $send_mail
     * @return array
     */
    private function createViewParams($send_mail)
    {
        $view_params = [
            'send_mail' => $send_mail,
            'subject' => $send_mail['mail_title'],
        ];

        //旅行社メールヘッダー情報
        if ($send_mail['agent_user_number']) {
            $view_params['agent_mail_header'] = $this->mail_query->getAgentMailHeader(
                $send_mail['travel_company_code'],
                $send_mail['agent_code'],
                $send_mail['agent_user_number']);
        }

        // 予約見出し情報
        if ($send_mail['reservation_number']) {
            $reservation = $this->mail_query->getReservation($send_mail['reservation_number']);
            $reservation['boss_name'] = "";
            if ($reservation['passenger_last_knj'] && $reservation['passenger_first_knj']) {
                $reservation['boss_name'] = $reservation['passenger_last_knj'] . ' ' . $reservation['passenger_first_knj'] . ' 様';
            } elseif ($reservation['passenger_last_kana'] && $reservation['passenger_first_kana']) {
                $reservation['boss_name'] = $reservation['passenger_last_kana'] . ' ' . $reservation['passenger_first_kana'] . ' 様';
            } elseif ($reservation['passenger_last_eij'] && $reservation['passenger_first_eij']) {
                $reservation['boss_name'] = $reservation['passenger_last_eij'] . ' ' . $reservation['passenger_first_eij'] . ' 様';
            }
            $view_params['reservation'] = $reservation;
        }

        // 商品情報
        if ($send_mail['item_code']) {
            $view_params['item'] = $this->mail_query->getItem($send_mail['item_code']);
        }

        // 予約の客室情報
        if ($send_mail['cabin_line_number']) {
            $view_params['reservation_cabin'] = $this->mail_query->getReservationCabinByLineNumber($send_mail['reservation_number'], $send_mail['cabin_line_number']);
        }

        // 手仕舞いの客室タイプ
        if ($send_mail['close_cabin_types']) {
            $close_cabin_types = StringUtil::explodeByLength($send_mail['close_cabin_types'], 2);
            $view_params['close_cabins'] = $this->mail_query->getCabinsByTypes($send_mail['item_code'], $close_cabin_types);
        }

        // WT → HK客室
        if ($send_mail['hk_cabin_line_numbers']) {
            $hk_cabins = [];
            $hk_cabin_line_numbers = StringUtil::explodeByLength($send_mail['hk_cabin_line_numbers'], 3);
            foreach ($hk_cabin_line_numbers as $cabin_line_number) {
                $cabin = $this->mail_query->getReservationCabinByLineNumber($send_mail['reservation_number'], $cabin_line_number);
                $hk_cabins[$cabin['cabin_type'] . $cabin['fare_type']][] = $cabin;
            }
            $view_params['hk_cabins'] = $hk_cabins;
        }

        //フリーフォーマット本文の取得
        if ($send_mail['mail_text_manage_number']) {
            //valueが空の列は削除する
            $free_format_texts = $this->mail_query->getFreeText($send_mail['mail_text_manage_number']);
            $len = count($free_format_texts);
            for ($i = $len - 1; $i >= 0; $i--) {
                if ($free_format_texts[$i]['mail_detail'] === '') {
                    unset($free_format_texts[$i]);
                } else {
                    break;
                }
            }
            $view_params['free_format_texts'] = $free_format_texts;

            // フリーフォーマットメールは件名をフリーの内容に変更
            if ($send_mail['send_instruction_code'] === "F99") {
                $view_params['subject'] = array_get($free_format_texts, '0.mail_title');
            }
        }

        return $view_params;
    }

    /**
     * 宛先のメールアドレス作成処理
     * @param $send_mail
     * @return array
     */
    private function createTo($send_mail)
    {
        $ret = [];
        for ($i = 1; $i <= 6; $i++) {
            if ($send_mail['mail_address' . $i]) {
                $ret[] = $send_mail['mail_address' . $i];
            }
        }
        return $ret;
    }

    /**
     * 送信状況を判定します
     * @param $is_send_mail
     * @param $send_mail_retry_count
     * @return string
     */
    private function getSendCon($is_send_mail, $send_mail_retry_count)
    {
        if (($send_mail_retry_count + 1) >= config('mail.max_retry_count')) {
            return "C";
        } elseif ($is_send_mail) {
            return "F";
        } else {
            return "R";
        }
    }

    /**
     * サービス停止時に呼び出されます。
     */
    protected function onStop()
    {
    }
}