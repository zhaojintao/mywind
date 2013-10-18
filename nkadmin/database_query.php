<?php if(!defined('IN_BKUP')) exit('Request Error!'); ?>

<form name="form" id="form" method="post" action="?action=query">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="mgr_tr">
			<td align="center" valign="middle" style="background:#f2f2f2;padding:5px;"><textarea name="sqlquery" style="width:100%;height:200px;border:0;overflow:auto;"></textarea></td>
		</tr>
	</table>
	<div class="mgr_divb">
		<div class="selall">
			<input value="0" type="radio" name="querytype" />
			单行命令（支持简单查询）
			<input value="2" checked="checked" type="radio" name="querytype" />
			多行命令 </div>
		<input type="hidden" name="dopost" value="runsql" />
		<span class="mgr_btn"><a href="#" onclick="form.submit();">执行语句</a></span> </div>
</form>
