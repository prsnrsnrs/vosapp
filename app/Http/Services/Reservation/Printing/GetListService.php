<?php

namespace App\Http\Services\Reservation\Printing;

use App\Libs\DateUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CruiseIDSearchOperation;
use App\Queries\PrintingQuery;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;

/**
 * 乗船券控え・確認書の印刷画面のサービスです
 *
 * Class GetListService
 * @package App\Http\Services\Reservation\Printing
 */
class GetListService extends BaseService
{
    /**
     * @var ReservationQuery
     */
    private $reservation_query;
    /**
     * @var PrintingQuery
     */
    private $printing_query;
    /**
     * @var
     */
    private $mode;

    /**
     * 初期化します
     */
    protected function init()
    {
        $this->reservation_query = new ReservationQuery();
        $this->printing_query = new PrintingQuery();
        $this->mode = $this->getMode();
    }

    /**
     * サービスの処理を実行します
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // 画面モードを取得
        $this->response_data['is_site'] = $this->mode;

        // パンくず取得
        $this->response_data['breadcrumbs'] = $this->getBreadCrumbs();

        // 検索条件を取得
        $search_con = $this->getSearchCondition();
        $this->response_data['search_con'] = $search_con;

        // クルーズIDソケット
        $operation = new CruiseIDSearchOperation();
        $operation->setDepartureDate(DateUtil::getTwoMonthBefore());
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }

        //クルーズ名(コース)の取得：検索条件のクルーズ名(コース)のドロップダウン
        $cruises = $this->reservation_query->findItemByCruiseIDs($result['cruise_ids']);
        $this->response_data['cruises'] = $cruises;

        // 一覧を取得
        //入力された検索条件の値に、例外がある場合は０件を返す
        try {
            $reservations = $this->getList($search_con);
        } catch (\Exception $e) {
            $reservations = [];
        }
        $this->response_data['reservations'] = $reservations;
    }

    /**
     * 現在の画面モードを取得します
     * @return array
     */
    private function getMode()
    {
        $mode = [
            'agent' => VossAccessManager::isAgentSite(),
            'agent_test' => VossAccessManager::isAgentTestSite(),
            'user' => VossAccessManager::isUserSite()
        ];

        return $mode;
    }

    /**
     * パンくずを取得します
     * @return array
     */
    private function getBreadCrumbs()
    {
        $return_param = request('return_param');
        if ($return_param) {
            VossSessionManager::set("return_param", array_merge(
                config('const.return_param'),
                request('return_param')
            ));
        }

        $return_param = VossSessionManager::get('return_param');

        // サイト名を取り除く
        $return_route = substr($return_param['route_name'], strcspn($return_param['route_name'], '.') + 1);

        $breadcrumbs = [];
        $breadcrumbs[] = ['name' => 'マイページ', 'url' => ext_route('mypage')];
        if ($return_route === 'reservation.detail') {
            $breadcrumbs[] = ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list')];
            $breadcrumbs[] = [
                'name' => '予約照会',
                'url' => ext_route('reservation.detail', ['reservation_number' => $return_param['reservation_number']])
            ];
        } else if ($return_route === 'reservation.reception.list') {
            $breadcrumbs[] = ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list')];
        }
        $breadcrumbs[] = ['name' => '乗船券控えと各種確認書の印刷'];

        return $breadcrumbs;
    }

    /**
     *　検索条件を取得します
     * @return array
     */
    private function getSearchCondition()
    {
        //検索条件の初期値に出発日fromをマージ※本番環境でシステム日付が取得できないため
        $default_departure_date_from = array('departure_date_from' => DateUtil::now());
        $default_search_con = array_merge(
            config('const.search_con.reservation_printing_list'),
            $default_departure_date_from
        );

        //出発日がブランクの時は、システム日付をセットする
        $request = request('search_con', []);
        if ($request && $request['departure_date_from'] == "") {
            $request['departure_date_from'] = DateUtil::now();
        }

        // 検索条件の設定
        $search_con = array_merge(
            $default_search_con,
            VossSessionManager::get("reservation_printing_list", []),
            $request
        );
        VossSessionManager::set("reservation_printing_list", $search_con);
        $search_con = $search_con + array(
                "net_travel_company_code" => VossSessionManager::get('auth')['travel_company_code'],
                "agent_code" => VossSessionManager::get('auth')['agent_code']);

        return $search_con;
    }

    /**
     * 一覧情報を取得します
     * @param $search_con
     * @return array
     */
    private function getList($search_con)
    {
        $reservations = [];

        if ($this->mode['agent'] || $this->mode['agent_test']) {

            // 乗船券控えと各種確認書の印刷検索一覧情報の取得
            $item_reservations = $this->printing_query->findAll($search_con);
            $collections = new Collection($item_reservations);
            $reservations = $collections->groupBy('reservation_number')->toArray();

        } else if ($this->mode['user']) {

            // TODO：フェーズ２（個人）乗船券控えと各種確認書の印刷検索一覧情報の取得

        }

        return $reservations;
    }
}


