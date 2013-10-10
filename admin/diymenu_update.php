<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('diymenu'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改菜单项</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__diymenu` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改菜单项</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="diymenu_save.php" onsubmit="return cfm_diymenu();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="110" height="35" align="right">菜单名称：</td>
			<td><input type="text" name="classname" id="classname" class="class_input" value="<?php echo $row['classname']; ?>" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">排列顺序：</td>
			<td><table width="250" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><input type="text" name="orderid" id="orderid" value="<?php echo $row['orderid']; ?>" class="class_input" style="width:80px;" /></td>
						<td align="right">隐藏类别：</td>
						<td><input type="radio" name="checkinfo" id="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked';?> />
							显示&nbsp;
							<input type="radio" name="checkinfo" id="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked';?> />
							隐藏</td>
					</tr>
				</table></td>
		</tr>
		<tr class="nb">
			<td height="35" colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table" id="mgraction">
		<tr class="thead" align="center">
			<td width="110" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
			<td align="left">菜单项名称</td>
			<td align="left">跳转链接</td>
			<td>排序</td>
			<td width="10%">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__diymenu` WHERE parentid=$id ORDER BY orderid ASC");
		while($row = $dosql->GetArray())
		{					
		?>
		<tr align="center" class="mgr_tr">
			<td height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><input type="text" name="classnameupdate[]" id="classnameupdate[]" class="input_gray2" value="<?php echo $row['classname']; ?>" />
				<input type="hidden" name="upid[]" id="upid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><input type="text" name="linkurlupdate[]" id="linkurlupdate[]" class="input_gray2" value="<?php echo $row['linkurl']; ?>" /></td>
			<td><a href="diymenu_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=up"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input type="text" name="orderidupdate[]" id="orderidupdate[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
				<a href="diymenu_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=down"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td class="action"><span>[<a href="diymenu_save.php?action=del&tid=<?php echo $id; ?>&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
		}
		?>
		<tr align="center">
			<td height="25" colspan="5" class="tr_orange">新增一个菜单项</td>
		</tr>
		<tr align="center" class="mgr_tr">
			<td height="32"><a href="javascript:;" onclick="AddDmTr()"><img src="templates/images/add_row.gif" title="新增一行" /></a></td>
			<td align="left"><input type="text" name="classnameadd[]" id="classnameadd[]" class="input_gray2" /></td>
			<td align="left"><input type="text" name="linkurladd[]" id="linkurladd[]" class="input_gray2" /></td>
			<td><input type="text" name="orderidadd[]" id="orderidadd[]" class="input_gray_short" value="<?php echo GetOrderID('#@__diymenu'); ?>" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<div class="mgr_divb">
		<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('diymenu_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('diymenu_save.php');">更新排序</a></div>
		<span class="mgr_btn_short"><a href="#" onclick="UpdateForm('diymenu_save.php');">更新全部</a><a href="diymenu.php" style="margin-right:5px;">返回管理</a></span> </div>
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="tid" id="tid" value="<?php echo $id; ?>" />
		<input type="hidden" name="orderidnum" id="orderidnum" value="<?php echo GetOrderID('#@__diymenu'); ?>" />
</form>
<script type="text/javascript">
function GetDmOrderID()
{	
	parseInt($("#orderidnum").val());
}

function AddDmTr(id)
{
	$("#orderidnum").attr("value", parseInt($("#orderidnum").val())+1);
	str = '<tr align="center" class="mgr_tr"><td height="32"><span class="action">[<a href="javascript:;" onclick="DelDmTr($(this))">删</a>]</span></td><td align="left"><input name="classnameadd[]" type="text" id="classnameadd[]" class="input_gray2" /></td><td align="left"><input name="linkurladd[]" type="text" id="linkurladd[]" class="input_gray2" /></td><td><input name="orderidadd[]" type="text" id="orderidadd[]" class="input_gray_short" value="'+$("#orderidnum").val()+'" /></td><td>&nbsp;</td></tr>';
	$(".mgr_table").append(str);
}

function DelDmTr(trobj)
{
	trobj.parent().parent().parent().remove();
	$("#orderidnum").val(parseInt($("#orderidnum").val())-1);
}

GetDmOrderID();
</script>
</body>
</html>