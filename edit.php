<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/3/2
 * Time: 21:05
 */

// 加载redis
$redis = require './class/Redis.php';

if($_POST){
    // 修改
    $data['title'] = $_POST['title'];
    $data['cnt'] = $_POST['cnt'];
    $aid = $_POST['aid'];
    $redis->hMset("article:id:$aid", $data);
    // 更新成功,跳转到首页
    header('Location:index.php');
}

// 接收数据
$aid = $_GET['aid'];

// 根据$aid获取文章信息
$data = $redis->hGetAll('article:id:' . $aid);
//var_dump($data);
// 加载编辑页面
require './view/edit.html';
