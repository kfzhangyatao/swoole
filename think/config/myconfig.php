<?php
return [
    // ali 短信发送配置
    'aliSms' => [
        'signName' => 'taotao-test',
        'templateCode' => 'SMS_134600001',
        'accessKeyId' => 'LTAIf2VRIqrif1ll',
        'accessKeySecret' => '5689TiXkKJ29bPL3dfMoLpYwZPFRX7'
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => '6379',
        'out_time' => 120,
        'timeOut' => 5, //连接得超时时间
        'live_game_key' => 'live_game_key',
    ],
    'live' => [
        'host' => 'http://172.19.241.22:9502/upload/',
    ],
    
];