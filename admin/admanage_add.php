<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admanage'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加广告</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript">
function GetMode(m)
{
	if(m == "html")
	{
		$("#adarea").hide();
		$("#adtext").show();
	}
	else
	{
		$("#adarea").show();
		$("#adtext").hide();
	}
}
</script>
</head>
<body>
<div class="gray_header"> <span class="title">添加广告信息</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="admanage_save.php" onsubmit="return cfm_admanager();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">投放范围：</td>
			<td width="75%">
			<select name="classid" id="classid">
				<option value="-1">请选择投放范围</option>
				<?php GetAllType('#@__adtype','#@__adtype','id'); ?>
			</select>
			<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">广告标识：</td>
			<td><input name="title" type="text" class="class_input" id="title" />
			<span class="maroon">*</span><span class="cnote">例如：某某推广第三期</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td align="right">展示内容：</td>
			<td><input type="radio" name="admode" checked="checked" value="image" onclick="GetMode('image');" />
				图片 &nbsp;
				<input type="radio" name="admode" value="flash" onclick="GetMode('flash');" />
				Flash &nbsp;
				<input type="radio" name="admode" value="video" onclick="GetMode('video');" />
				视频 &nbsp;
				<input type="radio" name="admode" value="html" onclick="GetMode('html');" />
				HTML代码
				<div class="hr_10"></div>
				<div id="adarea" style="margin-bottom:7px;">
					<input type="text" name="picurl" class="class_input" id="picurl" />
					<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','广告内容上传','*.jpg;*.png;*.gif;*.swf;*.flv;*.wmv','文件格式:(*.jpg;*.png;*.gif;*.bmp;*.swf;*.flv;*.wmv)',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span> </div>
				<div id="adtext" class="undis" style="margin-bottom:7px;">
					<textarea name="adtext" id="adtext" class="class_areatext"></textarea>
				</div>
				</td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input type="text" name="linkurl" class="class_input" id="linkurl" /></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" class="input_short" id="orderid" value="<?php echo GetOrderID('#@__admanage'); ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">更新时间：</td>
			<td><input type="text" name="posttime" class="input_short" id="posttime" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
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
			<td><input type="radio" name="checkinfo" id="checkinfo" value="true" checked="checked" />
				是 &nbsp;
				<input type="radio" name="checkinfo" id="checkinfo" value="false" />
				否<span class="cnote">选择“否”则该广告不会显示在前台。</span></td>
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