<?php if(!defined('IN_BKUP')) exit('Request Error!'); ?>

<form name="form" id="form" method="post" action="?action=import">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead2">
			<td width="5%" height="25"><input type="checkbox" name="checkall" onclick="CheckAllBtn(form)" value="check" checked="checked" /></td>
			<td width="30%">文件名</td>
			<td width="20%">文件大小[共<?php if(isset($files_size)){echo GetRealSize($files_size);}else{echo '0B';} ?>]</td>
			<td width="20%">备份时间</td>
			<td width="25%" class="noborder">操作</td>
		</tr>
		<?php 
		if(isset($bfiles) && is_array($bfiles))
		{
			foreach($bfiles as $s)
			{
		?>
		<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
			<td height="30" ><input name="tbname[]" type="checkbox" value="<?php echo $s['name']; ?>" checked="checked" /></td>
			<td><?php echo $s['name']; ?></td>
			<td><?php echo $s['size']; ?></td>
			<td class="number"><?php echo $s['mktime']; ?></td>
			<td class="action"><span>[<a href="?action=import&dopost=del&dirname=<?php echo $tbname; ?>&tbname=<?php echo $s['name']; ?>">删除</a>]</span></td>
		</tr>
		<?php 
			}
			$conut = count($bfiles);
		}
		else
		{
		?>
		<tr>
			<td colspan="5" class="mgr_nlist">暂时没有备份文件</td>
		</tr>
		<?php
			$conut = 0;
		}
		?>
	</table>
	<div class="mgr_divb">
		<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(form,true);">全部</a> - <a href="javascript:CheckAll(form,false);">无</a> - <a href="javascript:Repair('?action=import&dopost=delall&dirname=<?php echo $tbname; ?>');" onclick="return ConfDel(form);">删除</a></div>
		<input type="hidden" name="dirname" value="<?php echo $tbname; ?>" />
		<span class="mgr_btn"><a href="#" onclick="Repair('?action=import&dopost=reset');">还原备份文件</a></span> </div>
</form>
<div class="page_area">
	<div class="page_info">共<span><?php echo $conut; ?></span>个SQL文件</div>
</div>