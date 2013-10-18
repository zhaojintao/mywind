<?php	require(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>快捷方式管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">快捷方式管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="lnk_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="left">
			<td width="5%" height="30" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
			<td width="25%">快捷方式名称</td>
			<td width="25%">跳转链接</td>
			<td width="25%">ico地址</td>
			<td width="10%" align="center">排序</td>
			<td width="10%" align="center">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__lnk` ORDER BY orderid ASC");
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
			{	
		?>
		<tr align="left" class="mgr_tr">
			<td height="32" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><input type="text" name="lnkname[]" id="lnkname[]" class="input_gray2" value="<?php echo $row['lnkname']; ?>" />
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
			<td><input type="text" name="lnklink[]" id="lnklink[]" class="input_gray2" value="<?php echo $row['lnklink']; ?>" /></td>
			<td><input type="text" name="lnkico[]" id="lnkico[]" class="input_gray2" value="<?php echo $row['lnkico']; ?>" /></td>
			<td align="center"><a href="lnk_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=up"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input name="orderid[]" type="text" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
				<a href="lnk_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=down"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td class="action" align="center"><span>[<a href="lnk_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
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
			<td height="25" colspan="6" class="tr_orange">新增一个快捷方式</td>
		</tr>
		<tr align="left" class="mgr_tr">
			<td height="32">&nbsp;</td>
			<td><input type="text" name="lnknameadd" id="lnknameadd" class="input_gray2" /></td>
			<td><input type="text" name="lnklinkadd" id="lnklinkadd" class="input_gray2" /></td>
			<td><input type="text" name="lnkicoadd" id="lnkicoadd" class="input_gray2" /></td>
			<td align="center"><input type="text" name="orderidadd" id="orderidadd" class="input_gray_short" value="<?php echo GetOrderID('#@__lnk'); ?>" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('lnk_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('lnk_save.php');">更新排序</a></div>
	<span class="mgr_btn_short"><a href="javascript:void(0);" onclick="form.submit();return false;">更新全部</a></span></div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow("#@__lnk"); ?></span>条记录</div>
</div>
</body>
</html>