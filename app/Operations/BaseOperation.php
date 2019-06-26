<?php

namespace App\Operations;

use App\Libs\StringUtil;
use App\Libs\Voss\VossAccessManager;
use Stomp\StatefulStomp;
use Stomp\Transport\Message;

/**
 * ソケットメッセージの基底クラスです。
 * @package App\Operations
 * @author koichi.kita
 */
abstract class BaseOperation
{
    /**
     * @var StatefulStomp
     */
    private $stomp;

    /**
     * @var string
     */
    private $request;

    /**
     * @var string
     */
    private $response;

    /**
     * @var string
     */
    private $queue_in_path;

    /**
     * @var string
     */
    private $queue_out_path;

    /**
     * @var bool
     */
    private $is_output_info_log;

    /**
     * インスタンスを初期化します。
     * 独自の初期化処理を実装する場合、このメソッドではなく、init をオーバーライドしてください。
     *
     * @param StatefulStomp $stomp
     */
    public function __construct($stomp = null)
    {
        if ($stomp) {
            $this->stomp = $stomp;
        } else {
            if (VossAccessManager::isAgentTestSite()) {
                $this->stomp = \App::make('test_site_stomp');
            } else {
                $this->stomp = \App::make('stomp');
            }

        }
        if (!$this->stomp) {
            throw new \Exception('有効な Stomp クライアントが見つかりません。');
        }

        $config = config('stomp');
        $this->setQueueInPath($config['mq']['in']);
        $this->setQueueOutPath($config['mq']['out']);
        $this->is_output_info_log = $config['mq']['output_info_log'];

        $this->reset();

        $this->init();
    }

    /**
     * 入力キューのパスを設定します。
     *
     * @param string $queue_in_path
     */
    protected function setQueueInPath($queue_in_path)
    {
        $this->queue_in_path = $queue_in_path;
    }

    /**
     * 出力キューのパスを設定します。
     *
     * @param string $queue_out_path
     */
    protected function setQueueOutPath($queue_out_path)
    {
        $this->queue_out_path = $queue_out_path;
    }

    /**
     * ソケットメッセージをリセットします。
     */
    public function reset()
    {
        $this->request = '';
        $this->response = '';

        $this->setCommonKey('VOSS2018');
        if (VossAccessManager::isAgentSite() || VossAccessManager::isAgentTestSite()) {
            $auth = VossAccessManager::getAuth();
            $this->setCommonWebType('B');
            $this->setCommonUserNumber('');
            $this->setCommonTravelCompanyCode(array_get($auth, 'travel_company_code', ''));
            $this->setCommonAgentCode(array_get($auth, 'agent_code', ''));
            $this->setCommonAgentUserNumber(array_get($auth, 'agent_user_number', ''));
        } else {
            $auth = VossAccessManager::getAuth();
            $this->setCommonWebType('C');
            $this->setCommonUserNumber(array_get($auth, 'user_number', ''));
            $this->setCommonTravelCompanyCode('');
            $this->setCommonAgentCode('');
            $this->setCommonAgentUserNumber('');
        }
        $this->init();
    }

    /**
     * メッセージを初期化します。
     * 必要に応じてサブクラスでオーバーライドしてください。
     */
    protected function init()
    {
    }

    /**
     * リクエスト文字列の指定箇所に値を設定します。
     *
     * @param int $length
     * @param int $start
     * @param mixed $value
     * @param array $options
     * @throws \Exception
     */
    protected function set($length, $start, $value, $options = array())
    {
        // ソケット仕様書の記述に合わせるため、開始位置を-1。
        $start = $start - 1;

        $options = array_merge(array(
            'padding' => ' ',
            'right' => true,
            'overflow' => false
        ), $options);

        $value = StringUtil::utf8ToSjis($value);
        $value_length = strlen(StringUtil::sjisToSosi($value));
        if ($value_length > $length && $options['overflow']) {
            $value = $this->createOverflowString($value, $length);
        } elseif ($value_length > $length) {
            throw new \Exception("文字列 ${value} が指定桁数 ${length} を超過しています。");
        }

        $value = str_pad($value, $length, $options['padding'], $options['right'] ? STR_PAD_RIGHT : STR_PAD_LEFT);

        if (strlen($this->request) < ($start + $length)) {
            $this->request = str_pad($this->request, $start + $length);
        }
        $this->request = substr_replace($this->request, $value, $start, $length);
    }

    /**
     * 共通パラメータ キーを設定します。
     *
     * @param string $key
     */
    public function setCommonKey($key)
    {
        $this->set(8, 1, $key);
    }

    /**
     * 共通パラメータ Web 区分を設定します
     *
     * @param string $web_type web
     */
    public function setCommonWebType($web_type)
    {
        $this->set(1, 9, $web_type);
    }

