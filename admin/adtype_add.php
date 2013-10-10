<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('adtype'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加广告位</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加广告位</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="adtype_save.php" onsubmit="return cfm_adtype();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属广告位：</td>
			<td width="75%">
			<select name="parentid" id="parentid">
				<option value="0">一级广告位</option>
				<?php GetAllType('#@__adtype','#@__adtype','id'); ?>
			</select>
			<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">广告位名称：</td>
			<td><input type="text" name="classname" class="class_input" id="classname" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">广告位尺寸：</td>
			<td><input type="text" name="width" class="input_shorts" id="width" />
				宽度(px)　
				<input type="text" name="height" class="input_shorts" id="height" />
				高度(px)<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" class="class_input" style="width:80px;" value="<?php echo GetOrderID('#@__adtype'); ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" checked="checked"  />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" />
				隐藏</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="add" />
	</div>
</form>
</body>
</html>