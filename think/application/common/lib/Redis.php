<?php
namespace app\common\lib;

class Redis
{
    public static $pre = "sms_";
    public static $userPre = "user_";
    public static function smsKey($phoneNum){
        return self::$pre.$phoneNum;
    }

    public static function userKey($userName){
        return self::$userPre.$userName;
    }
    
}
