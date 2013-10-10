<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('infoclass');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2013-4-17 13:45:33
person: Feng
**************************
*/


//初始化参数
$action = isset($action) ? $action : '';


//获取栏目缩略图大小
if($action == 'catpsize')
{
	$str = '';

	$r = $dosql->GetOne("SELECT `picwidth`,`picheight` FROM `#@__infoclass` WHERE `id`=".$pid);
	if(isset($r['picwidth']))
		$str .= $r['picwidth'];
	
	if(isset($r['picheight']))
		$str .= '|'.$r['picheight'];
	
	if($str != '')
		echo $str;
}
?>