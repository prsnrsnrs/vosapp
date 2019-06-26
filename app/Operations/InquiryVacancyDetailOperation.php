<?php

namespace App\Operations;

/**
 * 客室タイプ別料金空席照会のソケットメッセージクラスです。
 * @package App\Operations
 */
class InquiryVacancyDetailOperation extends BaseOperation
{
    /**
     * 初期化します。
     */
    public function init()
    {
        $this->setCommonOperationCode('313');
    }

    /**
     * 要求パラメータ 商品コードをセットします。
     * @param string $departure_date
     */
    public function setItemCode($item_code)
    {
        $this->set(11, 43, $item_code);
    }


    public function parseResponse()
    {
        $response = ['cabins' => []];
        // 客室タイプ ＋ 金額 + STS
        for ($i = 0; $i < 15; $i++) {
            $cabins = [];
            $start = 30 * $i + 16;
            $cabins['cabin_type'] = trim($this->parse(2, $start));
            if (!$cabins['cabin_type']) {
                break;
            }
            $cabins['cabin_member_three'] = (int)trim($this->parse(9, $start + 2));
            $cabins['cabin_member_two'] = (int)trim($this->parse(9, $start + 11));
            $cabins['cabin_member_one'] = (int)trim($this->parse(9, $start + 20));
            $cabins['status'] = trim($this->parse(1, $start + 29));
            $response['cabins'][] = $cabins;
        }
        $response['inquiry_date_time'] = $this->parse(14, 466);

        return $response;
    }
}