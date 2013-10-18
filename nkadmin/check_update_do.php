<?php	require(dirname(__FILE__).'/inc/config.inc.php');error_reporting(0);

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-3-5 14:55:58
person: Feng
**************************
*/


require(PHPMYWIND_DATA.'/httpfile/down.class.php');


//获取升级服务器地址 下载远程数据
$dhd = new HttpDown();
$dhd->AjaxHead();
$dhd->OpenUrl('http://server.phpmywind.com/');
$serlist = trim($dhd->GetHtml());
$dhd->Close();
$serlist = mb_convert_encoding($serlist, 'UTF-8', 'GB2312');


//判断是否获取到服务器列表
if(empty($serlist))
{
	$oktime = substr($uptime,0,4).'-'.substr($uptime,4,2).'-'.substr($uptime,6,2).' '.substr($uptime,8,2).':'.substr($uptime,10,2);
?>
<div class="mgr_divt2"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="mgr_tr">
				<td height="200"><img src="templates/images/loading.gif"> <strong class="red">获取更新服务器列表失败，可能是官方服务器忙，请稍后再试！</strong><br />
						<br />
						系统最后更新时间为：<?php echo $oktime; ?></td>
		</tr>
</table>
<div class="mgr_divb"> <span class="mgr_btn_short"><a href="home.php">返回首页</a></span> </div>
<?php
	exit();
}

$serlist = preg_replace("#[\r\n]{1,}#", "\n", $serlist);
$serlists = explode("\n", $serlist);

//分析数据
$serverlists = array(); //存放服务器列表数组
$n = 0;
foreach($serlists as $serstr)
{
	if(empty($serstr) || preg_match("#^\/\/#", $serstr)) 
	{
		continue;
	}

	//生成数组
	@list($shost, $smsg) = explode(',', $serstr);
	$shost = trim($shost);
	$smsg = trim($smsg);
	$serverlists[$n]['shost'] = $shost;
	$serverlists[$n]['smsg'] = $smsg;
	$n++;
}

//取0到服务器个数-1的随机数，作为下标
$key = mt_rand(0,(count($serverlists)-1));

//设置升级服务器地址
$updateHost = $serverlists[$key]['shost'];

//生成版本时间
$oktime = substr($uptime,0,4).'-'.substr($uptime,4,2).'-'.substr($uptime,6,2).' '.substr($uptime,8,2).':'.substr($uptime,10,2);

//下载远程数据
$dhd = new HttpDown();
$dhd->AjaxHead();
$dhd->OpenUrl($updateHost.'/verinfo.txt');
$verlist = trim($dhd->GetHtml());
$dhd->Close();
$verlist = mb_convert_encoding($verlist,"UTF-8","GB2312");

//判断是否获取到跟新信息
if(empty($verlist))
{
?>
<div class="mgr_divt2"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="mgr_tr">
				<td height="200"><img src="templates/images/loading.gif"> <strong class="red">获取更新信息失败，可能是官方服务器忙，请稍后再试！</strong><br />
						<br />
						系统最后更新时间为：<?php echo $oktime; ?></td>
		</tr>
</table>
<div class="mgr_divb"> <span class="mgr_btn_short"><a href="home.php">返回首页</a></span> </div>
<?php
	exit();
}

$verlist = preg_replace("#[\r\n]{1,}#", "\n", $verlist);
$verlists = explode("\n", $verlist);
//分析数据
$updateVers = array();
$upitems = $lastTime = '';
$n = 0;
foreach($verlists as $verstr)
{
	if(empty($verstr) || preg_match("#^\/\/#", $verstr)) 
	{
		continue;
	}

	//生成数组
	@list($vtime, $vlang, $issafe, $vversion, $vmsg) = explode(',', $verstr);
	$vtime = trim($vtime);
	$vlang = trim($vlang);
	$issafe = trim($issafe);
	$vversion = trim($vversion);
	$vmsg = trim($vmsg);
	if($vtime > $uptime && $vlang==$cfg_soft_lang)
	{
		$updateVers[$n]['issafe'] = $issafe;
		$updateVers[$n]['vversion'] = $vversion;
		$updateVers[$n]['vmsg'] = $vmsg;
		$upitems .= ($upitems=='' ? $vtime : ','.$vtime);
		$lastTime = $vtime;
		$updateVers[$n]['vtime'] = substr($vtime,0,4).'-'.substr($vtime,4,2).'-'.substr($vtime,6,2).' '.substr($vtime,8,2).':'.substr($vtime,10,2);;
		$n++;
	}
	
}

//判断是否需要更新，并返回适合的结果
if($n == 0)
{
?>
<div class="mgr_divt2"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="mgr_tr">
				<td height="200"><strong class="blue">您的系统已是最新的，暂时没有可用更新！</strong><br />
						<br />
						系统最后更新时间为：<?php echo $oktime?></td>
		</tr>
</table>
<div class="mgr_divb"> <span class="mgr_btn_short"><a href="home.php">返回首页</a></span> </div>
<?php
}
else
{
?>
<form name="update" action="?action=getlist" method="post">
		<input type='hidden' name='vtime' value='<?php echo $lastTime?>' />
		<input type='hidden' name='vversion' value='<?php echo $vversion?>' />
		<input type='hidden' name='upitems' value='<?php echo $upitems?>' />
		<input type='hidden' name='updateHost' value='<?php echo $updateHost?>' />
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
				<tr class="thead" align="center">
						<td width="10%" height="30">重要级别</td>
						<td width="20%">发布日期</td>
						<td width="20%" align="left">版本号</td>
						<td width="50%" align="left">更新描述</td>
				</tr>
				<?php
				foreach($updateVers as $vers)
				{
				?>
				<tr align="center" class="mgr_tr">
						<td height="30"><strong style="color:<?php
						switch($vers['issafe'])
						{
							case "1":
								echo '#0099FF';
							break;
							case "2":
								echo '#003399';
							break;
							case "3":
								echo '#FF6600';
							break;
							case "4":
								echo '#FF0000';
							break;
							default:
								$imgurl = "一般";
						}
						?>;">【<?php
						switch($vers['issafe'])
						{
							case "1":
								echo '一般';
							break;
							case "2":
								echo '重要';
							break;
							case "3":
								echo '严重';
							break;
							case "4":
								echo '危急';
							break;
							default:
								$imgurl = "一般";
						}
						?>】</strong></td>
						<td class="number"><?php echo $vers['vtime']; ?></td>
						<td align="left"><?php echo $vers['vversion']; ?></td>
						<td align="left"><?php echo $vers['vmsg']; ?></td>
				</tr>
				<?php
				}
				?>
		</table>
		<div class="mgr_divb">
				<div class="selall">最后更新时间为：<?php echo $oktime?>　<span>操作：</span><a href="?action=skip&vtime=<?php echo $vtime?>">忽略这些更新</a></div>
				<span class="mgr_btn"><a href="#" onclick="update.submit();">获取更新文件</a></span> </div>
</form>
<?php
}
?>