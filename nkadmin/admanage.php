<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admanage'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/loadimage.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
<script type="text/javascript">
$(function(){
    $(".thumbs img").LoadImage();
});
</script>
</head>
<body>
<div class="mgr_header"> <span class="title">广告投放管理</span>
	<span class="alltype" id="alltype" onmouseover="ShowAllType('alltype');" onmouseout="HideAllType('alltype');">
		<?php
		if(isset($tid))
		{
			$r = $dosql->GetOne("SELECT classname FROM `#@__adtype` where id=$tid");
			$cname = $r['classname']; 
		}
		else
		{
			$cname = '查看全部';
		}
		?>
		<a href="?" class="btn"><?php echo $cname; ?></a>
		<span class="drop">
		<?php GetMgrType('#@__adtype'); ?>
		</span>
	</span>
	<a href="adtype.php" class="postype">[广告位管理]</a>
	<span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<form name="form" id="form" method="post" action="admanage_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="10%">缩略图</td>
			<td width="5%">ID</td>
			<td>广告标识</td>
			<td>投放范围</td>
			<td>广告形式</td>
			<td width="18%">操作</td>
		</tr>
		<?php
		$sql = "SELECT * FROM `#@__admanage` WHERE `siteid`='$cfg_siteid'";
		if(isset($tid)) $sql .= " AND `classid`=$tid";
		$dopage->GetPage($sql);

		while($row = $dosql->GetArray())
		{
			$r = $dosql->GetOne("SELECT `classname` FROM `#@__adtype` WHERE `id`=".$row['classid']);

			if(isset($r['classname']))
				$classname = $r['classname'].' ['.$row['classid'].']';
			else
				$classname = '<span class="red">分类已删除 ['.$row['classid'].']</span>';


			switch($row['checkinfo'])
			{
				case 'true':
				$checkinfo = '显示';
				break;  
				case 'false':
				$checkinfo = '隐藏';
				break;
				default:
				$checkinfo = '没有获取到参数';
			}
		?>
		<tr align="center" class="mgr_tr">
			<td height="70"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><span class="thumbs"><?php echo GetMgrThumbs($row['picurl']); ?></span></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $classname; ?></td>
			<td><?php echo $row['admode']; ?></td>
			<td class="action"><span>[<a href="admanage_save.php?action=check&id=<?php echo $row['id']; ?>&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="admanage_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="admanage_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a>]</span></td>
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
<div class="mgr_divb"> <span class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('admanage_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <span class="mgr_btn"><a href="admanage_add.php">添加新广告</a></span> </div>
<div class="pageinfo">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>