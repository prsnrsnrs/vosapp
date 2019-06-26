<?php

namespace App\Libs;

/**
 * Socket サーバーを提供するクラスです。
 *
 * @package App\Libs
 * @author koichi.kita
 */
class SocketServer
{
    /**
     * @var resource
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
        $this->shutdown();
    }

    /**
     * Socket を接続待ち状態にします。
     *
     * @param string $address
     * @param int $port
     */
    public function listen($address, $port)
    {
        if (!$this->socket) {
            $this->socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if (!$this->socket) {
                throw new \Exception('Socket の作成に失敗しました。(' . SocketClient::getLastErrorNumber() . ': ' . SocketClient::getLastErrorMessage() . ')');
            }
        }
        if (!@socket_bind($this->socket, $address, $port)) {
            throw new \Exception('Socket のバインドに失敗しました。(' . SocketClient::getLastErrorNumber() . ': ' . SocketClient::getLastErrorMessage() . ')');
        }
        if (!@socket_listen($this->socket)) {
            throw new \Exception('Socket の接続待ちに失敗しました。(' . SocketClient::getLastErrorNumber() . ': ' . SocketClient::getLastErrorMessage() . ')');
        }
    }

    /**
     * Socket サーバーを終了します。
     */
    public function shutdown()
    {
        if ($this->socket) {
            @socket_close($this->socket);
            $this->socket = null;
        }
    }

    /**
     * Socket への接続を受け入れます。
     *
     * @return SocketClient
     */
    public function accept()
    {
        $socket = @socket_accept($this->socket);
        if (!$socket) {
            throw new \Exception('Socket の受け入れに失敗しました。(' . SocketClient::getLastErrorNumber() . ': ' . SocketClient::getLastErrorMessage() . ')');
        }
        return new SocketClient($socket);
    }
}
