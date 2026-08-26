<?php

use Illuminate\Support\Str;
use Pdo\Mysql;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        'sqlite' => [
            'driver'                  => 'sqlite',
            'url'                     => env('DB_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout'            => null,
            'journal_mode'            => null,
            'synchronous'             => null,
            'transaction_mode'        => 'DEFERRED',
        ],

        /*
        |----------------------------------------------------------------------
        | MySQL dengan Read/Write Separation
        |----------------------------------------------------------------------
        | ✅ READ/WRITE SPLIT: Laravel secara otomatis mengirim query SELECT
        |    ke server "read" (replika) dan INSERT/UPDATE/DELETE ke server
        |    "write" (master/primary). Cocok untuk staging/production dengan
        |    MySQL replication.
        |
        | Untuk development lokal (tanpa replika), cukup isi DB_READ_HOST
        |    dengan nilai yang sama dengan DB_HOST di .env — Laravel tetap
        |    berfungsi normal karena read & write mengarah ke server yang sama.
        |
        | Variabel .env yang dibutuhkan:
        |   DB_HOST         → server utama (write)
        |   DB_READ_HOST    → server replika (read); jika tidak ada, isi sama dengan DB_HOST
        |   DB_DATABASE, DB_USERNAME, DB_PASSWORD, DB_PORT → sama untuk keduanya
        |----------------------------------------------------------------------
        */
        'mysql' => [
            'driver'    => 'mysql',
            'url'       => env('DB_URL'),

            // ── Read/Write Split ──────────────────────────────────────────────
            'read' => [
                'host' => [
                    env('DB_READ_HOST', env('DB_HOST', '127.0.0.1')),
                ],
            ],
            'write' => [
                'host' => [
                    env('DB_HOST', '127.0.0.1'),
                ],
            ],
            // Sticky: jika kita baru saja menulis data dalam request yang sama,
            // baca dari write server supaya data langsung konsisten (tidak lag replikasi).
            'sticky' => true,
            // ─────────────────────────────────────────────────────────────────

            'port'         => env('DB_PORT', '3306'),
            'database'     => env('DB_DATABASE', 'laravel'),
            'username'     => env('DB_USERNAME', 'root'),
            'password'     => env('DB_PASSWORD', ''),
            'unix_socket'  => env('DB_SOCKET', ''),
            'charset'      => env('DB_CHARSET', 'utf8mb4'),
            'collation'    => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix'       => '',
            'prefix_indexes' => true,
            'strict'       => true,
            'engine'       => null,
            'options'      => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? Mysql::ATTR_SSL_CA : PDO::MYSQL_ATTR_SSL_CA) => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        /*
        |----------------------------------------------------------------------
        | MariaDB dengan Read/Write Separation
        |----------------------------------------------------------------------
        | Konfigurasi identik dengan MySQL di atas — MariaDB mendukung
        | replikasi master-replica dengan cara yang sama.
        |----------------------------------------------------------------------
        */
        'mariadb' => [
            'driver'    => 'mariadb',
            'url'       => env('DB_URL'),

            // ── Read/Write Split ──────────────────────────────────────────────
            'read' => [
                'host' => [
                    env('DB_READ_HOST', env('DB_HOST', '127.0.0.1')),
                ],
            ],
            'write' => [
                'host' => [
                    env('DB_HOST', '127.0.0.1'),
                ],
            ],
            'sticky' => true,
            // ─────────────────────────────────────────────────────────────────

            'port'         => env('DB_PORT', '3306'),
            'database'     => env('DB_DATABASE', 'laravel'),
            'username'     => env('DB_USERNAME', 'root'),
            'password'     => env('DB_PASSWORD', ''),
            'unix_socket'  => env('DB_SOCKET', ''),
            'charset'      => env('DB_CHARSET', 'utf8mb4'),
            'collation'    => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix'       => '',
            'prefix_indexes' => true,
            'strict'       => true,
            'engine'       => null,
            'options'      => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? Mysql::ATTR_SSL_CA : PDO::MYSQL_ATTR_SSL_CA) => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver'      => 'pgsql',
            'url'         => env('DB_URL'),
            'host'        => env('DB_HOST', '127.0.0.1'),
            'port'        => env('DB_PORT', '5432'),
            'database'    => env('DB_DATABASE', 'laravel'),
            'username'    => env('DB_USERNAME', 'root'),
            'password'    => env('DB_PASSWORD', ''),
            'charset'     => env('DB_CHARSET', 'utf8'),
            'prefix'      => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode'     => env('DB_SSLMODE', 'prefer'),
        ],

        'sqlsrv' => [
            'driver'   => 'sqlsrv',
            'url'      => env('DB_URL'),
            'host'     => env('DB_HOST', 'localhost'),
            'port'     => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => env('DB_CHARSET', 'utf8'),
            'prefix'   => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    */

    'migrations' => [
        'table'                  => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster'    => env('REDIS_CLUSTER', 'redis'),
            'prefix'     => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')) . '-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url'               => env('REDIS_URL'),
            'host'              => env('REDIS_HOST', '127.0.0.1'),
            'username'          => env('REDIS_USERNAME'),
            'password'          => env('REDIS_PASSWORD'),
            'port'              => env('REDIS_PORT', '6379'),
            'database'          => env('REDIS_DB', '0'),
            'max_retries'       => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base'      => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap'       => env('REDIS_BACKOFF_CAP', 1000),
        ],

        'cache' => [
            'url'               => env('REDIS_URL'),
            'host'              => env('REDIS_HOST', '127.0.0.1'),
            'username'          => env('REDIS_USERNAME'),
            'password'          => env('REDIS_PASSWORD'),
            'port'              => env('REDIS_PORT', '6379'),
            'database'          => env('REDIS_CACHE_DB', '1'),
            'max_retries'       => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base'      => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap'       => env('REDIS_BACKOFF_CAP', 1000),
        ],

    ],

];
