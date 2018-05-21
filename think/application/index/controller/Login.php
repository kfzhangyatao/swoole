<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
use app\common\lib\Util;
use app\common\lib\Redis;
use app\common\lib\Predis;
class Login
{
    public function send(){
        $phoneNum = $_GET['phone_num'];
        //echo 'dd';
        if (empty($phoneNum)) {
            return Util::show(config('code.error'), 'error');
        }
        // todo
        // 生成随机数
        $code = rand(10000, 99999);
        // try{
        //     $response = Sms::sendSms($phoneNum, $code);
        // }
        // catch(\Exception $e){
        //     return Util::show(config('code.error'), '发送短信失败');
        // }

        // 存redis
        $response['code'] = 'OK';
        if ($response['code'] === 'OK') {
            // redis
            $redis = new \Swoole\Coroutine\Redis();
            $redis->connect(config('myconfig.redis.host'), config('myconfig.redis.port'));
            $redis->set(Redis::smsKey($phoneNum), $code, config('myconfig.redis.out_time'));
            return Util::show(config('code.success'), '发送验证码成功');
        }else {
            return Util::show(config('code.error'), '发送短信失败');
        }
    }

    public function login(){
        $phoneNum = $_GET['phone_num'];
        $code = $_GET['code'];
        if (empty($phoneNum) || empty($code)) {
            return Util::show(config('code.error'), 'phone or code is error');
        }

        // redis code 
        try{
            $redisCode = Predis::getInstance()->get(Redis::smsKey($phoneNum));
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
        if ($code == $redisCode) {
            // 写入redis
            $data = [
                'user' => $phoneNum,
                'srcKey' => md5(Redis::userKey($phoneNum)),
                'time' => time(),
                'isLogin' => true,
            ];
            Predis::getInstance()->set(Redis::userKey($phoneNum), $data);
            return Util::show(config('code.success'), 'login is success', $data);
        }
        return Util::show(config('code.error'), 'code is error');
    }
}
