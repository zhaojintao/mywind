<?php	require(dirname(__FILE__).'/include/config.inc.php');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2013-4-27 16:57:34
person: Adu
**************************
*/


//定义入口常量
define('IN_MOBILE', TRUE);


//初始化参数
$m   = isset($m)   ? $m   : 'index';     //控制显示模型
$c   = isset($c)   ? $c   : '';          //控制显示形式
$a   = isset($a)   ? $a   : '';          //控制执行操作
$cid = isset($cid) ? intval($cid) : 0;   //显示栏目ID
$id  = isset($id)  ? intval($id)  : 0;   //显示内容ID


//首页
if($m == 'index')
{
	require(PHPMYWIND_TEMP.'/default/mobile/index.php');
	exit();
}

//二级页
else if($m == 'page' or $m == 'list' or $m == 'img')
{
	require(PHPMYWIND_TEMP.'/default/mobile/page.php');
	exit();
}

//详细页
else if($m == 'show')
{
	require(PHPMYWIND_TEMP.'/default/mobile/show.php');
	exit();
}
?>