<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('diymenu'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加菜单项</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加菜单项</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="diymenu_save.php" onsubmit="return cfm_diymenu();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="110" height="35" align="right">菜单名称：</td>
			<td><input type="text" name="classname" id="classname" class="class_input" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">排列顺序：</td>
			<td><table width="250" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><input type="text" name="orderid" id="orderid" value="<?php echo GetOrderID('#@__diymenu'); ?>" class="class_input" style="width:80px;" /></td>
						<td align="right">隐藏类别：</td>
						<td><input type="radio" name="checkinfo" value="true" checked="checked"  />
							显示&nbsp;
							<input type="radio" name="checkinfo" value="false" />
							隐藏</td>
					</tr>
				</table></td>
		</tr>
		<tr class="nb">
			<td height="35" colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="110" height="30">操作</td>
			<td align="left">菜单项名称</td>
			<td align="left">跳转链接</td>
			<td>排序</td>
		</tr>
		<tr align="center" class="mgr_tr">
			<td height="32"><a href="javascript:AddDmTr();"><img src="templates/images/add_row.gif" title="新增一行" /></a></td>
			<td align="left"><input type="text" name="classnameadd[]" id="classnameadd[]" class="input_gray2" /></td>
			<td align="left"><input type="text" name="linkurladd[]" id="linkurladd[]" class="input_gray2" /></td>
			<td width="12%"><input type="text" name="orderidadd[]" id="orderidadd[]" class="input_gray_short" value="" /></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="add" />
		<input type="hidden" name="orderidnum" id="orderidnum" value="<?php echo GetOrderID('#@__diymenu'); ?>" />
	</div>
</form>
<script type="text/javascript">
function GetDmOrderID()
{
	$("input[name^=orderidadd]").val(parseInt($("#orderid").val())+1);
	$("#orderidnum").val(parseInt($("#orderidnum").val())+1);
}

function AddDmTr()
{
	$("#orderidnum").attr("value", parseInt($("#orderidnum").val())+1);

	str = '<tr align="center" class="mgr_tr"><td height="32"><span class="action">[<a href="javascript:;" onclick="DelDmTr($(this))">删</a>]</span></td><td align="left"><input type="text" name="classnameadd[]" id="classnameadd[]" class="input_gray2" /></td><td align="left"><input type="text" name="linkurladd[]" id="linkurladd[]" class="input_gray2" /></td><td><input type="text" name="orderidadd[]" id="orderidadd[]" class="input_gray_short" value="'+$("#orderidnum").val()+'" /></td></tr>';

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