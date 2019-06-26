<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Operations\PassengerDetailChangeOperation;


/**
 * ご乗船者詳細入力の更新のサービスです。
 *
 * Class PostPassengerService
 * @package App\Http\Services\Reservation\Input
 */
class PostPassengerService extends BaseService
{
    /**
     * @var string
     */
    private $reservation_number;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        if (!$this->sendPassengerDetailChangeOperation()) {
            return;
        }
        $this->response_data['redirect'] = ext_route('reservation.input.passenger_request', ['reservation_number' => $this->reservation_number]);
    }

    /**
     * 乗船者詳細情報変更ソケット通信
     * @return bool
     */
    private function sendPassengerDetailChangeOperation()
    {
        $operation = new PassengerDetailChangeOperation();

        // 開始データ
        $operation->setRecordType('1');
        $operation->setReservationNumber($this->reservation_number);
        $operation_result1 = $operation->execute();
        if ($operation_result1['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result1['event_number']);
            return false;
        }

        foreach (request('passengers') as $display_line_number => $passenger) {
            // データ
            $operation->reset();
            $operation->setRecordType('2');
            $operation->setTempWorkManagementNumber($operation_result1['temp_work_management_number']);
            $operation->setReservationNumber($this->reservation_number);
            $operation->setPassengerLineNumber($passenger['passenger_line_number']);
            $operation->setDisplayLineNumber($display_line_number);
            $operation->setPassengerLastEij($passenger['passenger_last_eij']);
            $operation->setPassengerFirstEij($passenger['passenger_first_eij']);
            $operation->setPassengerLastKnj($passenger['passenger_last_knj']);
            $operation->setPassengerFirstKnj($passenger['passenger_first_knj']);
            $operation->setPassengerLastKana($passenger['passenger_last_kana']);
            $operation->setPassengerFirstKana($passenger['passenger_first_kana']);
            $operation->setGender($passenger['gender']);
            $operation->setBirthDate($passenger['birth_date']);
            $operation->setWeddingAnniversary($passenger['wedding_anniversary']);
            $operation->setZipCode($passenger['zip_code']);
            $operation->setPrefectureCode($passenger['prefecture_code']);
            $operation->setAddress1($passenger['address1']);
            $operation->setAddress2($passenger['address2']);
            $operation->setAddress3($passenger['address3']);
            $operation->setTel1($passenger['tel1']);
            $operation->setTel2($passenger['tel2']);
            $operation->setEmergencyContactName($passenger['emergency_contact_name']);
            $operation->setEmergencyContactKana($passenger['emergency_contact_kana']);
            $operation->setEmergencyContactTel($passenger['emergency_contact_tel']);
            $operation->setEmergencyContactRelationship($passenger['emergency_contact_relationship']);
            $operation->setCountryCode($passenger['country_code']);
            $operation->setResidenceCode($passenger['residence_code']);
            $operation->setPassportNumber($passenger['passport_number']);
            $operation->setPassportIssuedDate($passenger['passport_issued_date']);
            $operation->setPassportIssuedPlace($passenger['passport_issued_place']);
            $operation->setPassportLoseDate($passenger['passport_lose_date']);

            if (VossAccessManager::isUserSite()) {
                // TODO:個人向けサイト
                $operation->setLinkId($passenger['link_id']);
            }

            $operation_result2 = $operation->execute();
            if ($operation_result2['status'] === 'E') {
                $this->setSocketErrorMessages($operation_result2['event_number']);
                return false;
            }
        }

        // 終了
        $operation->reset();
        $operation->setRecordType('9');
        $operation->setReservationNumber($this->reservation_number);
        $operation->setTempWorkManagementNumber($operation_result1['temp_work_management_number']);
        $operation->setLastUpdateDateTime(request('last_update_date_time'));
        $operation_result9 = $operation->execute();
        if ($operation_result9['status'] === 'E') {
            $this->setSocketErrorMessages($operation_result9['event_number']);
            return false;
        }
        return true;
    }
}