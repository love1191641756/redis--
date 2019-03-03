<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/2/28
 * Time: 20:08
 */

// 判断用户是否登录
session_start();
if(!$_SESSION['user']){
    // 没有登录,跳转到登录页面
    header('Location:login.php');
}

// 加载redis
$redis = require './class/Redis.php';

if($_POST){
    // 有数据提交
    $title = trim($_POST['title']);
    $cnt = trim($_POST['cnt']);
    if($title == '' || $cnt == ''){
        // 刷新跳转
        header("Refresh:3;url =" . $_SERVER['HTTP_REFERER']);
        // 输出信息
        die('文章标题和内容都不能为空');
    }
    if( !$redis->exists('aid') ){
        $redis->set('aid', 0);
    }
    // 添加文章到redis中
    // 1.用户id
    session_start();
    $data['uid'] = $_SESSION['user']['uid'];
    // 2.得到主键id值
    $id = $redis->incr('aid');
    // 3.把id放到文章列表中
    $redis->zAdd('article_set', $id, $id);
    // 4.把文章id放到对应的用户集合中
    $redis->sAdd('article_user', $id);
    // 5.把文章信息存在hash中
    $data['time'] = Date('Y-m-d');
    $data['title'] = $title;
    $data['cnt'] = $cnt;
    $data['aid'] = $id;
    $redis->hMSet('article:id:' . $id, $data);

    // 将文章id添加到列表中
    $redis->lPush('article_id', 'article:id:' . $id);
    // 添加成功,跳转到列表页
    header('Location:index.php');

}



// 加载添加页面
require './view/add.html';