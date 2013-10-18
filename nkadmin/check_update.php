<?php	require(dirname(__FILE__).'/inc/config.inc.php');error_reporting(0);

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-2-6 13:07:48
person: Feng
**************************
*/


//引入关联文件
require(PHPMYWIND_DATA.'/httpfile/down.class.php');


//当前软件版本文件
$verLockFile = PHPMYWIND_DATA.'/update/vertime.txt';


//升级信息保存文件
$cacheFiles = PHPMYWIND_DATA.'/update/update_temp.txt';


//系统版本,方便以后扩充其他编码
$cfg_soft_lang = 'utf-8';


//读取版本文件中的版本
$uptime = trim(Readf($verLockFile));


//生成版本时间
$oktime = substr($uptime,0,4).'-'.substr($uptime,4,2).'-'.substr($uptime,6,2);


//获取后台目录名称
$adminDir = preg_replace("#(.*)[\/\\\\]#", "", dirname(__FILE__));


//获取升级服务器地址 下载远程数据
$dhd = new HttpDown();
$dhd->AjaxHead();
$dhd->OpenUrl('http://server.phpmywind.com/');
$serlist = trim($dhd->GetHtml());
$dhd->Close();
$serlist = mb_convert_encoding($serlist,"UTF-8","GB2312");
$serlist = preg_replace("#[\r\n]{1,}#", "\n", $serlist);
$serlists = explode("\n", $serlist);


//分析数据
//存放服务器列表数组
$serverlists = array();
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
@$key = mt_rand(0,(count($serverlists)-1));


//设置升级服务器地址
@$updateHost = $serverlists[$key]['shost'];

if(empty($action)) $action = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>检查可用更新</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
<script type="text/javascript" src="templates/js/checkupdate_ajax.js"></script>
</head>
<body <?php if(empty($action)) echo 'onload="GetUpdateList(\''.$uptime.'\',\''.$cfg_soft_lang.'\')"'; ?> >
<div class="mgr_header"><span class="title">系统更新</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<div id="update_list" <?php if(!empty($action)) echo 'style="display:none"'; ?>>
		<div class="mgr_divt2"></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
				<tr align="center" class="mgr_tr">
						<td height="200"><div class="loadstyle"><img src="templates/images/loading.gif" />正在检查可用更新...</div></td>
				</tr>
		</table>
		<div class="mgr_divb"> <span class="mgr_btn_short"><a href="home.php">返回首页</a></span> </div>
</div>
<?php

//获取升级文件列表
if($action == 'getlist')
{
	if(!isset($upitems))
	{
		echo '<script>location.href="?"</script>';
		exit();
	}
    $upitemsArr = explode(',', $upitems);
    rsort($upitemsArr);
    $tmpdir = substr(md5("phpMyWind Feng&Adu"), 0, 16);
    $dhd = new HttpDown();
    $fileArr = array();
    $f = 0;
    foreach($upitemsArr as $upitem)
    {
        $durl = $updateHost.$cfg_soft_lang.'/'.$upitem.'.txt';
        $dhd->OpenUrl($durl);
        $filelist = $dhd->GetHtml();
		$filelist = mb_convert_encoding($filelist,"UTF-8","GB2312");
        $filelist = trim( preg_replace("#[\r\n]{1,}#", "\n", $filelist) );
        if(!empty($filelist))
        {
            $filelists = explode("\n", $filelist);
            foreach($filelists as $filelist)
            {
                $filelist = trim($filelist);
                if(empty($filelist)) continue;
                $fs = explode(',', $filelist);
                if( empty($fs[1]) ) 
                {
                    $fs[1] = $upitem." 常规功能更新文件";
                }
                if(!isset($fileArr[$fs[0]])) 
                {
                    $fileArr[$fs[0]] = $upitem." ".trim($fs[1]);
                    $f++;
                }
            }
        }
    }
    $dhd->Close();
	if($f == 0)
	{
	?>
	<div class="mgr_divt2"></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
			<tr align="center" class="mgr_tr">
					<td height="200"><img src="templates/images/loading.gif"> <strong class="red">获取更新信息失败，可能是官方服务器忙，请稍后再试！</strong><br />
							<br />
							系统最后更新时间为：<?php echo $uptime; ?></td>
			</tr>
	</table>
	<div class="mgr_divb"> <span class="mgr_btn_short"><a href="home.php">返回首页</a></span> </div>
	<?php
	}
	else
	{
	?>
<form name='update' action='?action=getfiles' method='post'>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
				<tr class="thead" align="center">
						<td width="10%" height="30">状态</td>
						<td width="36%" align="left">文件名路径名称</td>
						<td width="54%" align="left">更新描述</td>
				</tr>
				<?php
				$filelists = explode("\n",$filelist);
				foreach($fileArr as $k=>$v) 
				{       
				?>
				<tr align="center" class="mgr_tr">
						<td height="30"><input type='checkbox' name='files[]' value='<?php echo $k?>'  checked='checked' /></td>
						<td align="left"><?php
						if( preg_match("#^admin\/#i", $k) ) 
            			{
               				$k = preg_replace("#^admin\/#", $adminDir.'/', $k);
           				}
						if(substr($k,-3) == 'txt')
						{
							$k = substr($k,0,-4).'.php';
						}
						else
						{
							$k = $k;
						}
						 echo $k?></td>
						<td align="left"><?php echo $v?></td>
				</tr>
				<?php
				}
				?>
		</table>
		<div class="mgr_divb">
				<input type="hidden" name="vtime" value="<?php echo $vtime?>" />
				<input type="hidden" name="vversion" value="<?php echo $vversion?>" />
				<input type="hidden" name="upitems" value="<?php echo $upitems?>" />
				<div class="selall" style="padding-top:1px;_padding-top:5px;">
						<label>文件临时存放目录：../data/update/</label>
						<input type="text" name="tmpdir" style="width:150px;" value="<?php echo $tmpdir?>" />
				</div>
				<span class="mgr_btn"><a href="#" onclick="update.submit();">下载应用补丁</a></span> </div>
		<?php
	}
	?>
</form>
<?php
}

