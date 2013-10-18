<?php	require(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-1-1 11:39:01
person: Feng
**************************
*/


//初始化参数
$action = isset($action) ? $action : '';


if(isset($type))
{
	$tbname = "#@__$type";
}
else
{
	echo '参数错误，没有获取到表名称';
	exit();
}


//选择执行操作
switch($action)
{
	case 'reset':
		$sql = "UPDATE `$tbname` SET delstate='', deltime=0 WHERE id=$id";
		$dosql->ExecNoneQuery($sql);
	break;

	case 'del':
		$sql = "DELETE FROM `$tbname` WHERE id=$id";
		$dosql->ExecNoneQuery($sql);
	break;

	case 'resetall':
		$sql = "UPDATE `$tbname` SET delstate='', deltime=0 WHERE id IN ($ids)";
		$dosql->ExecNoneQuery($sql);
	break;

	case 'delall':
		$sql = "DELETE FROM `$tbname` WHERE id IN ($ids)";
		$dosql->ExecNoneQuery($sql);
	break;

	case 'empty':
		$sql = "DELETE FROM `$tbname` WHERE delstate='true'";
		$dosql->ExecNoneQuery($sql);
	break;
	default:
}

//Ajax输出数据
$dosql->Execute("SELECT * FROM `$tbname` WHERE delstate='true' ORDER BY deltime DESC");

if($dosql->GetTotalRow() == 0)
{
	echo '暂无内容';
	exit();
}
else
{
	while($row = $dosql->GetArray())
	{
	?>
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="mgr_table">
			<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
					<td width="30" align="center" height="28"><input type="checkbox" name="recycle_checkid[]" id="recycle_checkid[]" value="<?php echo $row['id']; ?>" /></td>
					<td width="30"><?php echo $row['id']; ?></td>
					<td align="left"><span title="删除日期：<?php echo GetDateTime($row['deltime'])."\n"; ?>所属栏目：<?php $r = $dosql->GetOne("SELECT `classname` FROM `#@__infoclass` WHERE id=".$row['classid']);echo $r['classname']; ?>"><?php echo $row['title'];?></span></td>
					<td width="90" class="action"><span><a href="javascript:;" onclick="RecycleRe('reset','<?php echo $row['id']; ?>')">还原</a></span><span>|</span><span><a href="javascript:;" onclick="RecycleRe('del',<?php echo $row['id']; ?>)">删除</a></span></td>
			</tr>
	</table>
<?php
	}
}
?>