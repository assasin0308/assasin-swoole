<?php
// 连接Tswoole CP服务器
$client = new Swoole\Client(SWOOLE_SOCK_TCP);
if( !$client->connect("0.0.0.0", 9501)){
    echo "连接失败";
    exit();
}
// php cli常量
fwrite(STDOUT,"请输入消息:");
$msg = trim(fgets(STDIN));

// 发送消息给TCP服务器
if(!$client->send($msg)){
    echo "发送失败";
}
// 接收来自server的数据
$result = $client->recv();
echo $result;




