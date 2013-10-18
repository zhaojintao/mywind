<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('upload_filemgr_sql'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传文件管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<?php

if(empty($dirname) or $dirname=='uploads/')
{
	$dirname = 'uploads/';
	$dirhigh = 'javascript:;';
	$dirtext = '上传根目录';
}
else
{
	$dirname = str_replace(array('..\\', '../', './', '.\\'), '', trim($dirname));
	$dirname = htmlspecialchars($dirname);
	$dirhigh = '?dirname=';
	$dirtext = '返回上一层';

	$dirarr = explode('/', $dirname);
	$curnum = count($dirarr)-2;
	for($i=0; $i<$curnum; $i++)
	{
		$dirhigh .= $dirarr[$i].'/';
	}
}
?>
<div class="mgr_header"> <span class="title">上传文件管理 </span><span class="header_text">[当前目录：<strong>/<?php echo $dirname; ?></strong><span>|</span><a href="<?php echo $dirhigh; ?>" class="topdir"><?php echo $dirtext; ?></a>]</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="upload_filemgr_save.php">
	<div class="mgr_divt">
		<ul class="flag">
			<li>属性：</li>
			<li><a href="upload_filemgr_sql.php">数据模式</a></li>
			<li><span>|</span></li>
			<li class="on_mode"><a href="upload_filemgr_dir.php">目录模式</a></li>
		</ul>
	</div>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead2" align="center">
			<td width="5%" height="25"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
			<td width="30%">文件名称</td>
			<td width="20%">上传日期</td>
			<td width="25%">文件大小</td>
			<td width="20%">操作</td>
		</tr>
		<?php

		//设置读取目录
		$dir = '../'.$dirname;

		//避免中文文件无法读取，强制转换
		$dir = iconv('utf-8', 'gb2312', $dir);

		//打开文件夹
		$handler = opendir($dir);

		$i = 0;
		while(($filename = readdir($handler)) !== false)
		{

			if($filename != '.' && $filename != '..'
			&& $filename != ($dirname=='uploads/' ? 'index.htm' : ''))
			{

				//用于显示中文目录
				$gbfilename = mb_convert_encoding($filename, 'utf-8', 'gb2312');

				if(is_dir($dir.$filename))
				{
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $gbfilename; ?>" disabled="disabled" /></td>
			<td><span class="isdir"><?php echo $gbfilename; ?></span></td>
			<td class="number"><span><?php echo date("Y-m-d H:i:s", filemtime($dir.$filename)); ?></span></td>
			<td><?php echo GetRealSize(GetDirSize($dir.$filename)); ?></td>
			<td class="action"><span>[<a href="upload_filemgr_dir.php?dirname=<?php echo urlencode($dirname.$gbfilename.'/'); ?>">进入</a>]</span><span>[<?php if($dirname == 'uploads/'){echo '删除';} else{ ?><a href="upload_filemgr_save.php?mode=dir&action=deldir&dirname=<?php echo urlencode($dirname); ?>&filename=<?php echo urlencode($filename.'/'); ?>" onclick="return ConfDel(0);">删除</a><?php } ?>]</span></td>
		</tr>
		<?php
				}
				else
				{
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $gbfilename; ?>" /></td>
			<td><?php echo $gbfilename; ?></td>
			<td class="number"><span><?php echo date("Y-m-d H:i:s", filemtime($dir.$filename)); ?></span></td>
			<td><?php echo GetRealSize(filesize($dir.$filename)); ?></td>
			<td class="action"><span>[<a href="../<?php echo $dirname.$gbfilename; ?>" target="_blank">预览</a>]</span><span>[<a href="upload_filemgr_save.php?mode=dir&action=delfile&dirname=<?php echo urlencode($dirname); ?>&filename=<?php echo urlencode($filename); ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
				}
			$i++;
			}
		}
		closedir($handler);
		?>
	</table>
	<input type="hidden" name="dirname" id="dirname" value="<?php echo $dirname; ?>" />
</form>
<?php
if($i == 0)
{
	echo '<div class="mgr_nlist">暂时没有上传的文件</div>';
}
?>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('upload_filemgr_save.php','&mode=dir');" onclick="return ConfDelAll(0);">删除</a></div>
</div>

<div class="page_area"> <div class="page_info">共<span><?php echo $i; ?></span>条记录</div> </div>
</body>
</html>