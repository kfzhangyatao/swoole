<?php
namespace app\index\controller;
use \app\common\lib\Util;

class Chart
{
    public function index(){
        $data = [
            'method' => 'pushChart',
            'data' => [
                'content' => $_POST['content'],
                'game_id' => $_POST['game_id']
            ]
        ];
        $_POST['http_server']->task($data);

        return Util::show(config('code.success'), 'ok');
    }
}