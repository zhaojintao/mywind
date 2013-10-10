<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('fragment'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>碎片数据管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">碎片数据管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr class="thead" align="center">
		<td width="5%" height="30">ID</td>
		<td width="50%">标识名称</td>
		<td width="25%">更新时间</td>
		<td width="20%">操作</td>
	</tr>
	<?php
	$sql = "SELECT * FROM `#@__fragment`";
	$dopage->GetPage($sql,$cfg_pagenum,'ASC');
	while($row = $dosql->GetArray())
	{
	?>
	<tr align="center" class="mgr_tr">
		<td height="30"><?php echo $row['id']; ?></td>
		<td><?php echo $row['title']; ?></td>
		<td class="number"><?php echo GetDateTime($row['posttime']); ?></td>
		<td class="action"><span>[<a href="fragment_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="fragment_save.php?action=del2&id=<?php echo $row['id']; ?>">删除</a>]</span></td>
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
<div class="mgr_divb"> <span class="mgr_btn"><a href="fragment_add.php">添加碎片数据</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
<div class="notewarn" id="notification"> <span class="close"><a href="javascript:;" id="notification_close" onclick="HideDiv('notification');"></a></span>
	<div>【碎片数据】一般用于页面中的数据需要后台更新，但不需要建立栏目的模块</div>
</div>
</body>
</html>