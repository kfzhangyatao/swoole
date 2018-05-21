<?php

$http = new swoole_http_server('0.0.0.0', 8001);
$http->on('request', function($request, $response){
    // 获取redis里面的key值 输出浏览器
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $value = $redis->get($request->get['a']);

    // mysql

    // time = max(redis, mysql)
    $response->header("Content-Type", "text/plain");
    $response->end($value);
});

$http->start();

/**
 * 1 redis
 * 2 mysql
 * redis + mysql 时间
 */ 