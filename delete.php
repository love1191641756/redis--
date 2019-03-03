<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/3/2
 * Time: 21:17
 */

// 加载redis
$redis = require './class/Redis.php';

$aid = $_GET['aid'];
// 列表中删除指定的aid
$res = $redis->lRem('article_id', "article:id:$aid", 1);

// 删除文章hash
$res = $redis->delete("article:id:$aid");
if($res){
    // 删除成功
    $data = [
        'code' => '10000',
        'msg' => '删除成功'
    ];
}else{
    // 删除失败
    $data = [
        'code' => '10001',
        'msg' => '删除成功'
    ];
}

echo json_encode($data);

