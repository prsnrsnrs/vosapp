<?php

namespace App\Queries;


class SocketQuery extends BaseQuery
{

    /**
     * 回答ソケットイベントメッセージの取得のクエリ
     * @return array
     */
    public function findByEventNumber($event_number)
    {

        $sql = <<<EOF
SELECT
  NEM.NEM230 AS net_message -- ネットメッセージ
FROM 
  {$this->voss_lib}.VOSNEMP NEM -- イベントメッセージファイル
WHERE
  NEM.NEM010 = :event_number -- イベントNo
EOF;
        $param = ['event_number' => $event_number];
        return $this->all($sql, $param);
    }
}