<?php	header('Content-Type:text/html; charset=utf-8');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2013-5-14 16:32:40
person: Feng
**************************
*/


//检测版本号
if(phpversion() < '5.0')
{
	exit('用户您好，由于您的php版本过低，不能安装本软件，为了系统功能全面可用，请升级到5.0或更高版本再安装，谢谢！<br />您可以登录 phpMyWind.com 获取更多帮助');
}


//不限制响应时间
@set_time_limit(0);
error_reporting(0);


//设置系统路径
define('INSTALL_PATH', preg_replace('/[\/\\\\]{1,}/', '/', dirname(__FILE__)));
define('IN_INSTALL', TRUE);


//提示已经安装
if(is_file(INSTALL_PATH.'/../data/install_lock.txt') && $_GET['s']!=md5('done'))
{
	require(INSTALL_PATH.'/templates/step_5.html');
	exit();
}


//初始化参数
$s = !empty($_POST['s']) ? intval($_POST['s']) : 0;


//如果有GET值则覆盖POST值
if(!empty($_GET['s']))
{
	if($_GET['s']==1 or $_GET['s']==15271 or $_GET['s']==md5('done'))
	{
		$s = $_GET['s'];
	}
}


//执行相应操作
switch($s)
{
	case 0: //协议说明
		require(INSTALL_PATH.'/templates/step_0.html'); 
		break;

	case 1: //环境检测
		$iswrite_array = array('/data/',
							   '/include/conn.inc.php',
							   '/include/config.cache.php',
							   '/uploads/');
		$exists_array = array('is_writable',
		                      'function_exists',
							  'mysql_connect');
		require(INSTALL_PATH.'/templates/step_1.html');
		break;

	case 2: //配置文件
		require(INSTALL_PATH.'/templates/step_2.html');
		break;

	case 3: //正在安装
		require(INSTALL_PATH.'/templates/step_3.html');

		if($_POST['s'] == 3)
		{
			$dbinfo    = $_POST['dbinfo'];
			$admininfo = $_POST['admininfo'];

			$conn = mysql_connect($dbinfo['dbhost'], $dbinfo['dbuser'], $dbinfo['dbpw']);
			if($conn)
			{
				if(mysql_get_server_info() < '4.0')
				{
					echo '<script>$("#content_area").append("检测到您的数据库版本过低，请更新！");</script>';
					exit();
				}

				$res = mysql_query('show Databases');

				//遍历所有数据库，存入数组
				while($row = mysql_fetch_array($res))
				{
					$dbname_arr[] = $row['Database'];
				}

				//检查数据库是否存在，没有则创建数据库
				if(!in_array(trim($dbinfo['dbname']), $dbname_arr))
				{
					if(!mysql_query("CREATE DATABASE `".$dbinfo['dbname']."`"))
					{
						echo '<script>$("#content_area").append("创建数据库失败，请检查权限或联系管理员！");</script>';
						exit();
					}
				}

				mysql_select_db($dbinfo['dbname'], $conn);


				//取出conn.inc模板内容
				$config_str = '';
				$fp = fopen(INSTALL_PATH.'/data/conn.tpl.php', 'r');
				while(!feof($fp))
				{
					$config_str .= fgets($fp, 1024);
				}
				fclose($fp);


				//进行替换
				$config_str = str_replace("~db_host~", $dbinfo['dbhost'], $config_str);
				$config_str = str_replace("~db_name~", $dbinfo['dbname'], $config_str);
				$config_str = str_replace("~db_user~", $dbinfo['dbuser'], $config_str);
				$config_str = str_replace("~db_pwd~",  $dbinfo['dbpw'],   $config_str);
				$config_str = str_replace("~db_tablepre~", $dbinfo['tablepre'], $config_str);
				$config_str = str_replace("~db_charset~", 'utf8', $config_str);


				//将替换后的内容写入conn.inc文件
				$fp = fopen(INSTALL_PATH.'/../include/conn.inc.php', 'w');
				fwrite($fp, $config_str);
				fclose($fp);

				ob_start();
				ob_implicit_flush(1);
				ob_end_flush();
				echo '<script>$("#content_area").append("数据库连接文件创建完成！<br />");</script>';


				//设置数据库状态
				mysql_query("SET NAMES 'utf8', character_set_client=binary, sql_mode='', interactive_timeout=3600;");


				//创建表结构
				$tbstruct = '';
				$fp = fopen(INSTALL_PATH.'/data/install_struct.txt', 'r');
				while(!feof($fp))
				{
					$tbstruct .= fgets($fp, 1024);
				}
				fclose($fp);

				$querys = explode(';', ClearBOM($tbstruct));
				foreach($querys as $q)
				{
					if(trim($q) == '') continue;
					mysql_query(str_replace('#@__', $dbinfo['tablepre'], trim($q)).';');
				}

				echo '<script>$("#content_area").append("数据库结构导入完成！<br />");</script>';


				//创建管理员
				mysql_query("INSERT INTO `".$dbinfo['tablepre']."admingroup` VALUES('1','超级管理员','超级管理员组','true');");
				mysql_query("INSERT INTO `".$dbinfo['tablepre']."admingroup` VALUES('2','站点管理员','站点管理员组','true');");
				mysql_query("INSERT INTO `".$dbinfo['tablepre']."admingroup` VALUES('3','文章发布员','文章发布员组','true');");
				echo '<script>$("#content_area").append("管理组信息导入完成！<br />");</script>';
				
				mysql_query("INSERT INTO `".$dbinfo['tablepre']."admin` VALUES('1','".$admininfo['username']."','".md5(md5($admininfo['password']))."','','0','','1','true','127.0.0.1','".time()."');");
				echo '<script>$("#content_area").append("管理员信息导入完成！<br />");</script>';


				
				//初始化环境变量
				if(!empty($_SERVER['REQUEST_URI']))
					$scriptName = $_SERVER['REQUEST_URI'];
				else
					$scriptName = $_SERVER['PHP_SELF'];

				$basepath = preg_replace("#\/install(.*)$#i", '', $scriptName);
				if(!empty($_SERVER['HTTP_HOST']))
					$baseurl = 'http://'.$_SERVER['HTTP_HOST'];
				else
					$baseurl = 'http://'.$_SERVER['SERVER_NAME'];
					
				$authkey = GetRandStr(16);


				//导入网站配置
				//替换安装地址与目录
				$data_str = "INSERT INTO `#@__webconfig` VALUES('1','cfg_webname','网站名称','0','string','我的网站','1');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_weburl','网站地址','0','string','$baseurl','2');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_webpath','网站目录','0','string','$basepath','3');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_author','网站作者','0','string','','4');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_generator','程序引擎','0','string','PHPMyWind CMS','5');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_keyword','关键字设置','0','string','','6');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_description','网站描述','0','bstring','','7');
				
				INSERT INTO `#@__webconfig` VALUES('1','cfg_icp','备案编号','0','string','','10');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_webswitch','启用站点','0','bool','Y','11');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_switchshow','关闭说明','0','bstring','对不起，网站维护，请稍后登陆。<br />网站维护期间对您造成的不便，请谅解！','12');

				INSERT INTO `#@__webconfig` VALUES('1','cfg_upload_img_type','上传图片类型','1','string','gif|png|jpg|bmp','23');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_upload_soft_type','上传软件类型','1','string','zip|gz|rar|iso|doc|xls|ppt|wps|txt','24');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_upload_media_type','上传媒体类型','1','string','swf|flv|mpg|mp3|rm|rmvb|wmv|wma|wav','25');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_max_file_size','上传文件大小','1','string','2097152','26');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_imgresize','自动缩略图方式　<br />(是\"裁切\",否\"填充\")','1','bool','Y','27');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_countcode','流量统计代码','1','bstring','','28');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_qqcode','在线QQ　<br />(多个用\",\"分隔)','1','bstring','','29');

				INSERT INTO `#@__webconfig` VALUES('1','cfg_mysql_type','数据库类型(支持mysql和mysqli)','2','string','mysqli','40');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_pagenum','每页显示记录数','2','string','20','41');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_timezone','服务器时区设置','2','string','8','42');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_member','开启会员功能','2','bool','Y','43');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_comment','开启文章评论','2','bool','Y','44');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_maintype','二级类别开关','2','bool','N','45');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_typefold','类别折叠显示','2','bool','N','46');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_diserror','PHP错误显示','2','bool','Y','47');

				INSERT INTO `#@__webconfig` VALUES('1','cfg_isreurl','是否启用伪静态','3','bool','N','60');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_index','首页规则','3','string','index.html','61');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_about','关于我们页','3','string','{about}-{cid}-{page}.html','62');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_news','新闻中心页','3','string','{news}-{cid}-{page}.html','63');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_newsshow','新闻内容页','3','string','{newsshow}-{cid}-{id}-{page}.html','64');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_product','产品展示页','3','string','{product}-{cid}-{page}.html','65');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_productshow','产品内容页','3','string','{productshow}-{cid}-{id}-{page}.html','66');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_case','案例展示页','3','string','{case}-{cid}-{page}.html','67');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_caseshow','案例内容页','3','string','{caseshow}-{cid}-{id}-{page}.html','68');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_join','人才招聘页','3','string','{join}-{page}.html','69');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_joinshow','招聘内容页','3','string','{joinshow}-{id}.html','70');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_message','客户留言页','3','string','{message}-{page}.html','71');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_contact','联系我们页','3','string','{contact}-{cid}-{page}.html','72');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_soft','软件下载页','3','string','{soft}-{cid}-{page}.html','73');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_softshow','软件内容页','3','string','{softshow}-{cid}-{id}-{page}.html','74');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_goods','商品展示页','3','string','{goods}-{cid}-{tid}-{page}.html','75');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_goodsshow','商品内容页','3','string','{goodsshow}-{cid}-{tid}-{id}-{page}.html','76');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_vote','投票内容页','3','string','{vote}-{id}.html','77');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_reurl_custom','自定义规则','3','string','{file}.html','78');

				INSERT INTO `#@__webconfig` VALUES('1','cfg_auth_key','网站标识码','4','string','$authkey','90');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_alipay_uname','支付宝帐户','4','string','','91');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_alipay_partner','支付宝合作身份者id','4','string','','92');
				INSERT INTO `#@__webconfig` VALUES('1','cfg_alipay_key','支付宝安全检验码','4','string','','93');";


				//导入其他安装数据
				$data_file = INSTALL_PATH.'/data/install_data.txt';

				if(filesize($data_file) > 0)
				{
					$fp = fopen($data_file, 'r');
					while(!feof($fp))
					{
						$data_str .= trim(fgets($fp, 512*1024));
					}
					fclose($fp);
				}

				$querys = explode(';', ClearBOM($data_str));
				foreach($querys as $q)
				{
					if(trim($q) == '') continue;
					mysql_query(str_replace('#@__', $dbinfo['tablepre'], trim($q)).';');
				}

				echo '<script>$("#content_area").append("网站数据导入完成！<br />");</script>';


				//生成配置文件
				$fp = fopen('../include/config.cache.php', 'w');
				flock($fp, 3);
				fwrite($fp, '<?php	if(!defined(\'IN_PHPMYWIND\')) exit(\'Request Error!\');'."\r\n\r\n");

				$res = mysql_query("SELECT `varname`,`vartype`,`varvalue`,`vargroup` FROM `".$dbinfo['tablepre']."webconfig` ORDER BY orderid ASC");
				while($row = mysql_fetch_array($res))
				{
					//强制去掉 '
					//强制去掉最后一位 / 
					$vartmp = str_replace("'",'',$row['varvalue']);

					if(substr($vartmp, -1) == '\\')
					{
						$vartmp = substr($vartmp,1,-1);
					}

					if($row['vartype'] == 'number')
					{
						if($row['varvalue'] == '')
							$vartmp = 0;

						fwrite($fp, "\${$row['varname']} = ".$vartmp.";\r\n");
					}
					else
					{
						fwrite($fp, "\${$row['varname']} = '".$vartmp."';\r\n");
					}
				}
				fwrite($fp,'?>');
				fclose($fp);


				//查看是否需要安装测试数据
				if($admininfo['testdata'] == 'true')
				{
					echo '<script>$("#content_area").append("正在加载测试数据！<br />");</script>';

					$sqlstr_file = INSTALL_PATH.'/data/install_testdata.txt';
					if(filesize($sqlstr_file) > 0)
					{
						$fp = fopen($sqlstr_file, 'r');
						while(!feof($fp))
						{
							$line = trim(fgets($fp, 512*1024));
							if($line == '') continue;
							mysql_query(str_replace('#@__', $dbinfo['tablepre'], trim($line)));
						}
						fclose($fp);
					}
		
					echo '<script>$("#content_area").append("测试数据导入完成！");</script>';
				}

				//安装完成进行跳转
				echo '<script>location.href="?s='.md5('done').'";</script>';
			}
			else
			{
				echo '<script>$("#content_area").append("数据库连接错误，请检查！");</script>';
			}
		}

		break;

	case 15271: //检测数据库信息
		if(mysql_connect($_GET['dbhost'], $_GET['dbuser'], $_GET['dbpw']))
			echo 'true';
		else
			echo 'false';
		break;

	case md5('done'): //安装完成
		require(INSTALL_PATH.'/templates/step_4.html');
		$fp = fopen(INSTALL_PATH.'/../data/install_lock.txt', 'w');
		fwrite($fp, '程序已正确安装，重新安装请删除本文件');
		fclose($fp);
		break;

	default: //协议说明
		require(INSTALL_PATH.'/templates/step_0.html');
}


