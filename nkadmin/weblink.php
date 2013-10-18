<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('weblink'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>友情链接管理</title>
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
<div class="mgr_header"> <span class="title">友情链接管理</span>
	<span class="alltype" id="alltype" onmouseover="ShowAllType('alltype');" onmouseout="HideAllType('alltype');">
		<?php
		if(isset($tid))
		{
			$r = $dosql->GetOne("SELECT classname FROM `#@__weblinktype` where id=$tid");
			$cname = $r['classname']; 
		}
		else
		{
			$cname = '查看全部';
		}
		?>
		<a href="?" class="btn"><?php echo $cname; ?></a>
		<span class="drop">
		<?php GetMgrType('#@__weblinktype'); ?>
		</span>
	</span>
	<a href="weblinktype.php" class="postype">[类别管理]</a>
	<span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<form name="form" id="form" method="post" action="weblink_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="10%">网站LOGO</td>
			<td width="5%">ID</td>
			<td>站点名称</td>
			<td>站点URL</td>
			<td>所属分类</td>
			<td width="18%">操作</td>
		</tr>
		<?php
		$sql = "SELECT * FROM `#@__weblink` WHERE `siteid`='$cfg_siteid'";
		if(isset($tid)) $sql .= " AND classid=$tid";
		$dopage->GetPage($sql);

		while($row = $dosql->GetArray())
		{
			$row2 = $dosql->GetOne("SELECT classname FROM `#@__weblinktype` WHERE id=".$row['classid']);

			if(isset($row2['classname']))
			{
				$classname = $row2['classname'].' ['.$row['classid'].']';
			}
			else
			{
				$classname = '<span class="red">分类已删除 ['.$row['classid'].']</span>';
			}
			
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
			<td height="70" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><span class="thumbs"><?php echo GetMgrThumbs($row['picurl']); ?></span></td>
			<td><?php echo $row['id']; ?></td>
			<td align="center"><span class="title"> <?php echo $row['webname']; ?></span></td>
			<td><a href="<?php echo $row['linkurl']; ?>" target="_blank" title="点击访问"><?php echo $row['linkurl']; ?></a></td>
			<td><?php echo $classname; ?></td>
			<td class="action"><span>[<a href="weblink_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="weblink_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="weblink_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(2);">删除</a>]</span></td>
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
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('weblink_save.php');" onclick="return ConfDel(0);">删除</a></div>
	<span class="mgr_btn"><a href="weblink_add.php">添加友情链接</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>