<?php
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2019/2/28
 * Time: 20:57
 */

// 设计用户表 hash
// 添加用户
// set uid 1  // 用户id 自增
// hmset user:username:admin uid 1 username admin password 100424


// 设计文章表 hash
// set aid 1  // 文章id,自增
// hmset article:aid:1 aid:1 title $title cnt $cnt uid $uid

// list 存储文章id
// lpush 'article_id' 'article:id:' . $id

// 删除指定 'article:id:' . $id
// $res = $redis->lRem('article_id', "article:id:$aid", 1);

// 统计当天登录的人数 set
// set toDayNum $username 86400


