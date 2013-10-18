<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('usergroup'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户组管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">用户组管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="usergroup_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="center">
			<td width="5%" height="30" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
			<td width="5%">ID</td>
			<td width="25%" align="left">用户组名称</td>
			<td width="15%">用户组经验值</td>
			<td width="20%">星星数</td>
			<td width="15%">头衔颜色</td>
			<td width="10%">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__usergroup` ORDER BY id ASC");
		
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
			{			
		?>
		<tr align="center" class="mgr_tr">
			<td height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td align="left"><input type="text" name="groupname[]" id="groupname[]" class="input_gray2" value="<?php echo $row['groupname']; ?>" />
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
			<td><input type="text" name="expvala[]" id="expvala[]" class="input_gray_short2" value="<?php echo $row['expvala']; ?>" />
				~
			<input type="text" name="expvalb[]" id="expvalb[]" class="input_gray_short2" value="<?php echo $row['expvalb']; ?>" /></td>
			<td><input type="text" name="stars[]" id="stars[]" class="input_gray_short" value="<?php echo $row['stars']; ?>" /></td>
			<td align="center"><input type="text" name="color[]" id="color[]" class="input_gray2" value="<?php echo $row['color']; ?>" /></td>
			<td class="action" align="center"><span>[<a href="usergroup_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
			}
		}
		else
		{
		?>
		<tr align="center">
			<td colspan="7" class="mgr_nlist">暂时没有相关的记录</td>
		</tr>
		<?Php
		}
		?>
		<tr align="center">
			<td height="25" colspan="7" class="tr_orange">新增一个用户组</td>
		</tr>
		<tr align="center" class="mgr_tr">
			<td height="32">&nbsp;</td>
			<td>&nbsp;</td>
			<td align="left"><input type="text" name="groupname_add" id="groupname_add" class="input_gray2" /></td>
			<td><input type="text" name="expvala_add" id="expvala_add" class="input_gray_short2" value="" />
				~
				<input type="text" name="expvalb_add" id="expvalb_add" class="input_gray_short2" value="" /></td>
			<td><input type="text" name="stars_add" id="stars_add" class="input_gray_short" /></td>
			<td><input type="text" name="color_add" id="color_add" class="input_gray2" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('usergroup_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
	<span class="mgr_btn_short"><a href="javascript:void(0);" onclick="form.submit();return false;">更新全部</a></span></div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow("#@__usergroup"); ?></span>条记录</div>
</div>
</body>
</html>