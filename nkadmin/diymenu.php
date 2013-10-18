<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('diymenu'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自定义菜单管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">自定义菜单管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="diymenu_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td align="left">菜单项名称</td>
			<td width="20%">跳转链接</td>
			<td width="25%">排序</td>
			<td width="20%">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__diymenu` WHERE `siteid`='$cfg_siteid' AND parentid=0 ORDER BY orderid ASC");
		while($row = $dosql->GetArray())
		{
			switch($row['checkinfo'])
			{
				case 'true':
				$checkinfo = '显示';
				break;  
				case 'false':
				$checkinfo = '隐藏';
				break;
				default:
				$checkinfo = '没有获取到参数';
			}
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id'] ?>" /></td>
			<td align="left" class="menuname"><?php echo $row['classname']; ?>
				<input type="hidden" name="id[]2" id="id[]2" value="<?php echo $row['id']; ?>" /></td>
			<td>&nbsp;</td>
			<td><a href="diymenu_save.php?action=up&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
				<a href="diymenu_save.php?action=down&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td height="30" class="action"><span>[<a href="diymenu_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行显示与隐藏操作"><?php echo $checkinfo; ?></a></span><span><a href="diymenu_update.php?id=<?php echo $row['id']; ?>">修改</a></span><span><a href="diymenu_save.php?action=del&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__diymenu` WHERE parentid=".$row['id']." ORDER BY orderid ASC", $row['id']);
		while($row2 = $dosql->GetArray($row['id']))
		{
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row2['id'] ?>" /></td>
			<td align="left"><span class="sub_type_ico"><?php echo $row2['classname']; ?>
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row2['id']; ?>" />
				</span></td>
			<td class="number"><?php echo $row2['linkurl']; ?></td>
			<td><a href="diymenu_save.php?id=<?php echo $row2['id']; ?>&parentid=<?php echo $row2['parentid']; ?>&orderid=<?php echo $row2['orderid']; ?>&action=up"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row2['orderid']; ?>" />
				<a href="diymenu_save.php?id=<?php echo $row2['id']; ?>&parentid=<?php echo $row2['parentid']; ?>&orderid=<?php echo $row2['orderid']; ?>&action=down"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td class="mgr_action">&nbsp;</td>
		</tr>
		<?php
		}
	}
	?>
	</table>
</form>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('diymenu_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('diymenu_save.php');">更新排序</a></div>
	<div class="mgr_btn"><a href="diymenu_add.php">添加菜单项</a></div>
</div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow('#@__diymenu',$cfg_siteid); ?></span>条记录</div>
</div>
</body>
</html>