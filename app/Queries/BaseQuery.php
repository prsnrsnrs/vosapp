<?php

namespace App\Queries;

use App\Libs\StringUtil;
use App\Libs\Voss\VossAccessManager;

/**
 * クエリの基底クラスです。
 * @package App\Queries
 */
abstract class BaseQuery
{
    const RECONNECT_TRY_COUNT = 5;
    /**
     * 再実行回数
     * @var int
     */
    protected $try_count = 0;

    /**
     * VOSSDB名
     * @var string
     */
    protected $voss_lib;

    /**
     * Frens共通DB名
     * @var string
     */
    protected $common_lib;

    /**
     * DB名を取得します。
     * @return array
     */
    public function __construct()
    {
        $this->voss_lib = VossAccessManager::isAgentTestSite() ? config('database.libs.agent_test') : config('database.libs.voss');
        $this->common_lib = config('database.libs.common');
        $this->init();
    }

    /**
     * クエリを初期化します。
     * 必要に応じてサブクラスでオーバーライドしてください。
     */
    protected function init()
    {
    }

    /**
     * 取得結果を全件返します。
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function all($sql, $params = [])
    {
        $result = $this->select($sql, $params);
        return $this->convert($result);
    }

    /**
     * 取得結果を1件返します。
     * @param string $sql
     * @param array $p9arams
     * @return array|string
     */
    public function first($sql, $params = [])
    {
        $result = $this->select($sql, $params);
        if ($result) {
            $result = $result[0];
        }
        return $this->convert($result);
    }

    /**
     * SELECTのSQLを実行します。
     * ODBC通信リンク障害が発生した場合は、再接続して再実行します。
     * @param $sql
     * @param array $params
     * @param int $reconnect_try_count
     * @return array
     * @throws \Exception
     */
    private function select($sql, $params = [], $reconnect_try_count = 0)
    {
        try {
            $result = \DB::select(StringUtil::utf8ToSjis($sql), StringUtil::utf8ToSjis($params));
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Communication link failure') !== false && $reconnect_try_count < self::RECONNECT_TRY_COUNT) {
                \Log::info('通信リンク障害発生!!DB再接続。message:' . $e->getMessage());
                // 通信リンク障害発生。持続的接続はスクリプトから接続を切断不可。再接続用のコネクションで実行。
                \DB::connection('reconnect_odbc');
                \DB::setDefaultConnection('reconnect_odbc');
                return $this->select($sql, $params, ++$reconnect_try_count);
            } else {
                throw $e;
            }
        }
        return $result;
    }

    /**
     * LIKE検索用にパラメータの両端に'%'をつけます。
     * @param $param
     * @return string
     */
    public function changeLike($param)
    {
        return '%' . $param . '%';
    }

    /**
     * 実行クエリのログを出します
     * @param $title
     * @param $params
     * @param $sql
     */
    public function logQuery($title, $params, $sql)
    {
        $array['param'] = $params;
        $array['query'] = $sql;
        $debug[$title] = $array;
        \Log::debug($debug);
    }

    /**
     * データベース取得結果をコンバートします。
     * @param $data
     * @return array|string
     */
    public function convert($data)
    {
        if (is_array($data) || is_object($data)) {
            $ret = [];
            foreach ($data as $key => $value) {
                $ret[strtolower($key)] = self::convert($value);
            }
        } else {
            $ret = trim(StringUtil::sjisToUtf8($data));
        }
        return $ret;
    }
}