//下载文件（保存需下载内容列表）
else if($action == 'getfiles')
{
    $skipnodir = (isset($skipnodir) ? 1 : 0);
    
    if(!isset($files))
    {   
		if(!isset($vtime))
		{
			echo '<script>location.href="?"</script>';
			exit();
		}
	?>
<div class="mgr_divt2"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="mgr_tr">
				<td height="200"><strong class="red"> 你没有指定任何需要下载更新的文件，是否跳过这些更新？</strong><br />
						<br />
						<a href="?action=skip&vtime=<?php echo $vtime?>" class="blue">[跳过这些更新]</a>&nbsp;&nbsp;<a href="?" class="blue">[保留提示以后再进行操作]</a></td>
		</tr>
</table>
<div class="mgr_divb"> </div>
<?php
	}
    else
    {
        $fp = fopen($cacheFiles, 'w');
        fwrite($fp, '<'.'?php'."\r\n");
        fwrite($fp, '$tmpdir = "'.$tmpdir.'";'."\r\n");
        fwrite($fp, '$vtime = '.$vtime.';'."\r\n");
		fwrite($fp, '$vversion = "'.$vversion.'";'."\r\n");
        $dirs = array();
        $i = -1;
        foreach($files as $filename)
        {
            $tfilename = $filename;
            if( preg_match("#^admin\/#i", $filename) ) 
            {
                $tfilename = preg_replace("#^admin\/#", $adminDir.'/', $filename);
            }
            $curdir = GetDirName($tfilename);
            if( !isset($dirs[$curdir]) ) 
            {
                $dirs[$curdir] = TestIsFileDir($curdir);
            }
            if($skipnodir==1 && $dirs[$curdir]['isdir'] == FALSE) 
            {
                continue;
            }
            else {
                @mkdir($curdir, 0777);
                $dirs[$curdir] = TestIsFileDir($curdir);
            }
            $i++;
            fwrite($fp, '$files['.$i.'] = "'.$filename.'";'."\r\n");
        }
        fwrite($fp, '$fileConut = '.$i.';'."\r\n");
        
        $items = explode(',', $upitems);
        foreach($items as $sqlfile)
        {
            fwrite($fp,'$sqls[] = "'.$sqlfile.'.sql";'."\r\n");
        }
        fwrite($fp, '?'.'>');
        fclose($fp);
        
        $echo = '';
        if($i > -1)
        {
		?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="center">
				<td width="2%" height="30" align="left"></td>
				<td width="84%" align="left">路径名称</td>
				<td width="14%" align="left">状态</td>
		</tr>
		<?php
				$i = 0;
				foreach($dirs as $curdir)
				{
				?>
		<tr align="center" class="mgr_tr">
				<td height="30" align="left"></td>
				<td height="30" align="left"><?php echo $curdir['name']?></td>
				<td width="14%" align="left"><?php echo ($curdir['writeable'] ? "<span class='green'>[√正常]</span>" : "<span class='red'>[×不可写]</span>")?></td>
		</tr>
		<?php
					$i++;
				}
				?>
</table>
<div class="mgr_divb"> <a href="?action=down&curfile=0" class="blue">确认目录状态都正常后，请点击开始下载文件&gt;&gt;</a></div>
<div class="page_info">共有<span><?php echo $i; ?></span>个目录</div>
<div class="notewarn" id="notification"> <span class="close"><a href="javascript:;" id="notification_close" onclick="HideDiv('notification');"></a></span>
		<div>如果您对文件进行过更改，请谨慎升级，文件可能会被覆盖；本次升级需要在以上文件夹写入更新文件，请注意文件夹是否有写入权限(../为系统根目录)</div>
</div>
<?php
		}
		?>
<?php
    }
}

