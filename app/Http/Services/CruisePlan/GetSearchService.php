<?php

namespace App\Http\Services\CruisePlan;

use App\Http\Services\BaseService;
use App\Libs\DateUtil;
use App\Libs\Voss\VossSessionManager;
use App\Operations\CruiseIDSearchOperation;
use App\Operations\CruisePlanSearchOperation;
use App\Queries\ReservationQuery;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * クルーズプラン検索のサービスです
 * Class GetSearchService
 * @package App\Http\Services\CruisePlan
 */
class GetSearchService extends BaseService
{
    /**
     * @var ReservationQuery
     */
    private $reservation_query;

    /**
     * 初期化します。
     */
    protected function init()
    {
        $this->reservation_query = new ReservationQuery();
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     * @throws \Exception
     */
    public function execute()
    {
        // 検索条件の設定
        $search_con = $this->getSearchCon();
        $this->response_data['search_con'] = $search_con;

        // クルーズID検索のソケット通信
        $operation = new CruiseIDSearchOperation();
        $operation->setDepartureDate(DateUtil::getTomorrow());
        $result = $operation->execute();
        if ($result['status'] === 'E') {
            $this->setSocketErrorMessages($result['event_number']);
            return;
        }

        // クルーズ名の取得
        $this->response_data['cruises'] = $this->reservation_query->findByCruiseIDs($result['cruise_ids']);
        // 出発地の取得
        $this->response_data['departures'] = $this->reservation_query->getDeparturesByCruiseIDs($result['cruise_ids']);

        //入力された検索条件を判定し、例外なら検索結果０件を返します。
        $search_result = $this->checkSearchCon($search_con);
        $this->response_data['search_result'] = $search_result;
        if ($search_result['status'] === 'E') {
            $this->response_data['item_count'] = 0;
            return;
        };

        //取得件数
        $this->response_data['item_count'] = $search_result['total'];

        // クルーズプラン検索結果の取得
        $item_codes = array_pluck($this->response_data['search_result']['results'], 'item_code');
        if ($item_codes) {
            $items = $this->reservation_query->findCruiseByItemCodes($item_codes);
            foreach ($this->response_data['search_result']['results'] as &$result) {
                foreach ($items as $item) {
                    if ($result['item_code'] === $item['item_code']) {
                        $result['item'] = $item;
                        break;
                    }
                }
            }
        }

        // ページャー作成
        $this->response_data['paginator'] = $this->getPaginator($search_result, $search_con);
    }

    /**
     * 検索条件の設定した配列を返します。
     */
    private function getSearchCon()
    {
        //検索条件の初期値に出発日fromをマージ
        $default_departure_date_from = array('departure_date_from' => DateUtil::getTomorrow());
        $default_search_con = array_merge(
            config('const.search_con.cruise_plan_search'),
            $default_departure_date_from
        );

        // 検索条件の設定
        $search_con = array_merge(
            $default_search_con,
            VossSessionManager::get("cruise_plan_search_con", []),
            request('search_con', [])
        );
        VossSessionManager::set("cruise_plan_search_con", $search_con);
        return $search_con;
    }

    /**
     * 検索時の例外をキャッチし、検索結果0件を返します。
     * @param $search_con
     */
    private function checkSearchCon($search_con)
    {
        try {
            // クルーズプラン検索のソケット通信
            $operation = new CruisePlanSearchOperation();
            $operation->setItemCode($search_con['item_code']);
            $operation->setDepartureDateFrom($search_con['departure_date_from']);
            $operation->setDepartureDateTo($search_con['departure_date_to']);
            $operation->setDeparturePortCode($search_con['departure_port_code']);
            $operation->setCruiseID($search_con['cruise_id']);
            $operation->setPage($search_con['page']);
            $search_result = $operation->execute();
            $this->response_data['search_result'] = $search_result;
            if ($search_result['status'] === 'E') {
                $this->setSocketErrorMessages($search_result['event_number']);
            }

        } catch (\Exception $e) {
            // 例外発生時は、検索結果 0件とする。
            $search_result = [
                'results' => [],
                'cabin_types' => [],
                'total' => 0,
                'status' => 'E',
                'inquiry_date_time' => DateUtil::nowDateTime()
            ];
        }
        return $search_result;

    }

    /**
     * ページングを生成するページャクラスを返します。
     * @param $search_result
     * @param $search_con
     * @return LengthAwarePaginator
     */
    private function getPaginator($search_result, $search_con)
    {
        $list = $search_result['results'];
        $total = $search_result['total'];
        $disp_limit = 10;
        $current_page = $search_con['page'];
        $option = [
            'path' => ext_route('cruise_plan.search'),
            'query' => ['search_con' => array_except($search_con, 'page')],
            'pageName' => 'search_con[page]'];

        return new LengthAwarePaginator($list, $total, $disp_limit, $current_page, $option);
    }
}