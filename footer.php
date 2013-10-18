<!-- weblink-->

<div class="weblink">
	<?php
	$dosql->Execute("SELECT * FROM `#@__weblink` WHERE classid=1 AND checkinfo=true ORDER BY orderid,id DESC");
	while($row = $dosql->GetArray())
	{
	?>
	<a href="<?php echo $row['linkurl']; ?>" target="_blank" title="<?php echo $row['webname']; ?>"><img width="100" height="20" src="<?php echo $row['picurl'] ?>"/></a>
	<?php
	}
	?>
</div>
<!-- /weblink-->
<!-- footer-->
<div class="footer"><?php echo $cfg_copyright ?></div>
<input type="hidden" id="input_pid" value="<?php echo $GLOBALS['base']['parentid']; ?>">
<input type="hidden" id="input_cid" value="<?php echo $GLOBALS['base']['id']; ?>">
<input type="hidden" id="input_cname" value="<?php echo $GLOBALS['base']['classname']; ?>">
<!-- /footer-->
<?php

echo GetQQ();

//将流量统计代码放在页面最底部
$cfg_countcode;

?>