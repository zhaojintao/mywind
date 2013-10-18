/*
**************************
(C)2010-2013 phpMyWind.com
update: 2012-2-21 9:49:35
person: Feng
**************************
*/


$(function(){
	$(".infosrc").mousemove(function(){
		$(this).find("ul").show();
	}).mouseleave(function(){
		$(this).find("ul").hide();
	});
});


function GetSrcName(name)
{
	$("#source").val(name);
}