//下载文件，具体操作步骤
else if($action == 'down')
{
    require($cacheFiles);
    if(empty($startup))
    {
        if($fileConut==-1 || $curfile > $fileConut)
        {
			Msg("<strong class='blue'>已下载所有文件，开始下载数据库升级文件</strong>","?action=down&startup=1");
            exit();
        }
        //检查临时文件保存目录是否可用
        MkTmpDir($tmpdir, $files[$curfile]);
        $downfile = $updateHost.$cfg_soft_lang.'/source/'.$files[$curfile];    
        $dhd = new HttpDown();
        $dhd->OpenUrl($downfile);
		if(substr($files[$curfile],-3) == 'txt')
		{
			$curfiles = substr($files[$curfile],0,-4).'.php';
		}
		else
		{
			$curfiles = $files[$curfile];
		}
        $dhd->SaveToBin(PHPMYWIND_DATA.'/update/'.$tmpdir.'/'.$curfiles);
        $dhd->Close();
		if(preg_match("#^admin\/#i", $curfiles) ) 
		{
			$newcurfiles = preg_replace("#^admin\/#", $adminDir.'/', $curfiles);
		}
		else
		{
			$newcurfiles = $curfiles;
		}
		Msg('<strong class="blue">成功下载并保存文件：'.$newcurfiles.'；继续下载下一个文件。','?action=down&curfile='.($curfile+1));
    }
    else
    {
        MkTmpDir($tmpdir, 'sql.txt');
        $dhd = new HttpDown();
        $ct = '';
        foreach($sqls as $sql)
        {
            $downfile = $updateHost.$cfg_soft_lang.'/'.$sql;
            $dhd->OpenUrl($downfile);
            $ct .= $dhd->GetHtml();
        }
        $dhd->Close();
        $truefile = PHPMYWIND_DATA.'/update/'.$tmpdir.'/sql.txt';
        $fp = fopen($truefile, 'w');
        fwrite($fp, $ct);
        fclose($fp);
        Msg("<strong class='green'>完成所有远程文件获取操作：</strong><a href='?action=apply' class='red' style='text-decoration:underline;'>&lt;&lt;点击此开始直接升级&gt;&gt;</a><br /><br />你也可以直接使用[../data/update/{$tmpdir}]目录的文件手动升级。","javascript:;");
    }
}
//应用升级
else if($action=='apply')
{
    require($cacheFiles);
    if(empty($step))
    {
        $truefile = PHPMYWIND_DATA.'/update/'.$tmpdir.'/sql.txt';
        $fp = fopen($truefile, 'r');
        $sql = @fread($fp, filesize($truefile));
        fclose($fp);
        if(!empty($sql))
        {
            $mysql_version = $dosql->GetVersion(true);
            $sql = preg_replace('#ENGINE=MyISAM#i', 'TYPE=MyISAM', $sql);
            $sql41tmp = 'ENGINE=MyISAM DEFAULT CHARSET='.$db_charset;
            if($mysql_version >= 4.1) 
            {
                $sql = preg_replace('#TYPE=MyISAM#i', $sql41tmp, $sql);
            }
            $sqls = explode(";\r\n", $sql);
            foreach($sqls as $sql)
            {
                if(trim($sql)!='') 
                {
                    $dosql->ExecuteNoneQuery(trim($sql));
                }
            }
        }
        Msg('<strong class="blue">完成数据库更新，现在开始复制文件。</span>','?action=apply&step=1');
    }
    else
    {
        $sDir = PHPMYWIND_DATA.'/update/'.$tmpdir;
        $tDir = PHPMYWIND_ROOT;
        $badcp = 0;
        if(isset($files) && is_array($files))
        {
            foreach($files as $f)
            {
				if(substr($f,-3) == 'txt')
				{
					$f = substr($f,0,-4).'.php';
				}
                if(preg_match('#^admin#', $f)) 
                {
                    $tf = preg_replace('#^admin#', $adminDir, $f);
                }
                else {
                    $tf = $f;
                }
                if(file_exists($sDir.'/'.$f))
                {
					
                    $rs = @copy($sDir.'/'.$f, $tDir.'/'.$tf);
                    if($rs) {
                        unlink($sDir.'/'.$f);
                    }
                    else {
                        $badcp++;
                    }
                }
            }
        }
        Writef($verLockFile,$vtime);
		Writef(PHPMYWIND_DATA.'/update/version.txt',$vversion);
        $badmsg = '！';
        if($badcp > 0)
        {
            $badmsg = "，其中失败 <strong class='red'>{$badcp}</strong> 个文件，<br /><br />请从临时目录[../data/{$tmpdir}]中取出这几个文件手动升级。";
        }
        Msg('<strong class="blue">恭喜您，成功完成升级</strong>'.$badmsg,'check_update.php');
    }
}

