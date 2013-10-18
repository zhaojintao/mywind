<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('info'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单页信息管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">单页信息管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr class="thead" align="center">
		<td width="5%" height="30">ID</td>
		<td align="left" class="title2">单页名称</td>
		<td width="45%">更新时间</td>
		<td width="20%">操作</td>
	</tr>
	<?php
	
	//权限验证
	if($_SESSION['adminlevel'] != 1)
	{
		//初始化参数
		$catgoryListPriv   = array();
		$catgoryUpdatePriv = array();

		$dosql->Execute("SELECT * FROM `#@__adminprivacy` WHERE `groupid`=".$_SESSION['adminlevel']." AND `model`='category' AND `action`<>'add' AND `action`<>'del'");
		while($row = $dosql->GetArray())
		{
			//查看权限
			if($row['action'] == 'list')
				$catgoryListPriv[]   = $row['classid'];
			
			//修改权限
			if($row['action'] == 'update')
				$catgoryUpdatePriv[] = $row['classid'];
		}
	}


	//循环单页
	$dopage->GetPage("SELECT * FROM `#@__infoclass` WHERE `siteid`='$cfg_siteid' AND `infotype`=0",$cfg_pagenum,'ASC');
	while($row = $dosql->GetArray())
	{
		if($_SESSION['adminlevel'] != 1)
		{
			if(in_array($row['id'],$catgoryListPriv))
			{
	?>
	<tr align="center" class="mgr_tr">
		<td height="30"><?php echo $row['id']; ?></td>
		<td align="left" class="title2"><?php echo $row['classname']; ?></td>
		<td class="number">
		<?php
		$r = $dosql->GetOne("SELECT `content`,`posttime` FROM `#@__info` WHERE `classid`=".$row['id']);
		if(isset($r['content']))
			echo GetDateTime($r['posttime']);
		else
			echo '暂无内容';
		?>
		</td>
		<td class="action">
		<?php

		//是否有修改权限
		if(in_array($row['id'],$catgoryUpdatePriv))
			echo '[<a href="info_update.php?id='.$row['id'].'">修改</a>]';
		else
			echo '[修改]';
		?>
		
		</td>
	</tr>
	<?php
			}
		}
		else
		{
	?>
	<tr align="center" class="mgr_tr">
		<td height="30"><?php echo $row['id']; ?></td>
		<td align="left" class="title2"><?php echo $row['classname']; ?></td>
		<td class="number">
		<?php
		$r = $dosql->GetOne("SELECT `content`,`posttime` FROM `#@__info` WHERE `classid`=".$row['id']);
		if(isset($r['content']))
			echo GetDateTime($r['posttime']);
		else
			echo '暂无内容';
		?>
		</td>
		<td class="action">[<a href="info_update.php?id=<?php echo $row['id']; ?>">修改</a>]</td>
	</tr>
	<?php
		}
	}
	?>
</table>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb"><span class="mgr_btn"><a href="infoclass.php">返回栏目管理</a></span></div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>