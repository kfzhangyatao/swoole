<?php
$http = new swoole_http_server("0.0.0.0", 9502);

$http->set([
    'document_root' => '/var/www/swoole/demo/web',
    'enable_static_handler' => true,
]);
$http->on('request', function ($request, $response) {
    $response->end("<h1>Hello Swoole. # 9502".rand(1000, 9999)."</h1>");
});
$http->start();