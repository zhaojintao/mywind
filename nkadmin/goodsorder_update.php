<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goodsorder'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑订单</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getarea.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__goodsorder` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">编辑订单</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="goodsorder_save.php" onsubmit="return cfm_goodsorder();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">会员用户名：</td>
			<td width="75%"><strong class="maroon2"><?php echo $row['username']; ?></strong><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="120" align="right">商品列表：</td>
			<td><div class="order_area order_text">
					<table width="99%" border="0" align="right" cellpadding="0" cellspacing="0" class="nb">
						<tr class="order_header">
							<td width="40" align="left">ID</td>
							<td height="20" align="left">商品名称</td>
							<td width="80">数量</td>
							<td width="80">价格</td>
							<td width="80">商品编号</td>
							
						</tr>
						<?php

						//初始化参数
						$totalprice = '';
						$shoppingcart = unserialize($row['attrstr']);
				
						//显示订单列表
						foreach($shoppingcart as $k=>$goods)
						{
						?>
						<tr>
							<td><?php echo $goods[0]; ?></td>
							<td height="30">
							<?php
				
							//获取数据库中商品信息
							$r = $dosql->GetOne("SELECT * FROM `#@__goods` WHERE `id`=".$goods[0]);
				
							//计算订单总价
							$totalprice += $r['salesprice']*$goods[1];
				
							//输出商品名称
							echo '<a href="../goodsshow.php?cid='.$r['classid'].'&tid='.$r['typeid'].'&id='.$r['id'].'" class="title" target="_blank">'.$r['title'].'</a>'; 
				
							//输出选中属性
							foreach($goods[2] as $v)
							{
								echo '<span class="attr">'.$v.'</span>';
							}
							?>
							</td>
							<td align="center"><?php echo $goods[1]; ?></td>
							<td align="center"><?php echo $r['salesprice']*$goods[1]; ?></td>
							<td align="center"><?php echo $r['goodsid']; ?></td>
						</tr>
						<?php
						}
						?>
					</table>
			</div></td>
		</tr>
		<tr>
			<td height="35" align="right">订单状态：</td>
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
						echo '等待商家确认订单';
	
					else if(!in_array('payment', $checkinfo))
						echo '已确认，等待付款';
	
					else if(!in_array('postgoods', $checkinfo))
						echo '已付款，等待发货';
	
					else if(!in_array('getgoods', $checkinfo))
						echo '已发货，等待收货';
	
					else if(!in_array('overorder', $checkinfo))
						echo '已收货，等待订单归档';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
				else
				{
					if(in_array('overorder', $checkinfo))
						echo '订单已归档';
					
					else if(in_array('moneyback', $checkinfo))
						echo '已退款，等待归档';
	
					else if(in_array('goodsback', $checkinfo))
						echo '已收到返货，等待退款';
	
					else if(in_array('agreedreturn', $checkinfo))
						echo '同意退货，等待收返货';
	
					else if(in_array('applyreturn', $checkinfo))
						echo '申请退货，等待退货';
	
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
						echo '等待商家确认订单';
	
					else if(!in_array('postgoods', $checkinfo))
						echo '已付款，等待发货';
	
					else if(!in_array('getgoods', $checkinfo))
						echo '已发货，等待收货';
					
					else if(!in_array('payment', $checkinfo))
						echo '已收货，等待付款';
	
					else if(!in_array('overorder', $checkinfo))
						echo '已付款，等待订单归档';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
				else
				{
					if(in_array('overorder', $checkinfo))
						echo '订单已归档';
					
					else if(in_array('moneyback', $checkinfo))
						echo '已退款，等待归档';
	
					else if(in_array('goodsback', $checkinfo))
						echo '已收到返货，等待退款';
	
					else if(in_array('agreedreturn', $checkinfo))
						echo '同意退货，等待收返货';
	
					else if(in_array('applyreturn', $checkinfo))
						echo '申请退货，等待退货';
	
					else
						echo '参数错误，没有获取到订单状态';
				}
			}
			?></td>
		</tr>
		<tr class="nb">
			<td height="80" align="right">订单操作：</td>
			<td style="line-height:22px;">
				<?php $checkinfo = explode(',',$row['checkinfo']); ?>
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="confirm" <?php if(in_array('confirm', $checkinfo)) echo 'checked'; ?> />
				确认订单&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="payment" <?php if(in_array('payment', $checkinfo)) echo 'checked'; ?> />
				确认付款&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="postgoods" <?php if(in_array('postgoods', $checkinfo)) echo 'checked'; ?> />
				商品发货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="getgoods" <?php if(in_array('getgoods', $checkinfo)) echo 'checked'; ?> />
				已收货 <br />
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="applyreturn" <?php if(in_array('applyreturn', $checkinfo)) echo 'checked'; ?> />
				申请退货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="agreedreturn" <?php if(in_array('agreedreturn', $checkinfo)) echo 'checked'; ?> />
				同意退货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="goodsback" <?php if(in_array('goodsback', $checkinfo)) echo 'checked'; ?> />
				收到返货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="moneyback" <?php if(in_array('moneyback', $checkinfo)) echo 'checked'; ?> />
				已退款 <br />
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="overorder" <?php if(in_array('overorder', $checkinfo)) echo 'checked'; ?> />
				已归档 <span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">收货人姓名： </td>
			<td><input name="truename" type="text" class="class_input" id="truename" value="<?php echo $row['truename']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">电　话：</td>
			<td><input name="telephone" type="text" class="class_input" id="telephone" value="<?php echo $row['telephone']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">邮　编： </td>
			<td><input name="zipcode" type="text" class="class_input" id="zipcode" value="<?php echo $row['zipcode']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">地　址：</td>
			<td><select name="postarea_prov" id="postarea_prov" onchange="SelProv(this.value,'postarea');">
					<option value="-1">请选择</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['postarea_prov'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';
	
						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="postarea_city" id="postarea_city" onchange="SelCity(this.value,'postarea');">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>".$row['postarea_prov']." AND datavalue<".($row['postarea_prov'] + 500)." ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['postarea_city'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="postarea_country" id="postarea_country">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=2 AND datavalue LIKE '".$row['postarea_city'].".%%%' ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['postarea_country'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
			<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">&nbsp;</td>
			<td><input name="address" type="text" class="class_input" id="address" value="<?php echo $row['address']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">证件号码：</td>
			<td><input type="text" name="idcard" id="idcard" class="class_input" value="<?php echo $row['idcard']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">订单号：</td>
			<td><input name="ordernum" type="text" class="class_input" id="ordernum" value="<?php echo $row['ordernum']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">运单号：</td>
			<td><input name="postid" type="text" class="class_input" id="postid" value="<?php echo $row['postid']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">配送方式：</td>
			<td><select name="postmode" id="postmode">
					<option value="-1">请选择配送方式</option>
					<?php GetTopType('#@__postmode','#@__goodsorder','postmode'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">支付方式：</td>
			<td><select name="paymode" id="paymode">
					<option value="-1">请选择支付方式</option>
					<?php GetTopType('#@__paymode','#@__goodsorder','paymode'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">货到方式：</td>
			<td><select name="getmode" id="getmode">
					<option value="-1">请选择货到方式</option>
					<?php GetTopType('#@__getmode','#@__goodsorder','getmode'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">订单重量：</td>
			<td><input name="weight" type="text" class="class_input" id="weight" value="<?php echo $row['weight']; ?>" />
				kg<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">商品运费：</td>
			<td><input name="cost" type="text" class="class_input" id="cost" value="<?php echo $row['cost']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">订单金额：</td>
			<td><input name="amount" type="text" id="amount" class="class_input" value="<?php echo $row['amount']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">赠送积分：</td>
			<td><input name="integral" type="text" class="class_input" id="integral" value="<?php echo $row['integral']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="116" align="right">购物备注：</td>
			<td><textarea name="buyremark" class="class_areatext" id="buyremark"><?php echo $row['buyremark']; ?></textarea></td>
		</tr>
		<tr>
			<td height="116" align="right">发货方备注：</td>
			<td><textarea name="sendremark" class="class_areatext" id="sendremark"><?php echo $row['sendremark']; ?></textarea></td>
		</tr>
		<tr>
			<td height="35" align="right">订单时间：</td>
			<td><input name="posttime" type="text" id="posttime" class="input_short" value="<?php echo GetDateTime($row['posttime']); ?>" readonly="readonly" />
				<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input name="orderid" type="text" id="orderid" class="input_short" value="<?php echo $row['orderid']; ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right"><span class="core_ico"></span>是否加星：</td>
			<td><input name="core" type="checkbox" id="core" value="true" <?php if($row['core']=='true') echo 'checked'; ?> />
				标注</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" onclick="history.go(-1)" value=""  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>