$(function(){$(".scroll-top").hide();$(window).scroll(function(){if($(this).scrollTop()>100){$(".scroll-top").fadeIn()}else{$(".scroll-top").fadeOut()}});$(".scroll-top a").click(function(){$("body,html").animate({scrollTop:0},500);return false})});$(function(){$("#myTab a").click(function(e){e.preventDefault();$(this).tab("show")});$("#myTab1 a").click(function(e){e.preventDefault();$(this).tab("show")});$("#myTab2 a").click(function(e){e.preventDefault();$(this).tab("show")});$("#chat-tab a").click(function(e){e.preventDefault();$(this).tab("show")});$(".left-primary-nav li a").tooltip({placement:"right"});$(".row-action .btn").tooltip({placement:"top"})});$(function(){$(".top-right-toolbar a").tooltip({placement:"top"})});$(function(){window.prettyPrint&&prettyPrint()});$(function(){$(".responsive-leftbar").click(function(){$(".leftbar").toggleClass("leftbar-close expand",500,"easeOutExpo")})});$(function(){$(".theme-setting").click(function(){$(".theme-slector").toggleClass("theme-slector-close theme-slector-open",500,"easeOutExpo")})});$(function(){$(".theme-color").click(function(){var e=$(this).attr("title").toLowerCase();$("#themes").attr("href","css"+"/"+e+".css")})});$(function(){$(".theme-default").click(function(){$("#themes").removeAttr("href")})})