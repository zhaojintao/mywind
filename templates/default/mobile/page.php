<?php	if(!defined('IN_MOBILE')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<?php echo GetHeader(1,$cid); ?>
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
				if($row['infotype'] == '0')
				{
					echo Info($row['id']);
				}
				else if($row['infotype'] == '1')
				{
					echo '<ul>';

					$dopage->GetPage("SELECT * FROM `#@__infolist` WHERE (classid=".$row['id']." or parentid=".$row['id']." or parentstr like '%".$row['id']."%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC",10);
					while($row1 = $dosql->GetArray())
					{
				?>
				<li><a href="?m=show&cid=<?php echo $row['id'];?>&id=<?php echo $row1['id']?>" style="color:<?php echo $row1['colorval']; ?>;font-weight:<?php echo $row1['boldval']; ?>;"><?php echo $row1['title']; ?></a></li>
				<?php
					}

					echo '<div class="cl"></div></ul>';
					echo $dopage->GetList();
				}
				else if($row['infotype'] == '2')
				{
					echo '<ul>';

					$dopage->GetPage("SELECT * FROM `#@__infoimg` WHERE (classid=".$row['id']." or parentid=".$row['id']." or parentstr like '%".$row['id']."%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC",9);
					while($row2 = $dosql->GetArray())
					{

						//获取缩略图地址
						if($row2['picurl']!='')
							$picurl = $row2['picurl'];
						else
							$picurl = 'templates/default/images/nofoundpic.gif';
				?>
				<li class="flag0 on">
					<div class="img"><a href="?m=show&cid=<?php echo $row['id'];?>&id=<?php echo $row2['id']?>"><img src="<?php echo $picurl; ?>" title="<?php echo $row2['title']; ?>" /></a></div>
					<div style="clear:both;"></div>
					<div class="title"><?php echo $row2['title']; ?></div>
				</li>
				<?php
					}

					echo '<div class="cl"></div></ul>';
					echo $dopage->GetList();
				}
				?>
			</div>
		</div>
		<?php
		}
		else
		{
			echo '<li>网站资料更新中...</li>';
		}
		?>
	</div>
	<?php require(dirname(__FILE__).'/footer.php'); ?>
</div>
</body>
</html>