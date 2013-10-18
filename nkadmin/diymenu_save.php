<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('diymenu');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-1-10 8:29:19
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__diymenu';
$gourl  = isset($tid) ? 'diymenu_update.php?id='.$tid : 'diymenu.php';
$action = isset($action) ? $action : '';


//添加自定义菜单项
if($action == 'add')
{
	$sql = "INSERT INTO `$tbname` (siteid, parentid, classname, linkurl, orderid, checkinfo) VALUES ('$cfg_siteid', '0', '$classname', '', '$orderid', '$checkinfo')";
	$dosql->ExecNoneQuery($sql);

	$r = $dosql->GetOne("SELECT id FROM `$tbname` WHERE classname='$classname' ORDER BY id DESC LIMIT 0,1");
	$parentid = $r['id'];

	if(is_array($classnameadd))
	{
		$namenum = count($classnameadd);
		for($i=0; $i<$namenum; $i++)
		{
			if($classnameadd[$i] != '')
			{
				$dosql->ExecNoneQuery("INSERT INTO `$tbname` (siteid, parentid, classname, linkurl, orderid, checkinfo) VALUES ('$cfg_siteid', '$parentid', '$classnameadd[$i]', '$linkurladd[$i]', '$orderidadd[$i]', 'true')");
			}
		}
	}
	
	header("location:$gourl");
	exit();
}


//修改自定义菜单项
else if($action == 'update')
{
	$upid = isset($upid) ? $upid : 0;

	$sql = "UPDATE `$tbname` SET siteid='$cfg_siteid', parentid='0', classname='$classname', linkurl='', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	$dosql->ExecNoneQuery($sql);

	if(is_array($upid))
	{
		$upidnum = count($upid);
		for($i=0; $i<$upidnum; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET siteid='$cfg_siteid', parentid='$id', classname='$classnameupdate[$i]', linkurl='$linkurlupdate[$i]', orderid='$orderidupdate[$i]', checkinfo='true' WHERE id=$upid[$i]");
		}
	}

	$namenum = count($classnameadd);
	for($i=0; $i<$namenum; $i++)
	{
		if($classnameadd[$i] != '')
		{
			$dosql->ExecNoneQuery("INSERT INTO `$tbname` (siteid, parentid, classname, linkurl, orderid, checkinfo) VALUES ('$cfg_siteid', '$id', '$classnameadd[$i]', '$linkurladd[$i]', '$orderidadd[$i]', 'true')");
		}
	}

	header("location:$gourl");
	exit();
}


//删除操作
else if($action == 'del')
{
	$dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE (id=$id Or `parentid`=$id)");
	header("location:$gourl");
	exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>