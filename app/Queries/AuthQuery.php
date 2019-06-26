<?php

namespace App\Queries;

class AuthQuery extends BaseQuery {

    /**
     * 販売店ログインのクエリ
     * @param $agent_id, $user_id, $password
     * @return array
     */
    public function getAgentLoginData ($agent_id, $user_id, $password) {

        $sql = <<<EOF
SELECT
  NBU.NBU010 AS travel_company_code -- 旅行社コード
 ,NBU.NBU020 AS agent_code -- 販売店コード
 ,NBU.NBU030 AS agent_user_number -- 販売店利用者No
 ,NBU.NBU060 AS user_name -- ユーザー名称
 ,NBU.NBU070 AS user_type -- ユーザー区分
 ,NBR.NBR040 AS agent_name -- 販売店名
 ,NBR.NBR180 AS agent_type -- 販売店区分
 ,NAG.NAG020 AS travel_company_name -- 旅行社名
FROM 
  {$this->voss_lib}.VOSNBUP NBU -- 販売店利用者ファイル
INNER JOIN
  {$this->voss_lib}.VOSNBRP NBR--販売店マスタ
  ON
     NBR.NBR010 = NBU.NBU010 -- 販売店旅行社コード
  AND
     NBR.NBR020 = NBU.NBU020 -- 販売店コード
  AND
     NBR.NBR190= 1 -- ログイン区分
  AND
     NBR.NBR280 <= 0 -- 削除日時
INNER JOIN
  {$this->voss_lib}.VOSNAGP NAG -- 旅行社マスタ
  ON
     NAG.NAG010 = NBU.NBU010 -- 旅行社コード
WHERE
  NBU.NBU040 = :agent_id -- 販売店ログインID
 AND
   NBU.NBU050 = :user_id -- ユーザーID
 AND
   NBU.NBU090 = :password -- パスワード
 AND
   NBU.NBU080 = 1 --ログイン区分
 AND
   NBU.NBU190  <= 0 -- 削除日時
EOF;
        $params = [
            'agent_id' => mb_substr($agent_id, 0, 15),
            'user_id' => mb_substr($user_id, 0, 12),
            'password' => mb_substr($password, 0, 12)
        ];
        return $this->first($sql, $params);
    }
}