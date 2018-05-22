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
    public function sendSms($data){
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
            $ret = Predis::getInstance()->set(Redis::smsKey($data['data']['phone_num']), $data['data']['code'], 5);

            return $ret;
        }

        return false;
    }
}