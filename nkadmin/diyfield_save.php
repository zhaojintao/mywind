<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('diyfield');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-7-23 14:34:17
person: Feng
**************************
*/


//初始化参数
$tbname   = '#@__diyfield';
$gourl    = 'diyfield.php';
$action   = isset($action) ? $action : '';
$infotype = isset($infotype) ? $infotype : '';


//获取操作表
switch($infotype)
{
	case 0:
	$tbnames = '#@__info';
	break;
	case 1:
	$tbnames = '#@__infolist';
	break;
	case 2:
	$tbnames = '#@__infoimg';
	break;
	case 3:
	$tbnames = '#@__soft';
	break;
	case 4:
	$tbnames = '#@__goods';
	break;
	default:
	ShowMsg("获取表名失败！");
	header("location:$gourl");
	exit();
}


//添加自定义字段
if($action == 'add')
{
	$r = $dosql->GetOne("SELECT id FROM `#@__diyfield` WHERE fieldname='$fieldname' AND infotype='$infotype'");
	if(!empty($r['id']))
	{
		ShowMsg("该字段名称已经存在！");
		exit();
	}

	//此类需要指定类型
	if($fieldtype == 'radio' or $fieldtype == 'checkbox' or $fieldtype == 'select' or $fieldtype == 'file')
	{
		$fieldtype2 = 'varchar';
	}
	else if($fieldtype == 'fileall')
	{
		$fieldtype2 = 'text';
	}
	else if($fieldtype == 'datetime')
	{
		$fieldtype2 = 'int';
		$fieldlong  = 10;
	}
	
	if(empty($fieldtype2))
	{
		$fieldtype2 = $fieldtype;
	}


	//开始组装SQL
	$sql = "ALTER TABLE `$tbnames` ADD `$fieldname` $fieldtype2";

	//此类型不需指定长度
	if($fieldtype2 != 'text' && $fieldtype2 != 'mediumtext')
	{
		$sql .= "($fieldlong)";
	}
	
	$sql .= " NOT NULL";


	//为变量长度添加括号
	if($dosql->ExecNoneQuery($sql))
	{
		$sql = "INSERT INTO `$tbname` (infotype, fieldname, fieldtitle, fielddesc, fieldtype, fieldlong, fieldsel, fieldcheck, fieldcback, orderid, checkinfo) VALUES ('$infotype', '$fieldname', '$fieldtitle', '$fielddesc', '$fieldtype', '$fieldlong', '$fieldsel', '$fieldcheck', '$fieldcback', '$orderid', '$checkinfo')";
		if($dosql->ExecNoneQuery($sql))
		{
			header("location:$gourl");
			exit();
		}
	}
	else
	{
		ShowMsg("字段插入失败！请检查类型，长度是否合法！");
		exit();
	}
}


//修改自定义字段
else if($action == 'update')
{
	if($fieldname_b != $fieldname)
	{
		$r = $dosql->GetOne("SELECT id FROM `#@__diyfield` WHERE fieldname='$fieldname' AND infotype='$infotype'");
		if(!empty($r['id']))
		{
			ShowMsg("该字段名称已经存在！");
			exit();
		}
	}


	//此类需要指定类型
	if($fieldtype == 'radio' or $fieldtype == 'checkbox' or $fieldtype == 'select' or $fieldtype == 'file')
	{
		$fieldtype2 = 'varchar';
	}
	else if($fieldtype == 'fileall')
	{
		$fieldtype2 = 'text';
	}
	else if($fieldtype == 'datetime')
	{
		$fieldtype2 = 'int';
		$fieldlong  = 10;
	}

	if(empty($fieldtype2))
	{
		$fieldtype2 = $fieldtype;
	}


	//开始组装SQL
	$sql = "ALTER TABLE `$tbnames` CHANGE `$fieldoldname` `$fieldname` $fieldtype2";

	if($fieldtype2 != 'text' && $fieldtype2 != 'mediumtext')
	{
		$sql .= "($fieldlong)";
	}

	if($fieldtype2 == 'varchar' || $fieldtype2 == 'text' || $fieldtype2 == 'mediumtext')
	{
		$sql .= " CHARACTER SET utf8 COLLATE utf8_general_ci";
	}

	$sql .= " NOT NULL";


	if($dosql->ExecNoneQuery($sql))
	{
		$sql = "UPDATE `$tbname` SET infotype='$infotype', fieldname='$fieldname', fieldtitle='$fieldtitle', fielddesc='$fielddesc', fieldtype='$fieldtype', fieldlong='$fieldlong', fieldsel='$fieldsel', fieldcheck='$fieldcheck', fieldcback='$fieldcback', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";

		if($dosql->ExecNoneQuery($sql))
		{
			header("location:$gourl");
			exit();
		}
	}
	else
	{
		ShowMsg("字段插入失败！请检查类型，长度是否合法！");
		exit();
	}
}


//自定义字段状态
else if($action == 'check')
{
	if($checkinfo == 'true')
	{
		$sql = "UPDATE `$tbname` SET checkinfo='false' WHERE id=$id";
	}
	else if($checkinfo == 'false')
	{
		$sql = "UPDATE `$tbname` SET checkinfo='true' WHERE id=$id";
	}

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//删除单条自定义字段
else if($action == 'del')
{
	$dosql->ExecNoneQuery("ALTER TABLE `$tbnames` DROP `$fieldname`");
	$dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE id=$id");
	header("location:$gourl");
	exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>