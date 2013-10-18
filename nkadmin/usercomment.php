<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('usercomment'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">用户评论管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="usergroup_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="center">
			<td width="5%" height="30" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
			<td width="5%">ID</td>
			<td width="5%">UID</td>
			<td align="left">用户名</td>
			<td width="25%" align="left">评论内容</td>
			<td>文章模型</td>
			<td>文章ID</td>
			<td>评论时间</td>
			<td>评论IP</td>
			<td width="15%">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__usercomment`");
		while($row = $dosql->GetArray())
		{			
			switch($row['isshow'])
			{
				case '1':
				$checkinfo = '显示';
				break;  
				case '0':
				$checkinfo = '隐藏';
				break;
				default:
				$checkinfo = '没有获取到参数';
			}
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['uid']; ?></td>
			<td align="left"><?php echo $row['uname']; ?>
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left" class="titles">
			<?php
			if($row['molds'] == 1)
				$tbname = '#@__infolist';

			else if($row['molds'] == 2)
				$tbname = '#@__infoimg';

			else if($row['molds'] == 3)
				$tbname = '#@__soft';

			else if($row['molds'] == 4)
				$tbname = '#@__goods';
			
			else
				$tbname = '';

			$r = $dosql->GetOne("SELECT * FROM `$tbname` WHERE id=".$row['aid']."");
			?>
			<a href="<?php echo $row['link']; ?>" target="_blank" title="点击访问"><?php echo ClearHtml($row['body']); ?></a>
			</td>
			<td><?php echo $row['molds']; ?></td>
			<td><?php echo $row['aid']; ?></td>
			<td class="number"><?php echo GetDateTime($row['time']); ?></td>
			<td><?php echo $row['ip']; ?></td>
			<td class="action" align="center"><span>[<a href="usercomment_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['isshow']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="usercomment_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
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
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('usercomment_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
</div>
<div class="pageinfo">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>