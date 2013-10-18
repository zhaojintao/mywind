<?php if(!defined('IN_BKUP')) exit('Request Error!'); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr align="center" class="thead2">
		<td height="25" colspan="2">字段[备注]</td>
		<td>类型(长度)</td>
		<td>整理</td>
		<td>允许为空</td>
		<td>默认值</td>
		<td>额外</td>
	</tr>
	<?php

	//"SHOW FULL COLUMNS FROM `$tbname`"
	$dosql->Execute("SHOW FULL COLUMNS FROM `$tbname`");
	$i = 0;
	while($r = $dosql->GetArray())
	{
		if($r['Comment'])
		{
			$comment = '<span style="font-size:10px;color:#999;padding-left:5px;">['.$r['Comment'].']</span>';
		}
		else
		{
			$comment = '';
		}
	?>
	<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
		<td width="110" height="30" align="right"><?php echo $r['Field'];if($r['Key'] == 'PRI') echo ' <img src="templates/images/database_key.gif" title="主键" />'; ?></td>
		<td width="110" align="left"><?php echo $comment; ?></td>
		<td><?php echo $r['Type']; ?></td>
		<td><?php echo $r['Collation'];?></td>
		<td><?php if($r['Null'] == 'NO'){echo '否';} else{echo '是';}  ?></td>
		<td><?php if($r['Default'] == ''){echo '无';} else{echo $r['Default'];} ?></td>
		<td><?php echo $r['Extra']; ?></td>
	</tr>
	<?php
		$i++;
	}
	?>
</table>
<div class="mgr_divb"> </div>
<div class="page_area">
	<div class="page_info">共<span><?php echo $i; ?></span>个字段</div>
</div>
