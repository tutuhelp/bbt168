<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

//if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
/**
 * 非www跳转到www
 */
$host = $_SERVER['HTTP_HOST'];
$request_url = $_SERVER['REQUEST_URI'];
$is_www = stripos($host, "www.");

if($is_www === false){
    header( "HTTP/1.1 301 Moved Permanently" );
    header( "Location: http://www.{$host}{$request_url}" );
    die;
}

/**
 * 前台访问时直接绑定Home模块，后台访问正常
 * 保证前台url中不包含前台模块
 */
$is_admin = stripos($request_url,"/backend/");
if($is_admin === false){
    define('BIND_MODULE','Home');
}


/**
 * 系统调试设置
 * 项目正式部署后请设置为false
 */
define ( 'APP_DEBUG', true );

/**
 * 应用目录设置
 * 安全期间，建议安装调试完成后移动到非WEB目录
 */
define ( 'APP_PATH', './Application/' );

// if(!is_file(APP_PATH . 'User/Conf/config.php')){
// 	header('Location: ./install.php');
// 	exit;
// }

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define ( 'RUNTIME_PATH', './Runtime/' );

/**
 * 引入核心入口
 * ThinkPHP亦可移动到WEB以外的目录
 */
require './ThinkPHP/ThinkPHP.php';