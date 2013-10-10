<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-10-16 13:19:25
person: Feng
**************************
*/


//初始化参数
$action    = isset($action) ? $action : '';
$datagroup = isset($datagroup) ? $datagroup : '';
$level     = isset($level) ? $level : '';
$v         = isset($areaval) ? $areaval : '0';


//检测用户是否存在
if($action == 'checkuser')
{
	$r = $dosql->GetOne("SELECT `username` FROM `#@__member` WHERE username='$username'");

	if(!is_array($r))
		echo '<span class="reok">可以使用</span>';
	else
		echo '<span class="renok">用户名已存在</span>';
	exit();
}


//获取级联
else if($action == 'getarea')
{
	$str = '<option value="-1">--</option>';
	$sql = "SELECT * FROM `#@__cascadedata` WHERE level=$level And ";

	if($v == 0)
		$sql .= "datagroup='$datagroup'";
	else if($v % 500 == 0)
		$sql .= "datagroup='$datagroup' AND datavalue>$v AND datavalue<".($v + 500);
	else
		$sql .= "datavalue LIKE '$v.%%%' AND datagroup='$datagroup'";
	
	$sql .= " ORDER BY orderid ASC, datavalue ASC";


	$dosql->Execute($sql);
	while($row = $dosql->GetArray())
	{
		$str .= '<option value="'.$row['datavalue'].'">'.$row['dataname'].'</option>';
	}
	
	if($str == '') $str .= '<option value="-1">--</option>'; 
	echo $str;
	exit();
}
?>