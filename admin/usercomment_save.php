<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('usercomment');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-10-8 17:32:29
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__usercomment';
$gourl  = 'usercomment.php';
$action = isset($action) ? $action : '';


//引入操作类
require(ADMIN_INC.'/action.class.php');


//无条件返回
header("location:$gourl");
exit();
?>