<?php
// swoole_table 是一个基于共享内存和锁实现的超高性能,并发数据结构
// 创建内存表
$table = new Swoole\Table(1024);
// 增加行
$table->column('id',Swoole\Table::TYPE_INT,4);
$table->column('name', Swoole\Table::TYPE_STRING, 64);
$table->column('age', Swoole\Table::TYPE_INT,1);
$table->create();

$table->set("assasin",['id' => 1,'name' => 'shibin','age' => 25]);
// 另一种
$table['assasin-2'] = [
    'id' => 2,'name' => 'shibin-2','age' => 28
];
var_dump($table->get('assasin'));
var_dump($table['assasin-2']);
// 自增
$table->incr('assasin-2','age',5);
var_dump($table['assasin-2']);
// 自减
$table->decr('assasin-2','age',10);
var_dump($table['assasin-2']);
// 删除
$table->del('assasin');