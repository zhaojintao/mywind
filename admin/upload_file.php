<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('upload_file'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传新文件</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">上传新文件</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr class="thead" align="left">
		<td height="30">&nbsp;&nbsp;技巧提示</td>
	</tr>
	<tr align="left">
		<td><ul class="cache_tips">
				<li>如果您通过上传窗口上传失败时，您也可以尝试通过原始的上传方式进行上传，然后将上传地址手动填写到文本框内</li>
				<li>php.ini设置的最大内容提交限制为：<?php echo get_cfg_var('post_max_size'); ?>；最大文件上传大小为：<?php echo get_cfg_var('upload_max_filesize')?get_cfg_var('upload_max_filesize'):'不允许上传附件'; ?></li>
			</ul></td>
	</tr>
</table>
<div class="newupload">
	<iframe frameborder="0" src="upload_file_do.php" width="100%" height="70" scrolling="no"></iframe>
</div>
<div class="notewarn" id="notification"> <span class="close"><a href="javascript:;" id="notification_close" onclick="HideDiv('notification');"></a></span>
	<div><strong>允许上传格式　</strong>图片格式：<?php echo $cfg_upload_img_type; ?>　软件类型：<?php echo $cfg_upload_soft_type; ?>　多媒体类型：<?php echo $cfg_upload_media_type; ?></div>
</div>
</body>
</html>