<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('editfile'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>默认模板文件管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">默认模板文件管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
				<td width="25%" height="30" class="title2">文件名称</td>
				<td width="30%">创建日期</td>
				<td width="25%">文件大小</td>
				<td width="20%">操作</td>
		</tr>
		<?php
		
		//设置读取目录
		$dir = PHPMYWIND_ROOT.'/';

		//打开文件夹
		$handler = opendir($dir);

		$i = 0;
		while(($filename = readdir($handler)) !== false)
		{
			if($filename != '.' && $filename != '..' && !is_dir($dir.$filename))
			{
				$gbfilename = mb_convert_encoding($filename, 'utf-8', 'gb2312');
				
				if($cfg_editfile == 'Y')
				{
					$editstr = '<a href="editfile_do.php?filename='.urlencode($gbfilename).'">修改</a>';
				}
				else
				{
					$editstr = '<i style="font-style:normal;" title="不允许直接编辑PHP文件">修改</i>';
				}
		?>
		<tr align="center" class="mgr_tr">
				<td height="30" align="left"><span class="editfile_ico"><?php echo $gbfilename; ?></span></td>
				<td class="number"><?php echo date("Y-m-d H:i:s", filemtime($dir.$filename)); ?></td>
				<td><?php echo GetRealSize(filesize($dir.$filename)); ?></td>
				<td class="action"><span>[<?php echo $editstr; ?>]</span></td>
		</tr>
		<?php
			$i++;
			}
		}
		closedir($handler);
		?>
</table>
<div class="mgr_divb"> </div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $i; ?></span>条记录</div>
</div>
<div class="notewarn" id="notification"> <span class="close"><a href="javascript:;" id="notification_close" onclick="HideDiv('notification');"></a></span>
	<div>由于允许直接通过后台编辑PHP脚本文件对系统造成安全隐患，所以系统默认关闭修改，若想通过后台编辑PHP文件，在 '/admin/inc/config.inc.php' 中将 '$cfg_editfile' 值设为 'Y' 即可</div>
</div>
<br />
</body>
</html>