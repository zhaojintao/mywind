<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('site'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>站点管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">站点管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr class="thead" align="center">
		<td width="10%" height="30">ID</td>
		<td width="40%">站点名称</td>
		<td width="30%">站点标识</td>
		<td width="20%">操作</td>
	</tr>
	<?php

	$sql = "SELECT * FROM `#@__site`";

	$dopage->GetPage($sql,$cfg_pagenum,'ASC');
	while($row = $dosql->GetArray())
	{
		if($row['id'] == 1)
			$delstr = '删除';
		else
			$delstr = '<a href="site_save.php?action=del&id='.$row['id'].'" onclick="return ConfDel(0);">删除</a>';
	?>
	<tr align="center" class="mgr_tr">
		<td height="30"><?php echo $row['id']; ?></td>
		<td><?php echo $row['sitename']; ?></td>
		<td><?php echo $row['sitekey']; ?></td>
		<td class="action"><span>[<a href="site_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<?php echo $delstr; ?>]</span></td>
	</tr>
	<?php
	}
	?>
</table>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb"> <span class="mgr_btn"><a href="site_add.php">添加新站点</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>