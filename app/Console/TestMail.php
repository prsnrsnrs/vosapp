<?php

namespace App\Console;

use Illuminate\Console\Command;


/**
 * テストメール送信の実行クラスです
 *
 * Class TestMail
 * @package App\Console\WindowsServices
 */
class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voss:test_mail';
    /**
     * コマンドを実行します。
     * @throws \Exception
     */
    public function handle()
    {
        $options = [
            'view' => 'emails.test',
            'view_params' => [
                'free' => 'これはフリー入力したものです。'
            ],
            'type' => 'text'
        ];
        $ret = \Mail::to('kozakura-shota@wiznet.co.jp')->send(new \App\Mail\VossMail($options));
        \Log::debug($ret);
    }
}