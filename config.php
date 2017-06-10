<?php

return [
    'db' => [
        'class'    => ORM\Driver\DB\PDO\Driver::class,
        'dsn'      => 'mysql:dbname=orm;host=127.0.0.1',
        'user'     => 'root',
        'password' => '1234567',
    ],
];
