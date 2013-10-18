<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('job'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>招聘信息添加</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">招聘信息添加</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="job_save.php" onsubmit="return cfm_job();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">岗位名称：</td>
			<td width="75%"><input type="text" name="title" id="title" class="class_input" onblur="checkuser()" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span> <span id="usernote"></span></td>
		</tr>
		<tr>
			<td height="35" align="right">工作地点：</td>
			<td><input type="text" name="jobplace" id="jobplace" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">工作性质：</td>
			<td><input type="text" name="jobdescription" id="jobdescription" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">招聘人数：</td>
			<td><input type="text" name="employ" id="employ" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">性别要求：</td>
			<td><input type="radio" name="jobsex" value="0" checked="checked"  />
				不限&nbsp;
				<input type="radio" name="jobsex" value="1"  />
				男&nbsp;
				<input type="radio" name="jobsex" value="2"  />
				女</td>
		</tr>
		<tr>
			<td height="35" align="right">工资待遇：</td>
			<td><input type="text" name="treatment" id="treatment" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">有效期限：</td>
			<td><input type="text" name="usefullife" id="usefullife" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">工作经验：</td>
			<td><input type="text" name="experience" id="experience" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">学历要求：</td>
			<td><input type="text" name="education" id="education" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">语言能力：</td>
			<td><input type="text" name="joblang" id="joblang" class="class_input" /></td>
		</tr>
		<tr>
			<td height="264" align="right">职位描述：</td>
			<td><textarea id="workdesc" name="workdesc"></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="workdesc"]', {allowFileManager : true,width:'667px',height:'240px'});
				});
				</script></td>
		</tr>
		<tr>
			<td height="264" align="right">职位要求：</td>
			<td><textarea id="content" name="content"></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="content"]', {allowFileManager : true,width:'667px',height:'240px'});
				});
				</script></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" class="input_short" value="<?php echo GetOrderID('#@__job'); ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">更新时间：</td>
			<td><input type="text" name="posttime" id="posttime" class="input_short" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
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