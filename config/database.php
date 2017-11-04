<?php
 return [
     'fetch' => PDO::FETCH_CLASS,
          'default' => env('DB_CONNECTION', 'mysql'),
          'connections' => [
              'mysql' => [
              'driver'    => 'mysql',
              'host'      => env('DB_HOST', 'localhost'),
//              'unix_socket'   => '/var/lib/mysql/mysql.sock',
              'database'  => env('DB_DATABASE', ''),
              'username'  => env('DB_USERNAME', ''),
              'password'  => env('DB_PASSWORD', ''),
              'charset'   => 'utf8',
              'collation' => 'utf8_unicode_ci',
              'prefix'    => '',
              'strict'    => false,
          ],
      ],
      'migrations' => 'migrations',
      'redis' => [
          'cluster' => false,
          'default' => [
              'host'     => '127.0.0.1',
              'port'     => 6379,
              'database' => 0,
          ],
      ],
  ];
