<?php

$process = new swoole_process(function(swoole_process $pro){
    //todo
    // php redis.php  在子进程中执行其它脚本
    $pro->exec("/usr/local/webserver/php/bin/php", [__DIR__.'/../server/http_server.php']);
}, true);

$pid = $process->start();
echo $pid . PHP_EOL;

swoole_process::wait();