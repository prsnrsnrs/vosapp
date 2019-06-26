<?php
/**
 * subscriberの設定ファイル
 * @author koichi.kita
 */

return [
    /** 実行間隔 (単位/マイクロ秒) */
    'interval' => 1,

    /** ソケット設定 */
    'socket_host' => env('SOCKET_HOST', ''),

    /** サービスごとの設定 */
    // aps11 通常
    'voss-subscriber-aps11' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50411',
    ],
    // aps12 通常
    'voss-subscriber-aps12' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50412',
    ],
    // aps13 予約取込
    'voss-subscriber-aps13' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50413',
    ],
    // aps14 予約取込
    'voss-subscriber-aps14' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50414',
    ],
    // aps15 決済
    'voss-subscriber-aps15' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/payment-in',
        'mq_out' => '/queue/payment-out',
        'socket_port' => '50415',
    ],
    // aps21 通常
    'voss-subscriber-aps21' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50421',
    ],
    // aps22 通常
    'voss-subscriber-aps22' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50422',
    ],
    // aps23 予約取込
    'voss-subscriber-aps23' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50423',
    ],
    // aps24 予約取込
    'voss-subscriber-aps24' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50424',
    ],
    // aps25 決済
    'voss-subscriber-aps25' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/payment-in',
        'mq_out' => '/queue/payment-out',
        'socket_port' => '50425',
    ],

    // aps1T AGENT TEST
    'voss-subscriber-aps1T1' => [
        'mq_uri' => 'localhost:61614',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50404',
    ],
    // aps1Ti AGENT TEST 予約取込
    'voss-subscriber-aps1T2' => [
        'mq_uri' => 'localhost:61614',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50405',
    ],
    // aps2T AGENT TEST
    'voss-subscriber-aps2T1' => [
        'mq_uri' => 'localhost:61614',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50406',
    ],
    // aps2Ti AGENT TEST 予約取込
    'voss-subscriber-aps2T2' => [
        'mq_uri' => 'localhost:61614',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50407',
    ],

    // 通常
    'voss-subscriber-dev11' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/in',
        'mq_out' => '/queue/out',
        'socket_port' => '50401',
    ],
    // 予約取込
    'voss-subscriber-dev12' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/import_in',
        'mq_out' => '/queue/import_out',
        'socket_port' => '50402',
    ],
    // 決済
    'voss-subscriber-dev13' => [
        'mq_uri' => 'localhost:61613',
        'mq_in' => '/queue/payment-in',
        'mq_out' => '/queue/payment-out',
        'socket_port' => '50403',
    ],
];