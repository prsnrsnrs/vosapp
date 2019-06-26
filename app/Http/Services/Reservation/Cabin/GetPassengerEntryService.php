<?php

namespace App\Http\Services\Reservation\Cabin;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;


/**
 * ご乗船者名入力のサービスです
 *
 * Class GetPassengerEntryService
 * @package App\Http\Services\Reservation\Cabin
 */
class GetPassengerEntryService extends BaseService
{

    const MODE_EDIT = 'edit';

    const MODE_NEW = 'new';


    /**
     * @var array
     */
    private $reservation_number;
    /**
     * @var array
     */
    private $temp_reservation_number;
    /**
     * @var string
     */
    private $mode;


    /**
     * サービスを初期化します
     */
    protected function init()
    {
        // パラメーターの初期化
        $this->reservation_number = VossSessionManager::get('reservation_cabin.reservation_number');
        $this->temp_reservation_number = VossSessionManager::get('reservation_cabin.temp_reservation_number');
        $this->mode = $this->getMode();
    }

    /**
     * サービスの処理を実行します
     * @return mixed|void
     */
    public function execute()
    {
        $this->response_data['mode'] = $this->mode;

        // パンくず取得
        $this->response_data['breadcrumbs'] = $this->getBreadCrumbs();
        // ユーザー向けサイト判定
        $this->response_data['user_site'] = VossAccessManager::isUserSite();
        // キャンセル時のリダイレクト先取得
        $this->response_data['redirect'] = $this->getCancelRedirect();

        // TODO:個人向け 登録済ドロップダウン情報の取得

        // 商品情報の取得
        $reservation_query = new ReservationQuery();
        $this->response_data['item'] = $reservation_query->getReservationByNumber($this->temp_reservation_number);

        // 客室・乗船者情報の取得
        $reservation_details = $reservation_query->findReservationDetailsByNumber($this->temp_reservation_number);

        //客室数の取得
        $cabins_count = $reservation_query->countCabinsByNumber($this->temp_reservation_number);
        $this->response_data['cabins_count'] = $cabins_count['cabins_count'];

        // データ整形
        $format_reservation_details = $this->formatDetails($reservation_details);
        $this->response_data['cabins'] = $format_reservation_details['cabins'];
        $this->response_data['has_waiting'] = $format_reservation_details['has_waiting'];
    }

    /**
     * 画面モードを返します
     * @return string
     */
    private function getMode()
    {
        $mode = '';
        if ($this->temp_reservation_number && !$this->reservation_number) {
            $mode = self::MODE_NEW;
        } elseif ($this->temp_reservation_number && $this->reservation_number) {
            $mode = self::MODE_EDIT;
        }
        return $mode;
    }

    /**
     * ご乗船者・客室ごとに振り分け、キャンセル待ちが含まれているかチェックします
     * @param array $reservation_details
     * @return array
     */
    private function formatDetails($reservation_details)
    {
        // 客室行ごとにグループ分け
        $collection_details = new Collection($reservation_details);
        $group_by_cabins = $collection_details->groupBy('cabin_line_number');

        $cabins_line_number = [];
        $has_waiting = false;

        foreach ($group_by_cabins as $group) {
            // 一階層深いので浅くする
            $cabins['cabin'] = $group->first();
            $cabins['passengers'] = $group->toArray();

            // 編集モードかつ、客室のステータスがキャンセル待ちの場合、客室タイプを変更するか確認
            if ($this->mode === self::MODE_EDIT && $cabins['cabin']['reservation_status'] === config('const.reservation_status.value.wait')) {
                $has_waiting = true;
            }

            $cabins_line_number[] = $cabins;
        }

        return ['cabins' => $cabins_line_number, 'has_waiting' => $has_waiting];
    }


    /**
     * パンくずを返します
     * @return array $breadcrumbs
     */
    private function getBreadCrumbs()
    {
        $breadcrumbs = [];
        if ($this->mode === self::MODE_NEW) {
            $breadcrumbs = [
                ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search'), 'confirm' => true],
                ['name' => 'ご乗船者名入力']
            ];
        } elseif ($this->mode === self::MODE_EDIT) {
            $breadcrumbs = [
                ['name' => 'マイページ', 'url' => ext_route('mypage'), 'confirm' => true],
                ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list'), 'confirm' => true],
                ['name' => '予約照会',
                    'url' => ext_route('reservation.detail', [
                        'reservation_number' => VossSessionManager::get('reservation_cabin.reservation_number')]),
                    'confirm' => true
                ],
                ['name' => 'ご乗船者名入力']
            ];
        }

        return $breadcrumbs;
    }


    /**
     * 予約取消または入力取消時のリダイレクト先を返します
     * @return string $redirect
     */
    private function getCancelRedirect()
    {
        $redirect = '';
        if ($this->mode === self::MODE_NEW) {
            // 新規予約時
            if (VossAccessManager::isAgentSite()) {
                $redirect = ext_route('cruise_plan.search');
            } else if (VossAccessManager::isUserSite()) {
                $redirect = ext_route('mypage');
            }
        } elseif ($this->mode === self::MODE_EDIT) {
            // 予約変更時
            $redirect = ext_route('reservation.detail', ['reservation_number' => VossSessionManager::get('reservation_cabin.reservation_number')]);
        }

        return $redirect;
    }


}