<?php

namespace App\Http\Services\Reservation\Contact;

use App\Http\Services\BaseService;
use App\Libs\DateUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CruiseIDSearchOperation;
use App\Queries\ContactQuery;
use App\Queries\ReservationQuery;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * ご連絡閲覧のサービスです。
 * Class GetDetailService
 * @package App\Http\Services\Reservation\Contact
 */
class GetDetailService extends BaseService
{
    /**
     * @var ContactQuery
     */
    private $contact_query;
    /**
     * @var string
     */
    private $mail_send_instruction_number;
    /**
     * @var string
     */
    private $travel_company_code;
    /**
     * @var string
     */
    private $agent_code;
    /**
     * @var boolean
     */
    private $is_jurisdiction_agent;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->contact_query = new ContactQuery();
        $this->mail_send_instruction_number = request('mail_send_instruction_number');
        $session_login = VossSessionManager::get('auth');
        $this->travel_company_code = $session_login['travel_company_code'];
        $this->agent_code = $session_login['agent_code'];
        $this->is_jurisdiction_agent = VossAccessManager::isJurisdictionAgent($session_login);
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //ご連絡閲覧情報の取得
        $user_info = [
            'mail_send_instruction_number' => $this->mail_send_instruction_number,
            'travel_company_code' => $this->travel_company_code,
            'agent_code' => $this->agent_code
        ];
        $contact_detail = $this->contact_query->getMailDetail($user_info);
        //取得できなかった場合は404エラー画面に遷移します。
        if (count($contact_detail) == 0) {
            throw new NotFoundHttpException();
        }

        $send_mail_addresses = $this->formatMailAddress($contact_detail);
        $this->response_data['send_mail_addresses'] = $send_mail_addresses;
        $this->response_data['contact_detail'] = $contact_detail;
    }


    /**
     * 取得してきたメールアドレスをカンマ区切りに成形
     * @param $contact_detail
     * @return string
     */
    private function formatMailAddress($contact_detail)
    {
        //取得してきたメールアドレス1～6の中から空のデータは削除
        for ($i = 1; $i <= 6; $i++) {
            if ($contact_detail['send_mail_address' . "$i"]) {
                $mail_addresses[$i] = $contact_detail['send_mail_address' . "$i"];
            } else {
                continue;
            }
        }
        $format_mail_address = implode(" , ", $mail_addresses);
        return $format_mail_address;
    }
}