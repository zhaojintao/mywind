<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('infoclass'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">栏目管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<form name="form" id="form" method="post">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="35%" class="title2">栏目名称</td>
			<td width="15%">ID</td>
			<td width="15%">排序</td>
			<td width="30%">操作</td>
		</tr>
		<?php
		$row = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");

		switch($row['infotype'])
		{
			case 0:
				$addurl   = 'info_update.php?id='.$row['id'];
				$infotype = ' <i title="栏目属于[单页]类型">[单页]</i>';
			break;  
			case 1:
				$addurl   = 'infolist_add.php?cid='.$row['id'];
				$infotype = ' <i title="栏目属于[列表]类型">[列表]<i>';
			break;
			case 2:
				$addurl   = 'infoimg_add.php?cid='.$row['id'];
				$infotype = ' <i title="栏目属于[图片]类型">[图片]<i>';
			break;
			case 3:
				$addurl   = 'soft_add.php?cid='.$row['id'];
				$infotype = ' <i title="栏目属于[下载]类型">[下载]<i>';
			break;
			case 4:
				$addurl   = 'soft_add.php?cid='.$row['id'];
				$infotype = ' <i title="栏目属于[商品]类型">[商品]<i>';
			break;
			default:
				$addurl   = 'javascript:;';
				$infotype = ' 没有获取到类型';
		}

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
		
		$classname = '<span class="disimg" id="rowid_'.$row['id'].'" onclick="DisplayRows('.$row['id'].');">'.$row['classname'].'</span>';
		?>
		<tr align="center" class="mgr_tr">
			<td height="32"><input type="checkbox" name="t_checkid[]" id="t_checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><?php echo $classname.'<span class="infotype">'.$infotype.'</span>'; ?></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['orderid']; ?></td>
			<td class="action"><span><a href="infoclass_add.php?infotype=<?php echo $row['infotype']; ?>&id=<?php echo $row['id']; ?>">添加子栏目</a></span> | <span><a href="infoclass_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行显示与隐藏操作"><?php echo $checkinfo; ?></a></span> | <span><a href="infoclass_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | <span>删除</span></td>
		</tr>
	</table>
	<?php
	$menulevel = $row['menulevel'];

	function Show($id=0, $i=0, $menulevel='')
	{
		global $dosql;
		$dosql->Execute("SELECT * FROM `#@__infoclass` WHERE parentid=$id ORDER BY orderid ASC",$id);
		$i++;
		while($row = $dosql->GetArray($id))
		{
			switch($row['infotype'])
			{
				case '0':
				$infotype = ' <i title="栏目属于[单页]类型">[单页]</i>';
				break;  
				case '1':
				$infotype = ' <i title="栏目属于[列表]类型">[列表]<i>';
				break;
				case '2':
				$infotype = ' <i title="栏目属于[图片]类型">[图片]<i>';
				break;
				case '3':
				$infotype = ' <i title="栏目属于[下载]类型">[下载]<i>';
				break;
				default:
				$infotype = ' 没有获取到类型';
			}

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
			
			//获取tr一级父类id
			if($row['parentstr'] == '0,')
			{
				$parentstr_id = 0;
			}
			else
			{
				$ids = explode(',', $row['parentstr']);
				$parentstr_id = $ids[1];
			}

			//设置classname区域
			$classname = '<span class="sub_type">'.$row['classname'].'</span>';
	?>
	<div rel="rowpid_<?php echo $parentstr_id; ?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
			<tr align="center" class="mgr_tr">
				<td width="5%" height="32" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="35%" align="left">
				<?php
				for($n=1; $n<$i; $n++) echo '&nbsp;&nbsp;';
				echo $classname.'<span class="infotype">'.$infotype.'</span>';
				?></td>
				<td width="15%"><?php echo $row['id']; ?>
					<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="15%" align="center"><a href="infoclass_save.php?action=up&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/up.gif" title="向上移动" /></a>
					<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
					<a href="infoclass_save.php?action=down&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/down.gif" title="向下移动" /></a></td>
				<td width="30%" class="action"><span>
					<?php if($menulevel >= substr_count($row['parentstr'], ',')){?>
					<a href="infoclass_add.php?infotype=<?php echo $row['infotype']; ?>&id=<?php echo $row['id']; ?>">添加子栏目</a>
					<?php }else{echo '添加子栏目';} ?>
					</span> | <span><a href="infoclass_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行显示与隐藏操作"><?php echo $checkinfo; ?></a></span> | <span><a href="infoclass_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | <span><a href="infoclass_save.php?action=delclass&id=<?php echo $row['id'] ?>" onclick="return ConfDel(2)">删除</a></span></td>
			</tr>
		</table>
	</div>
	<?php
			Show($row['id'], $i+2, $menulevel);
		}
	}
	Show($cid, 3, $menulevel);
	?>
	<div class="mgr_divb">
		<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:SubUrlParam('infoclass_save.php?action=delallclass');" onclick="return ConfDelAll(1);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('infoclass_save.php');">更新排序</a></div>
	</div>
	<input type="hidden" name="cid" id="cid" value="<?php echo $cid; ?>" />
</form>
</body>
</html>