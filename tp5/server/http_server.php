<?php
// http服务器
$http = new Swoole\Http\Server('0.0.0.0',9503);
// 配置可加载静态资源
$http->set([
    // 配置静态文件根目录，与 enable_static_handler 配合使用。
    'worker_num' => 5,
    'enable_static_handler' => true,
    'document_root' => '/data/wwwroot/default/assasin-swoole/tp5/public', //  此处必须为绝对路径
]);

$http->on('WorkerStart',function(Swoole\Http\Server $server) {
    // 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';


});
$http->on('request',function($request,$response) use($http){
//    $response->header("Content-Type","text/plain"); // header头设置
    $_SERVER = [];
    if(isset($request->server)){
        foreach($request->server as $k => $v){
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if(isset($request->header)){
        foreach($request->header as $k => $v){
            $_SERVER[strtoupper($k)] = $v;
        }
    }

    $_GET = [];
    if(isset($request->get)){
        foreach($request->get as $k => $v){
            $_GET[strtoupper($k)] = $v;
        }
    }
    $_POST = [];
    if(isset($request->post)){
        foreach($request->post as $k => $v){
            $_POST[strtoupper($k)] = $v;
        }
    }
    ob_start();
//    执行应用并响应
    try{
        \think\Container::get('app')->run()->send();
    }catch (\Exception $e){
        //TODO
    }
//    echo "action -- ".request()->action();
    $res = ob_get_contents();
    ob_end_clean();
    $response->end($res);
//    $http->close($response->fd);

});

// 启动服务
$http->start();


