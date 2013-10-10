<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('info');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2011-5-9 22:21:13
person: Feng
**************************
*/


$row = $dosql->GetOne("SELECT * FROM `#@__info` WHERE classid=$classid AND mainid=$mainid");
if(is_array($row))
{
	echo $row['content'].'[-||-]'.$row['picurl'].'[-||-]'.GetDateTime($row['posttime']);
	exit();
}
else
{
	echo '[-||-][-||-]'.GetDateTime(time());
	exit();
}
?>