//测试可写性
function ck_iswrite($file)
{
	if(is_writable($file))
	{
		echo '<span class="install_true">可写</span>';
	}
	else
	{
		echo '<span class="install_false">不可写</span>';
		$GLOBALS['isnext'] = 'N';
	}
}


//测试函数是否存在
function funexists($func)
{
	if(function_exists($func))
	{
		echo '<span class="install_true">支持</span>';
	}
	else
	{
		echo '<span class="install_false">不支持</span>';
		$GLOBALS['isnext'] = 'N';
	}
}


//测试函数是否存在
function funadvice($func)
{
	if(function_exists($func))
	{
		echo '<span style="color:#999;">无</span>';
	}
	else
	{
		echo '<span style="color:red">建议安装</span>';
		$GLOBALS['isnext'] = 'N';
	}
}


//清除txt中的BOM
function ClearBOM($contents)
{
	$charset[1] = substr($contents, 0, 1);
	$charset[2] = substr($contents, 1, 1);
	$charset[3] = substr($contents, 2, 1);

	if(ord($charset[1])==239 &&
	   ord($charset[2])==187 &&
	   ord($charset[3])==191)
	{
		return substr($contents, 3);
	}
	else
	{
		return $contents;
	}
}


//产生随机字符串
function GetRandStr($length=6)
{
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$random_str = '';

	for($i=0; $i<$length; $i++)
	{
		$random_str .= $chars[mt_rand(0, strlen($chars) - 1)];
	}

	return $random_str;
}
?>