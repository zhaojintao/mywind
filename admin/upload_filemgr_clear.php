<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('upload_filemgr_sql'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传文件管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">上传文件管理</span> <span class="header_text">[<a href="upload_filemgr_sql.php" class="topdir">返回数据模式</a>]</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="">
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="center">
			<td width="5%" height="30"><input type="checkbox" name="checkid[]" id="checkid[]" onclick="CheckAll(this.checked);" /></td>
			<td width="20%">文件名称</td>
			<td width="15%">文件类型</td>
			<td width="15%">上传日期</td>
			<td width="15%">文件大小</td>
			<td width="15%">使用状态</td>
			<td width="15%">操作</td>
		</tr>
		<?php

		$tb_array = array(
			'admanage'   => array('picurl'),
			'goods'      => array('picurl', 'content', 'picarr'),
			'goodsbrand' => array('picurl'),
			'goodstype'  => array('picurl'),
			'info'       => array('picurl', 'content'),
			'infoclass'  => array('picurl'),
			'infoimg'    => array('picurl', 'content', 'picarr'),
			'infolist'   => array('picurl', 'content', 'picarr'),
			'job'        => array('content'),
			'soft'       => array('picurl', 'content', 'picarr'),
			'message'    => array('content'),
			'nav'        => array('picurl'),
			'weblink'    => array('picurl')
		);


		//初始化参数		
		$fl_str = '';
		$img_ext   = $cfg_upload_img_type;
		$a_ext     = $cfg_upload_soft_type;
		$embed_ext = $cfg_upload_media_type;


		//取出所有存储图片路径
		//循环所有表
		foreach($tb_array as $k=>$tbname)
		{

			//循环表包含图片的字段
			foreach($tbname as $field)
			{

				//取出字段内容
				$dosql->Execute("SELECT `$field` FROM `#@__$k`");
				while($row = $dosql->GetArray())
				{
					
					//如果是内容字段，匹配字符串
					if($field == 'content')
					{
						preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:['.$img_ext.']))[\'|\"].*?[\/]?>/', $row[$field], $match);
						if(!empty($match[1]) && is_array($match[1]))
						{
							foreach($match[1] as $path)
							{
								$fl_str .= $path.',';
							}
						}

						preg_match_all('/<[a|A].*?href=[\'|\"](.*?(?:['.$a_ext.']))[\'|\"].*?[\/]?>/', $row[$field], $match);
						if(!empty($match[1]) && is_array($match[1]))
						{
							foreach($match[1] as $path)
							{
								$fl_str .= $path.',';
							}
						}
						
						preg_match_all('/<[embed|EMBED].*?src=[\'|\"](.*?(?:['.$embed_ext.']))[\'|\"].*?[\/]?>/', $row[$field], $match);
						if(!empty($match[1]) && is_array($match[1]))
						{
							foreach($match[1] as $path)
							{
								$fl_str .= $path.',';
							}
						}
					}
					
					//组图、缩略图直接连接
					else
					{
						$fl_str .= $row[$field].',';
					}

				}
			}
		}


		//查询上传文件记录
		$dosql->Execute("SELECT * FROM `#@__uploads` ORDER BY `id` DESC");
		$i = 0;
		while($row = $dosql->GetArray())
		{

			//对比是否在已用字符串中出现
			if(!strpos($fl_str,$row['path']))
			{
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['path']; ?>" /></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['type']; ?></td>
			<td class="number"><span><?php echo GetDateTime($row['posttime']); ?></span></td>
			<td><?php echo GetRealSize($row['size']); ?></td>
			<td>未使用</td>
			<td class="action"><span>[<a href="../<?php echo $row['path']; ?>" target="_blank">预览</a>]</span><span>[<a href="upload_filemgr_save.php?mode=sql&action=del&id=<?php echo $row['id']; ?>&path=<?php echo $row['path']; ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
				$i++;
			}
		}

		$fl_str = '';
		?>
	</table>
</form>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有上传的文件</div>';
}
else if($i == 0)
{
	echo '<div class="mgr_nlist">暂时没有可清理的文件</div>';
}
?>
<div class="mgr_divb"> <span class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('upload_filemgr_save.php','&mode=sql');" onclick="return ConfDelAll(0);">删除</a></span></div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $i; ?></span>条记录</div>
</div>
</body>
</html>