<?php	require(dirname(__FILE__).'/../include/common.inc.php');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-9-4 14:07:11
person: Feng
**************************
*/


//启动SESSION
if(!isset($_SESSION)) session_start();


//初始化参数
$action = isset($action) ? $action : '';


//锁屏操作
if($action == 'lock')
{
	if(!isset($_SESSION['admin'])) exit('Request Error!');

	$_SESSION['lockname'] = $_SESSION['admin'];
	unset($_SESSION['admin']);
	exit();
}


//锁屏密码
else if($action == 'check')
{
	if(!isset($_SESSION['lockname'])) exit('Request Error!');

	$row = $dosql->GetOne("SELECT `password` FROM `#@__admin` WHERE username='".$_SESSION['lockname']."'");

	if($row['password'] == md5(md5($password)))
	{
		$_SESSION['admin'] = $_SESSION['lockname'];
		unset($_SESSION['lockname']);

		echo TRUE;
		exit();
	}
	else
	{
		echo FALSE;
		exit();
	}
}


//设置当前站点
else if($action == 'selsite')
{
	if(isset($sitekeyvalue))
	{
		$r = $dosql->GetOne("SELECT `id`,`sitekey` FROM `#@__site` WHERE `sitekey`='$sitekeyvalue'");
		if(isset($r['id']))
		{
			$_SESSION['siteid']  = $r['id'];
			$_SESSION['sitekey'] = $r['sitekey'];
		}
		else
		{
			$r = $dosql->GetOne("SELECT `id`,`sitekey` FROM `#@__site` ORDER BY id ASC");
			if(isset($r['id']))
			{
				$_SESSION['siteid']  = $r['id'];
				$_SESSION['sitekey'] = $r['sitekey'];
			}
			else
			{
				$_SESSION['siteid']  = '';
				$_SESSION['sitekey'] = '';
			}
		}
	}

	//大后台不刷新左侧菜单
	if($_SESSION['adminlevel'] == 1)
		echo 1;
	else
		echo 2;
	
	exit();
}


//无条件返回
else
{
	exit('Request Error!');
}
?>