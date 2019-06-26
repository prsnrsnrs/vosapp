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


/**
 * ご連絡一覧のサービスです。
 * Class GetListService
 * @package App\Http\Services\Reservation\Contact
 */
class GetListService extends BaseService
{
    /**
     * @var ReservationQuery
     */
    private $reservation_query;
    /**
     * @var ContactQuery
     */
    private $contact_query;

    /**
     * サービスを初期化します。
     */
    protected function init()
    {
        $this->reservation_query = new ReservationQuery();
        $this->contact_query = new ContactQuery();
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

        //旅行社の管轄店か判別
        $this->response_data['is_jurisdiction_agent'] = VossAccessManager::isJurisdictionAgent();

        //旅行社向けサイトか判別
        $this->response_data['is_agent_site'] = VossAccessManager::isAgentSite();
        $this->response_data['is_agent_test_site'] = VossAccessManager::isAgentTestSite();

        //検索条件の設定
        $search_con = $this->getSearchCon();
        $this->response_data['search_con'] = $search_con;

        //クルーズID検索ソケット
        $operation = new CruiseIDSearchOperation();
        $operation->setDepartureDate(DateUtil::getOneMonthBefore());
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }

        //クルーズ名(コース)の取得：検索条件のクルーズ名(コース)のドロップダウン
        $cruises = $this->reservation_query->findItemByCruiseIDs($result['cruise_ids']);
        $this->response_data['cruises'] = $cruises;

        //ご連絡一覧情報の取得
        try {
            $contacts = $this->contact_query->findAll($search_con);
        } catch (\Exception $e) {
            $this->response_data['contacts'] = [];
            $this->response_data['contact_all_count'] = "0";
            return;
        }
        $this->response_data['contacts'] = $contacts;

        //ご連絡一覧カウント数の取得
        $contact_all_count = $this->contact_query->countAll($search_con);
        if ($contact_all_count['contact_count'] === "0") {
            $this->response_data['contact_all_count'] = "0";
            return;
        }
        $this->response_data['contact_all_count'] = $contact_all_count['contact_count'];

        // ページャー作成
        $this->response_data['paginator'] = $this->getpaginator($contact_all_count, $contacts, $search_con);
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
            config('const.search_con.reservation_contact_list'),
            $default_departure_date_from
        );

        $request = request('search_con', []);
        //ソート順を変更するときは、出発日にセッション情報を格納する。
        if ($request && !isset($request['departure_date_from'])) {
            $request['departure_date_from'] = VossSessionManager::get('contact_list_search')['departure_date_from'];
        }
        //出発日がブランクの時は、システム日付をセットする
        if ($request && $request['departure_date_from'] == "") {
            $request['departure_date_from'] = DateUtil::now();
        }

        //検索条件の設定
        $search_con = array_merge(
            $default_search_con,
            VossSessionManager::get('contact_list_search', []),
            $request
        );
        VossSessionManager::set('contact_list_search', $search_con);

        //検索条件の中にユーザー情報を格納
        $search_con = $search_con + array(
                "net_travel_company_code" => VossSessionManager::get('auth')['travel_company_code'],
                "agent_code" => VossSessionManager::get('auth')['agent_code'],
                "agent_user_number" => VossSessionManager::get('auth')['agent_user_number']
            );

        return $search_con;
    }

    /**
     * ページングを生成するページャクラスを返します。
     * @param $contact_all_count
     * @param $contacts
     * @param $search_con
     * @return LengthAwarePaginator
     */
    private function getpaginator($contact_all_count, $contacts, $search_con)
    {
        $list = $contacts;
        $total = $contact_all_count['contact_count'];
        $disp_limit = 10;
        $current_page = $search_con['page'];
        $option = [
            'path' => ext_route('reservation.contact.list'),
            'query' => ['search_con' => array_except($search_con, 'page')],
            'pageName' => 'search_con[page]'
        ];

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

        if ($return_route === 'reservation.detail') {
            $breadcrumbs[] = ['name' => '受付一覧', 'url' => ext_route('reservation.reception.list')];
            $breadcrumbs[] = [
                'name' => '予約照会',
                'url' => ext_route('reservation.detail', ['reservation_number' => $return_param['reservation_number']])
            ];
        } else {
            if ($return_route === 'reservation.reception.list') {
                $breadcrumbs[] = [
                    'name' => '受付一覧',
                    'url' => ext_route('reservation.reception.list',
                        ['reservation_number' => $return_param['reservation_number']])
                ];
            }
        }
        $breadcrumbs[] = ['name' => 'ご連絡一覧'];

        return $breadcrumbs;
    }
}