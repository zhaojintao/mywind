<?php	header("Content-Type:text/html;charset=utf-8");

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-8-28 13:47:05
person: Feng
**************************
*/

define('PHPMYWIND_INC', preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__)));
define('PHPMYWIND_ROOT', preg_replace("/[\/\\\\]{1,}/", '/', substr(PHPMYWIND_INC, 0, -8)));
define('PHPMYWIND_DATA', PHPMYWIND_ROOT.'/data');
define('PHPMYWIND_TEMP', PHPMYWIND_ROOT.'/templates');
define('PHPMYWIND_UPLOAD', PHPMYWIND_ROOT.'/uploads');
define('PHPMYWIND_BACKUP', PHPMYWIND_DATA.'/backup');
define('IN_PHPMYWIND', TRUE);


//检查外部传递的值并转义
function _RunMagicQuotes(&$svar)
{
	//PHP5.4已经将此函数移除
    if(@!get_magic_quotes_gpc())
    {
        if(is_array($svar))
        {
            foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
        }
        else
        {
            if(strlen($svar)>0 &&
			   preg_match('#^(cfg_|GLOBALS|_GET|_POST|_SESSION|_COOKIE)#',$svar))
            {
				exit('不允许请求的变量值!');
            }

            $svar = addslashes($svar);
        }
    }
    return $svar;
}


//直接应用变量名称替代
foreach(array('_GET','_POST') as $_request)
{
	foreach($$_request as $_k => $_v)
	{
		if(strlen($_k)>0 &&
		   preg_match('#^(GLOBALS|_GET|_POST|_SESSION|_COOKIE)#',$_k))
		{
			exit('不允许请求的变量名!');
		}

		${$_k} = _RunMagicQuotes($_v);
	}
}


require(PHPMYWIND_INC.'/config.cache.php'); //全局配置文件
require(PHPMYWIND_INC.'/common.func.php');  //全局常用函数
require(PHPMYWIND_INC.'/conn.inc.php');     //引入数据库类


//引入数据库类
if($cfg_mysql_type == 'mysqli' &&
   function_exists('mysqli_init'))
   require(PHPMYWIND_INC.'/mysqli.class.php');
else
   require(PHPMYWIND_INC.'/mysql.class.php');


//Session保存路径
$sess_savepath = PHPMYWIND_DATA.'/sessions/';
if(is_writable($sess_savepath) &&
   is_readable($sess_savepath))
   session_save_path($sess_savepath);


//上传文件保存路径
$cfg_image_dir = PHPMYWIND_UPLOAD.'/image';
$cfg_soft_dir  = PHPMYWIND_UPLOAD.'/soft';
$cfg_media_dir = PHPMYWIND_UPLOAD.'/media';


//系统版本号
$cfg_vernum  = file_get_contents(PHPMYWIND_DATA.'/version/version.txt');
$cfg_vertime = file_get_contents(PHPMYWIND_DATA.'/version/vertime.txt');


//设置默认时区
if(PHP_VERSION > '5.1')
{
	$time51 = $cfg_timezone * -1;
    @date_default_timezone_set('Etc/GMT'.$time51);
}


//判断是否开启错误提示
if($cfg_diserror == 'Y')
	error_reporting(E_ALL);
else
	error_reporting(0);


//判断访问设备
if(IsMobile() && !strstr(GetCurUrl(),'3g.php'))
{
	header('location:3g.php');
}

?>