'use strict';var bt_initHeader;(function($){var hasCentralMenu,verticalMenuEnabled,belowMenu,btStickyEnabled
function initial_header_setup(){hasCentralMenu=$('body').hasClass('btMenuCenterEnabled');verticalMenuEnabled=$('body').hasClass('btMenuVerticalLeftEnabled')||$('body').hasClass('btMenuVerticalRightEnabled');belowMenu=$('body').hasClass('btBelowMenu');btStickyEnabled=$('body').hasClass('btStickyEnabled');if(typeof window.btStickyOffset=='undefined')window.btStickyOffset=250;if(typeof window.responsiveResolution=='undefined')window.responsiveResolution='1200';}
function final_header_setup(){$('li.btMenuWideDropdown').addClass(function(){return'btMenuWideDropdownCols-'+$(this).children('ul').children('li').length;});$('li.btMenuWideDropdown').each(function(){var maxChildItems=0;$(this).find('> ul > li > ul').each(function(index){if($(this).children().length>maxChildItems){maxChildItems=$(this).children().length;}});$(this).find('> ul > li > ul').each(function(index){var bt_menu_base_length=$(this).children().length;if(bt_menu_base_length<maxChildItems){for(var i=0;i<maxChildItems-bt_menu_base_length;i++){$(this).append('<li><a class="btEmptyElement">&nbsp;</a></li>');}}});});$('.btHorizontalMenuTrigger').on('click',function(){$('body').toggleClass('btShowMenu');return false;});$('.btVerticalMenuTrigger').on('click',function(){$('body').toggleClass('btMenuVerticalOn');return false;});}
function top_tools_search(){$('.mainHeader .btSearchInner').prependTo('body').addClass('btFromTopBox');$('.mainHeader .widget_search').addClass('btIconWidget');$('.mainHeader .btSearch, .btFromTopBox .btSearchInnerClose').on('click',function(){$('body').toggleClass('btTopToolsSearchOpen');return false;});}
function divide_menu(){if($('.btTextLogo').length){var logoWidth=$('.mainHeader .logo').width();}else{var logoWidth=$('.mainHeader .logo').height()*$('.mainHeader .logo .btMainLogo').data('hw');}
$('.menuPort nav').addClass('leftNav');$('.menuPort').append('<nav class="rightNav"><ul></ul></nav>');var halfItems=Math.ceil($('.menuPort nav.leftNav ul>li:not(li li)').length*.5);$('.menuPort nav.rightNav > ul').append($('.menuPort nav.leftNav > ul > li').slice(halfItems));$('.menuPort nav.leftNav > ul > li').slice(halfItems).remove();$('.mainHeader .logo').css('transform','translateX('+Math.round(-logoWidth*.5)+'px)');$('.mainHeader .logo').css('width',logoWidth+'px');$('.menuPort nav.leftNav').css('margin-right',Math.round(logoWidth*.5)+'px');$('.menuPort nav.rightNav').css('margin-left',Math.round(logoWidth*.5)+'px');}
function boldthemes_activate_sticky(){var fromTop=$(window).scrollTop();if(fromTop>window.btStickyOffset&&!$('body').hasClass('btStickyHeaderActive')){$('body').addClass('btStickyHeaderActive');boldthemes_requestTimeout(boldthemes_activate_sticky_open,500);}else if(fromTop<=window.btStickyOffset&&$('body').hasClass('btStickyHeaderActive')&&!$('body').hasClass('btStickyHeaderClosed')){$('body').addClass('btStickyHeaderClosed');boldthemes_requestTimeout(boldthemes_activate_sticky_close,500);}}
function boldthemes_activate_sticky_open(){$('body').addClass('btStickyHeaderOpen');}
function boldthemes_activate_sticky_close(){$('body').removeClass('btStickyHeaderActive btStickyHeaderOpen btStickyHeaderClosed');}
window.boldthemes_requestTimeout=function(fn,delay){if(!window.requestAnimationFrame&&!window.webkitRequestAnimationFrame&&!(window.mozRequestAnimationFrame&&window.mozCancelRequestAnimationFrame)&&!window.oRequestAnimationFrame&&!window.msRequestAnimationFrame)
return window.setTimeout(fn,delay);var start=new Date().getTime(),handle=new Object();function loop(){var current=new Date().getTime(),delta=current-start;delta>=delay?fn.call():handle.value=boldthemes_requestAnimFrame(loop);};handle.value=boldthemes_requestAnimFrame(loop);return handle;};window.boldthemes_requestAnimFrame=(function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(callback,element){window.setTimeout(callback,1000/60);};})();function responsive_menu_handler(){if(!verticalMenuEnabled){$(window).on("resize",function(event){if(window.innerWidth<window.responsiveResolution){$('body').addClass('btMenuVerticalLeft btMenuVertical').removeClass('btMenuHorizontal');}else{$('body').removeClass('btMenuVertical btMenuVerticalLeft btMenuVerticalOn').addClass('btMenuHorizontal');}
boldthemes_calculate_content_padding();});}}
function init_menu(){initial_header_setup();if(verticalMenuEnabled){if($('body').hasClass('btMenuVerticalLeftEnabled'))$('body').addClass('btMenuVerticalLeft btMenuVertical');if($('body').hasClass('btMenuVerticalRightEnabled'))$('body').addClass('btMenuVerticalRight btMenuVertical');}else{if($('body').hasClass('btMenuRightEnabled'))$('body').addClass('btMenuRight btMenuHorizontal');if($('body').hasClass('btMenuLeftEnabled'))$('body').addClass('btMenuLeft btMenuHorizontal');if($('body').hasClass('btMenuCenterBelowEnabled'))$('body').addClass('btMenuCenterBelow btMenuHorizontal');if($('body').hasClass('btMenuCenterEnabled'))$('body').addClass('btMenuCenter btMenuHorizontal');if(window.innerWidth<window.responsiveResolution){$('body').addClass('btMenuVerticalLeft btMenuVertical').removeClass('btMenuHorizontal');}else{$('body').removeClass('btMenuVertical btMenuVerticalLeft btMenuVerticalOn').addClass('btMenuHorizontal');}}
if(!belowMenu){boldthemes_calculate_content_padding();}
setTimeout(function(){$('body').addClass('btMenuInitFinished');},100);if(btStickyEnabled){setTimeout(function(){$(window).scroll(function(){boldthemes_activate_sticky();});},1000);}
if(hasCentralMenu)divide_menu();$('.menuPort ul ul').parent().prepend('<div class="subToggler"></div>');$('.menuPort ul li').on('mouseenter mouseleave',function(e){if($('body').hasClass('btMenuVertical')||$('html').hasClass('touch')){return false;}
e.preventDefault();$(this).siblings().removeClass('on');$(this).toggleClass('on');});$('div.subToggler').on('click',function(e){var parent=$(this).parent();parent.siblings().removeClass('on');parent.toggleClass('on');if($('body').hasClass('btMenuVertical')){parent.find('ul').first().slideToggle(200);}
return false;});final_header_setup();}
function boldthemes_calculate_content_padding(){if(!belowMenu){if($(window).width()<window.responsiveResolution||verticalMenuEnabled){$('.btContentWrap').css('padding-top',$('.btVerticalHeaderTop').height()+'px');}else if(!$('body').hasClass('btStickyHeaderActive')){$('.btContentWrap').css('padding-top',$('.mainHeader').height()+'px');}}}
function reinit_menu(){top_tools_search();setTimeout(function(){init_menu();},100);boldthemes_calculate_content_padding();}
$(window).on("load",function(){boldthemes_calculate_content_padding();});bt_initHeader=reinit_menu;top_tools_search();init_menu();responsive_menu_handler();})(jQuery);;'use strict';var bt_initTheme;window.onunload=function(){};window.addEventListener("pageshow",function(evt){if(evt.persisted){setTimeout(function(){window.location.reload();},10);}},false);function bt_refresh_cart(){jQuery('.btCartWidgetIcon').unbind('click').on('click',function(e){jQuery(this).parent().parent().toggleClass('on');jQuery('body').toggleClass('btCartDropdownOn');});jQuery('.verticalMenuCartToggler').unbind('click').on('click',function(){jQuery(this).closest('.widget_shopping_cart_content').removeClass('on');jQuery('body').removeClass('.btCartDropdownOn');});}
(function($){function initFancySelect(){if(typeof $.fn.fancySelect==='function'){$('.no-touch .btSidebar select, .no-touch select.orderby, .no-touch #btSettingsPanelContent select, .no-touch .wpcf7-form select:not([multiple])').fancySelect().on('change.fs',function(){$(this).trigger('change.$');});}}
function loadInitActions(){if(!$('body').hasClass("btRemovePreloader")){$('body').addClass('btRemovePreloader');}
setTimeout(function(){$(window).trigger('btload');window.boldthemes_loaded=true;},500);$(window).trigger('resize');}
function initFooter(){$('#boldSiteFooterWidgetsRow').attr('data-width',$('#boldSiteFooterWidgetsRow').children().length).children().addClass('bt_bb_column');}
function initModernizrAndDetectBrowser(){btModernizr.load([{test:window.matchMedia}]);var doc=document.documentElement;doc.setAttribute('data-useragent',navigator.userAgent);if(!String.prototype.startsWith){String.prototype.startsWith=function(searchString,position){position=position||0;return this.lastIndexOf(searchString,position)===position;};}
if(!String.prototype.endsWith){String.prototype.endsWith=function(searchString,position){var subjectString=this.toString();if(position===undefined||position>subjectString.length){position=subjectString.length;}
position-=searchString.length;var lastIndex=subjectString.indexOf(searchString,position);return lastIndex!==-1&&lastIndex===position;};}}
function initPreloader(){$('body.bodyPreloader .mainHeader .menu').unbind('click').on('click','a',function(){var href=$(this).attr('href');if(href!==undefined&&!href.startsWith('#')&&!href.startsWith('mailto')&&!href.startsWith('callto')&&!$(this).hasClass('lightbox')&&!$(this).hasClass('add_to_cart_button')&&$(this).attr('target')!='_blank'){$('body').removeClass('btRemovePreloader');setTimeout(function(){window.location=href},750);return false;}});}
function initRefreshCart(){$('.cart-contents').each(function(){bt_refresh_cart();});}
function initTheme(){initFancySelect();initFooter();initModernizrAndDetectBrowser();initPreloader();initRefreshCart();loadInitActions();}
$(window).load(function(){loadInitActions();});$(document).ready(function(){initRefreshCart();});initFancySelect();initFooter();initModernizrAndDetectBrowser();initPreloader();bt_initTheme=initTheme;})(jQuery);
;!function(a,b){"use strict";function c(){if(!e){e=!0;var a,c,d,f,g=-1!==navigator.appVersion.indexOf("MSIE 10"),h=!!navigator.userAgent.match(/Trident.*rv:11\./),i=b.querySelectorAll("iframe.wp-embedded-content");for(c=0;c<i.length;c++){if(d=i[c],!d.getAttribute("data-secret"))f=Math.random().toString(36).substr(2,10),d.src+="#?secret="+f,d.setAttribute("data-secret",f);if(g||h)a=d.cloneNode(!0),a.removeAttribute("security"),d.parentNode.replaceChild(a,d)}}}var d=!1,e=!1;if(b.querySelector)if(a.addEventListener)d=!0;if(a.wp=a.wp||{},!a.wp.receiveEmbedMessage)if(a.wp.receiveEmbedMessage=function(c){var d=c.data;if(d)if(d.secret||d.message||d.value)if(!/[^a-zA-Z0-9]/.test(d.secret)){var e,f,g,h,i,j=b.querySelectorAll('iframe[data-secret="'+d.secret+'"]'),k=b.querySelectorAll('blockquote[data-secret="'+d.secret+'"]');for(e=0;e<k.length;e++)k[e].style.display="none";for(e=0;e<j.length;e++)if(f=j[e],c.source===f.contentWindow){if(f.removeAttribute("style"),"height"===d.message){if(g=parseInt(d.value,10),g>1e3)g=1e3;else if(~~g<200)g=200;f.height=g}if("link"===d.message)if(h=b.createElement("a"),i=b.createElement("a"),h.href=f.getAttribute("src"),i.href=d.value,i.host===h.host)if(b.activeElement===f)a.top.location.href=d.value}else;}},d)a.addEventListener("message",a.wp.receiveEmbedMessage,!1),b.addEventListener("DOMContentLoaded",c,!1),a.addEventListener("load",c,!1)}(window,document);
;(function($){"use strict";function bt_bb_video_background(){$('.bt_bb_section.video').each(function(){var video=$(this).find('video');var w=$(this).outerWidth();var h=$(this).outerHeight();if(w/h>16/9){video.css('width','105%');video.css('height','');}else{video.css('width','');video.css('height','105%');}});}
window.bt_bb_video_callback=function(v){$(v).parent().addClass('video_on');}
$(document).ready(function(){bt_bb_video_background();});$(window).on('resize',function(e){bt_bb_video_background();});$('a[href*="#"]:not([href="#"])').not('.menu-scroll-down').on('click',function(){if(location.pathname.replace(/^\//,'')==this.pathname.replace(/^\//,'')&&location.hostname==this.hostname){var target=$(this.hash);target=target.length?target:$('[name='+this.hash.slice(1)+']');if(target.length){$('html, body').animate({scrollTop:target.offset().top},1000);return false;}}});})(jQuery);