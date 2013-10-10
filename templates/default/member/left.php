<?php if(!defined('IN_MEMBER')) exit('Request Error!'); ?>
<div class="userinfo">
	<?php
	$r_user = $dosql->GetOne("SELECT * FROM `#@__member` WHERE username='$c_uname'");
	?>
	<div class="avater"><img src="<?php echo $cfg_webpath; ?>/data/avatar/index.php?uid=<?php echo $r_user['id']; ?>&size=middle" />
		<div></div>
		<a href="?c=avatar">修改头像</a>
	</div>
	<div><span class="username"><?php echo $c_uname; ?></span> <span class="usergroup">
		<?php
		$usergroup = '';
		$dosql->Execute("SELECT * FROM `#@__usergroup`");
		while($row = $dosql->GetArray())
		{
			if($r_user['expval'] >= $row['expvala'] and
			   $r_user['expval'] <= $row['expvalb'])
			{
				$usergroup = '<span style="color:'.$row['color'].'">'.$row['groupname'].'</span>';
			}
		}
		if($usergroup == '')
		{
			//系统不允许使用子查询
			$r = $dosql->GetOne("SELECT MAX(expvalb) as expvalb FROM `#@__usergroup`");
			
			if($r_user['expval'] > $r['expvalb'])
			{
				$r2 = $dosql->GetOne("SELECT `groupname` FROM `#@__usergroup` WHERE expvalb=".$r['expvalb']);
				$usergroup = '<span style="color:'.$row['color'].'">'.$r2['groupname'].'</span>';
			}
			else
			{
				$usergroup = '参数获取失败';
			}
		}
		
		if($r_user['enteruser'] == 1)
		{
			$usergroup .= '[认证]';
		}
		
		echo $usergroup
		?>
		</span><br />
	</div>
	<div class="cl"></div>
</div>
<div class="act"> <a href="?c=default" <?php if($c=='default') echo 'class="on"'; ?>>个人中心</a> <a href="?c=edit" <?php if($c=='edit' or $c=='avatar') echo 'class="on"'; ?>>编辑资料</a> <a href="?c=favorite" <?php if($c=='favorite') echo 'class="on"'; ?>>我的收藏</a> <a href="?c=comment" <?php if($c=='comment') echo 'class="on"'; ?>>我的评论</a> <a href="?c=order" <?php if($c=='order' or $c=='ordershow') echo 'class="on"'; ?>>我的订单</a> <a href="?c=msg" <?php if($c=='msg') echo 'class="on"'; ?>>我的留言</a> </div>
