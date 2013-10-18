<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admingroup'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理组管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">管理组管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr class="thead" align="center">
		<td width="10%" height="30">ID</td>
		<td width="20%">管理组名称</td>
		<td>管理组描述</td>
		<td width="20%">操作</td>
	</tr>
	<?php
	$sql = "SELECT * FROM `#@__admingroup`";

	$dopage->GetPage($sql,$cfg_pagenum,'ASC');
	while($row = $dosql->GetArray())
	{
		switch($row['checkinfo'])
		{
			case 'true':
				$checkinfo = '已审';
				break;  
			case 'false':
				$checkinfo = '未审';
				break;
			default:
				$checkinfo = '没有获取到参数';
		}
		
		if($row['id'] == 1)
			$checkstr = '已审';
		else
			$checkstr = '<a href="admingroup_save.php?id='.$row['id'].'&action=check&checkinfo='.$row['checkinfo'].'" title="点击进行审核与未审操">'.$checkinfo.'</a>';

		if($row['id'] == 1)
			$delstr = '删除';
		else
			$delstr = '<a href="admingroup_save.php?action=del&id='.$row['id'].'" onclick="return ConfDel(0);">删除</a>';
	?>
	<tr align="center" class="mgr_tr">
		<td height="30"><?php echo $row['id']; ?></td>
		<td><?php echo $row['groupname']; ?></td>
		<td><?php echo $row['description']; ?></td>
		<td class="action"><span>[<?php echo $checkstr; ?>]</span><span>[<a href="admingroup_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<?php echo $delstr; ?>]</span></td>
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
<div class="mgr_divb"> <span class="mgr_btn"><a href="admingroup_add.php">添加管理组</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>