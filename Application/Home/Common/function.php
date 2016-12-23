<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

/**
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status   数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1){
    static $count;
    if(!isset($count[$category])){
        $count[$category] = D('Document')->listCount($category, $status);
    }
    return $count[$category];
}

/**
 * 获取段落总数
 * @param  string $id 文档ID
 * @return integer    段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_part_count($id){
    static $count;
    if(!isset($count[$id])){
        $count[$id] = D('Document')->partCount($id);
    }
    return $count[$id];
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
        case '#' === substr($url, 0, 1):
            break;        
        default:
            $url = U($url);
            break;
    }
    return $url;
}

/**
 * 数据分页
 * @author Seven
 * @param int $count 总记录数
 * @param int $rows 每页显示记录数
 * @return string 分页结果
 */
function page($count, $rows = 0){

    if((int)$rows <= 0){
        $rows = C('LIST_ROWS');
    }

    $Page = new \Think\Page($count,$rows);// 实例化分页类 传入总记录数和每页显示的记录数

    //让最后一页设置有效
    $Page->lastSuffix = false;
    /* 设置样式 */
    //$Page->setConfig('header','<span class="rows">共 %TOTAL_ROW% 条记录，每页'.$rows.'条，共%TOTAL_PAGE%页</span>');
    $Page->setConfig('first',"第一页");
    $Page->setConfig('last',"最后一页");
    $Page->setConfig('prev',"上一页");
    $Page->setConfig('next',"下一页");
    $Page->setConfig('theme', '%HEADER% <span class="page">%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%</span>');

    $show = $Page->show();// 分页显示输出

    return "<div class=\"data-page\">{$show}</div>";
}