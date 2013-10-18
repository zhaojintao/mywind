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
<div class="mgr_header"> <span class="title">上传文件管理 </span><span class="header_text">[<a href="upload_filemgr_clear.php" class="clearfile">清理未使用文件</a>]</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<div class="mgr_divt">
	<ul class="flag">
		<li>属性：</li>
		<li class="on_mode"><a href="upload_filemgr_sql.php">数据模式</a></li>
		<li><span>|</span></li>
		<li><a href="upload_filemgr_dir.php">目录模式</a></li>
	</ul>
	<div id="search" class="search">
		<form name="search_f" id="search_f" method="get" action="">
			<span class="s">
			<input name="keyword" id="keyword" type="text" title="输入文件名进行搜索" value="<?php echo $keyword = isset($keyword) ? $keyword : ''; ?>" />
			</span> <span class="b"><a href="javascript:;" onclick="search_f.submit();"><img src="templates/images/search_btn.png" title="搜索" /></a></span>
		</form>
	</div>
</div>
<form name="form" id="form" method="post" action="">
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead2" align="center">
			<td width="5%" height="25"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
			<td width="20%">文件名称</td>
			<td width="20%">文件类型</td>
			<td width="20%">上传日期</td>
			<td width="20%">文件大小</td>
			<td width="15%">操作</td>
		</tr>
		<?php

		if(isset($keyword))
		{
			$sql = "SELECT * FROM `#@__uploads` WHERE name LIKE '%$keyword%'";
		}
		else
		{
			$sql = "SELECT * FROM `#@__uploads`";
		}

		$dopage->GetPage($sql, 50);
		while($row = $dosql->GetArray())
		{
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['path']; ?>" /></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['type']; ?></td>
			<td class="number"><span><?php echo GetDateTime($row['posttime']); ?></span></td>
			<td><?php echo GetRealSize($row['size']); ?></td>
			<td class="action"><span>[<a href="../<?php echo $row['path']; ?>" target="_blank">预览</a>]</span><span>[<a href="upload_filemgr_save.php?mode=sql&action=del&id=<?php echo $row['id']; ?>&path=<?php echo $row['path']; ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有上传的文件</div>';
}
?>
<div class="mgr_divb"> <span class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('upload_filemgr_save.php','&mode=sql');" onclick="return ConfDelAll(0);">删除</a></span></div>
<div class="page_area"> <?php echo $dopage->GetList(); ?> </div>
</body>
</html>