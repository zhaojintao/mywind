<?php	require(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-8-28 13:45:46
person: Feng
**************************
*/


//初始化变量
$b_url = 'templates/html/default.html';
$s_url = 'templates/html/default_user.html';

require($b_url);
/*
 * 浏览状态，$_SESSION['adminlevel']
 *
 * 超级管理员 1 普通管理员 2 文章管理员 
 * 10 包含所有身份(切换身份的虚拟值)
*/

// if($_SESSION['adminlevel'] == 1 or
//    $_SESSION['adminlevel'] == 999)
// {
// 	if(isset($c) && $c=='preview')
// 	{
// 		require($s_url);
// 		$_SESSION['adminlevel'] = 999;
// 	}
// 	else
// 	{
// 		require($b_url);
// 		$_SESSION['adminlevel'] = 1;
// 	}
// }

// else
// {
// 	require($s_url);
// }
?>