<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goodsorder'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品订单管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
<?php

//初始化参数
$attr       = isset($attr) ? $attr : '';
$keyword    = isset($keyword) ? $keyword : '';
$styleal    = '';
$core       = '';
$empty      = '';
$enterorder = '';
$alpay      = '';
$postgoods  = '';
$getgoods   = '';
$apregoods  = '';
$alregoods  = '';
$getregoods = '';
$alrefund   = '';
$storage    = '';

switch($attr)
{
	case '':
		$styleal = 'onflag';
	break;

	case 'core':	
		$core = 'onflag';
	break;
	
	case 'empty':	
		$empty = 'onflag';
	break;
	
	case 'enterorder':
		$enterorder = 'onflag';
	break;
	
	case 'alpay':
		$alpay = 'onflag';
	break;
	
	case 'postgoods':
		$postgoods = 'onflag';
	break;
	
	case 'getgoods':
		$getgoods = 'onflag';
	break;
	
	case 'apregoods':
		$apregoods = 'onflag';
	break;
	
	case 'alregoods':
		$alregoods = 'onflag';
	break;
	
	case 'getregoods':
		$getregoods = 'onflag';
	break;

	case 'alrefund':
		$alrefund = 'onflag';
	break;
	
	case 'storage':
		$storage = 'onflag';
	break;
	
	default:
		$styleal = 'onflag';
}
?>
</head>
<body>
<div class="mgr_header"> <span class="title">商品订单管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<div class="mgr_divt">
	<ul class="flag">
		<li>属性：</li>
		<li class="<?php echo $styleal; ?>"><a href="?">全部</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $core; ?>"><a href="?attr=core">星标</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $empty; ?>"><a href="?attr=empty">未审</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $enterorder; ?>"><a href="?attr=enterorder">确认</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $alpay; ?>"><a href="?attr=alpay">付款</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $postgoods; ?>"><a href="?attr=postgoods">发货</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $getgoods; ?>"><a href="?attr=getgoods">收货</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $apregoods; ?>"><a href="?attr=apregoods">申退</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $alregoods; ?>"><a href="?attr=alregoods">退货</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $getregoods; ?>"><a href="?attr=getregoods">返货</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $alrefund; ?>"><a href="?attr=alrefund">退款</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $storage; ?>"><a href="?attr=storage">归档</a></li>
	</ul>

    <div id="search" class="search"> <span class="s">
    	<form name="s" id="s" method="get" action="">
		<input name="keyword" id="keyword" type="text" title="输入用户名进行搜索" value="<?php echo $keyword; ?>" />
        </form>
		</span> <span class="b"><a href="javascript:;" onclick="s.submit();"><img src="templates/images/search_btn.png" title="搜索" /></a></span></div>
</div>
<form name="form" id="form" method="post" action="goodsorder_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead2">
			<td width="5%" height="25"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="12%">用户名</td>
			<td width="10%">订单编号</td>
		<td>联系方式</td>
			<td width="10%">金额</td>
			<td width="15%">更新时间</td>
			<td width="12%">订单状态</td>
			<td width="15%" class="noborder">操作</td>
		</tr>
		<?php
		$sql = "SELECT * FROM `#@__goodsorder` WHERE delstate=''";	
	
		if($attr == 'core')
			$sql .= " AND core='true'";	

		if($attr == 'empty')
			$sql .= " AND checkinfo=''";	

		if($attr != '' && $attr != 'core' && $attr != 'empty')
			$sql .= " AND checkinfo LIKE '%$attr%'";

		if($keyword != '')
			$sql .= " AND username LIKE '%$keyword%'";

		$dopage->GetPage($sql);
		while($row = $dosql->GetArray())
		{						
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['username']; ?></td>
			<td><?php echo $row['ordernum']; ?></td>
			<td><?php echo $row['telephone']; ?></td>
			<td><?php echo $row['amount']; ?></td>
			<td><span class="number"><?php echo GetDateTime($row['posttime']); ?></span></td>
			<td class="blue">
			<?php
			$checkinfo = explode(',',$row['checkinfo']);
			
			if($row['paymode'] == 1)
			{
				if(!in_array('applyreturn',  $checkinfo) &&
				   !in_array('agreedreturn',  $checkinfo) &&
				   !in_array('goodsback',   $checkinfo) &&
				   !in_array('moneyback', $checkinfo) &&
				   !in_array('overorder',    $checkinfo))
				{
					if($row['checkinfo'] == '' or
					   !in_array('confirm', $checkinfo))
						echo '等待确认';
	
					else if(!in_array('payment', $checkinfo))
						echo '等待付款';
	
					else if(!in_array('postgoods', $checkinfo))
						echo '等待发货';
	
					else if(!in_array('getgoods', $checkinfo))
						echo '等待收货';
	
					else if(!in_array('overorder', $checkinfo))
						echo '等待归档';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
				else
				{
					if(in_array('overorder', $checkinfo))
						echo '已归档';
					
					else if(in_array('moneyback', $checkinfo))
						echo '等待归档';
	
					else if(in_array('goodsback', $checkinfo))
						echo '等待退款';
	
					else if(in_array('agreedreturn', $checkinfo))
						echo '等待返货';
	
					else if(in_array('applyreturn', $checkinfo))
						echo '申请退货';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
			}
			else if($row['paymode'] == 2)
			{
				if(!in_array('applyreturn',  $checkinfo) &&
				   !in_array('agreedreturn',  $checkinfo) &&
				   !in_array('goodsback',   $checkinfo) &&
				   !in_array('moneyback', $checkinfo) &&
				   !in_array('overorder',    $checkinfo))
				{
					if($row['checkinfo'] == '' or
					   !in_array('confirm', $checkinfo))
						echo '等待确认';

					else if(!in_array('postgoods', $checkinfo))
						echo '等待发货';
	
					else if(!in_array('getgoods', $checkinfo))
						echo '等待收货';
					
					else if(!in_array('payment', $checkinfo))
						echo '等待付款';
	
					else if(!in_array('overorder', $checkinfo))
						echo '等待归档';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
				else
				{
					if(in_array('overorder', $checkinfo))
						echo '已归档';
					
					else if(in_array('moneyback', $checkinfo))
						echo '等待归档';
	
					else if(in_array('goodsback', $checkinfo))
						echo '等待退款';
	
					else if(in_array('agreedreturn', $checkinfo))
						echo '等待返货';
	
					else if(in_array('applyreturn', $checkinfo))
						echo '申请退货';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
			}
			?></td>
			<td class="action"><span>[<a href="goodsorder_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="goodsorder_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a>]</span></td>
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
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('goodsorder_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
</div>
<div class="page_area"> <?php echo $dopage->GetList(); ?> </div>
</body>
</html>