<?php

/*
 * 说明：前端引用文件
**************************
(C)2010-2013 phpMyWind.com
update: 2011-7-6 10:46:47
person: Feng
**************************
*/

require(dirname(__FILE__).'/common.inc.php');
require(PHPMYWIND_INC.'/func.class.php');
require(PHPMYWIND_INC.'/page.class.php');


if(!defined('IN_PHPMYWIND')) exit('Request Error!');


//网站开关
if($cfg_webswitch == 'N')
{
	echo $cfg_switchshow.'<br /><br /><i>'.$cfg_webname.'</i>';
	exit();
}
?>