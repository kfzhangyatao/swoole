<?php
namespace app\common\lib;

/**
 * redis 调用方法
 */
class Predis
{
    public $redis = "";
    private static $_instance = null;

    /**
     * 共有得静态函数
     *
     * @return void
     */
    public static function getInstance(){
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 私有得构造方法
     */
    private function __construct(){
        $this->redis = new \Redis();
        $result = $this->redis->connect('127.0.0.1', 6379, 5);
        if ($result === false) {
            throw new \Exception("Redis connect error");
        }
    }

    /**
     * redis set 方法
     *
     * @param [type] $key
     * @param [type] $value
     * @param integer $time
     * @return void
     */
    public function set($key, $value, $time = 0){
        if (!$key) {
            return '';
        }
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if (!$time) {
            return $this->redis->set($key, $value);
        }
        return $this->redis->set($key, $value, $time);
    }

    public function get($key){
        if (!$key) {
            return false;
        }
        return $this->redis->get($key);
    }

    /**
     * 向集合添加一个或多个成员
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function sAdd($key, $value){
        return $this->redis->sAdd($key, $value);
    }

    /**
     * 移除集合中的一个元素
     *
     * @param [type] $key
     * @return void
     */
    public function sRem($key, $value){
        return $this->redis->sRem($key, $value);
    }

    public function sMembers($key){
        return $this->redis->sMembers($key);
    }

    public function del($key){
        return $this->redis->del($key);
    }

    public function __call($name, $arguments){
        if (count($arguments) != 2) {
            return '';
        }
        return $this->redis->$name($arguments[0], $arguments[1]);
    }
}
