<?php

namespace App\Console\WindowsServices;

use App\Libs\SocketClient;
use App\Libs\StringUtil;
use Stomp\Client;
use Stomp\StatefulStomp;
use Stomp\Transport\Message;

/**
 * サブスクライバーの実行クラスです。
 *
 * @package App\Console\WindowsServices
 * @author koichi.kita
 */
class Subscriber extends WindowsService
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voss:subscriber {home} {service_name}';

    /**
     * @var StatefulStomp
     */
    protected $stomp;

    /**
     * @var SocketClient
     */
    protected $socket;

    /**
     * サービスクラスの初期化時に呼び出されます。
     */
    protected function onInit()
    {
        parent::onInit();
    }

    /**
     * サービス開始時に呼び出されます。
     */
    protected function onStart()
    {
        $mq_in = $this->config[$this->service_name]['mq_in'];
        $mq_out = $this->config[$this->service_name]['mq_out'];
        $mq_uri = $this->config[$this->service_name]['mq_uri'];

        $this->logger->info('MQ URI: ' . $mq_uri);
        $this->logger->info('MQ IN: ' . $mq_in);
        $this->logger->info('MQ OUT: ' . $mq_out);

        try {
            $this->stomp = new StatefulStomp(
                new Client('tcp://'.$mq_uri)
            );
            $this->stomp->subscribe($mq_in, null, 'client-individual');
        } catch (\Exception $e) {
            $this->logger->error('ActiveMQの接続に失敗しました。');
            throw $e;
        }

        $socket_host = $this->config['socket_host'];
        $socket_port = $this->config[$this->service_name]['socket_port'];

        $this->logger->info('Socket Host: ' . $socket_host);
        $this->logger->info('Socket Port: ' . $socket_port);

        try {
            $this->socket = new SocketClient();
            $this->socket->connect($socket_host, $socket_port);
        } catch (\Exception $e) {
            $this->logger->error('ソケットの接続に失敗しました。');
            throw $e;
        }
    }

    /**
     * 指定間隔ごとに呼び出されます。
     */
    protected function onTick()
    {
        $frame = $this->stomp->read();
        if ($frame && array_key_exists('message-id', $frame->getHeaders())) {
            $headers = $frame->getHeaders();
            $this->logger->info('=> ' . $headers['type'] . ': "' . $frame->body . '"');

            if (preg_match('/^VOSS2018.END.*$/', $frame->body)) {
                $this->logger->info('MQ から終了 Socket を受信しました。サービスを終了します。');
                $this->stomp->ack($headers['message-id']);
                return false;
            }

            try {
                $this->socket->write(StringUtil::utf8ToSjis($frame->getBody()));
                $this->stomp->ack($frame);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }

            $data = '';
            $response = '';
            try {
                $data = StringUtil::sjisToUtf8($this->socket->read());
                if (empty($data)) {
                    $response = '00000000000000F';
                } else {
                    $response = $data;
                }
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $response = '00000000000000F';
            }

            $this->logger->info('<= ' . $headers['type'] . ': "' . $response . '"');

            $replyTo = '';
            if (array_key_exists('reply-to', $headers)) {
                $replyTo = $headers['reply-to'];
            } else {
                $replyTo = $this->config[$this->service_name]['mq_out'];
            }

            $this->stomp->send($replyTo, new Message($response, ['type' => $headers['type']]));

            if (empty($data)) {
                $this->logger->error('Socket 接続が切断されているため、サービスを終了します。');
                return false;
            }
        }
    }

    /**
     * サービス停止時に呼び出されます。
     */
    protected function onStop()
    {
        if ($this->socket) {
            try {
                $this->socket->write('VOSS2018 END');
                $this->info('終了 Socket を送信しました。');
            } catch (\Exception $e) {
                $this->logger->error('終了 Socket の書き込みに失敗しました。');
                $this->logger->error($e->getMessage());
            }
        }
        $this->stomp->getClient()->disconnect();
        $this->socket->disconnect();
    }
}