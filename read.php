<?php
// 异步读取文件
$result = Swoole\Async::readFile(__DIR__ .'/test.txt',function($filename,$filecontent){
   echo "filename is {$filename}".PHP_EOL;
   echo "file content is ".$filecontent;
});

var_dump($result);
echo "start".PHP_EOL;