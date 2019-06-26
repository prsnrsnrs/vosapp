<?php

namespace App\Libs;

/**
 * 一つの Socket に対応するクラスです。
 *
 * @package App\Libs
 * @author koichi.kita
 */
class SocketClient
{
    /**
     * 最後に発生した Socket エラー番号を取得します。
     *
     * @return int
     */
    public static function getLastErrorNumber()
    {
        return @socket_last_error();
    }

    /**
     * 最後に発生した Socket エラーメッセージを取得します。
     *
     * @return string
     */
    public static function getLastErrorMessage()
    {
        return mb_convert_encoding(trim(@socket_strerror(self::getLastErrorNumber())), mb_internal_encoding(), 'sjis-win');
    }

    //--

    /**
     * @var resource Socket リソース
     */
    private $socket;

    /**
     * インスタンスを初期化します。
     *
     * @param resource $socket
     */
    public function __construct($socket = null)
    {
        $this->socket = $socket;
    }

    /**
     * インスタンスを破棄します。
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Socket 接続を確立します。
     * すでに Socket 接続が確立されている場合、何も行いません。
     */
    public function connect($host, $port, $options = array())
    {
        if (!$this->socket) {
            $this->socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if (!$this->socket) {
                throw new \Exception('Socket の作成に失敗しました。(' . self::getLastErrorNumber() . ': ' . self::getLastErrorMessage() . ')');
            }
            @socket_set_option($this->socket, SOL_SOCKET, SO_SNDTIMEO, array());
            @socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, array('sec'));
        }
        if (!@socket_connect($this->socket, $host, $port)) {
            throw new \Exception('Socket 接続の確立に失敗しました。(' . self::getLastErrorNumber() . ': ' . self::getLastErrorMessage() . ')');
        }
    }

    /**
     * Socket 接続を切断します。
     * Socket 接続が確立されていない場合、何も行いません。
     */
    public function disconnect()
    {
        if ($this->socket) {
            @socket_close($this->socket);
            $this->socket = null;
        }
    }

    /**
     * Socket に指定したデータを書き込みます。
     *
     * @param string $data
     */
    public function write($data, $length = 2048)
    {
        $data = str_pad($data, $length);
        if (@socket_write($this->socket, $data) === false) {
            throw new \Exception('データの書き込みに失敗しました。(' . self::getLastErrorNumber() . ': ' . self::getLastErrorMessage() . ')');
        }
    }

    /**
     * Socket から指定したバイト数のデータを読み取ります。
     *
     * @param int $length
     */
    public function read($length = 4096)
    {
        $data = @socket_read($this->socket, $length);
        if ($data === false) {
            throw new \Exception('データの読み取りに失敗しました。(' . self::getLastErrorNumber() . ': ' . self::getLastErrorMessage() . ')');
        }
        return $data;
    }
}
