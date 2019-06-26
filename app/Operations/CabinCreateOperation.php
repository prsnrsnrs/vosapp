<?php

namespace App\Operations;

/**
 * 客室タイプ新規作成（一次予約）ソケットのメッセージクラスです。
 * @package App\Operations
 */
class CabinCreateOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('322');
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

    /**
     * 要求パラメータ 大人の人数をセットします。（1部屋目）
     * @param $human_type
     */
    public function setHumanTypeAdult($human_type, $count)
    {
        $this->set(3, $count * 9 + 56, $human_type, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 小人の人数をセットします。（1部屋目）
     * @param $human_type
     */
    public function setHumanTypeChildren($human_type, $count)
    {
        $this->set(3, $count * 9 + 59, $human_type, ['padding' => 0, 'right' => false]);
    }

    /**
     * 要求パラメータ 幼児の人数をセットします。（1部屋目）
     * @param $human_type
     */
    public function setHumanTypeChild($human_type, $count)
    {
        $this->set(3, $count * 9 + 62, $human_type, ['padding' => 0, 'right' => false]);
    }

    public function parseResponse()
    {
        $response = [
            'temp_reservation_number' => trim($this->parse(9, 16))
        ];
        return $response;
    }
}