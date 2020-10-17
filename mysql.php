<?php
Co\run(function () {
    $swoole_mysql = new Swoole\Coroutine\MySQL();
    $swoole_mysql->connect([
        'host'     => '192.168.2.103',
        'port'     => 3306,
        'user'     => 'root',
        'password' => '*********',
        'database' => 'sys',
    ]);
    $res = $swoole_mysql->query('select * from sys_config');
    var_dump($res);
});

