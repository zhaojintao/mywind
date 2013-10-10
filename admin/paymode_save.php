<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('paymode');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-1-12 10:45:05
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__paymode';
$gourl  = 'paymode.php';


//引入操作类
require(ADMIN_INC.'/action.class.php');


//保存支付方式
if($action == 'save')
{
	if($classnameadd != '')
	{
		$dosql->ExecNoneQuery("INSERT INTO `$tbname` (classname, orderid, checkinfo) VALUES ('$classnameadd', '$orderidadd', '$checkinfoadd')");
	}

	if(isset($id))
	{
		$ids = count($id);
		for($i=0; $i<$ids; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET orderid='$orderid[$i]', classname='$classname[$i]' WHERE id=$id[$i]");
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