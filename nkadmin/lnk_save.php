<?php	require(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-8-13 9:50:05
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__lnk';
$gourl  = 'lnk.php';
$action = isset($action) ? $action : '';


//引入操作类
require(ADMIN_INC.'/action.class.php');


//保存操作
if($action == 'save')
{
	if($lnknameadd != '')
	{
		$dosql->ExecNoneQuery("INSERT INTO `$tbname` (lnkname, lnklink, lnkico, orderid) VALUES ('$lnknameadd', '$lnklinkadd', '$lnkicoadd', '$orderidadd')");
	}

	if(isset($id))
	{
		$ids = count($id);
		for($i=0; $i<$ids; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET lnkname='$lnkname[$i]', lnklink='$lnklink[$i]', lnkico='$lnkico[$i]',  orderid='$orderid[$i]' WHERE id=$id[$i]");
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