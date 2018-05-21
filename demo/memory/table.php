<?php
// 创建内容表
$table = new swoole_table(1024);

// 内存表增加一列
$table->column('id', $table::TYPE_INT, 4);
$table->column('name', $table::TYPE_STRING, 64);
$table->column('age', $table::TYPE_INT, 4);
$table->create();

$table->set('fly', ['id' => 1, 'name' => 'fly', 'age'=> 27]);
// 另一种方法
$table['fly2']=[
    'id' => 2,
    'name' => 'fly2',
    'age' => 27
];
$ret = $table->get('fly');

$table->incr('fly2', 'age', 1);
print_r($table['fly2']);