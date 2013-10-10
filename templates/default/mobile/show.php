<?php	if(!defined('IN_MOBILE')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<?php echo GetHeader(1,$cid,$id); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="HandheldFriendly"content="true"/>
<meta name="format-detection"content="telephone=no">
<meta http-equiv="x-rim-auto-match"content="none"/>
<link href="<?php echo $cfg_webpath; ?>/templates/default/style/mobile.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrap" data-role="page">
	<div class="header" data-toolbar="fixed">
		<div class="logo"><?php echo $cfg_webname; ?></div>
	</div>
	<div class="content">
		<?php require(dirname(__FILE__).'/nav.php'); ?>
		<!-- 栏目内容 -->
		<?php
		$row = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id = $cid AND checkinfo = 'true' ORDER BY orderid ASC");
		if(!empty($row['id']))
		{
		?>
		<div class="pubBox">
			<div class="hd">
				<h2><?php echo $row['classname']; ?></h2>
			</div>
			<div class="ft">
				<?php
				switch($row['infotype'])
				{
					case 1:
						$tbname = '#@__infolist';
					break;
					case 2: //关于
						$tbname = '#@__infoimg';
					break;
				}
				//增加一次点击量
				$dosql->ExecNoneQuery("UPDATE `$tbname` SET hits=hits+1 WHERE `id`=$id");
				$row = $dosql->GetOne("SELECT * from `$tbname` WHERE `id`=$id");
				?>
				<div class="sub_content">
					<span style="color:<?php echo $row['colorval']; ?>;font-weight:<?php echo $row['boldval']; ?>;"><?php echo $row['title']; ?></span>
				</div>
				<div class="sub_content_info"><small>更新时间：</small><?php echo GetDateTime($row['posttime']); ?></div>
				<?php
				if($row['picurl'] != '')
				{
				?>
					<div class="sub_content_showimg"><a href="<?php echo $row['picurl']; ?>" target="_blank"><img src="<?php echo $row['picurl']; ?>" onerror="this.src='images/nofoundpic.gif'" onload="DrawImage(this,560,400);" /></a></div>
				<?php
				}
				?>
				<?php
				if($row['content'] != '')
					echo GetContPage($row['content']);
				else
					echo '网站资料更新中...';
				?>
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<?php require(dirname(__FILE__).'/footer.php'); ?>
</div>
</body>
</html>