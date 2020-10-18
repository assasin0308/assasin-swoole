<?php
use Swoole\Process;
// swoole 进程 按需开启N个子进程执行
echo 'process start'.date('Ymd H:i:s').PHP_EOL;
$urls = [
    'https://www.baidu.com',
    'https://www.sina.com',
    'https://www.qq.com',
    'https://www.baidu.com?search=shibin',
    'https://www.baidu.com?search=assasin',
    'https://www.baidu.com?search=imooc',
];
$workers = [];
// 开启子进程
for($i = 0; $i < 6; $i++){
    //
    $process = new Process(function() use($i,$urls){
        // curl
        $res = curlData($urls[$i]);
        var_dump($res).PHP_EOL;
    });
    $pid = $process->start();
    $workers[$pid] = $process;
//    var_dump($workers);
}

 foreach($workers as $work){
     echo $work->read();
 }
function curlData($url){
    // file_get_contents 模拟请求 耗时1秒
    sleep(1);
    return $url.'---'.PHP_EOL;
}

echo 'process end'.date('Ymd H:i:s');



