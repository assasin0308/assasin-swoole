<?php

// 创建Server对象,监听127.0.0.1:9501端口
$server = new Swoole\Server("0.0.0.0", 9501);
// server 配置
$server->set([
    'worker_num'    => 4,     // worker process num   使用ps -aft | grep tcp_server.php 命令查看
    'max_request'   => 50,   //
//    'reactor_num'   => 2,     // reactor thread num
//    'backlog'       => 128,   // listen backlog
//    'dispatch_mode' => 1,
]);

// 监听连接进入事件
/**
 * $fd 客户端连接服务端的唯一标识
 * $reactor_id 线程ID
 */
$server->on('connect', function ($server, $fd,$reactor_id){
    echo "connection open: {$fd} - {$reactor_id}\n";
});
// 监听数据接收事件
$server->on('receive', function ($server, $fd, $reactor_id, $data) {
    $server->send($fd, "Swoole: {$fd} - {$reactor_id} - {$data}");
//    $server->close($fd);
});
// 监听连接关闭事件
$server->on('close', function ($server, $fd) {
    echo "connection close: {$fd}\n";
});
//启动服务器
$server->start();