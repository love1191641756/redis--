<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/2/28
 * Time: 19:08
 */

// 判断用户是否登录
session_start();
if(!$_SESSION['user']){
    // 没有登录,跳转到登录页面
    header('Location:login.php');
}
// var_dump($_SESSION['user']);



// 加载redis
$redis = require './class/Redis.php';

// 获取今日在线人数
$num = $redis->sCard('toDayNum');


// 分页
$page = $_GET['page'] ?? 1;
// 每页显示条数
$offcount = 2;
// 计算开始下标
$start = ($page - 1) * ($offcount + 1);
// 计算结束下标
$stop =  $page == 1 ? $page * $offcount : $page * ($offcount +1) - 1;
// 总记录数
$counts = count( $redis->lRange('article_id', 0, -1) );
// 总页数
$pages = ceil($counts/( $offcount + 1 ));

// 计算上一页--->当前页-1,如果是第一页就为1
$prev = $page > 1 ? $page - 1 : 1;

// 计算下一页--->当前页+1,如果是最有一页就为总页数
$next = $page < $pages ? $page + 1 : $pages;

// 获取全部文章列表
$articles = [];

// 获取所有的文章id                  开始下标  结束下标
$aid = $redis->lRange('article_id', $start,  $stop);

foreach($aid as $v){
    array_push($articles, $redis->hGetAll($v));
}
//var_dump($articles);
var_dump($start);
var_dump($stop);
// 加载模板
require './view/index.html';