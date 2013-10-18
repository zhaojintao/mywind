<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/message_ajax.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">留言管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="message_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="25%" align="left">留言内容</td>
			<td width="18%">更新时间</td>
			<td width="12%">IP地址</td>
			<td width="12%">用户名</td>
			<td width="23%">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__message` WHERE siteid='$cfg_siteid'");
		while($row = $dosql->GetArray())
		{
			$content ='<span class="titflag" id="tit_'.$row['id'].'">';
			if($row['htop'] == 'true') $content .= '置顶 ';
			if($row['rtop'] == 'true') $content .= '推荐 ';
			if($row['recont'] != '') $content .= '[已回复]';
			$content .= '</span>';
	
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
			<td align="left" class="titles"><?php echo ClearHtml($row['content']).$content; ?></td>
			<td class="number"><?php echo GetDateTime($row['posttime']); ?></td>
			<td><?php echo $row['ip']; ?></td>
			<td><?php echo $row['nickname']; ?></td>
			<td class="action"><span>[<a href="message_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="javascript:;" onclick="ShowReWin(<?php echo $row['id'] ?>)" rel="<?php echo $row['recont']; ?>" id="recont_<?php echo $row['id'] ?>">回复</a>]</span><span>[<a href="message_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="message_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
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
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('message_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
	<span class="mgr_btn"><a href="message_add.php">添加新留言</a></span>
</div>
<div class="page_area"> <?php echo $dopage->GetList(); ?> </div>
</body>
</html>