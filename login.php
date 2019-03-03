<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/2/28
 * Time: 19:55
 */

// 加载redis
$redis = require './class/Redis.php';

// 登录页面
if($_POST){
    // 登录验证
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if($username == '' || $password == ''){
        // 刷新跳转
        header("Refresh:3;url =" . $_SERVER['HTTP_REFERER']);
        // 输出信息
        die('账号密码都不能为空');
    }
    // 查询redis,验证账号密码
    $user = $redis->hGetAll('user:username:' . $username);
    // var_dump($user);die;
    if(!$user){
        // 刷新跳转
        header("Refresh:3;url =" . $_SERVER['HTTP_REFERER']);
        // 输出信息
        die('用户不存在');
    }
    if( $user['password'] != $password ){
        // 记录错误
        // 判断是否有记录
        if( !$redis->exists($username) ){
            // 用户名对应的key不存在,进行设置,设置有效期
            $redis->setEx($username, 3600, 1);
        }else{
            // 存在,判断错误次数,是否超过三次
            if($redis->get($username) >= 3){
                // 刷新跳转
                header("Refresh:3;url =" . $_SERVER['HTTP_REFERER']);
                // 输出信息
                die('错误三次,请在一小时后再登录');
            }else{
                // 增加错误次数
                $redis->incr($username);
            }
        }
        // 刷新跳转
        header("Refresh:3;url =" . $_SERVER['HTTP_REFERER']);
        // 输出信息
        die('密码错误');
    }
    // 登录成功,设置登录标识
    session_start();
    $_SESSION['user'] = $user;
    // 统计当天登录的人数
    if( !$redis->sIsMember('toDayNum', $username) ){
        // 没有统计,在集合中添加一个元素
        $redis->sAdd('toDayNum', $username);
    }

    // 跳转到首页
    // 刷新跳转
    header("Refresh:3;url=index.php");
    // 输出信息
    die('登录成功');
}


// 加载登录页面
require './view/login.html';