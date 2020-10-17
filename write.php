<?php
$content = date('Y-m-d H:i:s',time());
Swoole\Async::writeFile(__DIR__."/test.txt",$content,function($filename){
    echo "success".PHP_EOL;
},FILE_APPEND);
echo "start ".PHP_EOL;