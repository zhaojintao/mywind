<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goodstype');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-1-12 14:10:40
person: Feng
**************************
*/


if($tid != '-1')
{
	$dosql->Execute("SELECT * FROM `#@__goodsattr` WHERE `goodsid`=$tid");
	if($dosql->GetTotalRow() > 0)
	{
		$i = 1;
		while($row = $dosql->GetArray())
		{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="25%" height="35" align="right"><?php echo $row['attrname']; ?>：</td>
		<td><input type="text" name="attrvalue[]" id="attrvalue[]" class="input_short" />
			<input type="hidden" name="attrid[]" id="attrid[]" value="<?php echo $row['id']; ?>">
			<?php if($i <= 1){echo '<span class="cnote">不同属性值用 <span class="red">|</span> 隔开，例如：黑色|白色 等</span>';} ?></td>
	</tr>
</table>
<?php
			$i++;
		}
	}
	else
	{
		echo '<div style="text-align:center;color:#9C0;">暂无自定义属性，您可以在商品类别中进行绑定</div>';
	}
}
else
{
	echo '<div style="text-align:center;color:#9C0;">请选择商品类别获取自定义属性</div>';
}
?>
