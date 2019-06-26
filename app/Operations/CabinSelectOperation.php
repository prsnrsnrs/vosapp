<?php

namespace App\Operations;

/**
 * 客室タイプ選択ソケットのメッセージクラスです。
 * @package App\Operations
 */
class CabinSelectOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('321');
    }

    /**
     * 要求パラメータ 商品コードをセットします。
     * @param string $departure_date
     */
    public function setItemCode($item_code)
    {
        $this->set(11, 43, $item_code);
    }

    /**
     * 要求パラメータ 客室タイプコードをセットします。
     * @param $cabin_type
     */
    public function setCabinTypeCode($cabin_type_code)
    {
        $this->set(2, 54, $cabin_type_code);
    }


    public function parseResponse()
    {
        $response = [
            'price' => [],
            'vacancy_status' => trim($this->parse(1, 256)),
            'min_count' => trim($this->parse(1, 257)),
            'max_count' => trim($this->parse(1, 258)),
            'inquiry_date_time' => trim($this->parse(14, 259))
        ];

        $passenger = [];
        for ($i = 0; $i < 5; $i++) {
            $temp_passenger = [
                trim($this->parse(3, 16 + (48 * $i))) => [
                    '3' => [
                        'adult' => trim($this->parse(9, 19 + (48 * $i))),
                        'children' => trim($this->parse(9, 28 + (48 * $i)))
                    ],
                    '2' => [
                        'adult' => trim($this->parse(9, 37 + (48 * $i))),
                        'children' => trim($this->parse(9, 46 + (48 * $i))),
                    ],
                    '1' => [
                        'adult' => trim($this->parse(9, 55 + (48 * $i)))
                    ]
                ]
            ];
            $passenger = $passenger + $temp_passenger;
        };

        $response['prices'] = $passenger;
        return $response;
    }
}