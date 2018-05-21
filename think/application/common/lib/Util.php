<?php
namespace app\common\lib;

/**
 * 前端显示类
 *
 * @author zhangyatao <kfzhangyatao@email.com>
 */
class Util
{
    /**
     * 显示方法
     *
     * @param integer $code
     * @param string $message
     * @param array $data
     * @return json
     */
    public static function show($code = 0, $message = '', $data = []){
        $data = [
            'status'=>0,
            'message'=>$message,
            'data'=>$data
        ];
        return json($data);
    }
}
