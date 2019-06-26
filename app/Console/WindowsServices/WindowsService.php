<?php

namespace App\Console\WindowsServices;

use Illuminate\Console\Command;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

/**
 * 各種サービスの基底クラスです。
 *
 * @package App\Console\WindowsServices
 * @author koichi.kita
 */
abstract class WindowsService extends Command
{

    /**
     * @var string
     */
    protected $env;

    /**
     * @var string
     */
    protected $home;

    /**
     * @var string
     */
    protected $service_name;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * コマンドを実行します。
     * @throws \Exception
     */
    public function handle()
    {
        $this->onInit();
        try {
            $this->onStart();
            $this->logger->info('サービスを起動しました。');
        } catch (\Exception $e) {
            $this->logger->error('サービス起動時にエラーが発生しました。');
            $this->logger->error($e);
            throw $e;
        }
        $this->main();
        $this->stop();
    }

    /**
     * サービスクラスの初期化時に呼び出されます。
     */
    protected function onInit()
    {
        $this->env = config('app.env');

        // 引数
        $this->home = $this->argument('home');
        $this->service_name = $this->argument('service_name');

        // 設定ファイルのロード
        $this->config = config(strtolower(basename(get_class($this))));
        $this->config['stop_file'] = $this->home . $this->service_name . '.stop';

        $this->initLogger();

        if (file_exists($this->config['stop_file'])) {
            unlink($this->config['stop_file']);
            $this->logger->info('停止ファイル ' . $this->config['stop_file']. ' を削除しました。');
        }

        $this->logger->info('service_name: ' . $this->service_name);
        $this->logger->info('home: ' . $this->home);
        $this->logger->info('environment: ' . config('app.env'));
    }

    /**
     * サービス開始時に呼び出されます。
     */
    protected function onStart() {}

    /**
     * サービスのメインループです。
     */
    private function main()
    {
        while (true) {
            if (file_exists($this->config['stop_file'])) {
                break;
            }
            try {
                if ($this->onTick() === false) {
                    break;
                }
            } catch (\Exception $e) {
                $this->logger->error('サービス処理中にエラーが発生しました。');
                $this->logger->error($e);
                break;
            }
            usleep($this->config['interval']);
        }
    }

    /**
     * サービスを停止します。
     */
    private function stop()
    {
        try {
            $this->onStop();
            if (file_exists($this->config['stop_file'])) {
                unlink($this->config['stop_file']);
            }
            $this->logger->info('サービスを終了しました。');
        } catch (\Exception $e) {
            $this->logger->error('サービス終了時にエラーが発生しました。');
            $this->logger->error($e);
            throw $e;
        }
    }

    /**
     * ロガーを初期化します。
     */
    protected function initLogger()
    {
        $this->logger = new Logger($this->service_name);
        $this->logger->pushHandler(new RotatingFileHandler(storage_path() . "/logs/{$this->service_name}.log", config('app.log_max_files'), config('app.log_level')));
    }

    /**
     * 指定間隔ごとに呼び出されます。
     */
    protected function onTick()
    {
    }

    /**
     * サービス停止時に呼び出されます。
     */
    protected function onStop()
    {
    }
}