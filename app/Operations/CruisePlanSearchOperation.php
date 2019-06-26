<?php

namespace App\Operations;

/**
 * クルーズプラン検索のソケットメッセージクラスです。
 * @package App\Operations
 */
class CruisePlanSearchOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('311');
    }

    /**
     * 要求パラメータ 商品コードをセットします。
     * @param string $item_code
     */
    public function setItemCode($item_code)
    {
        $this->set(11, 43, $item_code);
    }

    /**
     * 要求パラメータ 出発日始めをセットします。
     * @param string $departure_date_from
     */
    public function setDepartureDateFrom($departure_date_from)
    {
        $this->set(8, 54, $departure_date_from, ['right' => false, 'padding' => '0']);
    }

    /**
     * 要求パラメータ 出発日終わりをセットします。
     * @param string $departure_date_to
     */
    public function setDepartureDateTo($departure_date_to)
    {
        $this->set(8, 62, $departure_date_to, ['right' => false, 'padding' => '0']);
    }

    /**
     * 要求パラメータ クルーズIDをセットします。
     * @param string $cruise_id
     */
    public function setCruiseID($cruise_id)
    {
        $this->set(8, 70, $cruise_id);
    }

    /**
     * 要求パラメータ 出発地コードをセットします。
     * @param string $port_code
     */
    public function setDeparturePortCode($port_code)
    {
        $this->set(6, 78, $port_code);
    }

    /**
     * 要求パラメータ 要求ページをセットします。
     * @param string $page
     */
    public function setPage($page)
    {
        $this->set(3, 84, $page, ['right' => false, 'padding' => '0']);
    }


    public function parseResponse()
    {
        $response = [
            'cabin_types' => [],
            'results' => [],
            'page' => (int)$this->parse(3, 486),
            'total' => (int)$this->parse(4, 489),
            'inquiry_date_time' => $this->parse(14, 493),
        ];

        // 客室タイプコード 12桁 x 15
        for ($i = 0; $i < 15; $i++) {
            $cabin_type = trim($this->parse(12, $i * 12 + 16));
            if ($cabin_type) {
                $response['cabin_types'][] = $cabin_type;
            }
        }

        // 商品コード + 空室状況 + 予約件数
        $cabin_type_count = count($response['cabin_types']);
        for ($i = 0; $i < 10; $i++) {
            $cabin_type = [];
            $start = 29 * $i + 196;
            $cabin_type['item_code'] = trim($this->parse(11, $start));
            if (!$cabin_type['item_code']) {
                break;
            }
            $cabin_type['vacancies'] = [];
            for ($j = 0; $j < $cabin_type_count; $j++) {
                $cabin_type['vacancies'][] = $this->parse(1, $start + 11 + ($j * 1));
            }
            $cabin_type['reservation_count'] = (int)$this->parse(3, $start + 26);
            $response['results'][] = $cabin_type;
        }

        return $response;
    }

}