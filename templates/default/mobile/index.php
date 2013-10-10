<?php	if(!defined('IN_MOBILE')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<?php echo GetHeader(); ?>
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
		
		//目前只支持 单页、列表、图片模型
		$dosql->Execute("SELECT * FROM `#@__infoclass` WHERE `infotype` IN (0,1,2) AND parentid=0 AND checkinfo='true' ORDER BY orderid ASC");
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
			{
				switch ($row['infotype'])
				{
					case 0:
						$m = 'page';
					 break;
					case 1:
						$m = 'list';
					 break;
					case 2:
						$m = 'img';
					 break;
					default:
						echo 'No number between 1 and 3';
				}
		?>
		<div class="pubBox">
			<div class="hd">
				<h2><?php echo $row['classname']; ?></h2>
			</div>
			<div class="ft">
				<?php

				//单页模型
				if($row['infotype'] == '0')
				{
					echo ClearHtml(Info($row['id'],200));
				}

				//列表模型
				else if($row['infotype'] == '1')
				{
					echo '<ul>';

					$dosql->Execute("SELECT * FROM `#@__infolist` WHERE (classid=".$row['id']." or parentid=".$row['id']." or parentstr like '%".$row['id']."%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC LIMIT 0,10",$row['id']);
					while($row1 = $dosql->GetArray($row['id']))
					{
					?>
				<li><a href="?m=show&cid=<?php echo $row['id'];?>&id=<?php echo $row1['id']?>" style="color:<?php echo $row1['colorval']; ?>;font-weight:<?php echo $row1['boldval']; ?>;"><?php echo $row1['title']; ?></a></li>
				<?php
					}

					echo '</ul>';
				}

				//图片模型
				else if($row['infotype'] == '2')
				{
					echo '<ul>';

					$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE (classid=".$row['id']." or parentid=".$row['id']." or parentstr like '%".$row['id']."%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC LIMIT 0,9",$row['id']);			
					while($row2 = $dosql->GetArray($row['id']))
					{
						//获取缩略图地址
						if($row2['picurl'] != '')
							$picurl = $row2['picurl'];
						else
							$picurl = 'templates/default/images/nofoundpic.gif';
				?>
					<li class="flag0 on1">
						<div class="img"><a href="?m=show&cid=<?php echo $row['id'];?>&id=<?php echo $row2['id']?>"><img src="<?php echo $picurl; ?>" title="<?php echo $row2['title']; ?>" /></a></div>
					</li>
					<?php
					}

					echo '</ul>';
				}
				?>
			</div>
			<div class="cl"></div>
			<div class="gochannel"><span><a href="?m=<?php echo $m; ?>&cid=<?php echo $row['id']; ?>">进入<?php echo $row['classname']; ?></a></span></div>
		</div>
		<?php
			}
		}
		?>
	</div>
	<?php require(dirname(__FILE__).'/footer.php'); ?>
</div>
</body>
</html>
