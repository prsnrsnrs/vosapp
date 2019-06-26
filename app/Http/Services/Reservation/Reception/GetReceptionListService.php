<?php

namespace App\Http\Services\Reservation\Reception;

use App\Http\Services\BaseService;
use App\Libs\DateUtil;
use App\Libs\Voss\VossAccessManager;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CruiseIDSearchOperation;
use App\Queries\ReceptionQuery;
use App\Queries\ReservationQuery;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * 受付一覧のサービスです。
 * Class GetReceptionListService
 * @package App\Http\Services\Reservation\Reception
 */
class GetReceptionListService extends BaseService
{
    /**
     * @var ReservationQuery
     */
    private $reservation_query;
    /**
     * @var ReceptionQuery
     */
    private $reception_query;


    /**
     * サービスを初期化します。
     */
    public function init()
    {
        $this->reservation_query = new ReservationQuery();
        $this->reception_query = new ReceptionQuery();
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // パンくず取得
        $this->response_data['breadcrumbs'] = $this->getBreadCrumbs();

        //アクセス中のユーザー種別の取得
        $this->response_data['is_agent_site'] = VossAccessManager::isAgentSite();
        $this->response_data['is_agent_test_site'] = VossAccessManager::isAgentTestSite();


        //検索結果ヘッダータイトルに表示するログイン情報の取得
        $session_login = VossSessionManager::get('auth');
        $this->response_data['travel_company_name'] = $session_login['travel_company_name'];;
        $this->response_data['agent_name'] = $session_login['agent_name'];

        //検索条件の設定
        $search_con = $this->getSearchCon();
        $this->response_data['search_con'] = $search_con;

        //クルーズID検索ソケット
        $operation = new CruiseIDSearchOperation();
        $operation->setDepartureDate(DateUtil::getThreeMonthBefore());
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }

        //クルーズ名(コース)の取得：検索条件のクルーズ名(コース)のドロップダウン
        $cruises = $this->reservation_query->findItemByCruiseIDs($result['cruise_ids']);
        $this->response_data['cruises'] = $cruises;

        //受付一覧情報の取得
        //入力された検索条件の値に、例外があった場合は、０件の検索結果を返します。
        try {
            $reservations = $this->reception_query->findAll($search_con);
        } catch (\Exception $e) {
            $this->response_data['reservations'] = [];
            $this->response_data['reception_count_all'] = "0";
            return;
        }
        $this->response_data['reservations'] = $reservations;

        //受付一覧カウント数の取得
        //取得結果が０件だった場合は0を返し、ページャー作成を行わない
        $reception_count_all = $this->reception_query->countAll($search_con);
        if ($reception_count_all['reservation_count'] === "0") {
            $this->response_data['reception_count_all'] = "0";
            return;
        }
        $this->response_data['reception_count_all'] = $reception_count_all['reservation_count'];

        // ページャー作成
        $this->response_data['paginator'] = $this->getpaginator($reception_count_all, $reservations, $search_con);
    }

    /**
     * 検索条件を返します。
     * @return array
     */
    private function getSearchCon()
    {
        //検索条件の初期値に出発日fromをマージ※本番環境でシステム日付が取得できないため
        $default_departure_date_from = array('departure_date_from' => DateUtil::now());
        $default_search_con = array_merge(
            config('const.search_con.reservation_reception_list'),
            $default_departure_date_from
        );

        //出発日がブランクの時は、システム日付をセットする
        $request = request('search_con', []);
        if ($request && $request['departure_date_from'] == "") {
            $request['departure_date_from'] = DateUtil::now();
        }

        //検索条件の設定
        $search_con = array_merge(
            $default_search_con,
            VossSessionManager::get("reception_list_search", []),
            $request
        );
        VossSessionManager::set("reception_list_search", $search_con);
        $search_con = $search_con + array(
                "net_travel_company_code" => VossSessionManager::get('auth')['travel_company_code'],
                "agent_code" => VossSessionManager::get('auth')['agent_code']);

        return $search_con;
    }

    /**
     * ページングを生成するページャクラスを返します。
     * @param $reception_count_all
     * @param $reservations
     * @param $search_con
     * @return LengthAwarePaginator
     */
    private function getpaginator($reception_count_all, $reservations, $search_con)
    {
        $list = $reservations;
        $total = $reception_count_all['reservation_count'];
        $disp_limit = 10;
        $current_page = $search_con['page'];
        $option = [
            'path' => ext_route('reservation.reception.list'),
            'query' => ['search_con' => array_except($search_con, 'page')],
            'pageName' => 'search_con[page]'];

        return new LengthAwarePaginator($list, $total, $disp_limit, $current_page, $option);
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

        if ($return_route === 'cruise_plan.search') {
            $breadcrumbs[] = ['name' => 'クルーズプラン検索', 'url' => ext_route('cruise_plan.search')];
        } else if ($return_route === 'reservation.import.result') {
            $breadcrumbs[] = ['name' => '取込予約一覧', 'url' => ext_route('reservation.import.file_select')];
        }

        $breadcrumbs[] = ['name' => '受付一覧'];

        return $breadcrumbs;
    }
}