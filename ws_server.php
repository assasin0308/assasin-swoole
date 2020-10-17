<?php
// WebSocket协议是基于TCP的一种新的网络协议.他实现了浏览器与服务器的全双工(full-duplex)通信 --- 允许服务器
//主动发送信息给客户端
// HTTP的通信只能由客户端发起
// 特点:
// 建立在TCP协议之上
// 性能开销小通信效率高
// 客户端可以与任意服务器通信
// 协议标识符ws wss
// 持久化网络通信

//创建WebSocket Server对象，监听0.0.0.0:9502端口
$ws = new Swoole\WebSocket\Server('0.0.0.0',9504);

$ws->set([
    // 配置静态文件根目录，与 enable_static_handler 配合使用。
    'enable_static_handler' => true,
    'document_root' => '/data/wwwroot/default/assasin-swoole', //  此处必须为绝对路径
]);

//监听WebSocket连接打开事件
$ws->on('open',function($ws,$request){
    var_dump($request->fd,$request->server);
    $ws->push($request->fd,"heelo-assasin\n");
});
//$ws->on('open','onOpen');
//function onOpen($ws,$request){
//    print_r($request->fd);
//}

//监听WebSocket消息事件
$ws->on('message',function($ws,$frame){
    echo "Message revieve from :{$frame->fd} : {$frame->data},
    opcode: {$frame->opcode},fin: {$frame->finish} \n";
    $ws->push($frame->fd,"this is server: {$frame->data}");
});


//监听WebSocket连接关闭事件
$ws->on('close',function($ws,$fd){
    echo "client -- {$fd} is closed\n";
});

// 开启服务
$ws->start();