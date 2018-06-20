<?php
/**
 * 监控服务
 */
class Server{
    const PORT = 9503;

    public function port(){
        $shell = "netstat -anp | grep ".self::PORT.' | grep LISTEN | wc -l';

        $result = shell_exec($shell);
        if ($result != 1) {
            // 发送报警服务 邮件 短信
            // todo
            echo date("Y-m-d H:i:s", time()).'error'.PHP_EOL;
        }else {
            echo date("Y-m-d H:i:s", time()).'success'.PHP_EOL;
        }
    }
}

swoole_timer_tick(2000, function($timer_id){
    (new Server())->port();
});
