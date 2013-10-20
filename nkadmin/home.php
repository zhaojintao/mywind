<?php	require(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".notewarn").fadeIn();
	$(".notewarn .close a").click(function(){
		$(".notewarn").fadeOut();
	});

//	$("#showad").html('<iframe src="showad.php" width="100%" height="25" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
});
</script>
</head>
<body>
<div class="home_header">
	<div class="refurbish"><span class="title">官方公告</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
	<div class="home_info">
		<div id="showad">
		<strong>如果您的管理您的网站过程中遇到问题或者程序代码出现错误时烦请及时告知，我们会在第一时间内和您协商解决。</strong>
		</div>
	</div>
</div>
<div class="main_area">
	<div class="main_l">
		<div class="main_l_left">
			<div class="weladmin"> <span>Hi,</span> <strong><?php echo $_SESSION['admin']; ?></strong></div>
			<div class="logininfo">您上次登录的时间：<span><?php echo GetDateTime($_SESSION['lastlogintime']); ?></span><br />
				您上次登录的IP：<span><?php echo $_SESSION['lastloginip']; ?></span> <span><a href="admin_update.php?id=<?php $row = $dosql->GetOne("SELECT id FROM `#@__admin` WHERE username='".$_SESSION['admin']."'");echo $row['id'];?>" class="uppwd">修改密码</a></span></div>
			<div class="cl"></div>
			<div class="siteinfo">
				<h2 class="title">系统信息</h2>
				<?php
				function ShowResult($revalue)
				{
					if($revalue == 1) return '<span class="ture">支持</span>';
					else return '<span class="flase">不支持</span>';
				}
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="home_table">
					<tr>
						<td height="33" colspan="2">软件版本号： <span title="<?php echo $cfg_vertime; ?>"><?php echo $cfg_vernum; ?></span></td>
					</tr>
					<tr>
						<td width="50%" height="33">服务器版本： <span title="<?php echo $_SERVER['SERVER_SOFTWARE']; ?>"><?php echo ReStrLen($_SERVER['SERVER_SOFTWARE'],7,''); ?></span></td>
						<td width="50%">操作系统： <?php echo PHP_OS; ?></td>
					</tr>
					<tr>
						<td height="33">PHP版本号： <?php echo PHP_VERSION; ?></td>
						<td>GDLibrary： <?php echo ShowResult(function_exists('imageline')); ?></td>
					</tr>
					<tr>
						<td height="33">MySql版本： <?php echo $dosql->GetVersion(); ?></td>
						<td height="28">ZEND支持： <?php echo ShowResult(function_exists('zend_version')); ?></td>
					</tr>
					<tr class="nb">
						<td height="33" colspan="2">支持上传的最大文件：<?php echo ini_get('upload_max_filesize'); ?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="main_l_right">
			<h2 class="lnktitle">快捷操作</h2>
			<div class="lnkarea">
				<div class="lnkarea_btn">[<a href="lnk.php">管理</a>]</div>
				<div class="lnkarea_btns">
					<?php
					$dosql->Execute("SELECT * FROM `#@__lnk` ORDER BY orderid ASC LIMIT 0, 8");
					while($row = $dosql->GetArray())
					{
						echo '<a href="'.$row['lnklink'].'">';
						if($row['lnkico'] != '') echo '<img src="'.$row['lnkico'].'" />';
						echo $row['lnkname'].'</a>';
					}
					?>
				</div>
			</div>
			<div class="countinfo">
				<h2 class="title">信息统计</h2>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="home_table">
					<tr>
						<td width="80" height="33">网站栏目数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__infoclass',$cfg_siteid); ?></td>
					</tr>
					<tr>
						<td height="33">单页信息数：</td>
						<td class="num">
						<?php
						$dosql->Execute("SELECT `id` FROM `#@__infoclass` WHERE `siteid`='$cfg_siteid' AND `infotype`=0");
						echo $dosql->GetTotalRow();
						?></td>
					</tr>
					<tr>
						<td height="33">列表信息数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__infolist',$cfg_siteid); ?></td>
					</tr>
					<tr>
						<td height="33">图片信息数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__infoimg',$cfg_siteid); ?></td>
					</tr>
					<tr class="nb">
						<td height="33">注册会员数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__member'); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="main_r">
		<div class="main_r_dev">
			<div class="title" style="border-top-color:<?php $border_color = array('#fcdf1f','#85cb20','#01b8f4','#f79d00');echo $border_color[mt_rand(0,3)]; ?>">开发团队</div>
			<ul class="cont">
				<li><strong>程序开发及交互设计</strong>：<br />
				<i><a href="mailto:jintaozhao@qq.com?subject=Rocky哥，我有项目需要您来开发&body=Rocky，您好：<br>最近我们有个新的项目急需开发人员来实现，希望您能帮助我们。">Rocky</a></i>, <i>小奎</i></li>
				<li><strong>鸣谢</strong>：<br />
			    <i>老师们曾经的教诲<i>,互联网资源</i>, <i>OsChina开源社区……</i>
			    </li>
			    <br>
			    <li>在本项目开发过程中很多不知名的朋友提供了不少无偿帮助，在此感谢他们的无私奉献，让我们一起弘扬爱的精神。</li>
			    
<!--				<li class="btn"><a href="help.php" class="devhelp">开发帮助</a><a href="mailto:jintaozhao@qq.com" class="fbmsg">给我们电邮</a></li>-->
			</ul>
		</div>
	</div>
	<div class="cl"></div>
</div>
<div class="notewarn"> <span class="close"><a href="javascript:;"></a></span>
	<div>显示分辨率 1360*768 显示效果最佳，建议使用新版浏览器；敬请您将在使用中发现的问题或者不适提交给我们，以便改进 <a href="mailto:jintaozhao@qq.com" class="text">点击提交反馈</a></div>
</div>
</body>
</html>