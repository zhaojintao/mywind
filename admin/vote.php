<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('vote'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>投票信息管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">投票信息管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="job_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="18%" align="left" class="title">投票标题</td>
			<td width="12%">开始时间</td>
			<td width="12%">结束时间</td>
			<td> 游客投票</td>
			<td> 查看投票</td>
			<td width="15%">发布时间</td>
			<td width="18%">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__vote` WHERE `siteid`='$cfg_siteid'");
		while($row = $dosql->GetArray())
		{			
			$r = $dosql->GetOne("SELECT COUNT(id) as total FROM `#@__votedata` WHERE voteid=".$row['id']);
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td align="left" class="title"><?php echo $row['title']; ?></td>
			<td class="number"><?php if(empty($row['starttime'])){echo '不限制';}else{echo GetDateTime($row['starttime']);} ?></td>
			<td class="number"><?php if(empty($row['endtime'])){echo '不限制';}else{echo GetDateTime($row['endtime']);} ?></td>
			<td><?php if($row['isguest']=='true'){echo '允许';} else{echo '不允许';} ?></td>
			<td><?php if($row['isview']=='true'){echo '允许';} else{echo '不允许';} ?></td>
			<td class="number"><?php echo GetDateTime($row['posttime']); ?></td>
			<td class="action"><span>[<a href="../vote.php?id=<?php echo $row['id']; ?>" target="_blank" title="查看投票结果">预览</a>]</span><span>[<a href="vote_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="vote_save.php?action=delvote&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
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
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('vote_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
	<span class="mgr_btn"><a href="vote_add.php">添加投票信息</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>