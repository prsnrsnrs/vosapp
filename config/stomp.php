<?php
/**
 * Created by PhpStorm.
 * User: kita-kouichi
 * Date: 2017/11/29
 * Time: 15:31
 */

return [
    /** ActiveMQ設定 */
    'mq' => [
        'uri' => env('MQ_URI', 'localhost:61613'),
        'test_site_uri' => env('MQ_TEST_SITE_URI', 'localhost:61614'),
        'in' => '/queue/in',
        'out' => '/queue/out',
        'payment_in' => '/queue/payment-in',
        'payment_out' => '/queue/payment-out',
        'import_in' => '/queue/import_in',
        'import_out' => '/queue/import_out',
        'time_out' => 900, // 秒
        'output_info_log' => true,
    ],
];