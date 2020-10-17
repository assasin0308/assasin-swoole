<?php

Co\run(function () {
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('192.168.2.103', 6379);
    $val = $redis->get('key');
});