//忽略某个日期前的升级
else if($action == 'skip')
{
    Writef($verLockFile,$vtime);
    Msg('<strong class="blue">忽略更新成功,这些更新将不再显示！</strong>','?');
}

//自定义函数开始
function TestWriteAble($d)
{
    $tfile = '_dedet.txt';
    $fp = @fopen($d.$tfile,'w');
    if(!$fp) {
        return false;
    }
    else {
        fclose($fp);
        $rs = @unlink($d.'/'.$tfile);
        return true;
    }
}

function GetDirName($filename)
{
    $dirname = '../'.preg_replace("#[\\\\\/]{1,}#", '/', $filename);
    $dirname = preg_replace("#([^\/]*)$#", '', $dirname);
    return $dirname;
}

function TestIsFileDir($dirname)
{
    $dirs = array('name'=>'', 'isdir'=>FALSE, 'writeable'=>FALSE);
    $dirs['name'] =  $dirname;
    if(is_dir($dirname))
    {
        $dirs['isdir'] = TRUE;
        $dirs['writeable'] = TestWriteAble($dirname);
    }
    return $dirs;
}

function MkTmpDir($tmpdir,$filename)
{
    $basedir = PHPMYWIND_DATA.'/update/'.$tmpdir;
    $dirname = trim(preg_replace("#[\\\\\/]{1,}#", '/', $filename));
    $dirname = preg_replace("#([^\/]*)$#","",$dirname);
    if(!is_dir($basedir)) 
    {
        mkdir($basedir,0777);
    }
    if($dirname=='') 
    {
        return TRUE;
    }
    $dirs = explode('/', $dirname);
    $curdir = $basedir;
    foreach($dirs as $d)
    {
        $d = trim($d);
        if(empty($d)) continue;
        $curdir = $curdir.'/'.$d;
        if(!is_dir($curdir)) 
        {
            mkdir($curdir, 0777) or die($curdir);
        }
    }
    return TRUE;
}

/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转链接
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function Msg($msg, $gourl, $onlymsg=0, $limittime=0)
{
    $htmlhead = '<base target="_self" />';
    $htmlfoot = '<div class="mgr_divb"></div>';

    $litime = ($limittime==0 ? 3000 : $limittime);
    $func = '';

    if($gourl=='-1')
    {
        if($limittime==0) $litime = 200;
        $gourl = "javascript:history.go(-1);";
    }

    if($gourl=='' || $onlymsg==1)
    {
        $msg = "<script>alert(\"".str_replace("\"","\"",$msg)."\");</script>";
    }
    else
    {
        $func .= "<script>var pgo=0;function JumpUrl(){if(pgo==0){location='$gourl'; pgo=1;}}</script>";
        $rmsg = $func;
		$rmsg .= '<div class="mgr_divt2"></div>';
        $rmsg .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table"><tr align="center" class="mgr_tr">';
        $rmsg .= '<td height="200">';
        $rmsg .= '<img src="templates/images/loading.gif" />&nbsp;'.$msg.'</strong>';
        if($onlymsg == 0)
        {
            if($gourl != 'javascript:;' && $gourl != '')
            {
                $rmsg .= "<br /><br /><a href='{$gourl}'>[如果您的浏览器没有自动跳转，请点击这里]</a>";
                $rmsg .= '</td></tr></table>';
                $rmsg .= "<script>setTimeout('JumpUrl()',$litime);</script>";
            }
            else
            {
                $rmsg .= '</td></tr></table>';
            }
        }
        else
        {
            $rmsg .= '</td></tr></table>';
        }
        $msg = $htmlhead.$rmsg.$htmlfoot;
    }
    echo $msg;
}
?>
</body>
</html>