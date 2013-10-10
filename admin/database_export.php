<?php if(!defined('IN_BKUP')) exit('Request Error!'); ?>

<form name="form" id="form" method="post" action="?action=export">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead2">
			<td width="5%" height="25"><input type="checkbox" name="checkall" onclick="CheckAllBtn(form)" value="check" checked="checked" /></td>
			<td width="30%">表名</td>
			<td width="20%">记录数</td>
			<td width="20%">数据大小[共<?php if(isset($total_size)){echo GetRealSize($total_size);}else{echo '0B';} ?>]</td>
			<td width="25%" class="noborder">操作</td>
		</tr>
		<?php 
		if(is_array($name))
		{
			$i = 0;
			foreach($name as $i => $tbname)
			{
		?>
		<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
			<td height="30"><input type="checkbox" name="tbname[]" value="<?php echo $tbname; ?>" checked="checked" /></td>
			<td><?php echo $tbname?></td>
			<td><?php echo $rows[$i]?></td>
			<td><?php echo $size[$i]?></td>
			<td class="action"><span>[<a href="?action=export&dopost=struct&tbname=<?php echo $tbname; ?>">结构</a>]</span><span>[<a href="?action=export&dopost=repair&tbname=<?php echo $tbname?>">修复</a>]</span><span>[<a href="?action=export&dopost=optimize&tbname=<?php echo $tbname?>">优化</a>]</span></td>
		</tr>
		<?php
			}
			$i++;
		}
		?>
	</table>
	<div class="mgr_divb"> <span class="selall"><span>选择：</span><a href="javascript:CheckAll(form,true);">全部</a> - <a href="javascript:CheckAll(form,false);">无</a> - <a href="#" onclick="Repair('?action=export&dopost=repair')">修复</a> - <a href="#" onclick="Repair('?action=export&dopost=optimize')">优化</a> </span> <span class="mgr_btn"><a href="#" onclick="Repair('?action=export&dopost=backup')">开始备份数据</a></span> <span class="db_backopt">备份表结构：
		<input type="checkbox" name="isstruct" value="1" checked="checked" />
		&nbsp;&nbsp;
		分卷大小：
		<input type="text" name="fsize" value="2048" size="5" style="text-indent:3px;" />
		KB&nbsp; </span> </div>
</form>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $i; ?></span>个表</div>
</div>