<?php

namespace App\Providers\Stomp;

use Illuminate\Support\ServiceProvider;
use Stomp\Client;
use Stomp\StatefulStomp;

/**
 * Stompのサービスプロバイダークラスです。
 * @package App\Providers\Stomp
 */
class StompServiceProvider extends ServiceProvider
{

    /**
     * プロバイダのローディングを遅延させるフラグ
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * サービスプロバーダーの登録
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('stomp', function ($app) {
            $config = $app['config']->get('stomp');
            $stomp = new StatefulStomp(
                new Client('tcp://' . $config['mq']['uri'])
            );
            $stomp->getClient()->getConnection()->setReadTimeout($config['mq']['time_out']);
            return $stomp;
        });
        $this->app->singleton('test_site_stomp', function ($app) {
            $config = $app['config']->get('stomp');
            $stomp = new StatefulStomp(
                new Client('tcp://' . $config['mq']['test_site_uri'])
            );
            $stomp->getClient()->getConnection()->setReadTimeout($config['mq']['time_out']);
            return $stomp;
        });
    }

    /**
     * このプロバイダにより提供されるサービス
     *
     * @return array
     */
    public function provides()
    {
        return ['stomp', 'test_site_stomp'];
    }
}
