<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/2/28
 * Time: 20:05
 */

// 实例化一个$redis对象
$redis = new Redis();
// 连接$redis服务
/**
 * 参数1  主机地址
 * 参数2  端口号
 */
$redis->connect('127.0.0.1', 6379);
// 密码的验证 如果没有密码则不需要此方法
// $redis->auth('100424');


return $redis;