<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('info'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改单页信息</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript">

/*
 * 当开启二级分类
 * 要利用Ajax异步获取内容
*/

function GetMainType(v)
{
	var classid = $("#classid").val();
	$.ajax({
		url : 'info_update_do.php?&classid='+classid+'&mainid='+v,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#loading2").attr("class","loading2");
		},
		success:GetDone
	});
}

function GetDone(data, textStatus, xmlHttp)
{
	if(xmlHttp.responseText != '')
	{
		var str = xmlHttp.responseText;
		var arr = new Array();
		arr = str.split('[-||-]');
		$("#content").val(arr[0]);
		$("#picurl").val(arr[1]);
		$("#posttime").val(arr[2]);

		//设置编辑器内容
		editor.html(arr[0]);
	}
	$("#loading2").attr("class","undis");
}
</script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__info` WHERE classid=$id AND mainid=-1");

$content  = isset($row['content'])  ? $row['content']  : '';
$picurl   = isset($row['picurl'])   ? $row['picurl']   : '';
$posttime = isset($row['posttime']) ? GetDateTime($row['posttime']) : GetDateTime(time());
?>
<div class="gray_header"> <span class="title">修改单页信息</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="info_save.php">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">栏目名称：</td>
			<td width="75%">
				<strong>
				<?php
				$r = $dosql->GetOne("SELECT classname FROM `#@__infoclass` WHERE id=$id");
				echo $r['classname'];
				?>
				</strong><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<?php
		if($cfg_maintype == 'Y')
		{
		?>
		<tr>
			<td height="35" align="right">所属二级类别：</td>
			<td><select name="mainid" id="mainid" onchange="GetMainType(this.value)">
					<option value="-1">请选择所属类别</option>
					<?php GetAllType('#@__maintype','#@__info','mainid'); ?>
				</select>
				<span class="maroon">*</span><span id="loading2" class="undis">数据读取中...</span></td>
		</tr>
		<?php
		}
		GetDiyField('0',$row);
		?>
		<tr>
			<td height="304" align="right">内　　容：</td>
			<td><textarea name="content" id="content" class="kindeditor"><?php echo $content; ?></textarea>
				<script type="text/javascript">
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="content"]', {allowFileManager : true,width:'667px',height:'280px'});
				});
				</script></td>
		</tr>
		<tr>
			<td height="35" align="right">缩略图片：</td>
			<td><input type="text" name="picurl" id="picurl" class="class_input" value="<?php echo $picurl; ?>" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">更新时间：</td>
			<td>
				<input type="text" name="posttime" class="input_short" id="posttime" value="<?php echo $posttime; ?>" readonly="readonly" />
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					//position       :    [440, 264],
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="classid" id="classid" value="<?php echo $id; ?>" />
		<input name="action" type="hidden" id="action" value="update" />
	</div>
</form>
</body>
</html>