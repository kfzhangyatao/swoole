<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
use think\facade\Config as MyConfig;
use app\common\lib\Predis;
class Index
{
    public function index()
    {
        echo 'taotao';
        //print_r($_GET);
        //echo ENV::get('APP_PATH').'../extend/ali/vendor/autoload.php';
        print_r(MyConfig::get('myconfig.aliSms.signName'));
        //echo config('myconfig.aliSms.signName').'dd';
        $val = rand(100, 999);
        //$redis = Predis::getInstance()->set('tao', $val, 200);
        echo config('myconfig.redis.host');
        //echo to_guid_string('sss');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function sms(){
        try{
            $ret = Sms::sendSms(17621142025, 12345);
            var_dump($ret);
        }
        catch(\Exception $e){
            // todo
            echo "message:".$e->getMessage();
            //echo 'ddd';
        }
    }
}
