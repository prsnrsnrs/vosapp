<?php

namespace App\Http\Services\Reservation\Contact;


use App\Http\Services\BaseService;
use App\Queries\ContactQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * i5専用のメール確認サービスです。
 * Class GetDetailForApsService
 * @package App\Http\Services\Reservation\Contact
 */
class GetDetailForApsService extends BaseService
{
    /**
     * メール内容取得クエリ
     * @var ContactQuery
     */
    private $query;

    /**
     * メール送信指示No
     * @var string
     */
    private $mail_send_instruction_number;


    /**
     * サービスを初期化処理を実行します。
     */
    protected function init()
    {
        //コンタクトクエリより取得
        $this->query = new ContactQuery();

        //リクエストから取得?
        $this->mail_send_instruction_number = request('mail_send_instruction_number');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //メール情報を取得
        $user_info['mail_send_instruction_number'] =$this->mail_send_instruction_number;
        $mail_detail = $this->query->getMailDetail($user_info);
        $this->response_data['contact_detail'] = $mail_detail;

        //メール内容を取得できない場合
        if (count($mail_detail) == 0) {
            //404エラー画面を返す
            throw new NotFoundHttpException();
        }

        //メールアドレス情報を取得
        $send_mail_addresses　 = $this->formatMailAddress($mail_detail);
        $this->response_data['send_mail_addresses'] = $send_mail_addresses　;
    }


    /**
     * 取得してきたメールアドレスをカンマ区切りに整形
     */
    private function formatMailAddress($contact_detail)
    {
        //空データを排除
        for ($i = 1; $i <= 6; $i++) {
            if ($contact_detail['send_mail_address' . "$i"]) {
                $mail_addresses[$i] = $contact_detail['send_mail_address' . "$i"];
            } else {
                continue;
            }
        }
        //カンマ区切り
        $format_mail_address = implode(" , ", $mail_addresses);
        return $format_mail_address;
    }
}