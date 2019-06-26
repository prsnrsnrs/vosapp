<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'odbc'),

    'libs' => [
        'voss' => env('DB_VOSS_LIB', ''),
        'agent_test' => env('DB_AGENT_TEST_LIB', ''),
        'common' => env('DB_COMMON_LIB', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

//        'odbc-wiz' => [
//            'driver'   => 'odbc',
//            'dsn'      => 'odbc:DRIVER={IBM DB2 ODBC DRIVER};HOSTNAME=192.168.11.87;PORT=50000;DATABASE=VOSS;PROTOCOL=TCPIP;UID=User;PWD=P@ssw0rd',
//            'host'     => '192.168.11.87',
//            'database' => 'VOSS',
//            'username' => 'User',
//            'password' => 'P@ssw0rd',
//        ],

        'odbc' => [
            'dsn' => 'odbc:' . env('DB_DATABASE', 'i5php'),
            'database' => env('DB_DATABASE','i5php'),
            'username' => env('DB_USERNAME','WEBVOSS'),
            'password' => env('DB_PASSWORD','V3T0R1B0S5'),
            'options' => [
                PDO::ATTR_PERSISTENT => env('DB_OPTIONS_PERSISTENT', false),
            ],
        ],

        // 通信リンク障害発生時に再接続するためのODBC接続設定
        // 備忘録：持続的接続はスクリプトから接続を切断不可。通信リンク障害発生時は新しく非持続的接続をすることでエラーを回避する。
        'reconnect_odbc' => [
            'dsn' => 'odbc:' . env('DB_DATABASE', 'i5php'),
            'database' => env('DB_DATABASE', 'i5php'),
            'username' => env('DB_USERNAME', 'WEBVOSS'),
            'password' => env('DB_PASSWORD', 'V3T0R1B0S5'),
            'options' => [
                // 必ず非持続的接続で接続すること。
            ],
        ],

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],


];
