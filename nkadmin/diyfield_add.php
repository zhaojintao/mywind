<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('diyfield'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加自定义字段</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加自定义字段</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="diyfield_save.php" onsubmit="return cfm_diyfield();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属模型：</td>
			<td width="75%"><select name="infotype" id="infotype">
					<?php
				foreach(array('0'=>'单页','1'=>'列表','2'=>'图片','3'=>'下载','4'=>'商品') as $k => $v)
				{
					echo "<option value=\"$k\">$v</option>";
				}
				?>
				</select>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td width="25%" height="35" align="right">字段名称：</td>
			<td width="75%"><input type="text" name="fieldname" id="fieldname" class="class_input" />
				<span class="maroon">*</span><span class="cnote">仅由英文字母、数字和下划线组成，并且仅能字母开头，不能以下划线结尾</span></td>
		</tr>
		<tr>
			<td height="35" align="right">字段标题：</td>
			<td><input type="text" name="fieldtitle" id="fieldtitle" class="class_input" />
				<span class="maroon">*</span><span class="cnote">例如：文章标题</span></td>
		</tr>
		<tr>
			<td height="35" align="right">字段提示：</td>
			<td><input type="text" name="fielddesc" id="fielddesc" class="class_input" /></td>
		</tr>
		<tr>
			<td height="290" align="right">字段类型：</td>
			<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="nb">
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="varchar" checked="checked" />
							<strong>单行文本：</strong>字数较少，例如文章标题等；默认长度小于或等于 &quot;<span class="blue">255</span>&quot; [varchar]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="text">
							<strong>多行文本：</strong>字数偏多，类似于文章描述形式的多行文本；<span class="blue">字段长度留空</span> [text]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="mediumtext">
							<strong>编 辑 器 ：</strong>字数较多，输入框带编辑器大型文本，如文章内容；<span class="blue">字段长度留空</span> [mediumtext]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="int">
							<strong>整　　数：</strong>正负整数类型字段，如123456；长度默认为 &quot;<span class="blue">11</span>&quot; [int]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="radio">
							<strong>单选菜单</strong>&nbsp;&nbsp;
							<input type="radio" name="fieldtype" id="fieldtype" value="checkbox">
							<strong>多选菜单</strong>&nbsp;&nbsp;
							<input type="radio" name="fieldtype" id="fieldtype" value="select">
							<strong>下拉菜单</strong>&nbsp;&nbsp;默认长度小于或等于 &quot;<span class="blue">255</span>&quot; [varchar]</td>
					</tr>
					<tr>
						<td height="28"><input type="text" name="fieldsel" id="fieldsel" style="width:300px;padding:2px;" value="" />
							单选、多选、下拉菜单填值，格式：&quot;选项=值&quot;，每个选项用&quot;,&quot;分割</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="decimal">
							<strong>货　　币：</strong>如102.56；长度默认为 &quot;<span class="blue">10,2</span>&quot;，&quot;10&quot;代表值总长度，&quot;2&quot;代表小数位数 [decimal]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="datetime">
							<strong>日期时间：</strong>如2012-07-25 10:21:23，本系统日期格式为整型，所以系统会为您创建为整型字段；<span class="blue">字段长度留空</span> [int]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="file">
							<strong>单个附件：</strong>上传类型字段(如图片、文档等)，上传类型、大小等限制按系统附件设置执行；默认长度小于或等于 &quot;<span class="blue">100</span>&quot; [varchar]</td>
					</tr>
					<tr>
						<td height="28"><input type="radio" name="fieldtype" id="fieldtype" value="fileall">
							<strong>多个附件：</strong>可上传多个附件，类似于组图上传；<span class="blue">字段长度留空 </span>[text]</td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td height="35" align="right">字段长度：</td>
			<td><input type="text" name="fieldlong" id="fieldlong" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">校验正则：</td>
			<td><input type="text" name="fieldcheck" id="fieldcheck" class="class_input" />
				<span class="cnote">
				<select name="fieldcheck_select" onchange="javascript:$('#fieldcheck').val(this.value)">
					<option value="">常用正则</option>
					<option value="/^[0-9.-]+$/">数字</option>
					<option value="/^[0-9-]+$/">整数</option>
					<option value="/^[a-z]+$/i">字母</option>
					<option value="/^[0-9a-z]+$/i">数字+字母</option>
					<option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
					<option value="/^[0-9]{5,20}$/">QQ</option>
					<option value="/^http:\/\//">超级链接</option>
					<option value="/^(1)[0-9]{10}$/">手机号码</option>
					<option value="/^[0-9-]{6,13}$/">电话号码</option>
					<option value="/^[0-9]{6}$/">邮政编码</option>
				</select>
				&nbsp;不想校验数据请留空</span></td>
		</tr>
		<tr>
			<td height="35" align="right">未通过提示：</td>
			<td><input type="text" name="fieldcback" id="fieldcback" class="class_input" />
				<span class="cnote">最多不要超过30个文字</span></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" class="input_short" value="<?php echo GetOrderID('#@__diyfield'); ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" checked="checked"  />
				启用&nbsp;
				<input type="radio" name="checkinfo" value="false" />
				禁用</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" value="" class="blue_submit_btn" />
		<input type="button" value="" class="blue_back_btn" onclick="history.go(-1)" />
		<input type="hidden" name="action" id="action" value="add" />
	</div>
</form>
</body>
</html>