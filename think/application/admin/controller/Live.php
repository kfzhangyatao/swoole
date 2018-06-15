<?php
namespace app\admin\controller;
use app\common\lib\Util;
use app\common\lib\Predis;
class Live
{
    public function index(){
        echo 'ddd';
    }
    public function push(){
        if (empty($_GET)) {
            return Util::show(config('code.error'), 'error');
        }
        $teams = [
            1 => [
                'name' => '马刺',
                'logo' => '/live/imgs/team1.png'
            ],
            2 => [
                'name' => '火箭队',
                'logo' => '/live/imgs/team2.png'
            ],
        ];
        $data = [
            'method' => 'pushLive',
            'data' =>[
                'type' => intval($_GET['type']),
                'name' => !empty($teams[$_GET['team_id']]['name']) ? $teams[$_GET['team_id']]['name'] : '直播员',
                'logo' => !empty($teams[$_GET['team_id']]['logo']) ? $teams[$_GET['team_id']]['logo'] : '',
                'content' => !empty($_GET['content']) ? $_GET['content'] : '',
                'image' => !empty($_GET['image']) ? $_GET['image'] : '',
            ]
        ];
        $_POST['http_server']->task($data);
        return Util::show(config('code.success'), 'ok');
    }
}