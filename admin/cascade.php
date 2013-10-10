<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('cascade'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">级联数据管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="cascade_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="center">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="25%" align="left">级联名称</td>
			<td width="25%" align="left">级联标识</td>
			<td width="20%">排序</td>
			<td width="20%">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__cascade` ORDER BY orderid ASC, id ASC");
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
			{
		?>
		<tr align="center" class="mgr_tr">
			<td height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>,|,<?php echo $row['groupsign']; ?>"></td>
			<td><?php echo $row['id']; ?></td>
			<td align="left"><input type="text" name="groupname[]" id="groupname[]" class="input_gray2" value="<?php echo $row['groupname']; ?>" />
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><input type="text" name="groupsign[]" id="groupsign[]" class="input_gray2" value="<?php echo $row['groupsign']; ?>" /></td>
			<td><a href="cascade_save.php?id=<?php echo $row['id']; ?>&amp;orderid=<?php echo $row['orderid']; ?>&amp;action=up"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input name="orderid[]" type="text" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
			<a href="cascade_save.php?id=<?php echo $row['id']; ?>&amp;orderid=<?php echo $row['orderid']; ?>&amp;action=down"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td class="action"><span>[<a href="cascadedata.php?sign=<?php echo $row['groupsign'] ?>">查看</a>]</span><span>[<a href="cascade_save.php?action=delclass&amp;sign=<?php echo $row['groupsign'] ?>&amp;id=<?php echo $row['id'] ?>" onclick="return ConfDel(2);">删除</a>]</span></td>
		</tr>
		<?php
			}
		}
		else
		{
		?>
		<tr align="center">
			<td colspan="6" class="mgr_nlist">暂时没有相关的记录</td>
		</tr>
		<?php
		}
		?>
		<tr align="center">
			<td height="25" colspan="6" class="tr_orange">新增一个级联组</td>
		</tr>
		<tr align="left" class="mgr_tr">
			<td height="32">&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="text" name="groupname_add" id="groupname_add" class="input_gray2" /></td>
			<td><input type="text" name="groupsign_add" id="groupsign_add" class="input_gray2" /></td>
			<td align="center"><input type="text" name="orderid_add" id="orderid_add" class="input_gray_short" value="<?php echo GetOrderID('#@__cascade'); ?>" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:SubUrlParam('cascade_save.php?action=delallclass');" onclick="return ConfDelAll(2);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('cascade_save.php');">更新排序</a></div>
	<span class="mgr_btn_short"><a href="javascript:void(0);" onclick="form.submit();return false;">更新全部</a></span></div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow("#@__cascade"); ?></span>条记录</div>
</div>
</body>
</html>