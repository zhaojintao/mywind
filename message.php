<?php	require(dirname(__FILE__).'/include/config.inc.php');


//留言内容处理
if(isset($action) and $action=='add')
{
	if(empty($nickname) or
	   empty($content))
	{
		header('location:message.php');
		exit();
	}


	$r = $dosql->GetOne("SELECT Max(orderid) AS orderid FROM `#@__message`");
	$orderid  = (empty($r['orderid']) ? 1 : ($r['orderid'] + 1));
	$nickname = htmlspecialchars($nickname);
	$contact  = htmlspecialchars($contact);
	$content  = htmlspecialchars($content);
	$posttime = GetMkTime(time());
	$ip       = gethostbyname($_SERVER['REMOTE_ADDR']);


	$sql = "INSERT INTO `#@__message` (siteid, nickname, contact, content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES (1, '$nickname', '$contact', '$content', '$orderid', '$posttime', '', '', 'false', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('留言成功，感谢您的支持！','message.php');
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo GetHeader(1,0,0,'客户留言'); ?>
<link href="templates/default/style/webstyle.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="templates/default/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/default/js/top.js"></script>
<script type="text/javascript">
function cfm_msg()
{
	if($("#contact").val() == "")
	{
		alert("请填写联系方式！");
		$("#contact").focus();
		return false;
	}
	if($("#content").val() == "")
	{
		alert("请填写留言内容！");
		$("#content").focus();
		return false;
	}
	$("#form").submit();
}

$(function(){
	$("#contact").focus(function(){
		$("#contact").attr("class", "msg_input_on"); 
	}).blur(function(){
		$("#contact").attr("class", "msg_input"); 
	});

	$("#content").focus(function(){
		$("#content").attr("class", "msg_input_on"); 
	}).blur(function(){
		$("#content").attr("class", "msg_input"); 
	});

	$("#contact").focus();
});
</script>
</head>
<body>
<!-- header-->
<?php require('header.php'); ?>
<!-- /header-->
<!-- banner-->
<div class="subBanner"> <img src="templates/default/images/banner-ir.png" /> </div>
<!-- /banner-->
<!-- notice-->
<div class="subnotice"><strong>网站公告：</strong><?php echo Info(1); ?> </div>
<!-- /notice-->
<!-- mainbody-->
<div class="subBody">
	<div class="subTitle"> <span class="catname">客户留言</span> <span>您当前所在位置：首页 &gt; 客户留言</span>
		<div class="cl"></div>
	</div>
	<div class="OneOfTwo">
		<div class="subCont">
			
			<form name="form" id="form" method="post" action="">
				<span class="msgtitle">联系方式：</span><input name="contact" type="text" id="contact" class="msg_input" /><div class="hr_10"></div><div class="hr_10"></div>
				<span class="msgtitle">内　　容：</span><textarea name="content" class="msg_input" style="width:729px;height:180px;overflow:auto;" id="content" ></textarea>
				<div class="msg_btn_area"> <a href="javascript:void(0);" onclick="cfm_msg();return false;">提　交</a></div>
				<input type="hidden" name="action" id="action" value="add" />
				<?php
				if(!empty($_COOKIE['username']))
					$nickname = AuthCode($_COOKIE['username']);
				else
					$nickname = '游客';
				?>
				<input type="hidden" name="nickname" id="nickname" value="<?php echo $nickname; ?>" />
			</form>
		
			<?php
			$dopage->GetPage("SELECT * FROM `#@__message` WHERE checkinfo=true ORDER BY orderid DESC",10);
			$i = $dosql->GetTotalRow();
			while($row = $dosql->GetArray())
			{
			?>
			<div class="message_block">
				<div class="message_title">
					<h2><?php echo $row['nickname']; ?></h2>
					<span><?php echo $i; ?>#</span></div>
				<p><?php echo $row['content']; ?></p>
				<?php
				if($row['recont'] != '')
				{
				?>
				<div class="message_replay"><strong>回复：</strong><?php echo $row['recont']; ?></div>
				<?php
				}
				?>
				<div class="message_info"><?php echo GetDateTime($row['posttime']); ?> / <?php echo preg_replace('/((?:\d+\.){3})\d+/', '\\1*', $row['ip']); ?></div>
			</div>
			<?php
				$i--;
			}
			echo $dopage->GetList();
			?>
		</div>
	</div>
	<div class="TwoOfTwo">
		<?php require('lefter.php'); ?>
	</div>
	<div class="cl"></div>
</div>
<!-- /mainbody-->
<!-- footer-->
<?php require('footer.php'); ?>
<!-- /footer-->
</body>
</html>