    /**
     * 共通パラメータ 操作コードを設定します。
     *
     * @param string $operation_code
     */
    public function setCommonOperationCode($operation_code)
    {
        $this->set(3, 10, $operation_code);
    }

    /**
     * 共通パラメータ ネット利用者No を設定します。
     *
     * @param string $user_number
     */
    public function setCommonUserNumber($user_number)
    {
        if (!$user_number) {
            $this->set(10, 13, '', array('padding' => ' '));
        } else {
            $this->set(10, 13, $user_number, array('right' => false, 'padding' => '0'));
        }
    }

    /**
     * 共通パラメータ 旅行会社コード を設定します。
     *
     * @param string $travel_company_code
     */
    public function setCommonTravelCompanyCode($travel_company_code)
    {
        if (!$travel_company_code) {
            $this->set(8, 23, '', array('padding' => ' '));
        } else {
            $this->set(8, 23, $travel_company_code);
        }
    }

    /**
     * 共通パラメータ 販売店コード を設定します。
     *
     * @param string $agent_code
     */
    public function setCommonAgentCode($agent_code)
    {
        if (!$agent_code) {
            $this->set(7, 31, '', array('padding' => ' '));
        } else {
            $this->set(7, 31, $agent_code);
        }
    }

    /**
     * 共通パラメータ 販売店利用者No を設定します。
     *
     * @param string $agent_user_number
     */
    public function setCommonAgentUserNumber($agent_user_number)
    {
        if (!$agent_user_number) {
            $this->set(5, 38, '', array('padding' => ' '));
        } else {
            $this->set(5, 38, $agent_user_number, array('right' => false, 'padding' => '0'));
        }
    }

    /**
     * メッセージを送信し、レスポンスを連想配列で返します。
     *
     * @return array
     */
    final public function execute()
    {
        $type = sha1($this->request . microtime());

        $this->stomp->send($this->queue_in_path, new Message(StringUtil::sjisToUtf8($this->request), array(
            'reply-to' => $this->queue_out_path,
            'type' => $type,
        )));

        if ($this->is_output_info_log) {
            $utf8_request = StringUtil::sjisToUtf8(StringUtil::sjisToSosi($this->request));
            \Log::info('<MQ set => ' . $type . ': "' . $utf8_request . '"');
        }

        $this->stomp->subscribe($this->queue_out_path, "JMSType = '${type}'", 'client-individual');

        $frame = $this->stomp->read();

        if ($this->is_output_info_log) {
            \Log::info('<MQ get <= ' . $type . ': "' . trim($frame->getBody()) . '"');
        }

        if (array_key_exists('message-id', $frame->getHeaders())) {
            $this->stomp->ack($frame);
        } else {
            throw new \Exception('不明なメッセージを受信しました。');
        }

        $this->response = StringUtil::utf8ToSjis($frame->getBody());
        $ret = array_merge([
            'event_number' => $this->parse(11, 1),
            'operation_code' => $this->parse(3, 12),
            'status' => $this->parse(1, 15)
        ], $this->parseResponse());
//        \Log::debug(get_class($this) . ".parseResponse : ", $ret);
        return $ret;
    }

    /**
     * レスポンス文字列を解析します。
     *
     * @param int $length
     * @param int $start
     * @return string
     */
    protected function parse($length, $start)
    {
        // ソケット仕様書の記述に合わせるため、開始位置を-1。
        $start = $start - 1;

        $tmp = substr($this->response, $start, $length);
        return $tmp === false ? '' : StringUtil::sjisToUtf8($tmp);
    }

    /**
     * レスポンスを解析し、結果を連想配列で返します。
     * 必要に応じてサブクラスでオーバーライドしてください。
     *
     * @return array
     */
    protected function parseResponse()
    {
        return array();
    }

    /**
     * 桁数超過を表す文字列を生成します。
     *
     * @param string $sjis
     * @param int $length
     * @return string
     */
    private function createOverflowString($sjis, $length)
    {
        $encoding = 'sjis-win';

        $sjis = mb_substr($sjis, 0, $length, $encoding);
        $result = StringUtil::sjisToSosi($sjis);
        while (strlen($result) >= $length) {
            $mb_length = mb_strlen($result, $encoding);
            $last_char = mb_substr($result, $mb_length - 1, 1, $encoding);
            $before_last_char = mb_substr($result, $mb_length - 2, 1, $encoding);
            if ($before_last_char === StringUtil::SO && $last_char === StringUtil::SI) {
                $result = mb_substr($result, 0, $mb_length - 2, $encoding);
            } elseif ($last_char === StringUtil::SI) {
                $result = mb_substr($result, 0, $mb_length - 2, $encoding) . StringUtil::SI;
            } else {
                $result = mb_substr($result, 0, $mb_length - 1, $encoding);
            }
        }
        return str_replace(array(StringUtil::SO, StringUtil::SI), "", $result) . '+';
    }
}
