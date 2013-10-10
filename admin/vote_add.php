<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('vote'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加投票信息</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript">
function AddDmTr()
{
	str = '<tr><td height="35" align="right"><span class="delvote">[<a href="javascript:;" onclick="DelDmTr($(this))">删</a>]</span>：</td><td><input type="text" name="options[]" id="options[]" class="class_input" /></td></tr>';
	$("#tboption").append(str);
}

function DelDmTr(trobj)
{
	trobj.parent().parent().parent().remove();
}
</script>
</head>
<body>
<div class="gray_header"> <span class="title">添加投票信息</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="vote_save.php" onsubmit="return cfm_vote();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">投票标题：</td>
			<td width="75%"><input type="text" name="title" id="title" class="class_input" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span> <span id="usernote"></span></td>
		</tr>
		<tr>
			<td height="116" align="right">投票描述：</td>
			<td><textarea name="content" id="content" class="class_areatext"></textarea></td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table" id="tboption">
		<tr>
			<td width="25%" height="35" align="right">投票项目：</td>
			<td width="75%"><input type="text" name="options[]" id="options[]" class="class_input" /> <span class="cnote"><a href="javascript:AddDmTr();"><img src="templates/images/add_row.gif" title="新增一个项目" /></a></span></td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">开始时间：</td>
			<td width="75%"><input type="text" name="starttime" id="starttime" class="input_short" value="" readonly="readonly" />
			<script type="text/javascript">
				Calendar.setup({
					inputField     :    "starttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr>
			<td height="35" align="right">结束时间：</td>
			<td><input type="text" name="endtime" id="endtime" class="input_short" value="" readonly="readonly" />
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "endtime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr>
			<td height="35" align="right">游客投票：</td>
			<td><input type="radio" name="isguest" value="true" checked="checked"  />
				允许&nbsp;
				<input type="radio" name="isguest" value="false"  />
				不允许</td>
		</tr>
		<tr>
			<td height="35" align="right">查看投票：</td>
			<td><input type="radio" name="isview" value="true" checked="checked"  />				
				允许&nbsp;
				<input type="radio" name="isview" value="false"  />
				不允许</td>
		</tr>
		<tr>
			<td height="35" align="right">投票间隔：</td>
			<td><input type="text" name="intval" id="intval" class="class_input" />
				<span class="cnote">分钟为单位，0 表示此IP地址只能投一次</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">是否多选：</td>
			<td><input type="radio" name="isradio" value="1" checked="checked"  />
				单选&nbsp;
				<input type="radio" name="isradio" value="2"  />
				多选</td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" class="input_short" value="<?php echo GetOrderID('#@__vote'); ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">更新时间：</td>
			<td><input type="text" name="posttime" id="posttime" class="input_short" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">发　布：</td>
			<td><input type="radio" name="checkinfo" value="true" checked="checked"  />
				是 &nbsp;
				<input type="radio" name="checkinfo" value="false" />
				否<span class="cnote">选择“否”则该信息不会显示在前台。</span></td>
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