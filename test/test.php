<?php


$redis = new \Redis();
$redis->connect('192.168.1.78', 6379, 5);
//echo $redis->get('name');
var_dump($redis->sIsMember('dddd', 1));
var_dump($redis->sMembers('dddd'));
