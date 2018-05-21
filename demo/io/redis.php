<?php

$redisClient = new swoole_redis; //Swoole\Redis
$redisClient->connect('127.0.0.1', 6379, function(swoole_redis $redisClient, $result){
    echo 'connect'.PHP_EOL;
    var_dump($result);
});