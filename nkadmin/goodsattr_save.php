<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goodstype');
	
/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-12-30 13:05:27
person: Feng
**************************
*/


//初始化参数
$gid    = !empty($gid) ? intval($gid) : 0;
$tbname = '#@__goodsattr';
$gourl  = 'goodsattr.php?gid='.$gid;


//商品类型出错
if(empty($gid))
{
	header("location:$gourl");
	exit();
}


//引入操作类
require(ADMIN_INC.'/action.class.php');


//保存商品属性
if($action == 'save')
{
	if($attrnameadd != '')
	{
		$dosql->ExecNoneQuery("INSERT INTO `$tbname` (goodsid, attrname, orderid, checkinfo) VALUES ('$gid', '$attrnameadd', '$orderidadd', '$checkinfoadd')");
	}

	if(isset($id))
	{
		$ids = count($id);
		for($i=0; $i<$ids; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET orderid='$orderid[$i]', attrname='$attrname[$i]' WHERE id=$id[$i]");
		}
	}

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