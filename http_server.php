<?php
// http服务器
$http = new Swoole\Http\Server('0.0.0.0',9503);
// 配置可加载静态资源
$http->set([
    // 配置静态文件根目录，与 enable_static_handler 配合使用。
    'enable_static_handler' => true,
    'document_root' => '/data/wwwroot/default/assasin-swoole', //  此处必须为绝对路径
]);

$http->on('request',function($request,$response){
//    var_dump($request);
    var_dump($request->get); // 获取GET参数
    $response->header("Content-Type","text/plain"); // header头设置
    $response->cookie('cookie_name','assasin',time()+1800); // cookie设置
    $response->end("GET 参数:". json_encode($request->get));
});

// 启动服务
$http->start();


