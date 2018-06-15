<?php
namespace app\common\lib\task;
use app\common\lib\ali\Sms;
use app\common\lib\Predis;
use app\common\lib\Redis;
/**
 * swoole task 异步任务得分发都在这里边
 */
class Task{

    /**
     * 异步发送验证码
     *
     * @param [type] $data
     * @return void
     */
    public function sendSms($data, $serv){
        // try{
        //     $response = Sms::sendSms($data['data']['phone_num'], $data['data']['code']);
        // }
        // catch(\Exception $e){
        //     return $e->getMessage();
        // }
        // 存redis
        $response['code'] = 'OK';
        if ($response['code'] === 'OK') {
            // redis
            $ret = Predis::getInstance()->set(Redis::smsKey($data['data']['phone_num']), $data['data']['code'], 120);

            return $ret;
        }

        return false;
    }

    /**
     * 异步推送 直播消息
     *
     * @param [type] $data
     * @param [type] $serv
     * @return void
     */
    public function pushLive($data, $serv){
        $clients = Predis::getInstance()->sMembers('live_game_key');
        foreach ($clients as $fd) {
            $serv->push($fd, json_encode($data['data']));
        }
        return true;
    }

    /**
     * 异步推送聊天室
     *
     * @param [type] $data
     * @param [type] $serv
     * @return void
     */
    public function pushChart($data, $serv){
        $clients = $serv->ports[1]->connections;
        foreach ($clients as $fd) {
            $serv->push($fd, json_encode($data['data']));
        }
        return true;
    }
}