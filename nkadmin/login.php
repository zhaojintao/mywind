<?php	require(dirname(__FILE__).'/../include/common.inc.php');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-6-14 14:03:05
person: Feng
**************************
*/


//判断登陆请求
if(@$dopost == 'login')
{
	
	//初始化参数
	$username = empty($username) ? '' : $username;
	$password = empty($password) ? '' : md5(md5($password));
	$question = empty($question) ? 0  : $question;
	$answer   = empty($answer)   ? '' : $answer;


	//验证输入数据
	if($username == '' or
	   $password == '')
	{
		header('location:login.php');
		exit();
	}


	//删除已过时记录
	$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE (UNIX_TIMESTAMP(NOW())-time)/60>15");


	//判断是否被暂时禁止登录
	$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE username='$username'");
	if(is_array($r))
	{
		$min = round((time()-$r['time']))/60;
		if($r['num']==0 and $min<=15)
		{
			ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','login.php');
			exit();
		}
	}


	//获取用户信息
	$row = $dosql->GetOne("SELECT * FROM `#@__admin` WHERE username='$username'");


	//密码错误
	if(!is_array($row) or $password!=$row['password'])
	{
		$logintime = time();
		$loginip   = GetIP();

		$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE username='$username'");
		if(is_array($r))
		{
			$num = $r['num']-1;

			if($num == 0)
			{
				$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET time=$logintime, num=$num WHERE username='$username'");
				ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','login.php');
				exit();
			}
			else if($r['num']<=5 and $r['num']>0)
			{
				$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET time=$logintime, num=$num WHERE username='$username'");
				ShowMsg('用户名或密码不正确！您还有'.$num.'次尝试的机会！','login.php');
				exit();
			}
		}
		else
		{
			$dosql->ExecNoneQuery("INSERT INTO `#@__failedlogin` (username, ip, time, num, isadmin) VALUES ('$username', '$loginip', '$logintime', 5, 1)");
			ShowMsg('用户名或密码不正确！您还有5次尝试的机会！','login.php');
			exit();
		}
	}


	//密码正确，查看登陆问题是否正确
	else if($row['question'] != 0 && ($row['question'] != $question || $row['answer'] != $answer))
	{
		ShowMsg('登陆提问或回答不正确！','login.php');
		exit();
	}


	//密码正确，查看是否被禁止登录
	else if($row['checkadmin'] == 'false')
	{
		ShowMsg('抱歉，您的账号被禁止登陆！','login.php');
		exit();
	}


	//用户名密码正确
	else
	{
		$logintime = time();
		$loginip = GetIP();


		//删除禁止登录
		if(is_array($r))
		{
			$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE `username`='$username'");
		}

		if(!isset($_SESSION)) session_start();

		//设置登录站点
		$r = $dosql->GetOne("SELECT `id`,`sitekey` FROM `#@__site` ORDER BY id ASC");
		if(isset($r['id']) &&
		   isset($r['sitekey']))
		{
			$_SESSION['siteid']  = $r['id'];
			$_SESSION['sitekey'] = $r['sitekey'];
		}
		else
		{
			$_SESSION['siteid']  = '';
			$_SESSION['sitekey'] = '';
		}

		//提取当前用户账号
		$_SESSION['admin'] = $username;

		//提取当前用户权限
		$r = $dosql->GetOne("SELECT `checkinfo` FROM `#@__admingroup` WHERE `id`=".$row['levelname']);
		if(isset($r['checkinfo']) &&
		   $r['checkinfo']=='true')
			$_SESSION['adminlevel'] = $row['levelname'];
		else
			$_SESSION['adminlevel'] = 0;

		//提取上次登录时间
		$_SESSION['lastlogintime'] = $row['logintime'];

		//提取上次登录IP
		$_SESSION['lastloginip'] = $row['loginip'];

		//记录本次登录时间
		$_SESSION['logintime'] = $logintime;

		$dosql->ExecNoneQuery("UPDATE `#@__admin` SET loginip='$loginip',logintime='$logintime' WHERE username='$username'");
		header('location:default.php');
		exit();
	}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>农科化肥 管理中心</title>
<link href="templates/style/admin.css" rel="stylesheet" />
<script src="templates/js/jquery.min.js"></script>
<script>
function CheckForm()
{
	if($("#username").val() == "")
	{
		alert("请输入用户名！");
		$("#username").focus();
		return false;
	}
	if($("#password").val() == "")
	{
		alert("请输入密码！");
		$("#password").focus();
		return false;
	}
	if($("#question").val() != 0 && $("#answer").val() == "")
	{
        alert("请输入问题回答！");
        $("#answer").focus();
        return false;
    }
}

$(function(){
	$(".loginForm input").keydown(function(){
		$(this).prev().hide();
	}).blur(function(){
		if($(this).val() == ""){
			$(this).prev().show();
		}
	});
	
	$("#username").focus(function(){
		$("#username").attr("class", "uname inputOn"); 
	}).blur(function(){
		$("#username").attr("class", "uname input"); 
	});

	$("#password").focus(function(){
		$("#password").attr("class", "pwd inputOn"); 
	}).blur(function(){
		$("#password").attr("class", "pwd input"); 
	});

	$("#question").focus(function(){
		$(".quesArea").attr("class", "quesAreaOn"); 
	}).blur(function(){
		$(".quesAreaOn").attr("class", "quesArea"); 
	});

	$("#answer").focus(function(){
		$(".quesArea").attr("class", "quesAreaOn"); 
	}).blur(function(){
		$(".quesAreaOn").attr("class", "quesArea"); 
	});

	$("#username").focus();
});
</script>
</head>
<body class="loginBody">
<div class="loginTop">
	<div class="text"><a href="http://www.nkhf.com.cn/index.php" target="_self">农科网站首页</a></div>
</div>
<div class="loginWarp">
	<div class="loginArea">
		<div class="loginHead"> </div>
		<div class="loginTxt">登陆管理中心</div>
		<div class="loginForm">
			<form name="login" method="post" action="" onSubmit="return CheckForm()">
				<div class="txtLine">
					<label>用户名</label>
					<input type="text" name="username" id="username" class="uname input" maxlength="20" />
				</div>
				<div class="txtLine mar8">
					<label>密码</label>
					<input type="password" name="password" id="password" class="pwd input" maxlength="16" />
				</div>
				<div class="hr_20"></div>
				<input type="submit" class="loginBtn" value="登 陆" style="cursor:pointer;" />
				<input type="hidden" name="dopost" value="login" />
			</form>
		</div>
	</div>
</div>
<div class="loginCopyright">
版权所有 （C） 陕西农科化肥有限公司<br>
地址：西安市高新区沣惠南路18号西格玛大厦5层  邮编：710075<br>
电话：029-82301199  传真：029-82301188  <a target="_blank" href="http://www.miibeian.gov.cn/">陕ICP备07011665号</a>
</div>
</body>
</html>