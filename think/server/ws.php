<?php
/**
 * http 类
 */
class Ws{
    CONST HOST = "0.0.0.0";
    CONST PORT = 9502;
    CONST CHART_PORT = 9503;
    public $server;

    public function __construct(){
        $this->server = new swoole_websocket_server(self::HOST, self::PORT);
        $this->server->listen(self::HOST, self::CHART_PORT, SWOOLE_SOCK_TCP);

        $this->server->set([
            'document_root' => '/var/www/swoole/think/public/static',
            'enable_static_handler' => true,
            'worker_num' => 4,
            'task_worker_num' => 20,
        ]);

        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }
        /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request) {
        //$ws->push($request->fd, 'success');
        \app\common\lib\Predis::getInstance()->sAdd('live_game_key', $request->fd);
        echo 'open';
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame) {
        echo 'message';
    }

    public function onWorkerStart($server, $worker_id){
        // 加载基础文件
        require __DIR__ . '/../thinkphp/base.php';
        \app\common\lib\Predis::getInstance()->del('live_game_key');
    }

    public function onRequest($request, $response){
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
        if (!empty($_FILES)) {
            unset($_FILES);
        }
        if (isset($request->files)) {
            foreach ($request->files as $k => $val) {
                $_FILES[$k] = $val;
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
        $_POST['http_server'] = $this->server;
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
    }

    public function onTask($serv, $task_id, $src_worker_id, $data){
        // task 任务分发，让不同得任务走不同得逻辑
        $obj = new app\common\lib\task\Task;
        $method = $data['method'];
        echo $method;
        if (empty($method) || empty($data['data'])) {
            return false;
        }
        $flag = $obj->$method($data, $serv);
        if ($flag) {
            echo 'finish-'.PHP_EOL;
        }else{
            echo 'failed-'.PHP_EOL;
        }
    }

    public function onFinish(){
        //
    }

    public function onClose($server, $fd, $reactorId){
        \app\common\lib\Predis::getInstance()->sRem('live_game_key', $fd);
        echo $fd;
    }

    public function onShutdown($server){
        \app\common\lib\Predis::getInstance()->del('live_game_key');
        echo 'del ok';
    }
}

new Ws();
