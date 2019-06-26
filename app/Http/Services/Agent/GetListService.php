<?php

namespace App\Http\Services\Agent;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossSessionManager;
use App\Queries\AgentQuery;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 販売店一覧の検索・表示するサービスです。
 * Class GetListService
 * @package App\Http\Services\Agent
 */
class GetListService extends BaseService
{

    /**
     * 販売店一覧のクエリ
     * @var AgentQuery
     */
    private $agent_query;


    /**
     * 初期化します。
     */
    public function init()
    {
        $this->agent_query = new AgentQuery();
    }

    /**
     * 処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        // 検索条件の設定
        $search_con = $this->getSearchCondition();
        $this->response_data['search_con'] = $search_con;

        // 検索結果の取得
        //販売店一覧情報取得
        $list =  $this->agent_query->findAll($search_con);
        $this->response_data['list'] = $list;

        //販売店一覧情報件数取得
        $list_count_all =  $this->agent_query->countAll($search_con);
        $this->response_data['list_count_all'] = $list_count_all['agent_count'];

        // ページャー作成
        $this->response_data['paginator'] = $this->getPaginator($list_count_all, $list, $search_con);
    }

    /**
     * 検索条件の設定した配列を返します。
     */
    private function getSearchCondition()
    {
        // 検索条件の設定
        $search_con = array_merge(
            config('const.search_con.agent_list'),
            VossSessionManager::get("agent_list", []),
            request('search_con',[]));

        $search_con = $search_con + array(
                "net_travel_company_code" => VossSessionManager::get('auth')['travel_company_code'],
                "agent_code" => VossSessionManager::get('auth')['agent_code']);

        VossSessionManager::set("agent_list", $search_con);


        return $search_con;
    }

    /**
     * ページングを生成するページャクラスを返します。
     * @param $list_count_all
     * @param $search_result
     * @param $search_con
     * @return LengthAwarePaginator
     */

    private function getPaginator($list_count_all,$search_result, $search_con)
    {
        $list = $search_result;
        $total =$list_count_all['agent_count'];
        $disp_limit = 10;
        $current_page = $search_con['page'];
        $option = [
            'path' => ext_route('list'),
            'query' => ['search_con' => array_except($search_con, 'page')],
            'pageName' => 'search_con[page]'];
        return new LengthAwarePaginator($list, $total, $disp_limit, $current_page, $option);
    }

}