/*
**************************
(C)2010-2013 phpMyWind.com
update: 2013-5-12 8:18:34
person: Feng
**************************
*/

$(function(){
	//document.getElementById('quick').style.display = 'none';//隐藏 
	//快捷菜单
	bindQuickMenu();

	//左侧菜单开关
	LeftMenuToggle();
	
	//锁屏按钮
	bindLockScreen();

}).keydown(function(event){

	//快捷键
	if(event.keyCode == 27){
		location.href = 'logout.php';
	}
});


//快捷菜单
function bindQuickMenu(){
	$(".quick").bind("mouseover",function(){
		$(".quick .btn").html("系统首页").addClass("on");
		$(".quick #qucikmenu").fadeIn(200);
	}).bind("mouseout",function(){
		hidequcikmenu = setTimeout('$(".quick #qucikmenu").fadeOut(200);$(".quick .btn").html("快捷导航").removeClass("on");',100);
		$(this).bind("mouseover",function(){clearTimeout(hidequcikmenu);});
	}).find("a").click(function(){
		$(this).blur();
		$(".quick #qucikmenu").fadeOut(200);
	});
}


//左侧菜单开关
function LeftMenuToggle()
{
	$(".togglemenu").click(function(){
		if($(this).attr("title") == "隐藏菜单"){
			$(".left").animate({width:"0px"},300,function(){$(this).hide()});
			$(".right").animate({left:"0px"},300);
			$(this).attr("title","显示菜单");
			$("body").attr("class","hidemenu");
		}
		else{
			$(".left").show().animate({width:"207px"},300);
			$(".right").animate({left:"207px"},300);
			$(this).attr("title","隐藏菜单");
			$("body").attr("class","showmenu");
		}
	});
}


//锁屏函数
function bindLockScreen(){
	$(".lockscreen").bind("click",function(){
		$("body").append("<div id=\"lockscreen_bg\"> </div><div id=\"lockscreen_win\"><div id=\"lockscreen_pwd\"><label>密码：</label><input type=\"password\" id=\"password\" /><input id=\"lockscreen_btn\" type=\"image\" src=\"templates/images/lockscreen_enter.png\" onclick=\"CheckPwd()\" /><div id=\"lockscreen_note\"></div></div></div><div id=\"lockscreen_copy\">© 2013 phpMyWind.com</div>")
		$("#lockscreen_bg, #lockscreen_win, #lockscreen_copy").show();
		$.get("lockscreen_do.php",{action:"lock"});
	});
}


//锁屏密码检测
function CheckPwd()
{
	if($("#password").val() == ''){
		$("#lockscreen_note").html("请输入解锁密码！");
		setTimeout('$("#lockscreen_note").html("")',5000);
	}else{
		$.get("lockscreen_do.php",{action:"check",password:$("#password").val()},function(data){
			if(data == true){
				$("#lockscreen_bg, #lockscreen_win, #lockscreen_copy").remove();
			}else{
				$("#lockscreen_note").html("密码错误，请重新输入！");
				setTimeout('$("#lockscreen_note").html("")',5000);
			}
		});
	}
}


//站点选择样式
function SelSite(sitekey)
{
	$.get("lockscreen_do.php?action=selsite&sitekeyvalue="+sitekey,function(data){
		if(data == 1){
			window.top.main.location.reload();
		}else if(data == 2){
			window.top.menu.location.reload();
			window.top.main.location.reload();
		}
	});

	$(".sitelist a").attr("class","");
	$("#"+sitekey).attr("class","on");
}