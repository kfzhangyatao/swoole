<?php
// 开启 swoole http  服务

$http = new swoole_http_server("0.0.0.0", 9502);
$http->set([
    'document_root' => '/var/www/swoole/think/public/static/live',
    'enable_static_handler' => true,
    'worker_num' => 4,
]);
$http->on('WorkerStart', function($serv, $worker_id){
    // 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';
});
$http->on('request', function ($request, $response){
    // todo , 收到请求对象，get、post、cookie、header、files、server等
    // if (!empty($_SERVER)) {
    //     unset($_SERVER);54
    // }
    if (isset($request->server)) {
        foreach ($request->server as $k => $val) {
            $_SERVER[strtoupper($k)] = $val;
        }
    }
    if (!empty($_GET)) {
        unset($_GET);
    }
    if (isset($request->get)) {
        foreach ($request->get as $k => $val) {
            $_GET[$k] = $val;
        }
    }
    if (!empty($_POST)) {
        unset($_POST);
    }
    if (isset($request->post)) {
        foreach ($request->post as $k => $val) {
            $_POST[$k] = $val;
        }
    }
    if (!empty($_COOKIE)) {
        unset($_COOKIE);
    }
    if (isset($request->cookie)) {
        foreach ($request->cookie as $k => $val) {
            $_COOKIE[$k] = $val;
        }
    }
    //$response->end("<h1>Hello Swoole. #" . rand(1000, 9999)."</h1>");
    // 执行应用并响应
    ob_start();
    try{
        think\Container::get('app')->run()->send();
    }catch(\Exception $e){
        // todo
    }
    $ret = ob_get_contents();
    ob_end_clean();
    $response->end($ret);
});
$http->start();