<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('job'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>招聘信息管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">招聘信息管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="job_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="18%" align="left" class="title">岗位名称</td>
			<td>工作地点</td>
			<td>工作性质</td>
			<td>招聘人数</td>
			<td>有效时间</td>
			<td width="15%">发布时间</td>
			<td width="18%">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__job` WHERE `siteid`='$cfg_siteid'");
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
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td align="left" class="title"><?php echo $row['title']; ?></td>
			<td><?php echo $row['jobplace']; ?></td>
			<td><?php echo $row['jobdescription']; ?></td>
			<td><?php echo $row['employ']; ?></td>
			<td><?php echo $row['usefullife']; ?></td>
			<td class="number"><?php echo GetDateTime($row['posttime']); ?></td>
			<td class="action"><span>[<a href="job_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="job_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="job_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
		}	
		?>
	</table>
</form>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('job_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
	<span class="mgr_btn"><a href="job_add.php">添加招聘信息</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>