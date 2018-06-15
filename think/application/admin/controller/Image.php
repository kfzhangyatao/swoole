<?php
namespace app\admin\controller;
use app\common\lib\Util;

class Image
{
    public function index(){
        $file = request()->file('file');
        $info = $file->move('../public/static/upload');
        
        if ($info) {
            $data = [
                'image' => config('myconfig.live.host') . $info->getSaveName(),
            ];
            return Util::show(config('code.success'), 'OK', $data);
        }else {
            return Util::show(config('code.error'), 'error');
        }
    }
}