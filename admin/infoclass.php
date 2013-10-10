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
<div class="mgr_header"> <span class="title">栏目管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="35%" class="title2">栏目名称</td>
			<td width="15%">ID</td>
			<td width="15%">排序</td>
			<td width="30%">操作</td>
		</tr>
	</table>
	<?php

	//权限验证
	if($_SESSION['adminlevel'] > 1)
	{
		$catgoryListPriv = array();
		$dosql->Execute("SELECT * FROM `#@__adminprivacy` WHERE `groupid`=".$_SESSION['adminlevel']." AND `model`='category' AND `action`='list'");
		while($row = $dosql->GetArray())
		{
			$catgoryListPriv[] = $row['classid'];
		}
		
		$catgoryAddPriv = array();
		$dosql->Execute("SELECT * FROM `#@__adminprivacy` WHERE `groupid`=".$_SESSION['adminlevel']." AND `model`='category' AND `action`='add'");
		while($row = $dosql->GetArray())
		{
			$catgoryAddPriv[] = $row['classid'];
		}
		
		$catgoryUpdatePriv = array();
		$dosql->Execute("SELECT * FROM `#@__adminprivacy` WHERE `groupid`=".$_SESSION['adminlevel']." AND `model`='category' AND `action`='update'");
		while($row = $dosql->GetArray())
		{
			$catgoryUpdatePriv[] = $row['classid'];
		}
		
		$catgoryDelPriv = array();
		$dosql->Execute("SELECT * FROM `#@__adminprivacy` WHERE `groupid`=".$_SESSION['adminlevel']." AND `model`='category' AND `action`='del'");
		while($row = $dosql->GetArray())
		{
			$catgoryDelPriv[] = $row['classid'];
		}
	}

	//循环栏目函数
	function Show($id=0, $i=0)
	{
		global $dosql,$cfg_siteid,
		       $catgoryListPriv,$catgoryAddPriv,
			   $catgoryUpdatePriv,$catgoryDelPriv;

		$i++;

		$dosql->Execute("SELECT * FROM `#@__infoclass` WHERE siteid='$cfg_siteid' AND parentid=$id ORDER BY orderid ASC", $id);
		while($row = $dosql->GetArray($id))
		{

			switch($row['infotype'])
			{
				case 0:
					$addurl   = 'info_update.php?id='.$row['id'];
					$infotype = ' <i title="栏目属于[单页]类型">[单页]</i>';
					break;  
				case 1:
					$addurl   = 'infolist_add.php?cid='.$row['id'];
					$infotype = ' <i title="栏目属于[列表]类型">[列表]</i>';
					break;
				case 2:
					$addurl   = 'infoimg_add.php?cid='.$row['id'];
					$infotype = ' <i title="栏目属于[图片]类型">[图片]</i>';
					break;
				case 3:
					$addurl   = 'soft_add.php?cid='.$row['id'];
					$infotype = ' <i title="栏目属于[下载]类型">[下载]</i>';
					break;
				case 4:
					$addurl   = 'soft_add.php?cid='.$row['id'];
					$infotype = ' <i title="栏目属于[商品]类型">[商品]</i>';
					break;
				default:
					$addurl   = 'javascript:;';
					$infotype = ' 没有获取到类型';
			}


			//设置classname区域
			$classname = '';

			if($row['parentid'] == '0')
				$classname .= '<span class="disimg" id="rowid_'.$row['id'].'" onclick="DisplayRows('.$row['id'].');">';
			else
				$classname .= '<span class="sub_type">';


			//添加权限
			if($_SESSION['adminlevel'] > 1)
			{
				if(in_array($row['id'], $catgoryAddPriv))
				{
					$classname .= '<a href="'.$addurl.'" title="点击添加内容">'.$row['classname'].'</a></span>';
					$addStr = '<a href="infoclass_add.php?infotype='.$row['infotype'].'&id='.$row['id'].'">添加子栏目</a>';
				}
				else
				{
					$classname .= '<span title="暂无添加权限哦~">'.$row['classname'].'</span></span>';
					$addStr = '添加子栏目';
				}
			}
			else
			{
				$classname .= '<a href="'.$addurl.'" title="点击添加内容">'.$row['classname'].'</a></span>';
				$addStr = '<a href="infoclass_add.php?infotype='.$row['infotype'].'&id='.$row['id'].'">添加子栏目</a>';
			}
			
			
			//修改权限
			if($_SESSION['adminlevel'] > 1)
			{
				if(in_array($row['id'], $catgoryUpdatePriv))
					$updateStr = '<a href="infoclass_update.php?id='.$row['id'].'">修改</a>';
				else
					$updateStr = '修改';
			}
			else
			{
				$updateStr = '<a href="infoclass_update.php?id='.$row['id'].'">修改</a>';
			}


			//删除权限
			if($_SESSION['adminlevel'] > 1)
			{
				if(in_array($row['id'], $catgoryDelPriv))
					$delStr = '<a href="infoclass_save.php?action=delclass&id='.$row['id'].'" onclick="return ConfDel(2);">删除</a>';
				else
					$delStr = '删除';
			}
			else
			{
				$delStr = '<a href="infoclass_save.php?action=delclass&id='.$row['id'].'" onclick="return ConfDel(2);">删除</a>';
			}


			//审核状态
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


			//审核权限
			if($_SESSION['adminlevel'] > 1)
			{
				if(in_array($row['id'], $catgoryUpdatePriv))
					$checkStr = '<a href="infoclass_save.php?action=check&id='.$row['id'].'&checkinfo='.$row['checkinfo'].'" title="点击进行显示与隐藏操作">'.$checkinfo.'</a>';
				else
					$checkStr = $checkinfo;
			}
			else
			{
				$checkStr = '<a href="infoclass_save.php?action=check&id='.$row['id'].'&checkinfo='.$row['checkinfo'].'" title="点击进行显示与隐藏操作">'.$checkinfo.'</a>';
			}


			$topid = GetTopID($row['parentstr']);
	?>
	<div rel="rowpid_<?php echo $topid ; ?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
			<tr align="center" class="mgr_tr">
				<td width="5%" height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="35%" align="left">
				<?php
				for($n=1; $n<$i; $n++) echo '&nbsp;&nbsp;';
				echo $classname.'<span class="infotype">'.$infotype.'</span>';
				?>
				</td>
				<td width="15%"><?php echo $row['id']; ?>
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="15%"><a href="infoclass_save.php?action=up&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/up.gif" title="向上移动" /></a>
					<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
					<a href="infoclass_save.php?action=down&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/down.gif" title="向下移动" /></a></td>
				<td width="30%" class="action"><span><?php echo $addStr; ?></span> | <span><?php echo $checkStr; ?></span> | <span><?php echo $updateStr; ?></span> | <span><?php echo $delStr; ?></span>
				</td>
			</tr>
		</table>
	</div>
	<?php
			Show($row['id'], $i+2);
		}
	}
	Show();


	//判断类别页是否折叠
	if($cfg_typefold == 'Y')
	{
		echo '<script>HideAllRows();</script>';
	}
	?>
</form>
<?php
if($dosql->GetTotalRow(0) == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:SubUrlParam('infoclass_save.php?action=delallclass');" onclick="return ConfDelAll(1);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('infoclass_save.php');">排序</a> - <a href="javascript:ShowAllRows();">展开</a> - <a href="javascript:HideAllRows();">隐藏</a></div>
	<span class="mgr_btn"><a href="infoclass_add.php">添加网站栏目</a></span> </div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow('#@__infoclass',$cfg_siteid); ?></span>条记录</div>
</div>
</body>
</html>