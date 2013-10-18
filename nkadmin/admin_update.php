<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admin'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__admin` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改管理员</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<form name="form" id="form" method="post" action="admin_save.php" onsubmit="return cfm_upadmin();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">用户名：</td>
			<td width="75%"><strong><?php echo $row['username']; ?></strong></td>
		</tr>
		<tr>
			<td height="35" align="right">旧密码：</td>
			<td><input type="password" name="oldpwd" id="oldpwd" class="class_input" maxlength="16" />
				<span class="maroon">*</span><span class="cnote">若不修改密码请留空</span></td>
		</tr>
		<tr>
			<td height="35" align="right">新密码：</td>
			<td><input type="password" name="password" id="password" class="class_input" maxlength="16" />
				<span class="maroon">*</span><span class="cnote">6-16个字符组成，区分大小写</span></td>
		</tr>
		<tr>
			<td height="35" align="right">确　认：</td>
			<td><input type="password"  name="repassword" id="repassword" class="class_input" maxlength="16" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">提　问：</td>
			<td><select name="question" id="question">
				<?php
				$question = array('无安全提问','母亲的名字','爷爷的名字','父亲出生的城市','你其中一位老师的名字', '你个人计算机的型号','你最喜欢的餐馆名称','驾驶执照最后四位数字');
				foreach($question as $k=>$v)
				{
					if($row['question'] == $k)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}

					echo "<option value=\"$k\" $selected>$v</option>";									
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">回　答：</td>
			<td><input name="answer" type="text" class="class_input" id="answer" value="<?php echo $row['answer']; ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">昵　称：</td>
			<td><input type="text"  name="nickname" id="nickname" class="class_input" value="<?php echo $row['nickname']; ?>" />
				<span class="maroon">&nbsp;</span><span class="cnote">用于文章作者的显示</span></td>
		</tr>
		<tr>
			<td height="35" align="right">管理组：</td>
			<td><select name="levelname" id="levelname">
				<?php
				$dosql->Execute("SELECT * FROM `#@__admingroup` ORDER BY id ASC");
				while($row2 = $dosql->GetArray())
				{
					if($row['levelname'] == $row2['id'])
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}

					if($cfg_curmode != 'small')
					{
						echo '<option value="'.$row2['id'].'" '.$selected.'>'.$row2['groupname'].'</option>';
					}
					else
					{
						if($row2['id'] != 1)
						{
							echo '<option value="'.$row2['id'].'" '.$selected.'>'.$row2['groupname'].'</option>';
						}
						
					}
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkadmin" value="true" <?php if($row['checkadmin'] == 'true') echo "checked"; ?> />
				已审核&nbsp;
				<input type="radio" name="checkadmin" value="false" <?php if($row['checkadmin'] == 'false') echo "checked"; ?> />
				未审核</td>
		</tr>
		<tr>
			<td height="35" align="right">登录时间：</td>
			<td><?php echo GetDateTime($row['logintime']); ?></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">登录IP：</td>
			<td><?php echo $row['loginip']; ?></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>