<div class="header">
	<h1 class="logo"><a href="javascript:;"></a></h1>
	<div class="txt">
	<a href="./index.php">返回首页</a>&nbsp;&nbsp;&nbsp;<span>|</span>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://mail.nkhf.com.cn">企业邮箱</a></div>
	<div class="tel"><?php echo $cfg_hotline; ?></div>
</div>
<div class="navArea">
	<div class="navBg">
		<ul class="nav">
			<?php echo GetNav(); ?>
		</ul>
	</div>
</div>
<script type="text/javascript">

$(function(){

	/*当前页面导航高亮*/
	var href = window.location.href.split('/')[window.location.href.split('/').length-1].substr(0,4);
	var pid = $('#input_pid').val();
	var cid = $('#input_cid').val();
	if(href.length > 0){
		$(function(){
			$("ul.nav a:first[cid='"+pid+"']").attr("class","on");
			$("ul.nav_sub a:first[cid='"+cid+"']").attr("class","on");
			if($("ul.nav a:first[cid='"+pid+"']").size() == 0){
				$("ul.nav a:first[cid='"+cid+"']").attr("class","on");
			}
		});
	}else{
		$(function(){$("ul.nav a:first[href^='index']").attr("class","on")});
	}

	/*下拉菜单*/
	$(".nav li").hover(function(){
		$(this).parents(".nav > li").find("a:first").addClass("on2");
		$(this).find("ul:first").show(); //鼠标滑过查找li下面的第一个ul显示
	},function(){
		var navobj = $(this).find("ul:first");
		navobj.hide();

		//鼠标离开隐藏li下面的ul
		if(navobj.attr("class") == "nav_sub")
		{
			$(this).find("a:first").removeClass("on2");
		}
	})

	//给li下面ul是s的样式的前一个同辈元素添加css
	$(".nav li ul li ul").prev().addClass("t");
})


//加入收藏
function AddFavorite(){
	if(document.all){
		try{
			window.external.addFavorite(window.location.href,document.title);
		}catch(e){
			alert("加入收藏失败，请使用Ctrl+D进行添加！");
		}
	}else if(window.sidebar){
		window.sidebar.addPanel(document.title, window.location.href, "");
	}else{
		alert("加入收藏失败，请使用Ctrl+D进行添加！");
	}
}
</script>