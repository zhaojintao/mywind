<?php if(!defined('IN_BKUP')) exit('Request Error!'); ?>

<form name="form" id="form" method="post" action="?action=import">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead2">
			<td width="5%" height="25"><input type="checkbox" name="checkall" onclick="CheckAllBtn(form)" value="check" /></td>
			<td width="30%">目录名</td>
			<td width="20%">目录大小[共<?php if(isset($files_size)){echo GetRealSize($files_size);}else{echo '0B';} ?>]</td>
			<td width="20%">创建时间</td>
			<td width="25%" class="noborder">操作</td>
		</tr>
		<?php 
		if(isset($bfiles) && is_array($bfiles))
		{
			foreach($bfiles as $b)
			{
		?>
		<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
			<td height="30" ><input name="tbname[]" type="checkbox" value="<?php echo $b['name']; ?>" /></td>
			<td><a href="?action=import&dopost=sqldir&tbname=<?php echo $b['name']; ?>" title="查看目录" class="sqlback_dir"><?php echo $b['name']; ?></a></td>
			<td><?php echo $b['size']; ?></td>
			<td class="number"><?php echo $b['mktime']; ?></td>
			<td class="action"><span>[<a href="?action=import&dopost=sqldir&tbname=<?php echo $b['name']; ?>">查看</a>]</span><span>[<a href="?action=import&dopost=deldir&tbname=<?php echo $b['name']; ?>">删除</a>]</span></td>
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
		<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(form,true);">全部</a> - <a href="javascript:CheckAll(form,false);">无</a> - <a href="javascript:Repair('?action=import&dopost=deldirall');" onclick="return ConfDel(form);">删除</a></div>
	</div>
</form>
<div class="page_area">
	<div class="page_info">共<span><?php echo $conut; ?></span>个备份目录</div>
</div>
<div class="notewarn" id="notification">
<span class="close"><a href="javascript:;" id="notification_close" onclick="HideDiv('notification');"></a></span>
<div>点击目录或查看可进入备份目录单独还原数据表结构或数据表，也可点击还原备份文件还原所选文件</div>
