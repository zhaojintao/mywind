<?php	require(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$action = isset($action) ? $action : '';

//是否保存便签
if($action == 'adminnotes')
{
	$uname    = $_SESSION['admin'];
	$posttime = time();
	$postip   = GetIP();

	if($dosql->GetOne("SELECT `uname` FROM `#@__adminnotes` WHERE uname='$uname'"))
	{
		$sql = "UPDATE `#@__adminnotes` SET body='$body', posttime='$posttime', postip='$postip' WHERE uname='$uname'";
		echo $sql;
		$dosql->ExecNoneQuery($sql);
		exit();
	}
	else
	{
		$sql = "INSERT INTO `#@__adminnotes` (uname, body, posttime, postip) VALUES ('$uname', '$body', '$posttime', '$postip')";
		$dosql->ExecNoneQuery($sql);
		exit();
	}
}
else if($action == 'deladminnotes')
{
	$sql = "DELETE FROM `#@__adminnotes` WHERE `uname`='".$_SESSION['admin']."'";
	$dosql->ExecNoneQuery($sql);
	exit();
}

?>
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
	
	//控制便签
	$("#homeNote").focus(function(){
		if($(this).val() == "点击输入便签内容..."){
			$(this).val("");
		}
	}).blur(function(){
		if($(this).val() == ""){
			$.ajax({
				url : "home_user.php",
				type:'post',
				data:{"action":"deladminnotes"},
				dataType:'html',
				success:function(data){	
				}
			});
			$(this).val("点击输入便签内容...");
		}else{
			$.ajax({
				url : "home_user.php",
				type:'post',
				data:{"action":"adminnotes", "body":$(this).val()},
				dataType:'html',
				success:function(data){
				}
			});
		}
	});

	$("#showad").html('<iframe src="showad.php" width="100%" height="25" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
});
</script>
</head>
<body>
<div class="home_header">
	<div class="refurbish"><span class="title">官方公告</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
	<div class="home_info">
		<div id="showad"> </div>
	</div>
</div>
<div class="main_area">
	<div class="main_l">
		<div class="main_l_left">
			<h2 class="home_content_title">空间信息</h2>
			<ul class="home_content">
				<li>服务器名： <?php echo $_SERVER['SERVER_NAME']; ?> </li>
				<li>服务器IP： <?php echo gethostbyname($_SERVER['SERVER_NAME']); ?> </li>
				<li>服务器端口： <?php echo $_SERVER['SERVER_PORT']; ?> </li>
				<li><span style="border-bottom:none;">服务器系统： <?php echo PHP_OS; ?></span></li>
				<li> 服务器版本： <?php echo ReStrLen($_SERVER['SERVER_SOFTWARE'],12); ?></li>
				<li>PHP&amp;MySQL版本： <?php echo PHP_VERSION; ?>&amp;<?php echo $dosql->GetVersion(); ?></li>
				<li>POST提交内容限制： <?php echo get_cfg_var('post_max_size'); ?></li>
				<li>脚本超时时间： <?php echo get_cfg_var('max_execution_time').'秒';; ?></li>
				<li>脚本上传文件大小限制： <?php echo get_cfg_var('upload_max_filesize')?get_cfg_var('upload_max_filesize'):'不允许上传附件'; ?></li>
				<li style="border-bottom:none;">脚本运行时可占最大内存： <?php echo get_cfg_var('memory_limit')?get_cfg_var('memory_limit'):'无'; ?></li>
			</ul>
		</div>
		<div class="main_l_right">
			<h2 class="home_content_title">支持信息</h2>
			<ul class="home_content">
				<li>GD扩展： <?php echo showResult(function_exists('imageline')); ?> </li>
				<li>ODBC数据库： <?php echo showResult(function_exists('odbc_close')); ?> </li>
				<li>Socket支持： <?php echo showResult(function_exists('socket_accept')); ?> </li>
				<li>XML解析： <?php echo showResult(function_exists('xml_set_object')); ?> </li>
				<li>FTP登陆： <?php echo showResult(function_exists('ftp_login')); ?> </li>
				<li>PDF支持： <?php echo showResult(function_exists('pdf_close')); ?> </li>
				<li>显示错误信息： <?php echo showResult(get_cfg_var('display_errors')); ?> </li>
				<li>使用URL打开文件： <?php echo showResult(get_cfg_var('allow_url_fopen')); ?> </li>
				<li>压缩文件支持(Zlib)： <?php echo showResult(function_exists('gzclose')); ?> </li>
				<li style="border-bottom:none;">ZEND支持： <?php echo showResult(function_exists('zend_version')); ?> </li>
			</ul>
		</div>
	</div>
	<div class="main_r">
		<div class="main_r_dev">
			<div class="title" style="border-top-color:<?php $border_color = array('#fcdf1f','#85cb20','#01b8f4','#f79d00');echo $border_color[mt_rand(0,3)]; ?>">记事便签</div>
			<textarea name="homeNote" id="homeNote" class="home_note"><?php
			$uname    = $_SESSION['admin'];
			$posttime = time();
			$postip   = GetIP();

			$r = $dosql->GetOne("SELECT `body` FROM `#@__adminnotes` WHERE uname='$uname'");
			if(isset($r['body']))
				echo $r['body'];
			else
				echo '点击输入便签内容...';
			?></textarea>
		</div>
	</div>
	<div class="cl"></div>
</div>
<div class="cl"></div>
<?php
function showResult($v)
{
	if($v == 1) echo'<span class="ture">支持</span>';
	else echo'<span class="flase">不支持</span>';
}
?>
<div class="notewarn"> <span class="close"><a href="javascript:;"></a></span>
	<div>显示分辨率 1360*768 显示效果最佳，建议使用新版浏览器；敬请您将在使用中发现的问题或者不适提交给我们，以便改进 <a href="http://phpmywind.com/bbs/" target="_blank" class="text">点击提交反馈</a></div>
</div>
</div>
</body>
</html>