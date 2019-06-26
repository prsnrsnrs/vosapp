<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCK\Odbc\ODBCConnection;
use TCK\Odbc\ODBCConnector;

/**
 * 通信陸障害発生時に再接続する用のODBCプロバイダークラス。
 * 備忘録：持続的接続はスクリプトから接続を切断不可。通信リンク障害発生時は新しく非持続的接続をすることでエラーを回避する。
 * Class ReconnectOdbcServiceProvider
 * @package App\Providers
 */
class ReconnectOdbcServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }


    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $factory = $this->app['db'];
        $factory->extend('reconnect_odbc', function ($config) {
            if (!isset($config['prefix'])) {
                $config['prefix'] = '';
            }

            $connector = new ODBCConnector();
            $pdo = $connector->connect($config);

            return new ODBCConnection($pdo, $config['database'], $config['prefix']);

        });
    }

}
