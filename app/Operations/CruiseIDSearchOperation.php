<?php

namespace App\Operations;

/**
 * クルーズID検索のソケットメッセージクラスです。
 * @package App\Operations
 */
class CruiseIDSearchOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('312');
    }

    /**
     * 要求パラメータ 出発日始めをセットします。
     * @param string $departure_date
     */
    public function setDepartureDate($departure_date)
    {
        $this->set(8, 43, $departure_date);
    }

    public function parseResponse()
    {
        $response = [];
        $response['cruise_ids'] = [];
        for ($i = 0; $i < 100; $i++) {
            $cruise_id = trim($this->parse(8, $i * 8 + 16));
            if ($cruise_id) {
                $response['cruise_ids'][] = $cruise_id;
            }
        }
        $response['inquiry_date_time'] = $this->parse(14, 816);
        return $response;
    }

}