jQuery(document).ready(function() {
	'use strict';
	rockthemes_extend_modernizr();
	var spfx = '';
	switch (BrowserDetect.browser) {
		case 'Chrome':
			spfx = '-webkit-';
			break;
		case 'Explorer':
			spfx = '-ms-';
			break;
		case 'Firefox':
			spfx = '-moz-';
			break;
		case 'Safari':
			spfx = '-webkit-';
			break;
		case 'Opera':
			spfx = '-o-';
			break;
	}
	if (spfx != '') {
		rockthemes.frontend_options.style_prefix = spfx;
	}
	if (Modernizr.ismobile) {
		jQuery('html').addClass('disable-transition');
	}
	if (rockthemes.frontend_options.activate_smooth_scroll === 'true') {
		if (!(/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) && !(navigator.userAgent.match(/msie|trident/i))) {
			var rockthemes_nice_s_object = {
				cursorcolor: typeof rockthemes.colors !== 'undefined' && rockthemes.colors ? rockthemes.colors.main_color : "#0c78bd",
				cursorwidth: "14px",
				cursorborder: "none",
				cursorborderradius: "4px",
				zindex: "999999",
				bouncescroll: "true",
				cursoropacitymin: "0.3",
				background: "rgba(0,0,0,0.3)",
				horizrailenabled: (rockthemes.resposivity === 'false') ? true : false
			};
			rockthemes_nice_s_object.scrollspeed = 98;
			rockthemes_nice_s_object.mousescrollstep = 48;
			if (rockthemes.frontend_options.nicescroll_style_enabled !== 'yes') {
				jQuery('html').addClass('nicescroll-style-disabled');
				rockthemes_nice_s_object.autohidemode = 'hidden';
			}
			var rockthemes_nice_s = jQuery('html').niceScroll(rockthemes_nice_s_object);
			rockthemes.elements = new Object();
			rockthemes.elements.nice_scroll = rockthemes_nice_s;
			jQuery(document).on('rockthemes:nicescroll_enable', function() {
				rockthemes_nice_s.show();
			});
			jQuery(document).on('rockthemes:nicescroll_disable', function() {
				jQuery('html').css('transform', '');
				rockthemes_nice_s.stop();
				rockthemes_nice_s.hide();
			});
		}
	}
	rockthemes_scroll_events();
	if (typeof rockthemes.settings == "undefined") {
		rockthemes.settings = new Object();
	}
	rockthemes.settings.undermenu_box_classes = ['woocommerce-cart-active', 'search-box-active'];
	if (typeof rockthemes.init_queue == 'undefined') {
		rockthemes.init_queue = new Object();
		rockthemes.init_queue.fullscreen_bg_videos = new Array();
	}
	rockthemes_fullscreen_elements();
	jQuery(window).smartresize(rockthemes_fullscreen_elements);
	if (jQuery('.rockthemes-before-header.intro-effect-slide').children().length && (jQuery(window).width() >= 768 || jQuery(window).height() >= 768)) {
		var eh = jQuery('.rockthemes-before-header.intro-effect-slide').height();
		if (eh < 667) eh = 667;
		jQuery('.rockthemes-before-header.intro-effect-slide').css('height', eh + 'px');
	} else {
		jQuery('.rockthemes-before-header.intro-effect-slide').removeClass('intro-effect-slide');
	}
	rockthemes_multi_bg_colors();
	jQuery(window).smartresize(function() {
		setTimeout(rockthemes_multi_bg_colors, 180);
	});
	jQuery('.disable-link').click(function(e) {
		e.preventDefault();
	});
	//rocktheme_wrap_iframe_videos();
	rockthemes_mobile_menu();
	rockthemes_menu_ajax_search();
	rockthemes_woocommerce_elements_init();
	rockthemes_menu_ajax_woocommerce_cart();
	rockthemes_check_bg_videos();
	rockthemes_responsive_flash();
	rockthemes_activate_hover();
	rockthemes_activate_load_more();
	rockthemes_activate_cat_filter_ajax();
	rockthemes_activate_elements_js();
	rockthemes_activate_down_arrows();
	rockthemes_activate_animations();
	rockthemes_activate_loader_motion();
	jQuery(document).on('rockthemes:all_fonts_loaded', function() {
		jQuery('body').css('visibility', 'visible');
		var hmf_elements = ['.sticky-header-wrapper', '.main-header-area', '.header-top-2', '.azoom-title-breadcrumbs'];
		for (var i = 0; i < hmf_elements.length; i++) {
			if (jQuery(hmf_elements[i] + '.not-visible').length) {
				jQuery(hmf_elements[i] + '.not-visible').removeClass('not-visible');
			}
		}
		jQuery(document).trigger('rockthemes:mega_menu_resize');
	});
	if (rockthemes.fonts.activate_font_loading === 'true') {
		if (jQuery('html').hasClass('rockthemes_fonts_loaded')) {
			jQuery(document).trigger('rockthemes:all_fonts_loaded');
		} else {
			var font_max_try = 10,
				font_current_try = 0,
				font_int = setInterval(function() {
					if (jQuery('html').hasClass('rockthemes_fonts_loaded') || font_current_try >= font_max_try) {
						jQuery(document).trigger('rockthemes:all_fonts_loaded');
						clearInterval(font_int);
					}
					font_current_try++;
				}, 500);
		}
	} else {
		jQuery(document).trigger('rockthemes:all_fonts_loaded');
	}
});

function rockthemes_activate_loader_motion() {
	var loader_classes = ['.woocommerce-loader', '.load-more-button-loader', '.ajax-category-navigation-loader', '.azoom-search-loader'];
	var use_gif = false;
	if (jQuery('html').hasClass('ie9')) {
		use_gif = true;
	}
	if (use_gif) {
		if (jQuery('.rockthemes-css-loader').length) {
			jQuery('.rockthemes-css-loader > div > div').remove();
			jQuery('.rockthemes-css-loader .gif-loader').removeClass('hidden');
			jQuery('.rockthemes-css-loader').removeClass('rockthemes-css-loader');
		}
		if (jQuery('.azoom-search-loader').length) {
			jQuery('.azoom-search-loader').after(rockthemes.gif_loader);
		}
		for (var i = 0; i < loader_classes.length; i++) {
			if (jQuery(loader_classes[i]).length) {
				jQuery(loader_classes[i]).remove();
			}
		}
	} else {
		if (jQuery('.rockthemes-css-loader .gif-loader').length) {
			jQuery('.rockthemes-css-loader .gif-loader').remove();
		}
	}
}

function rockthemes_scroll_events() {
	if (typeof rockthemes.events == 'undefined') {
		rockthemes.events = new Object();
	}
	rockthemes.events.scroll_keys = [37, 38, 39, 40];
	var don_wheel = window.onwheel;
	jQuery(document).on('rockthemes:scroll_events_enable', function() {
		window.onwheel = don_wheel;
		if (rockthemes.frontend_options.activate_smooth_scroll === 'true') {
			jQuery(document).trigger('rockthemes:nicescroll_enable');
		}
		jQuery(document).off('wheel DOMMouseScroll onmousewheel', wheel);
		jQuery(window).off('onmousewheel onwheel', wheel);
		document.onkeydown = null;
	});
	jQuery(document).on('rockthemes:scroll_events_disable', function() {
		if (rockthemes.frontend_options.activate_smooth_scroll === 'true') {
			jQuery(document).trigger('rockthemes:nicescroll_disable');
		}
		jQuery(document).on('wheel DOMMouseScroll onmousewheel', wheel);
		jQuery(window).on('onmousewheel onwheel', wheel);
		document.onkeydown = keydown;
	});

	function rockthemes_preventDefault(e) {
		e = e || window.event;
		if (e.preventDefault) e.preventDefault();
		if (e.stopImmediatePropagation) e.stopImmediatePropagation();
		e.returnValue = false;
		return false;
	}

	function keydown(e) {
		for (var i = rockthemes.events.scroll_keys.length; i--;) {
			if (e.keyCode === rockthemes.events.scroll_keys[i]) {
				rockthemes_preventDefault(e);
				return;
			}
		}
	}

	function wheel(e) {
		rockthemes_preventDefault(e);
	}
}

function rockthemes_activate_animations() {
	if (!jQuery('.rockthemes-animate').length) return;
	if (Modernizr.ismobile || !Modernizr.cssanimations) {
		jQuery('.rockthemes-animate').removeClass('rockthemes-animate');
		return;
	}
	var ended_events = 'animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd';
	jQuery('.rockthemes-animate').each(function() {
		var that = jQuery(this);
		that.appear();
		that.on('appear', function() {
			that.off('appear');
			that.appearOff();
			setTimeout(function() {
				if (that.find('img').length) {
					that.imagesLoaded(function() {
						setTimeout(function() {
							activate_animate_animation(that, ended_events);
						}, 180);
					});
				} else {
					activate_animate_animation(that, ended_events);
				}
			}, parseInt(that.attr('data-animation-delay-time')));
		});
	});
}

function activate_animate_animation(that, ended_events) {
	that.addClass(that.attr('data-animation-class') + ' animated');
	if (that.find(".rockthemes-list").length) {
		rockthemes_ea_list(that, that.attr('data-animation-class') + ' animated');
	}
	that.on(ended_events, function() {
		that.removeClass('rockthemes-animate ' + that.attr('data-animation-class') + ' animated');
		that.off(ended_events);
	});
}

function rockthemes_ea_list(el, anim) {
	el.find("li").css("opacity", "0");
	var latest_i = 0;
	list_element.find(" ul > li").each(function(i) {
		var that = jQuery(this);
		setTimeout(function() {
			that.addClass(anim);
		}, 300 * i);
		latest_i = i;
	});
}

function rockthemes_woocommerce_elements_init() {
	jQuery(document).on("click", ".woocommerce-review-link", function() {
		var tab_id = jQuery(this).attr('href');
		var content = jQuery(tab_id + '.rock-tab-header')
		if (typeof content == 'undefined' || content.length < 1) return;
		content.trigger('click');
	});
}

/*function rocktheme_wrap_iframe_videos() {
	var elems = ['iframe', 'embed', 'video', '.video-player'];
	for (var i = 0; i < elems.length; i++) {
		jQuery(elems[i]).each(function() {;
			var that = jQuery(this);
			if (that.parent().is('body')) {
				return;
			}
			if (!that.parents('.azoom-iframe-container').length && !that.parent().hasClass('rockthemes-background-video')) {
				that.wrap('<div class="azoom-iframe-container"></div>');
			}
		});
	}
}*/

function rockthemes_extend_modernizr() {
	if (Modernizr) {
		Modernizr.addTest('ipad', function() {
			return !!navigator.userAgent.match(/iPad/i);
		});
		Modernizr.addTest('iphone', function() {
			return !!navigator.userAgent.match(/iPhone/i);
		});
		Modernizr.addTest('ipod', function() {
			return !!navigator.userAgent.match(/iPod/i);
		});
		Modernizr.addTest('appleios', function() {
			return (Modernizr.ipad || Modernizr.ipod || Modernizr.iphone);
		});
		Modernizr.addTest('android', function() {
			return !!navigator.userAgent.match(/Android/i);
		});
		Modernizr.addTest('iemobile', function() {
			return !!navigator.userAgent.match(/IEMobile/i);
		});
		Modernizr.addTest('ismobile', function() {
			return (Modernizr.ipad || Modernizr.ipod || Modernizr.iphone || Modernizr.android || Modernizr.iemobile);
		});
	}
}

function rockthemes_activate_elements_js() {
	if (jQuery('.rock-toggles-container').length) {
		rockthemes_ae_toggles();
	}
	if (jQuery('.rock-tabs-container').length) {
		rockthemes_ae_tabs();
	}
	if (jQuery('.rock-achievement').length) {
		rockthemes_ae_achievement();
	}
	if (jQuery('.rock-iconictext-container').length) {
		rockthemes_ae_iconictext();
	}
	if (jQuery('.button[data-button-js-colors="true"]').length) {
		rockthemes_ae_buttons();
	}
	if (jQuery('.azoom-steps').length) {
		rockthemes_ae_steps();
	}
	if (jQuery('.azoom-skill').length) {
		rockthemes_ae_skills();
	}
	if (jQuery('.azoom-love-icon').length) {
		rockthemes_ae_love_icon();
	}
	if (jQuery('.rock-references-builder').length) {
		rockthemes_ae_references();
	}
	if (jQuery('.alert-box').length) {
		rockthemes_ae_alertbox();
	}
	if (jQuery('.azoom-team-members').length) {
		rockthemes_ae_teammembers();
	}
	if (jQuery('.azoom-single-image').length) {
		rockthemes_ae_singleimage();
	}
}

function rockthemes_ae_singleimage() {
	if (jQuery('.azoom-overflow-image').length) {
		rockthemes_overflow_image();
		jQuery(window).smartresize(rockthemes_overflow_image);
	}
	if (jQuery('.azoom-snap-image').length) {
		rockthemes_snap_image();
		jQuery(window).smartresize(rockthemes_snap_image);
	}
}

function rockthemes_overflow_image() {
	jQuery('.azoom-overflow-image').each(function() {
		if (jQuery(window).width() <= 800) {
			jQuery(this).css({
				'bottom': ''
			});
			return;
		}
		jQuery(this).parents('.columns').css({
			'min-height': '10px'
		});
		var image = jQuery(this),
			sg = jQuery(this).parents('.rockthemes-unique-grid'),
			vs = typeof sg !== 'undefined' ? sg.hasClass('rsb-vertical-space') : false,
			df = parseInt(image.attr('data-overflow')),
			th = image.parents('.row').outerHeight(true) + df - image.parents('.columns').outerHeight();
		if (vs && !image.parents('.row').hasClass('rsb-vertical-space')) {
			th += 105;
		} else if (vs) {
			th -= 105;
		}
		image.css({
			'bottom': '-' + th + 'px'
		});
	});
}

function rockthemes_snap_image() {
	jQuery('.azoom-snap-image').each(function() {
		jQuery(this).css({
			'left': '',
			'right': ''
		});
		if (jQuery(window).width() <= 800) {
			return;
		}
		var image = jQuery(this),
			m = jQuery(this).parents('.main-container'),
			ds = image.attr('data-snap-image'),
			snap = 0,
			le = image.hasClass('azoom-overflow-image') ? parseInt(image.parent().css('padding-left')) : 0;
		switch (ds) {
			case 'left':
				snap = m.offset().left - image.offset().left + le;
				image.css({
					'left': snap + 'px'
				});
				break;
			case 'right':
				image.imagesLoaded(function() {
					snap = -((m.offset().left + m.width()) - (image.offset().left + image.width()) + le);
					image.css({
						'right': snap + 'px'
					});
				});
				break;
		}
	});
}

function rockthemes_ae_teammembers() {
	jQuery('.azoom-team-members').each(function() {
		var that = jQuery(this);
		that.find('.team-member-article').click(function(e) {
			e.preventDefault();
			var id = jQuery(this).parents('.azoom-team-members').attr('id');
			var no_slide = false;
			var content = jQuery(this).find('.member-details').clone();
			if (jQuery('.' + id).length) {
				no_slide = true;
				jQuery('.' + id).empty();
				jQuery('.' + id).append(jQuery('<div class="team-member-box-close">×</div>'));
				jQuery('.' + id).append(content);
			} else {
				var box = jQuery('<div class="team-member-box ' + id + '"><div class="team-member-box-close">×</div></div>');
				box.append(content);
				that.prepend(box);
				that.find('.team-member-box').slideDown();
			}
			var go_top = parseInt(jQuery('.' + id).offset().top) - 30;
			if (jQuery('.header-sticky-active').length) {
				go_top = go_top - parseInt(rockthemes.menu.sticky_height);
			}
			if (jQuery('#wpadminbar').length) {
				go_top = go_top - parseInt(jQuery('#wpadminbar').height());
			}
			jQuery('html, body').animate({
				scrollTop: go_top
			}, 1000);
			jQuery(document).on('click touchend', '.team-member-box-close', function() {
				var that_tm = jQuery(this).parents('.team-member-box');
				if (that_tm.length) {
					that_tm.slideUp(480, function() {
						if (that_tm.length) {
							that_tm.remove();
						}
					});
				}
			});
		});
	});
}

function rockthemes_ae_alertbox() {
	jQuery('.alert-box').each(function() {
		var that = jQuery(this);
		if (that.find('.alert-box-close').length) {
			that.on("click touchend", ".alert-box-close", function() {
				that.slideUp();
			});
		}
	});
}

function rockthemes_ae_references() {
	jQuery('.rock-references-builder').each(function() {
		var that = jQuery(this);
		that.rock_ref = new Object();
		that.rock_ref.time = parseInt(that.attr('data-time'));
		that.rock_ref.id = that.attr('id');
		that.rock_ref.timer;
		that.rock_ref.current_row = 0;
		that.rock_ref.total_in_row = that.attr('data-total-in-row');
		that.rock_ref.auto_slide = that.attr('data-auto-slide');
		that.rock_ref.total_rows = jQuery('#' + that.rock_ref.id + ' ul').length;
		if (that.rock_ref.auto_slide == 'true') {
			that.rock_ref.timer = setInterval(function() {
				change_references(false, that);
			}, that.rock_ref.time);
		}
		jQuery('#' + that.rock_ref.id + ' ul').each(function(i) {
			jQuery(this).css({
				'margin-top': '-' + jQuery(this).position().top + 'px'
			});
		});
		jQuery(document).on('click', '#' + that.rock_ref.id + ' .references_previous_button', function() {
			if (that.rock_ref.auto_slide == 'true') {
				clearInterval(that.rock_ref.timer);
			}
			change_references(true, that);
			if (that.rock_ref.auto_slide == 'true') {
				that.rock_ref.timer = setInterval(function() {
					change_references(true, that);
				}, that.rock_ref.time);
			}
		});
		jQuery(document).on('click', '#' + that.rock_ref.id + ' .references_next_button', function() {
			if (that.rock_ref.auto_slide == 'true') {
				clearInterval(that.rock_ref.timer);
			}
			change_references(false, that);
			if (that.rock_ref.auto_slide == 'true') {
				that.rock_ref.timer = setInterval(function() {
					change_references(false, that);
				}, that.rock_ref.time);
			}
		});
		var first_time = false;
		that.imagesLoaded(function() {
			rockthemes_references_resize(that.rock_ref.id, first_time);
		});
		jQuery(window).smartresize(function() {
			rockthemes_references_resize(that.rock_ref.id, first_time);
		});
	});
}

function rockthemes_references_resize(id, first_time) {
	jQuery('#' + id + ' .absolute-class').first().find('li').css('margin-top', '0');
	var height = jQuery('#' + id + ' .absolute-class').first().height();
	jQuery('#' + id + ' .rock-references-content').css('height', height);
	if (!first_time) {
		height = jQuery('#' + id + ' .absolute-class').first().find('li').first().height();
		jQuery('#' + id + ' .azoom-element-responsive-header').css({
			top: height / 2 - 13
		});
		first_time = true;
	}
}

function change_references(previous, that) {
	jQuery('#' + that.rock_ref.id + ' .absolute-class').eq(that.rock_ref.current_row).find('li').each(function(i) {
		jQuery(this).stop(true, true).animate({
			'margin-top': '-30px',
			'opacity': '0'
		}, (i * 200) + 100);
	});
	jQuery('#' + that.rock_ref.id + ' .absolute-class').eq(that.rock_ref.current_row).css({
		'zIndex': '0'
	});
	if (typeof previous !== 'undefined' && previous === true) {
		that.rock_ref.current_row--;
		if (that.rock_ref.current_row < 0) {
			that.rock_ref.current_row = that.rock_ref.total_rows - 1;
		}
	} else {
		that.rock_ref.current_row++;
		if (that.rock_ref.current_row >= that.rock_ref.total_rows) {
			that.rock_ref.current_row = 0;
		}
	}
	jQuery('#' + that.rock_ref.id + ' .absolute-class').eq(that.rock_ref.current_row).css({
		'zIndex': '1'
	});
	jQuery('#' + that.rock_ref.id + ' .absolute-class').eq(that.rock_ref.current_row).find('li').each(function(i) {
		jQuery(this).css({
			'margin-top': '60px'
		});
		jQuery(this).stop(true, true).animate({
			'margin-top': '0px',
			'opacity': '1'
		}, (i * 150) + 250);
	});
}

function rockthemes_ae_skills() {
	jQuery('.azoom-skill').each(function() {
		var that = jQuery(this);
		if (that.parents('.rockthemes-animate.skill-animating').length) {
			return;
		} else if (that.parents('.rockthemes-animate').length) {
			that.parents('.rockthemes-animate').addClass('skill-animating');
			var r = that.parents('.rockthemes-animate.skill-animating');
			r.appear();
			r.on('appear', function() {
				r.off('appear');
				r.appearOff();
				r.find('.azoom-skill').each(function(i) {
					var t = jQuery(this);
					if (!t.find('.active').length) {
						if (Modernizr.csstransitions) {
							setTimeout(function() {
								t.addClass('active');
								t.off('appear');
								t.appearOff();
							}, parseInt(i * 600));
						} else {
							t.addClass('active');
							t.off('appear');
							t.appearOff();
						}
					}
				});
			});
		} else {
			that.appear();
			that.on('appear', function() {
				if (!that.find('.active').length) {
					setTimeout(function() {
						that.addClass('active');
						that.off('appear');
						that.appearOff();
					}, 600);
				}
			});
		}
	});
}

function rockthemes_ae_love_icon() {
	jQuery(document).on('click touchend', '.azoom-love-icon', function(e) {
		e.preventDefault();
		var that = jQuery(this);
		if (typeof that.attr('data-loved-this') !== 'undefined' && that.attr('data-loved-this') && that.attr('data-loved-this') === 'yes') {
			return;
		}
		if (typeof that.attr('data-post-id') !== 'undefined' && that.attr('data-post-id') && that.attr('data-post-id') !== '') {
			var sd = {
				post_id: that.attr('data-post-id')
			};
			jQuery.post(rockthemes.ajaxurl, {
				action: 'azoom_love_ajax',
				_ajax_nonce: rockthemes.nonces.love,
				data: sd
			}, function(data) {
				if (data == 'success') {
					var n = jQuery('.azoom-love-icon[data-post-id="' + that.attr('data-post-id') + '"]').attr('data-loved-this', 'yes');
					if (n.find('span').length) {
						n.find('span').html(parseInt(n.find('span').html()) + 1);
					}
				}
			});
		}
	});
}

function rockthemes_ae_steps() {
	rockthemes_ae_steps_init_resize();
	jQuery(window).smartresize(rockthemes_ae_steps_init_resize);
	jQuery('.azoom-steps .step-icon').click(function() {
		rockthemes_se_elem_clicked(jQuery(this));
	});
	jQuery('.azoom-steps').each(function() {
		var that = jQuery(this);
		var size = (parseInt(that.attr('data-min-width')) / that.find('li').length);
		var starting_x = 0;
		var ending_x = 0;
		var matrix = (that.css("transform")).substr(7, (that.css("transform")).length - 8).split(', ');
		var last_size = matrix[4];
		var first_x_val = -(parseInt(that.find('li').first().offset().left + ((parseInt(that.attr('data-min-width')) / that.find('li').length) / 2)) - 35);
		first_x_val = first_x_val + Number(last_size);
		var first_x_val_desk = -(parseInt(that.find('li').first().position().left + ((parseInt(that.attr('data-min-width')) / that.find('li').length) / 2)) - 35);
		first_x_val_desk = first_x_val_desk + Number(last_size);
		that.on('touchstart', function(e) {
			starting_x = e.originalEvent.touches[0].pageX;
			ending_x = parseInt(starting_x - e.originalEvent.touches[0].pageX);
			matrix = (that.css("transform")).substr(7, (that.css("transform")).length - 8).split(', ');
			last_size = matrix[4];
			that.removeClass('azoom-transition');
		}).on("touchmove", function(e) {
			e.preventDefault();
			ending_x = parseInt(starting_x - e.originalEvent.touches[0].pageX);
			var diff = parseInt(last_size - ending_x);
			if (Math.abs(ending_x) < 5) return;
			that.css({
				'transform': 'translateX(' + diff + 'px)',
				'-webkit-transform': 'translateX(' + diff + 'px)'
			});
		}).on("touchend", function(e) {
			that.addClass('azoom-transition');
			if (Math.abs(ending_x) < 5) return;
			var diff = parseInt(last_size - ending_x);
			var new_val = parseInt(last_size) - (ending_x + (size - ((ending_x) % size)));
			if (ending_x < 0) {
				new_val = parseInt(new_val) + (size * 2);
			}
			if (new_val < -(parseInt(that.attr('data-min-width')) - (size / 2))) {
				new_val = first_x_val;
			} else if (new_val > (first_x_val - 10)) {
				new_val = first_x_val;
			}
			that.css({
				'transform': 'translateX(' + new_val + 'px)',
				'-webkit-transform': 'translateX(' + new_val + 'px)'
			});
		});
		that.on('mousedown', function(e) {
			that.addClass('mousedown');
			starting_x = e.pageX - that.offset().left;
			ending_x = parseInt(starting_x - (e.pageX - that.offset().left));
			matrix = (that.css("transform")).substr(7, (that.css("transform")).length - 8).split(', ');
			last_size = matrix[4];
			that.removeClass('azoom-transition');
		});
		jQuery('body').on("mousemove", function(e) {
			if (!that.hasClass('mousedown')) {
				e.preventDefault();
				return true;
			}
			e.stopPropagation();
			ending_x = parseInt(starting_x - (e.pageX - that.offset().left));
			var diff = parseInt(last_size - ending_x);
			if (Math.abs(ending_x) < 5) return;
			that.css({
				'transform': 'translateX(' + diff + 'px)',
				'-webkit-transform': 'translateX(' + diff + 'px)'
			});
		});
		jQuery('body').on("mouseup", function(e) {
			e.preventDefault();
			if (!that.hasClass('mousedown')) return;
			that.removeClass('mousedown');
			that.addClass('azoom-transition');
			if (Math.abs(ending_x) < 5) return;
			var diff = parseInt(last_size - ending_x);
			var new_val = parseInt(last_size) - (ending_x + (size - ((ending_x) % size)));
			if (ending_x < 0) {
				new_val = parseInt(new_val) + (size * 2);
			}
			if (new_val < -(parseInt(that.attr('data-min-width')) - (size / 2))) {
				new_val = first_x_val_desk;
			} else if (new_val > (first_x_val_desk - 10)) {
				new_val = first_x_val_desk;
			}
			that.css({
				'transform': 'translateX(' + new_val + 'px)',
				'-webkit-transform': 'translateX(' + new_val + 'px)'
			});
		});
	});
	jQuery('.azoom-steps .step-back').click(function(e) {
		var t_steps = jQuery(this).parents('.azoom-steps');
		if (t_steps.parent().width() < parseInt(t_steps.attr('data-min-width')) && t_steps.find('li.active').length > 1) {
			var size = t_steps.find('li').first().width() + 20;
			var matrix = (t_steps.css("transform")).substr(7, (t_steps.css("transform")).length - 8).split(', ');
			var last_size = matrix[4];
			t_steps.css({
				'transform': 'translateX(' + (parseInt(last_size) + size) + 'px)',
				'-webkit-transform': 'translateX(' + (parseInt(last_size) + size) + 'px)',
				'-ms-transform': 'translateX(' + (parseInt(last_size) + size) + 'px)',
			});
		}
		rockthemes_se_elem_clicked(jQuery(this).parents('li').find('.step-icon'));
		if (jQuery(this).parents('li').prev().length && jQuery(this).parents('li').prev().hasClass('done')) {
			jQuery(this).parents('li').prev().removeClass('done');
		}
	});
	jQuery('.azoom-steps .step-next').click(function(e) {
		var t_steps = jQuery(this).parents('.azoom-steps');
		if (t_steps.parent().width() < parseInt(t_steps.attr('data-min-width')) && t_steps.find('li.active').length < t_steps.find('li').length) {
			var size = t_steps.find('li').first().width() + 20;
			var matrix = (t_steps.css("transform")).substr(7, (t_steps.css("transform")).length - 8).split(', ');
			var last_size = matrix[4];
			t_steps.css({
				'transform': 'translateX(' + (parseInt(last_size) - size) + 'px)',
				'-webkit-transform': 'translateX(' + (parseInt(last_size) - size) + 'px)',
				'-ms-transform': 'translateX(' + (parseInt(last_size) - size) + 'px)',
			});
		}
		if (jQuery(this).parents('li').next().length) {
			rockthemes_se_elem_clicked(jQuery(this).parents('li').next().find('.step-icon'));
		}
	});
	jQuery('.azoom-steps').each(function() {
		var that = jQuery(this);
		if (that.attr('data-start_steps') === 'none') return;
		that.appear();
		that.on('appear', function() {
			if (!that.find('.active').length) {
				if (!Modernizr.touch && that.attr('data-start_steps') === 'all' && parseInt(that.attr('data-min-width')) < jQuery(window).width()) {
					rockthemes_se_elem_clicked(that.find('li .step-icon'));
				} else {
					rockthemes_se_elem_clicked(that.find('li').first().find('.step-icon'));
				}
				that.off('appear');
				that.appearOff();
			}
		});
	});
}

function rockthemes_ae_steps_init_resize() {
	jQuery('.azoom-steps').each(function() {
		var data_width = typeof jQuery(this).attr('data-min-width') !== '' && jQuery(this).attr('data-min-width') !== '' ? parseInt(jQuery(this).attr('data-min-width')) : 960;
		if (parseInt(jQuery(this).find(' > ul > li').length % 2) === 0) {
			data_width += jQuery(this).find(' > ul > li').first().width();
		}
		if (jQuery(this).parent().width() < parseInt(data_width)) {
			var f = jQuery(this).find('li').first();
			var x_val = -(parseInt(((parseInt(jQuery(this).attr('data-min-width')) / jQuery(this).find('li').length) / 2)) - 35);
			if (jQuery(this).hasClass('responsive')) {
				var matrix = (jQuery(this).css("transform")).substr(7, (jQuery(this).css("transform")).length - 8).split(', ');
				var last_size = matrix[4];
			}
			jQuery(this).addClass('responsive');
			jQuery(this).css({
				'min-width': jQuery(this).attr('data-min-width') + 'px',
				'transform': 'translateX(' + x_val + 'px)',
				'-webkit-transform': 'translateX(' + x_val + 'px)',
				'-moz-transform': 'translateX(' + x_val + 'px)',
				'-ms-transform': 'translateX(' + x_val + 'px)'
			});
		} else if (jQuery(this).hasClass('responsive')) {
			jQuery(this).removeClass('responsive');
			jQuery(this).css({
				'transform': 'translateX(0px)',
				'-webkit-transform': 'translateX(0px)',
				'-moz-transform': 'translateX(0px)',
				'-ms-transform': 'translateX(0px)'
			});
		}
	});
}

function rockthemes_se_elem_clicked(elem) {
	var that = elem.parents('li');
	var steps = that.parents('.azoom-steps');
	var start_class = steps.attr('class');
	if (steps.hasClass('connect-steps')) {
		var this_i = that.parents('ul').find('li').index(that);
		var not_connected = false;
		for (var b = 0; b < this_i; b++) {
			if (!steps.find('li:eq(' + b + ')').hasClass('active')) {
				not_connected = true;
				break;
			}
		}
		for (var a = this_i + 1; a < steps.find('li').length; a++) {
			if (steps.find('li:eq(' + a + ')').hasClass('active')) {
				not_connected = true;
				break;
			}
		}
		if (not_connected) {
			return;
		}
	}
	that.toggleClass('active');
	if (that.hasClass('done')) {
		that.removeClass('done');
	}
	if (that.hasClass('active')) {
		elem.css({
			'background-color': that.attr('data-step-color')
		});
		that.css({
			'background-color': that.attr('data-step-color')
		});
		that.find('.step-details-line').css({
			'background-color': that.attr('data-step-color')
		});
		if (that.index() % 2 === 0) {
			that.parents('.azoom-steps').addClass('azoom-steps-margin-bottom');
		} else {
			that.parents('.azoom-steps').addClass('azoom-steps-margin-top');
		}
	} else {
		elem.css({
			'background-color': ''
		});
		that.css({
			'background-color': ''
		});
		that.find('.step-details-line').css({
			'background-color': ''
		});
	}
	if (elem.parents('.azoom-steps').hasClass('jump-steps')) {
		if (that.hasClass('active')) {
			for (var i = 0; i < that.parents('ul').find('li').index(that); i++) {
				steps.find('li:eq(' + i + ')').find('.step-icon').css({
					'background-color': steps.find('li:eq(' + i + ')').attr('data-step-color')
				});
				steps.find('li:eq(' + i + ')').css({
					'background-color': steps.find('li:eq(' + i + ')').attr('data-step-color')
				});
				steps.find('li:eq(' + i + ')').find('.step-details-line').css({
					'background-color': steps.find('li:eq(' + i + ')').attr('data-step-color')
				});
				steps.find('li:eq(' + i + ')').addClass('active done');
				if (i % 2 === 0) {
					steps.addClass('azoom-steps-margin-bottom');
				} else {
					steps.addClass('azoom-steps-margin-top');
				}
			}
		} else {
			for (var t = that.parents('ul').find('li').index(that); t < steps.find('li').length; t++) {
				steps.find('li:eq(' + t + ')').removeClass('active done');
				steps.find('li:eq(' + t + ')').find('.step-icon').css({
					'background-color': ''
				});
				steps.find('li:eq(' + t + ')').css({
					'background-color': ''
				});
				steps.find('li:eq(' + t + ')').find('.step-details-line').css({
					'background-color': ''
				});
			}
		}
	} else {
		if (that.prev().length) {
			that.prev().addClass('done');
		}
	}
	if (!that.parents('.azoom-steps').find('.active').length) {
		that.parents('.azoom-steps').removeClass('azoom-steps-margin-top azoom-steps-margin-bottom');
	}
}

function rockthemes_ae_buttons() {
	jQuery('.button[data-button-js-colors="true"]').each(function() {
		var that = jQuery(this);
		that.on('mouseenter', function() {
			var btn = jQuery(this);
			var bg_hover = btn.attr('data-bg_color_hover');
			var text_hover = btn.attr('data-text_color_hover');
			var border_hover = btn.attr('data-border_color_hover');
			if (btn.attr("data-bg-disabled") && btn.attr("data-bg-disabled") == "true") {
				that.css({
					'border-color': border_hover,
					'color': text_hover,
					'background': bg_hover
				});
			} else if (btn.hasClass('button-border-bottom')) {
				that.css({
					'background': bg_hover,
					'box-shadow': '0px 3px 0px ' + border_hover,
					'-webkit-box-shadow': '0px 3px 0px ' + border_hover,
					'-moz-box-shadow': '0px 3px 0px ' + border_hover,
					'color': text_hover
				});
			} else {
				that.css({
					'background': bg_hover,
					'color': text_hover
				});
			}
		});
		that.on('mouseleave', function() {
			var btn = jQuery(this);
			var bg_default = btn.attr("data-bg_color_default");
			var text_default = btn.attr("data-text_color_default");
			var border_color = btn.attr('data-border_color');
			if (btn.attr("data-bg-disabled") && btn.attr("data-bg-disabled") == "true") {
				that.css({
					'border-color': border_color,
					'color': text_default,
					'background': 'none'
				});
			} else if (btn.hasClass('button-border-bottom')) {
				that.css({
					'background': bg_default,
					'box-shadow': '0px 6px 0px ' + border_color,
					'-webkit-box-shadow': '0px 6px 0px ' + border_color,
					'-moz-box-shadow': '0px 6px 0px ' + border_color,
					'color': text_default
				});
			} else {
				that.css({
					'background': bg_default,
					'color': text_default
				});
			}
		});
	});
	jQuery(document).trigger('rockthemes:activate_lightbox');
}

function rockthemes_ae_iconictext() {
	jQuery('.rock-iconictext-container').each(function() {
		var that = jQuery(this);
		if (that.hasClass('full-width-box') && that.hasClass('top')) {
			return;
		}
		that.on('mouseenter', function() {
			var icon = jQuery(this).find('.rockicon-container');
			var bg_color = icon.attr('data-bg-color');
			var bg_hover_color = icon.attr('data-bg-hover-color');
			var icon_color = icon.attr('data-icon-color');
			var icon_hover_color = icon.attr('data-icon-hover-color');
			if (typeof icon.attr('data-box-fill') != 'undefined' && icon.attr('data-box-fill').indexOf('border') > -1) {
				icon.stop(true, true).animate({
					"border-color": bg_hover_color,
					"color": icon_hover_color
				}, 180);
			} else if (icon.attr("data-bg-disabled") && icon.attr("data-bg-disabled") == "true") {
				icon.stop(true, true).animate({
					"color": icon_hover_color
				}, 280);
			} else {
				icon.stop(true, true).animate({
					"backgroundColor": bg_hover_color,
					"color": icon_hover_color
				}, 180);
			}
		});
		that.on('mouseleave', function() {
			var icon = jQuery(this).find(".rockicon-container");
			var bg_color = icon.attr('data-bg-color');
			var bg_hover_color = icon.attr('data-bg-hover-color');
			var icon_color = icon.attr('data-icon-color');
			var icon_hover_color = icon.attr('data-icon-hover-color');
			if (typeof icon.attr('data-box-fill') != 'undefined' && icon.attr('data-box-fill').indexOf('border') > -1) {
				icon.stop(true, true).animate({
					"border-color": bg_color,
					"color": icon_color
				}, 180);
			} else if (icon.attr("data-bg-disabled") && icon.attr("data-bg-disabled") == "true") {
				icon.stop(true, true).animate({
					"color": icon_color
				}, 180);
			} else {
				icon.stop(true, true).animate({
					"backgroundColor": bg_color,
					"color": icon_color
				}, 180);
			}
		});
	});
}

function rockthemes_ae_achievement() {
	jQuery('.rock-achievement').each(function() {
		var that = jQuery(this),
			that_id = that.attr('id') + '_number',
			achievement = jQuery('#' + that_id);;
		if (Modernizr.ismobile) {
			achievement.removeClass('odometer');
		}
		switch (that.data('mode')) {
			case 'static':
				if (Modernizr.ismobile) {
					achievement.html(that.attr('data-value'));
				} else {
					that.appear();
					jQuery(document).on('appear', '#' + that.attr('id'), function() {
						var u = new CountUp(that_id, 0, that.attr('data-value'));
						u.start();
						jQuery(document).off('appear', '#' + that.attr('id'));
						that.appearOff();
					});
				}
				break;
			case 'function_php':
				if (Modernizr.ismobile) {
					achievement.html(that.attr('data-value'));
				} else {
					that.appear();
					jQuery(document).on('appear', '#' + that.attr('id'), function() {
						var u = new CountUp(that_id, 0, that.attr('data-value'));
						u.start();
						jQuery(document).off('appear', '#' + that.attr('id'));
						that.appearOff();
					});
				}
				break;
			case 'function_js':
				if (!Modernizr.ismobile) {
					that.appear();
				}
				var fn = window[that.data('function_js')];
				if (typeof fn === 'function') {
					var number = fn();
					if (Modernizr.ismobile) {
						achievement.html(number);
					} else {
						jQuery(document).on('appear', '#' + that.attr('id'), function() {
							var u = new CountUp(that_id, 0, number);
							u.start();
							jQuery(document).off('appear', '#' + that.attr('id'));
							that.appearOff();
						});
					}
				}
				break;
			case 'function_ajax':
				if (!Modernizr.ismobile) {
					that.appear();
				}
				var fn = that.data('function_ajax');
				var data = {
					function_name: fn
				};
				if (Modernizr.ismobile) {
					jQuery.post(rockthemes.ajaxurl, {
						action: 'rockthemes_achievement_ajax',
						_ajax_nonce: rockthemes.nonces.achievement,
						data: data
					}, function(data) {
						if (data && typeof data.number != 'undefined') {
							achievement.html(data.number);
						}
					});
				} else {
					jQuery(document).on('appear', '#' + that.attr('id'), function() {
						jQuery.post(rockthemes.ajaxurl, {
							action: 'rockthemes_achievement_ajax',
							_ajax_nonce: rockthemes.nonces.achievement,
							data: data
						}, function(data) {
							if (data && typeof data.number != 'undefined') {
								var u = new CountUp(that_id, 0, data.number);
								u.start();
							}
						});
						jQuery(document).off('appear', '#' + that.attr('id'));
						that.appearOff();
					});
				}
				break;
			default:
				if (Modernizr.ismobile) {
					achievement.html(that.attr('data-value'));
				} else {
					that.appear();
					jQuery(document).on('appear', '#' + that.attr('id'), function() {
						var u = new CountUp(that_id, 0, that.attr('data-value'));
						u.start();
						jQuery(document).off('appear', '#' + that.attr('id'));
						that.appearOff();
					});
				}
				break;
		}
	});
}

function rockthemes_ae_tabs() {
	jQuery('.rock-tabs-container').each(function() {
		var tab = jQuery(this);
		var hash_on = tab.hasClass('tab-hash-active') ? true : false;
		var address_hash = location.hash;
		if (address_hash.indexOf("/") > -1) {
			address_hash = false;
		}
		if (typeof address_hash != 'undefined' && address_hash && tab.find(address_hash).length) {
			tab.find('.tabs-motion-content.active').css('display', 'none').removeClass('active');
			tab.find('.rock-tab-header.active').removeClass('active');
			var ref = '#' + jQuery(address_hash).attr('data-tab-ref') + ' .' + jQuery(address_hash).attr('data-content-ref');
			var tabRef = jQuery(address_hash).attr('data-tab-ref');
			jQuery(address_hash).addClass('active');
			jQuery(ref).css({
				'opacity': '0.1',
				'display': 'block'
			}).addClass('active');
			jQuery(ref).stop(true, true).animate({
				'opacity': '1'
			}, 280);
		}
		tab.on('click touchend', '.rock-tab-header', function(e) {
			var ref = '#' + jQuery(this).attr('data-tab-ref') + ' .' + jQuery(this).attr('data-content-ref');
			var tabRef = jQuery(this).attr('data-tab-ref');
			jQuery('#' + tabRef + ' .tabs-motion-content.active').css('display', 'none').removeClass('active');
			jQuery('#' + tabRef + ' .rock-tab-header.active').removeClass('active');
			jQuery(this).addClass('active');
			jQuery(ref).css({
				'opacity': '0.1',
				'display': 'block'
			}).addClass('active');
			jQuery(ref).stop(true, true).animate({
				'opacity': '1'
			}, 280);
			if (hash_on) {
				var this_hash = typeof jQuery(this).attr('id') != 'undefined' && jQuery(this).attr('id') ? jQuery(this).attr('id') : false;
				var this_link = typeof jQuery(this).attr('data-link') != 'undefined' && jQuery(this).attr('data-link') ? jQuery(this).attr('data-link') : false;
				if (!this_hash) return;
				setTimeout(function() {
					if (history.pushState) {
						history.pushState(null, null, this_link + '#' + this_hash);
					} else {
						location.hash = this_hash;
					}
				}, 100);
			}
		});
	});
}

function rockthemes_ae_toggles() {
	var icon_lib = (typeof rockthemes.fonts.use_icomoon != 'undefined' && rockthemes.fonts.use_icomoon === 'true') ? 'icomoon' : 'fontawesome';
	var address_hash = location.hash;
	if (address_hash.indexOf("/") > -1) {
		address_hash = false;
	}
	jQuery('.rock-toggles-container').each(function() {
		var toggle = jQuery(this);
		var hash_on = toggle.hasClass('toggle-hash-active') ? true : false;
		if (typeof address_hash != 'undefined' && address_hash && toggle.find(address_hash).length) {
			if (toggle.hasClass('multiple-mode')) {
				toggle.find('.active .rock-toggle-content').slideToggle(280);
				toggle.find('.active .rock-toggle-header .main-toggle-icon').removeClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-up6' : 'fa fa-chevron-up');
				toggle.find('.active .rock-toggle-header .main-toggle-icon').addClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-down6' : 'fa fa-chevron-down');
				toggle.find('.active').removeClass('active');
			}
			jQuery(address_hash).addClass('active');
			jQuery(address_hash).find('.rock-toggle-content').slideToggle(280);
			jQuery(address_hash).find('.rock-toggle-header .main-toggle-icon').removeClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-down6' : 'fa fa-chevron-down');
			jQuery(address_hash).find('.rock-toggle-header .main-toggle-icon').addClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-up6' : 'fa fa-chevron-up');
		}
		toggle.on('click touchend', '.rock-toggle-header', function(e) {
			e.preventDefault();
			if (toggle.hasClass('multiple-mode')) {
				if (jQuery(this).parent().hasClass('active') && jQuery(this).parent().find('.rock-toggle-content').css('display') != 'none') return;
				toggle.find('.active .rock-toggle-content').slideToggle(280);
				toggle.find('.active .rock-toggle-header .main-toggle-icon').removeClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-up6' : 'fa fa-chevron-up');
				toggle.find('.active .rock-toggle-header .main-toggle-icon').addClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-down6' : 'fa fa-chevron-down');
				toggle.find('.active').removeClass('active');
				jQuery(this).parent().addClass('active');
				jQuery(this).parent().find('.rock-toggle-content').slideToggle(280);
				jQuery(this).parent().find('.rock-toggle-header .main-toggle-icon').removeClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-down6' : 'fa fa-chevron-down');
				jQuery(this).parent().find('.rock-toggle-header .main-toggle-icon').addClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-up6' : 'fa fa-chevron-up');
			} else {
				if (jQuery(this).parent().hasClass('active')) {
					jQuery(this).parent().removeClass('active');
					jQuery(this).parent().find('.rock-toggle-header .main-toggle-icon').removeClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-up6' : 'fa fa-chevron-up');
					jQuery(this).parent().find('.rock-toggle-header .main-toggle-icon').addClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-down6' : 'fa fa-chevron-down');
				} else {
					jQuery(this).parent().addClass('active');
					jQuery(this).parent().find('.rock-toggle-header .main-toggle-icon').removeClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-down6' : 'fa fa-chevron-down');
					jQuery(this).parent().find('.rock-toggle-header .main-toggle-icon').addClass(icon_lib === 'icomoon' ? 'icomoon icomoon-icon-arrow-up6' : 'fa fa-chevron-up');
				}
				jQuery(this).parent().find('.rock-toggle-content').slideToggle(280);
			}
			if (hash_on) {
				var this_hash = typeof jQuery(this).parent().attr('id') != 'undefined' && jQuery(this).parent().attr('id') ? jQuery(this).parent().attr('id') : false;
				if (!this_hash) return;
				setTimeout(function() {
					if (history.pushState) {
						history.pushState(null, null, '#' + this_hash);
					} else {
						location.hash = this_hash;
					}
				}, 480);
			}
		});
	});
}

function rockthemes_activate_down_arrows() {
	if (jQuery('.rockthemes-before-header.intro-effect-slide').length) {
		jQuery(document).on('rockthemes:intro_effect_canvas_resize', function() {
			jQuery('.rockthemes-before-header.intro-effect-slide').css('height', '');
			if (jQuery('.rockthemes-before-header.intro-effect-slide').children().length) {
				jQuery('.rockthemes-before-header.intro-effect-slide').css('height', jQuery('.rockthemes-before-header.intro-effect-slide').children().outerHeight() + 'px');
			} else {
				jQuery('.rockthemes-before-header.intro-effect-slide').css('height', jQuery('.rockthemes-before-header.intro-effect-slide').outerHeight() + 'px');
			}
		});
		jQuery('.rockthemes-before-header.intro-effect-slide').appear();
		jQuery('div[data-rsb-fullscreen="true"], section[data-rsb-fullscreen="true"]').each(function() {
			if (jQuery(this).find('.rockthemes-curvy-slider').length < 1) {
				jQuery(this).addClass('header');
			}
		});
		jQuery('.rockthemes-curvy-slider').addClass('header');
		jQuery(document).trigger('rockthemes:intro_effect_canvas_resize');
		var timeOut = null;
		jQuery(document).on('appear', '.rockthemes-before-header.intro-effect-slide', function(e, that) {
			if (that.hasClass('modify') && !that.hasClass('modify-motion') && parseInt(that.offset().top + that.outerHeight()) - 40 > jQuery(window).scrollTop()) {
				jQuery(document).trigger('rockthemes:scroll_events_disable');
				rockthemes_overlay_transparent_enable();
				that.addClass('modify-motion').removeClass('modify');
				jQuery('html,body').stop(true, true).delay(400).animate({
					scrollTop: parseInt((that.offset().top))
				}, 1100, function() {
					that.removeClass('modify-motion');
					rockthemes_overlay_transparent_disable();
					jQuery(document).trigger('rockthemes:sticky_menu_resize');
					jQuery(document).trigger('rockthemes:scroll_events_enable');
				});
			}
		});
		jQuery(document).on('disappear', '.rockthemes-before-header.intro-effect-slide', function(e, that) {
			if (that.hasClass('modify-motion') && !that.is(':appeared')) {
				that.removeClass('modify-motion');
				jQuery(document).trigger('rockthemes:sticky_menu_resize');
			}
		});
	}
	jQuery(document).on('click touchend', '.azoom-down-arrow-container', function(e) {
		var that = jQuery(this).parents('.rockthemes-unique-grid');
		if (that.parents('.rockthemes-before-header').length) {
			jQuery(document).trigger('rockthemes:scroll_events_disable');
			rockthemes_overlay_transparent_enable();
		}
		var next_el = null;
		var found = false;
		next_el = that.nextAll('.rockthemes-unique-grid');
		jQuery('.rockthemes-unique-grid').each(function(i) {
			if (found) {
				next_el = jQuery(this);
				found = false;
			}
			if (typeof jQuery(this).attr('id') !== 'undefined' && jQuery(this).attr('id') == that.attr('id')) {
				found = true;
			}
		});
		var use_intro_effect = false;
		if (that.parents('.rockthemes-before-header').length) {
			if (jQuery('.header-top-2').length) {
				next_el = jQuery('.header-top-2');
			} else {
				if (jQuery('.sticky-header-wrapper').length) {
					next_el = jQuery('.sticky-header-wrapper');
				} else {
					if (jQuery('.main-header-area').length) {
						next_el = jQuery('.main-header-area');
					}
				}
			}
			if (that.parents('.rockthemes-before-header').hasClass('intro-effect-slide')) {
				var header_that = that.parents('.rockthemes-before-header');
				if (!header_that.hasClass('modify-motion') && !header_that.hasClass('modify')) {
					header_that.addClass('modify modify-motion');
					use_intro_effect = true;
					if (timeOut) clearTimeout(timeOut);
					timeOut = setTimeout(function() {
						if (header_that.hasClass('modify-motion')) {
							header_that.removeClass('modify-motion');
						}
						jQuery(document).trigger('rockthemes:sticky_menu_resize');
					}, 1400);
				}
			}
		}
		setTimeout(function() {
			if (that.parents('.rockthemes-before-header').length) {
				jQuery(document).trigger('rockthemes:scroll_events_enable');
				rockthemes_overlay_transparent_disable();
			}
		}, 1500);
		if (typeof next_el == 'undefined' || !next_el || typeof next_el.offset() == 'undefined' || !next_el.offset()) return;
		var wp_nav_height = 0;
		if (rockthemes.frontend_options.is_admin_bar_showing) {
			wp_nav_height = jQuery('#wpadminbar').outerHeight();
		}
		var scrollTopVal = (parseInt(next_el.offset().top) - parseInt(wp_nav_height));
		if (jQuery('.main-header-area').length && jQuery('.main-header-area').offset().top < scrollTopVal && scrollTopVal - rockthemes.menu.sticky_height > 0) {
			scrollTopVal = scrollTopVal - parseInt(rockthemes.menu.sticky_height);
		}
		jQuery('html, body').animate({
			'scrollTop': scrollTopVal
		}, 1000, function() {
			var this_hash = typeof next_el.attr('id') != 'undefined' && next_el.attr('id') ? next_el.attr('id') : false;
			if (!this_hash) return;
			setTimeout(function() {
				if (history.pushState) {
					history.pushState(null, null, '#' + this_hash);
				} else {
					location.hash = this_hash;
				}
			}, 100);
		});
	});
}

function rockthemes_overlay_transparent_enable() {
	if (jQuery('#azoom_overlay_transparent').length) return;
	jQuery('body').append(jQuery('<div id="azoom_overlay_transparent" class="azoom-fixed-overlay-transparent"></div>'));
}

function rockthemes_overlay_transparent_disable() {
	if (jQuery('#azoom_overlay_transparent').length) {
		jQuery('#azoom_overlay_transparent').remove();
	}
}

function rockthemes_activate_lightbox() {
	jQuery(document).on('rockthemes:activate_lightbox', function() {
		jQuery('a[data-rel^="prettyPhoto"]').prettyPhoto({
			hook: 'data-rel',
			overlay_gallery_max: 9999
		});
	});
	jQuery(document).trigger('rockthemes:activate_lightbox');
}

function rockthemes_activate_cat_filter_ajax() {
	if (jQuery('.ajax-category-navigation').length < 1) return;
	var animate_active = true;
	var anim_obj = {
		_out: 'fadeOut',
		_in: 'fadeIn'
	};
	jQuery('.ajax-category-navigation > ul > li').click(function() {
		var that = jQuery(this).parents('.ajax-category-navigation');
		var _this = jQuery(this);
		if (that.hasClass('loading')) return;
		that.addClass('loading');
		that.find('li a.active').removeClass('active');
		jQuery(this).find(' > a').addClass('active');
		var de = jQuery(this).parents('.ajax-category-navigation').find(".data-cat-details");
		var ds = de.data();
		de.attr('data-last_load', '0');
		ds.last_load = 0;
		ds.category = _this.attr('data-slug-holder');
		var elem_selector = jQuery('#' + ds.id_ref).parents('.azoom-portfolio-container').hasClass('list') ? 'div' : 'li';
		jQuery.post(rockthemes.ajaxurl, {
			data: ds,
			_ajax_nonce: rockthemes.nonces.portfolio,
			action: 'rockthemes_portfolio_load_more'
		}, function(data) {
			if (!data || !data.body) {
				that.removeClass('loading');
				return;
			}
			var new_elems = jQuery(data.body);
			var holder = jQuery('#' + ds.id_ref);
			holder.find(' > ' + elem_selector).remove();
			if (animate_active) {
				new_elems.addClass('azoom-animate-queue');
			}
			holder.append(new_elems);
			if (typeof ds.masonry != 'undefined' && (ds.masonry || ds.masonry == 'true')) {
				var mo;
				holder.masonry('appended', new_elems);
				rockthemes_init_single_masonry(holder, mo, true, true);
			} else if (animate_active) {
				rockthemes_animate_queue(holder, 'fadeIn');
			}
			if (that.parents('.azoom-portfolio-container').find('.load-more').length) {
				var lmb = that.parents('.azoom-portfolio-container').find('.load-more');
				var lmd = lmb.parent().find('.data-details');
				lmd.attr('data-last_load', '0');
				lmd.attr('data-category', ds.category);
				if (!data.disable || data.disable !== 'yes') {
					if (lmb.hasClass('hide')) lmb.removeClass('hide');
				} else if (data.disable && data.disable === 'yes') {
					lmb.addClass('hide');
				}
			}
			jQuery(document).trigger('rockthemes:activate_lightbox');
			that.removeClass('loading');
			return;
		});
	});
}

function rockthemes_activate_load_more() {
	if (jQuery('.load-more').length < 1) return;
	var animate_active = true;
	var anim_obj = {
		_out: 'fadeOut',
		_in: 'fadeIn'
	};
	jQuery('.load-more').click(function() {
		var that = jQuery(this);
		if (that.hasClass('loading')) return;
		that.addClass('loading');
		var de = jQuery(this).parent().find('.data-details');
		var ds = de.data();
		var ll = parseInt(parseInt(de.attr('data-last_load')) + parseInt(ds.load_amount));
		de.attr('data-last_load', ll);
		ds.last_load = ll;
		ds.category = de.attr('data-category');
		if (ds.archive_load_more === 'true' || ds.archive_load_more === true) {
			var alme = that.parent().find('.archive_load_more').find('.load-more-link').first();
			var alme_link = alme.attr('href');
			alme.remove();
			var data = Object();
			if (!that.parent().find('.archive_load_more').find('.load-more-link').length) {
				data.disable = 'yes';
			}
			var alme_id = '#' + that.attr('data-id_ref');
			jQuery('<div>').load(alme_link + ' ' + alme_id, function() {
				rockthemes_portfolio_ajax_callback_add(that, ds, data, jQuery(jQuery(this).find(alme_id)));
			});
			return;
		}
		jQuery.post(rockthemes.ajaxurl, {
			data: ds,
			_ajax_nonce: rockthemes.nonces.portfolio,
			action: 'rockthemes_portfolio_load_more'
		}, function(data) {
			if (!data || !data.body) {
				that.removeClass('loading');
				return;
			}
			var new_elems = jQuery(data.body);
			rockthemes_portfolio_ajax_callback_add(that, ds, data, new_elems);
		});
	});
}

function rockthemes_portfolio_ajax_callback_add(that, ds, data, new_elems) {
	var holder = jQuery('#' + that.attr('data-id_ref'));
	var animate_active = true;
	if (typeof ds.masonry != 'undefined' && (ds.masonry || ds.masonry == 'true')) {
		holder.append(new_elems);
		holder.imagesLoaded(function() {
			holder.css({
				'width': ''
			});
			holder.parent().css({
				'width': ''
			});
			var col_size = rockthemes_masonry_get_col_size(holder);
			new_elems.filter('.azoom-default-item:not(.widetall):not(.wide)').css('width', (col_size.px) + 'px');
			new_elems.filter('.widetall, .wide').css('width', (col_size.px * 2) + 'px');
			if (jQuery(window).width() <= parseInt(col_size.px * 2) - 30) {
				new_elems.filter('.widetall, .wide').css('width', '');
				new_elems.filter('.azoom-default-item:not(.widetall):not(.wide)').css('width', '');
			}
			holder.masonry('appended', new_elems);
			rockthemes_animate_queue(holder, 'fadeIn');
			jQuery(document).trigger('rockthemes:activate_lightbox');
			that.removeClass('loading');
			if (data.disable && data.disable === 'yes') {
				that.addClass('hide');
			}
		});
		return;
	} else if (animate_active) {
		if (new_elems.find('img').length) {
			new_elems.imagesLoaded(function() {
				holder.append(new_elems);
				rockthemes_animate_queue(holder, 'fadeIn');
				jQuery(document).trigger('rockthemes:activate_lightbox');
				that.removeClass('loading');
				if (data.disable && data.disable === 'yes') {
					that.addClass('hide');
				}
				return;
			});
		} else {
			holder.append(new_elems);
			rockthemes_animate_queue(holder, 'fadeIn');
			jQuery(document).trigger('rockthemes:activate_lightbox');
			that.removeClass('loading');
			if (data.disable && data.disable === 'yes') {
				that.addClass('hide');
			}
			return;
		}
	}
}

function rockthemes_activate_portfolio() {
	jQuery('.azoom-portfolio-container').each(function() {
		var that = jQuery(this);
		if (!that.hasClass('masonry-active') && !that.find('.swiper-container').length) {
			that.imagesLoaded(function() {
				rockthemes_animate_queue(that);
			});
		}
	});
	if (jQuery('.swiper-single-element').length) {
		jQuery('.swiper-single-element').each(function() {
			if (!jQuery(this).parents('.masonry-active').length && !jQuery(this).parents('.azoom-portfolio').length) {
				var jt = jQuery(this);
				var side_arrows = jQuery(this).find('.side-arrow-left').length ? true : false;
				rockthemes_activate_swiper(jQuery(this), side_arrows);
				jQuery(window).smartresize(function() {
					rockthemes_activate_swiper(jt, side_arrows);
				});
			}
		});
	};
	if (jQuery('.swiper-navigation-active').length) {
		jQuery('.swiper-navigation-active').each(function() {
			var that = jQuery(this);
			if (!that.find('.rockthemes-masonry').length) {
				rockthemes_activate_swiper(that);
				jQuery(window).smartresize(function() {
					rockthemes_activate_swiper(that);
				});
			}
		});
		jQuery(document).on('rockthemes:masonry_single_active', function(e, mas) {
			var all_ready = true;
			jQuery('#' + mas).find('.azoom-default-item').each(function() {
				if (!jQuery(this).hasClass('masonry-brick')) {
					all_ready = false;
				}
			});
			if (all_ready) {
				rockthemes_activate_swiper(jQuery('#' + mas));
			}
		});
	}
	if (jQuery('.rockthemes-masonry').length < 1) {
		return;
	}
	jQuery('.rockthemes-masonry').each(function() {
		var that = jQuery(this);
		var selector = that.attr('data-masonry-elem');
		if (typeof selector == 'undefined') return;
		var mo;
		rockthemes_init_single_masonry(that, mo, true, true);
	});
	jQuery(window).smartresize(function() {
		jQuery('.rockthemes-masonry').each(function() {
			var that = jQuery(this);
			var selector = that.attr('data-masonry-elem');
			if (typeof selector == 'undefined') return;
			var mo;
			rockthemes_init_single_masonry(that, mo);
		});
	});
}

function rockthemes_activate_swiper(that, side_arrows) {
	var this_id = '';
	if (typeof that.attr('id') !== 'undefined') {
		this_id = '#' + that.attr('id') + ' ';
	} else if (typeof that.parent().attr('id') !== 'undefined') {
		this_id = '#' + that.parent().attr('id') + ' ';
	}
	if (that.hasClass('azoom-portfolio-container')) {
		if (!that.hasClass('wall-mode-active')) {
			that.css('width', (parseInt(that.width()) + 20) + 'px');
		} else {
			that.css('width', (parseInt(that.width())) + 'px');
		}
	}
	if (that.hasClass('swiper-ready')) {
		if (that.hasClass('swiper-single-element') || !that.find('.rockthemes-masonry').length) {
			that.find('.swiper-container').find('.swiper-slide').css({
				'height': '',
				'width': ''
			});
			that.find('.swiper-wrapper').css({
				'height': '',
				'width': '100%'
			});
		}
		that.find('.swiper-container').data('swiper').resizeFix(true);
		if (that.parents('.rockthemes-unique-grid').length) {
			if (that.parents('.rockthemes-unique-grid[data-rsb-fullscreen="true"]').length) {
				jQuery(document).trigger('rockthemes:resize_rsb_fullscreen_grid', [that.parents('.rockthemes-unique-grid[data-rsb-fullscreen="true"]')]);
			} else if (that.parents('.rockthemes-video-bg').length) {
				rockthemes_fullscreen_bg_video(that.parents('.rockthemes-video-bg'));
			} else if (that.parents('.rockthemes-parallax').length) {
				rockthemes_parallax_bg_image(that.parents('.rockthemes-parallax'));
			} else if (that.parents('.rockthemes-static-bg-image').length) {
				rockthemes_static_bg_image(that.parents('.rockthemes-static-bg-image'));
			}
		}
		return;
	}
	var swiper;
	if (!that.hasClass('swiper-ready')) {
		var swiper_details_obj = {
			mode: 'horizontal',
			calculateHeight: true,
			roundLengths: true,
			grabCursor: false,
			autoResize: false,
			resizeReInit: false,
			moveStartThreshold: 1,
			touchRatio: 1,
			longSwipesRatio: 0.3,
			loop: false,
			pagination: (typeof side_arrows !== 'undefined' && side_arrows == true) ? '' : this_id + '.swiper-pagination',
			centeredSlides: true,
			keyboardControl: true,
			onFirstInit: function() {
				if (that.find('.azoom-animate-queue').length) {
					rockthemes_animate_queue(that);
				}
				that.addClass('swiper-ready');
				if (that.parents('.rockthemes-unique-grid').length) {
					setTimeout(function() {
						if (that.parents('.rockthemes-unique-grid[data-rsb-fullscreen="true"]').length) {
							jQuery(document).trigger('rockthemes:resize_rsb_fullscreen_grid', [that.parents('.rockthemes-unique-grid[data-rsb-fullscreen="true"]')]);
						} else if (that.parents('.rockthemes-video-bg').length) {
							rockthemes_fullscreen_bg_video(that.parents('.rockthemes-video-bg'));
						} else if (that.parents('.rockthemes-parallax').length) {
							rockthemes_parallax_bg_image(that.parents('.rockthemes-parallax'));
						} else if (that.parents('.rockthemes-static-bg-image').length) {
							rockthemes_static_bg_image(that.parents('.rockthemes-static-bg-image'));
						}
					}, 50);
				}
			}
		}
		if (!Modernizr.ismobile) {
			if (typeof that.attr('data-auto-play') !== 'undefined' && that.attr('data-auto-play') === 'true') {
				var auto_play_time = typeof that.attr('data-auto-play-time') !== 'undefined' && that.attr('data-auto-play-time') ? that.attr('data-auto-play-time') : 5000;
				swiper_details_obj.autoplay = parseInt(auto_play_time);
				swiper_details_obj.speed = 1000;
			}
		}
		if (typeof that.attr('data-use-pagination') !== 'undefined' && that.attr('data-use-pagination') === 'true') {
			swiper_details_obj.pagination = this_id + ' .swiper-pagination';
		}
		swiper = that.find('.swiper-container').swiper(swiper_details_obj);
		if (typeof side_arrows !== 'undefined' && side_arrows == true) {
			if (typeof that.attr('data-use-pagination') !== 'undefined' && that.attr('data-use-pagination') === 'true') {} else {
				that.find('.swiper-pagination').remove();
			}
		}
		that.on('click touchend', '.swiper-pagination .swiper-pagination-switch', function() {
			swiper.swipeTo(jQuery(this).index());
		});
		if (that.hasClass('azoom-portfolio-container') || that.parents('.azoom-portfolio-container').length) {
			var main = that.hasClass('azoom-portfolio-container') ? that : that.parents('.azoom-portfolio-container');
			main.on('click touchend', '.swiper-arrow-left', function() {
				swiper.swipePrev();
			});
			main.on('click touchend', '.swiper-arrow-right', function() {
				swiper.swipeNext();
			});
		}
		if (typeof side_arrows !== 'undefined' && side_arrows == true) {
			that.find('.side-arrow-left').click(function(e) {
				e.preventDefault()
				swiper.swipePrev();
			});
			that.find('.side-arrow-right').click(function(e) {
				e.preventDefault()
				swiper.swipeNext();
			});
		}
		jQuery(document).trigger('rockthemes:activate_lightbox');
	}
}

function rockthemes_init_single_masonry(that, mo, load_images, animate) {
	animate = (typeof animate == 'undefined' || !animate) ? false : true;
	that.css({
		'height': ''
	});
	that.parent().css({
		'width': 'auto',
		'position': 'relative',
		'display': 'block'
	});
	if (that.parents('.swiper-slide').length) {
		that.find('.azoom-animate-queue').removeClass('azoom-animate-queue');
		that.parent().css('width', '100%');
	}
	var upto_class = ['.azoom-portfolio-container', '.swiper-slide', '.swiper-wrapper', '.azoom-portfolio-container'];
	for (var u = 0; u < upto_class.length; u++) {
		if (that.parents(upto_class[u]).length) {
			that.parents(upto_class[u]).css({
				'width': '100%'
			});
		}
	}
	var col_size = rockthemes_masonry_get_col_size(that);
	that.parent().css('width', col_size.cd);
	that.find('.azoom-default-item:not(.widetall):not(.wide)').css('width', (col_size.px) + 'px');
	that.find('.widetall, .wide').css('width', (col_size.px * 2) + 'px');
	if (jQuery(window).width() <= parseInt(col_size.px * 2) - 30) {
		that.find('.widetall, .wide').css('width', '');
		that.find('.azoom-default-item:not(.widetall):not(.wide)').css('width', '');
	}
	var selector = that.attr('data-masonry-elem');
	if (that.find('.masonry-brick').length) {}
	var anim = false;
	if (typeof load_images != 'undefined' && load_images) {
		that.imagesLoaded(function() {
			mo = that.masonry({
				itemSelector: '.' + selector,
				transitionDuration: false,
				columnWidth: (col_size.px)
			});
			jQuery(document).trigger('rockthemes:masonry_single_active', [that.parents('.azoom-portfolio-container').attr('id')]);
			if (animate) {
				rockthemes_animate_queue(that, anim);
			}
		});
	} else {
		mo = that.masonry({
			itemSelector: '.' + selector,
			transitionDuration: false,
			columnWidth: (col_size.px)
		});
		jQuery(document).trigger('rockthemes:masonry_single_active', [that.parents('.azoom-portfolio-container').attr('id')]);
		if (animate) {
			rockthemes_animate_queue(that, anim);
		}
	}
}

function rockthemes_animate_queue(that, animation) {
	if (typeof that == 'undefined') return;
	if (typeof animation == 'undefined' || !animation || animation == '') animation = 'fadeIn';
	that.find('.azoom-default-item.azoom-animate-queue').each(function(i) {
		var ref_elem = jQuery(this);
		if (jQuery(this).parents('.swiper-slide').length) {
			jQuery(this).addClass('animated ' + animation).removeClass('azoom-animate-queue');
		} else {
			setTimeout(function() {
				ref_elem.addClass('animated ' + animation).removeClass('azoom-animate-queue');
			}, parseInt(180 * i));
		}
	});
}

function rockthemes_masonry_get_col_size(that) {
	if (typeof that == 'undefined') return 540;
	var tc = 4;
	var ec = that.attr('class').split(' ');
	for (var i = 0; i < ec.length; i++) {
		if (ec[i] == '') {
			ec.splice(i, 1);
		}
	}
	tc = rockthemes_check_class_names(ec, that);
	return {
		px: ((that.outerWidth()) / tc),
		fluid: (100 / tc),
		cols: tc,
		cd: (that.outerWidth())
	};
}

function rockthemes_check_class_names(ar, that) {
	if (typeof ar == 'undefined') return 4;
	var w = jQuery(window);
	var class_name = '';
	if (w.width() > parseInt(rockthemes.grid.block.medium)) {
		class_name = 'large-block-grid-';
	} else if (w.width() >= parseInt(rockthemes.grid.block.small)) {
		class_name = 'medium-block-grid-';
	} else {
		class_name = 'small-block-grid-';
	}
	var col = 4;
	for (var i = 0; i < ar.length; i++) {
		if (ar[i].indexOf(class_name) > -1) {
			col = parseInt(ar[i].trim().replace(class_name, ''));
		}
	}
	return col;
}

function rockthemes_activate_hover() {
	var hover_elems = ['.azoom-default-item .rockthemes-hover', '.single-box-element', '.entry-thumbnail', '.rockthemes-wp-gallery li'];
	var hover_classes = 'hover-active-medium hover-active hover-active-small';
	for (var i = 0; i < hover_elems.length; i++) {
		var that = hover_elems[i];
		jQuery(document).on('mouseenter', that, function() {
			rockthemes_hover_vertical_center(jQuery(this));
			jQuery(this).addClass(rockthemes_get_hover_active_class(jQuery(this)));
		}).on('touchstart', that, function(e) {
			jQuery(this).attr('data-touch-start-y', e.originalEvent.touches[0].pageY);
		}).on('touchend', that, function(e) {
			var tend = e.originalEvent.changedTouches[0].pageY;
			if (typeof jQuery(this).attr('data-touch-start-y') !== 'undefined' && Math.abs(parseInt(jQuery(this).attr('data-touch-start-y')) - tend) < 5) {
				jQuery(this).addClass(rockthemes_get_hover_active_class(jQuery(this)));
				jQuery(this).attr('data-touch-start-y', tend);
			}
		}).on('mouseleave', that, function() {
			jQuery(this).removeClass(rockthemes_get_hover_active_class(jQuery(this)));
		}).on('click', '.hover-mobile-back', function() {}).on('touchend', that + ' .hover-mobile-back', {
			that: that
		}, function(e) {
			e.originalEvent.preventDefault();
			e.stopPropagation();
			var el = jQuery(this).parents(e.data.that);
			el.removeClass(rockthemes_get_hover_active_class(el));
			el.attr('data-touch-start-y', e.originalEvent.changedTouches[0].pageY);
		}).on('touchend', '.small-hover-elem', {
			that: that
		}, function(e) {
			e.preventDefault();
			e.stopPropagation();
			if (typeof jQuery(this).attr('data-link_url') != 'undefined') {
				window.location = jQuery(this).attr('data-link_url');
			}
			var el = jQuery(this).parents(that);
			el.removeClass(rockthemes_get_hover_active_class(el));
			el.attr('data-touch-start-y', e.originalEvent.changedTouches[0].pageY);
		});
	}
}

function rockthemes_hover_vertical_center(res) {
	res.css('padding-top', '');
	var hi = res.find('.hover-item-details-container'),
		th = 0;
	hi.children().each(function() {
		th = th + parseInt(jQuery(this).outerHeight(true));
	});
	th = parseInt((hi.outerHeight() - th) / 2) - 19;
	if (th < 19) th = 19;
	hi.css('padding-top', th + 'px');
}

function rockthemes_get_hover_active_class(that) {
	if (that.find('.rockthemes-hover').length) {
		that = that.find('.rockthemes-hover');
	}
	var large_width = parseInt(rockthemes.hover_details.hover_width_min_large);
	var large_height = parseInt(rockthemes.hover_details.hover_height_min_large);
	var medium_width = parseInt(rockthemes.hover_details.hover_width_min_medium);
	var medium_height = parseInt(rockthemes.hover_details.hover_height_min_medium);
	if (that.find('.woo-grid-hover').length) {
		large_height += 75;
	}
	if (that.parents('.dunder_image').length) {
		medium_height = 140;
	}
	var class_name;
	if ((that.width() * that.height()) >= (large_width * large_height) && that.height() > large_height) {
		class_name = 'hover-active';
	} else if ((that.width() * that.height()) >= (medium_width * medium_height) && that.width() > medium_width && that.height() > medium_height) {
		class_name = 'hover-active-medium hover-active';
	} else {
		class_name = 'hover-active-small';
	}
	return class_name;
}

function rockthemes_responsive_flash() {
	if (jQuery('object[type="application/x-shockwave-flash"]').length < 1) return;
	var flash = [],
		rebuild = setTimeout(function() {
			return;
		}, 10);
	jQuery('object[type="application/x-shockwave-flash"]').each(function() {
		flash.push({
			element: jQuery(this),
			height: jQuery(this).attr('height'),
			width: jQuery(this).attr('width')
		});
	});
	jQuery(window).smartresize(function() {
		clearTimeout(rebuild);
		rebuild = setTimeout(resize_flash, 100);
	});

	function resize_flash() {
		if (flash.length < 1) return;
		jQuery.each(flash, function(i, value) {
			flash[i].element.height(flash[i].element.width() / flash[i].width * flash[i].height);
		});
	}
	resize_flash();
}

function rockthemes_check_bg_videos() {
	if (Modernizr.touch) {
		jQuery('.rockthemes-video-bg').each(function() {
			var that = jQuery(this);
			var img = that.attr('data-video_bg_fallback_url');
			if (typeof img === 'undefined' || img === '') {
				if (that.find('.azoom-iframe-container').length) {
					that.find('.azoom-iframe-container').remove();
				}
				if (that.find('video').length) {
					that.find('video').remove();
				}
				return;
			}
			if (!that.find('iframe').length) {
				if (typeof that.attr('data-rsb-fullscreen') != 'undefined' && that.attr('data-rsb-fullscreen') == 'true') {
					return;
				}
				var ve = that.find('video'),
					th = that.outerHeight(),
					tw = parseInt(ve.width() * th / ve.height()),
					ml = -parseInt((tw - jQuery(window).width()) / 2);
				that.find('video').css({
					'min-height': th + 'px',
					'width': tw + 'px',
					'margin-left': ml + 'px'
				});
			} else {
				that.find('iframe').before('<img src="' + img + '" alt="Video" />');
				that.find('.azoom-iframe-container').css({
					'padding': '0px',
					'height': 'auto',
					'top': ''
				});
				that.find('iframe').remove();
			}
		});
		return;
	}
	jQuery('.azoom-iframe-container.vimeo-video.use-api > iframe').each(function() {
		var iframe = jQuery(this)[0];
		Froogaloop(iframe).addEvent('ready', rockthemes_vimeo_ready);
	});

	function rockthemes_vimeo_ready(player_id) {
		if (jQuery('#' + player_id).length && jQuery('#' + player_id).parents('.not-visible').length) {
			jQuery('#' + player_id).parents('.not-visible').removeClass('not-visible');
		}
		var player = Froogaloop(player_id);
		player.api('setVolume', 0);
	}
	if (jQuery('.azoom-iframe-container.youtube-video.use-api .youtube-video-iframe-holder').length) {
		var tag = document.createElement('script');
		var protocol = window.location.protocol == 'https:' ? 'https' : 'http';
		tag.src = protocol + '://www.youtube.com/iframe_api';
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	}
}

function onYouTubeIframeAPIReady() {
	jQuery('.azoom-iframe-container.youtube-video.use-api .youtube-video-iframe-holder').each(function() {
		var hid = jQuery(this).attr('id');
		var yid = jQuery(this).parents('.azoom-iframe-container').attr('data-youtube-id');
		var player = new YT.Player(hid, {
			playerVars: {
				'autoplay': 1,
				'loop': 1,
				'playlist': yid,
				'modestbranding': 1,
				'controls': 0,
				'showinfo': 0,
				'rel': 0,
				'wmode': 'transparent'
			},
			videoId: yid,
			events: {
				'onReady': rockthemes_youtube_onPlayerReady,
			}
		});
	});
}

function rockthemes_youtube_onPlayerReady(event) {
	event.target.mute();
	rockthemes_check_queue_videos();
}

function rockthemes_get_font_name(font_family) {
	font_family = font_family.toString();
	var font_name = '';
	if (font_family.indexOf("'") > -1) {
		font_name = font_family.match(/\'.*?\'/i);
		if (!font_name[0]) {
			return '';
		}
		font_name = font_name[0].split("'").join("");
	} else if (font_family.indexOf('"') > -1) {
		font_name = font_family.match(/\".*?\"/i);
		if (!font_name[0]) {
			return '';
		}
		font_name = font_name[0].split('"').join('');
	} else {
		return '';
	}
	return font_name;
}

function rockthemes_fullscreen_elements() {
	if (!jQuery('.rockthemes-before-header.intro-effect-slide div[data-rsb-fullscreen="true"], .rockthemes-before-header.intro-effect-slide section[data-rsb-fullscreen="true"]').length) {
		jQuery('.rockthemes-before-header.intro-effect-slide').removeClass('intro-effect-slide');
	}
	var clear_classes = ['.rockthemes-before-header.intro-effect-slide', '.rockthemes-unique-grid', '.static-bg-mask-class', '.bg-image-overlay'];
	for (var s = 0; s < clear_classes.length; s++) {
		var del_style = jQuery(clear_classes[s]);
		if (del_style.length) {
			del_style.css({
				'min-height': '',
				'height': ''
			});
		}
		del_style = null;
	}
	jQuery('div[data-rsb-fullscreen="true"], section[data-rsb-fullscreen="true"]').each(function() {
		var that = jQuery(this);
		rockthemes_rsb_fullscreen(that);
	});
	jQuery(document).on('rockthemes:resize_rsb_fullscreen_grid', function(e, elem) {
		rockthemes_rsb_fullscreen(elem);
		if (elem.hasClass('.rockthemes-video-bg')) {
			rockthemes_fullscreen_bg_video(elem);
		}
		if (elem.hasClass('.rockthemes-parallax')) {
			rockthemes_parallax_bg_image(elem);
		}
		if (elem.hasClass('.rockthemes-static-bg-image')) {
			rockthemes_static_bg_image(elem);
		}
	});
	jQuery('.rockthemes-video-bg[data-rsb-fullscreen="true"]').each(function() {
		var that = jQuery(this);
		var w = jQuery(window);
		if (jQuery(this).find('iframe').length < 1 && jQuery(this).find('video').length < 1) {
			rockthemes.init_queue.fullscreen_bg_videos.push(that);
			return;
		}
		rockthemes_fullscreen_bg_video(that);
	});
	jQuery('.rockthemes-unique-grid.rockthemes-parallax').each(function() {
		rockthemes_parallax_bg_image(jQuery(this));
	});
	jQuery('.rockthemes-unique-grid.rockthemes-static-bg-image').each(function() {
		rockthemes_static_bg_image(jQuery(this));
	});
}

function rockthemes_rsb_fullscreen(that) {
	var w = jQuery(window),
		m = jQuery('#main-container');
	that.css({
		'min-height': '',
		'height': ''
	});
	var that_height = that.outerHeight();
	var e_height = (w.height() > that_height) ? w.height() : 'auto';
	if (jQuery(this).find('.rockthemes-curvy-slider').length && m.width() < 800 && w.height() < 800) {
		that.css({
			'width': '100%',
			'height': 'auto'
		});
	} else {
		that.css({
			'width': m.width(),
			'min-height': e_height
		});
	}
}

function rockthemes_static_bg_image(that) {
	var tile = false;
	if (that.find('.static-bg-mask-class').length < 1) {
		if (that.hasClass("rockthemes-fullwidth-colored")) that.removeClass("rockthemes-fullwidth-colored").attr("style", "");
		if (that.attr('data-image-tile') && that.attr('data-image-tile') === 'tile') {
			tile = true;
		}
		//var vertical_space=that.attr('data-padding')!==''?that.attr('data-padding'):'';var overlay_style=that.attr('data-overlay-color')!==''?that.attr('data-overlay-color'):'';var data_image=window.devicePixelRatio>=2&&typeof that.attr('data-static-bg-image-retina')!=='undefined'?that.attr('data-static-bg-image-retina'):that.attr('data-static-bg-image');var mask='<div class="static-bg-mask-class" style="background:url('+data_image+') '+(!tile?'no-repeat; background-size:100% auto;':'')+'">'+'<div class="bg-image-overlay  '+vertical_space+'" style="'+overlay_style+'"></div>'+'</div>';that.wrapInner(mask);
	}
	if (tile) {
		return;
	}
	var img = {
		w: 1920,
		h: 1080
	};
	if (typeof that.attr('data-image-ratio') != 'undefined' && that.attr('data-image-ratio')) {
		var img_r = that.attr('data-image-ratio').split('_');
		img.w = img_r[0];
		img.h = img_r[1];
	}
	var mask_elem = that.find('.static-bg-mask-class');
	mask_elem.css('height', '');
	mask_elem.find('.bg-image-overlay').css({
		'min-height': ''
	});
	var con = {
		w: that.width(),
		h: that.height()
	};
	var factor = Math.max(con.w / img.w, con.h / img.h);
	var mask_height = typeof that.attr("data-static-mask-height") !== 'undefined' && that.attr("data-static-mask-height") !== '' ? parseInt(that.attr("data-static-mask-height")) : 0;
	mask_height = Math.max(mask_height, that.height());
	mask_elem.find('.bg-image-overlay').css({
		'min-height': mask_height + 'px'
	});
	mask_elem.css({
		'background-size': 'cover',
		'background-position': '0px 50%'
	});
}

function rockthemes_parallax_bg_image(that) {
	var parallax_model = typeof that.attr('data-parallax-model') !== 'undefined' && that.attr('data-parallax-model') !== '' ? that.attr('data-parallax-model') : 'height_specific';
	if (Modernizr.ismobile || jQuery(window).width() > 1920) {
		parallax_model = 'height_specific';
	}
	if (that.find('.parallax-mask-class').length < 1) {
		if (that.hasClass("rockthemes-fullwidth-colored")) that.removeClass("rockthemes-fullwidth-colored").attr("style", "");
		var vertical_space = typeof that.attr('data-parallax-padding') !== 'undefined' && that.attr('data-parallax-padding') !== '' ? that.attr('data-parallax-padding') : '';
		var overlay_style = typeof that.attr('data-overlay-color') !== 'undefined' && that.attr('data-overlay-color') !== '' ? that.attr('data-overlay-color') : '';
		var data_image = window.devicePixelRatio >= 2 && typeof that.attr('data-parallax-bg-image-retina') !== 'undefined' ? that.attr('data-parallax-bg-image-retina') : that.attr('data-parallax-bg-image');
		var mask = '<div class="parallax-mask-class ' + parallax_model + '" style="background-image:url(' + data_image + ') ; ">' + '<div class="bg-image-overlay ' + vertical_space + '" style="' + overlay_style + '">' + '</div>' + '</div>';
		that.wrapInner(mask);
		rockthemes_add_image_size_data(that.find('.parallax-mask-class'));
		if (!Modernizr.ismobile && parallax_model === 'advanced_parallax' && jQuery(window).width() <= 1440) {
			that.find(".parallax-mask-class").parallax("50%", 0.4);
		}
	}
	var img = {
		w: 1920,
		h: 1080
	};
	if (typeof that.attr('data-image-main-width') !== 'undefined' && typeof that.attr('data-image-min-height') !== 'undefined') {
		img.w = parseInt(that.attr('data-image-main-width'));
		img.h = parseInt(that.attr('data-image-main-height'));
	} else if (typeof that.attr('data-image-ratio') != 'undefined' && that.attr('data-image-ratio')) {
		var img_r = that.attr('data-image-ratio').split('_');
		img.w = img_r[0];
		img.h = img_r[1];
	}
	var con = {
		w: that.width(),
		h: jQuery(window).height()
	};
	var mask_elem = that.find('.parallax-mask-class');
	var factor = Math.max(con.w / img.w, con.h / img.h);
	var mask_height = typeof that.attr("data-parallax-mask-height") !== 'undefined' && that.attr("data-parallax-mask-height") !== '' && that.attr("data-parallax-mask-height") ? parseInt(that.attr("data-parallax-mask-height")) : 0;
	mask_elem.css('height', '');
	mask_elem.find('.bg-image-overlay').css({
		'min-height': ''
	});
	if (Modernizr.ismobile) {
		if (con.h < that.height()) {
			factor = (Math.max(con.w / img.w, (that.height()) / img.h));
		}
	}
	mask_height = Math.max(mask_height, that.height());
	mask_elem.find('.bg-image-overlay').css({
		'min-height': mask_height + 'px'
	});
	if (parallax_model !== 'advanced_parallax') {}
}

function rockthemes_add_image_size_data(that) {
	var image_url = that.css('background-image'),
		image;
	image_url = image_url.match(/^url\("?(.+?)"?\)$/);
	if (typeof image_url != 'undefined' && image_url[1]) {
		image_url = image_url[1];
		image = new Image();
		jQuery(image).load(function() {
			that.attr('data-image-main-width', image.width);
			that.attr('data-image-main-height', image.height);
			image = null;
		});
		image.src = image_url;
	}
}

function rockthemes_check_queue_videos() {
	for (var i = 0; i < rockthemes.init_queue.fullscreen_bg_videos.length; i++) {
		rockthemes_fullscreen_bg_video(rockthemes.init_queue.fullscreen_bg_videos[i]);
	}
}

function rockthemes_fullscreen_bg_video(that) {
	var w = {
		width: function() {
			return jQuery(window).width();
		},
		height: function() {
			return (jQuery(window).height() > that.outerHeight() ? jQuery(window).height() : that.outerHeight()) + 15;
		}
	}
	var v;
	var iframe_container = null;
	var user_ratio = {
		w: 16,
		h: 9
	};
	if (typeof that.attr('data-rsb-ratio') != 'undefined' && that.attr('data-rsb-ratio')) {
		var tem = that.attr('data-rsb-ratio').split('_');
		user_ratio = {
			w: parseInt(tem[0]),
			h: parseInt(tem[1])
		};
	}
	if (typeof that.attr('data-html5-video-ratio') != 'undefined' && that.attr('data-html5-video-ratio')) {
		var sem = that.attr('data-html5-video-ratio').split('_');
		user_ratio = {
			w: parseInt(sem[0]),
			h: parseInt(sem[1])
		};
	}
	if (that.find('video').length) {
		v = that.find('video');
		if (typeof that.attr('data-html5-video-ratio') != 'undefined' && that.attr('data-html5-video-ratio')) {} else {
			user_ratio.w = parseInt(v.width());
			user_ratio.h = parseInt(v.height() - 4);
			that.attr('data-html5-video-ratio', user_ratio.w + '_' + user_ratio.h);
		}
	} else {
		v = that.find('iframe');
		iframe_container = that.find('.azoom-iframe-container');
	}
	var r = user_ratio.w / user_ratio.h;
	var wr = w.width() / w.height();
	if (wr > r) {
		if (iframe_container) {
			iframe_container.css({
				'width': w.width() + 'px',
				'height': parseInt(user_ratio.w * w.height() / user_ratio.h) + 'px'
			});
		} else {
			v.css({
				'width': w.width() + 'px',
				'height': parseInt(user_ratio.w / user_ratio.h * w.height()) + 'px'
			});
		}
	} else {
		if (iframe_container) {
			iframe_container.css({
				'width': parseInt(w.height() * user_ratio.w / user_ratio.h) + 'px',
				'height': w.height() + 'px',
				'top': '0px'
			});
		} else {
			v.css({
				'width': parseInt(w.height() * user_ratio.w / user_ratio.h) + 'px',
				'height': w.height() + 'px',
				'top': '0px'
			});
		}
	}
	if (iframe_container) {
		iframe_container.css({
			'left': '0px',
			'top': '0px'
		});
	} else {
		v.css({
			'left': '0px',
			'top': '0px'
		});
	}
	var l_moved = false;
	if (v.width() > w.width()) {
		l_moved = true;
		if (iframe_container) {
			iframe_container.css('left', '-' + (parseInt((v.width() - w.width()) / 2) - 2) + 'px');
		} else {
			v.css('left', '-' + parseInt((v.width() - w.width()) / 2) + 'px');
		}
	}
	if (!l_moved && iframe_container) {
		iframe_container.css('left', '-2px');
	}
	if (v.height() > w.height()) {
		if (iframe_container) {
			iframe_container.css('top', '-' + (parseInt((v.height() - (w.height())) / 2)) + 'px');
		} else {
			v.css('top', '-' + parseInt((v.height() - w.height()) / 2) + 'px');
		}
	}
	that.css({
		'width': w.width(),
		'height': w.height()
	});
	if (typeof v.attr('src') != 'undefined' && v.attr('src') && v.attr('src').toString().indexOf('vimeo') > -1) {
		if (typeof rockthemes.visibility_hidden_elements == 'undefined' || !rockthemes.visibility_hidden_elements) {
			rockthemes.visibility_hidden_elements = new Array();
			rockthemes.visibility_hidden_elements.push(iframe_container);
		}
	}
	that.css({
		'visibility': 'visible'
	});
}

function rockthemes_menu_ajax_woocommerce_cart() {
	if (jQuery('.azoom-undermenu-mask').length < 1) return;
	var underbox_menu_mask = jQuery('.azoom-undermenu-mask');
	var underbox_menu = jQuery('.azoom-undermenu-box');
	var is_box_active = false;
	var display_cart_ar = (typeof rockthemes.woocommerce.auto_display_cart_after_refresh != "undefined" && rockthemes.woocommerce.auto_display_cart_after_refresh == true ? true : false);
	var to_all_button_cover = jQuery('.undermenu-box-button-cover');
	var to_all_button = jQuery('.undermenu-box-button');
	var to_all_button_height = 63 + 10;
	var cart_link_html = '<div class="link-icon azoom-transition-fast">' + '<i class="icomoon icomoon-icon-next15"></i>' + '</div>';
	if (rockthemes.is_rtl == 'rtl') {
		cart_link_html = '<div class="link-icon azoom-transition-fast">' + '<i class="icomoon icomoon-icon-previous11"></i>' + '</div>';
	}
	var cart_datas = [];
	var woo_initialized = false;
	var remove_classes = '';
	for (var r = 0; r < rockthemes.settings.undermenu_box_classes.length; r++) {
		if (rockthemes.settings.undermenu_box_classes[r] != 'woocommerce-cart-active') {
			remove_classes += rockthemes.settings.undermenu_box_classes[r] + ' ';
		}
	}
	jQuery(document).on('click', '.add_to_cart_button', function() {
		var product = null;
		if (jQuery(this).parents('.product:eq(0)').length) {
			product = jQuery(this).parents('.product:eq(0)');
		} else if (jQuery(this).parents('.azoom-default-item').length) {
			product = jQuery(this).parents('.azoom-default-item');
		}
		if (product && product.find('.added_icon').length < 1) {
			product.find('.grid-price').append(' <i class="icomoon icomoon-icon-checkmark animated bounceIn added_icon"></i>');
		}
	});
	var data_timer = setTimeout(data_timer_function, 50);
	var data_timer_max_count = 10,
		data_timer_current_count = 0;

	function data_timer_function() {
		if (jQuery('.azoom-woocommerce-box .cart_list li').length > 0 && typeof jQuery('.azoom-woocommerce-box .cart_list li').html() != "undefined") {
			clearTimeout(data_timer);
			if (!woo_initialized) {
				init_woo_cart();
			}
			get_cart_datas();
		} else {
			clearTimeout(data_timer);
			data_timer_current_count++;
			if (data_timer_current_count < data_timer_max_count) {
				setTimeout(data_timer_function, 50);
			}
		}
	}

	function get_cart_datas() {
		if (jQuery('.azoom-woocommerce-box .cart_list li .ajax-cart-content a .text-overflow').length < 1) {
			cart_datas = [];
			return;
		}
		var cart_item_html = jQuery('.azoom-woocommerce-box .cart_list li');
		cart_datas = [];
		cart_item_html.each(function() {
			var el = jQuery(this).find('.ajax-cart-content').length > 0 ? jQuery(this).find('.ajax-cart-content') : jQuery(this);
			cart_datas.push({
				name: el.find('a .text-overflow').html(),
				quantity: el.find('.quantity').html(),
				link_url: el.find('a').not('.remove').attr('href')
			});
		});
	}

	function return_new_item_in_cart() {
		if (cart_datas.length <= 0) get_cart_datas();
		var el;
		var found = false;
		var cart_item_html = jQuery('.azoom-woocommerce-box-content .cart_list li');
		if (cart_datas.length > 0 && cart_item_html.find('.ajax-cart-content').length) {
			cart_item_html.each(function() {
				if (found) return;
				var that = jQuery(this).find('.ajax-cart-content');
				for (var s = 0; s < cart_datas.length; s++) {
					if (that.find('a .text-overflow').html().trim() == cart_datas[s].name.trim() && that.find('a').not('.remove').attr('href').trim() == cart_datas[s].link_url.trim() && that.find('.quantity').html().trim() != cart_datas[s].quantity.trim()) {
						el = that;
						found = true;
						return;
					}
				}
			});
		}
		if (!found) {
			el = jQuery('.azoom-woocommerce-cart-wrapper.azoom-woocommerce-box .azoom-woocommerce-box-content ul.cart_list li').last().find('.ajax-cart-content');
		}
		get_cart_datas();
		return el;
	}

	function update_woo_cart_contents() {
		if (!woo_initialized) {
			init_woo_cart();
		} else {
			jQuery('.azoom-woocommerce-cart-wrapper.azoom-woocommerce-box .azoom-woocommerce-box-content ul.cart_list').addClass('large-block-grid-3 medium-block-grid-2 small-block-grid-1');
			jQuery('.azoom-woocommerce-cart-wrapper.azoom-woocommerce-box .azoom-woocommerce-box-content ul.cart_list > li').wrapInner('<div class="ajax-cart-content azoom-transition"></div>');
			jQuery('.azoom-woocommerce-cart-wrapper .azoom-woocommerce-box-content ul.cart_list li .ajax-cart-content').each(function() {
				var img = jQuery(this).find('a img');
				var text = jQuery(this).find('a').not('.remove').text();
				var span_el = jQuery(this).find('.quantity');
				jQuery(this).find('a').not('.remove').html(img).append('<span class="text-overflow">' + text + '</span>');
				jQuery(this).find('a').not('.remove').append(span_el).append(cart_link_html);
			});
		}
		var last_item = return_new_item_in_cart();
		update_special_cart_icon_count();
		if (display_cart_ar) {
			var delay_time = 1000;
			if (!is_box_active) {
				jQuery('.special-cart-container').trigger('click');
				delay_time += 600;
			}
			last_item.addClass('ajax-cart-animate-border azoom-transition');
			setTimeout(function() {
				setTimeout(function() {
					if (is_box_active) {
						jQuery('.special-cart-container').trigger('click');
					}
				}, 1500);
				last_item.removeClass('ajax-cart-animate-border');
			}, delay_time);
		}
	}

	function update_special_cart_icon_count() {
		var cart = jQuery('.special-cart-container .display-cart-count');
		var cart_con = jQuery('.special-cart-container');
		var new_val = cart_con.find('.new_value').clone();
		if (cart.find('.cart-current-count.old').length) {}
		cart.append(new_val.html());
		cart.find('.cart-current-count').first().addClass('old animated slideOutUpSmall');
		cart.find('.cart-current-count').last().addClass('animated bounceInUp');
		if (Modernizr.cssanimations) {
			cart.find('.cart-current-count.old').on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function() {
				cart.find('.cart-current-count.old').remove();
			});
		} else {
			cart.find('.cart-current-count.old').remove();
		}
	}

	function init_woo_cart() {
		jQuery('.azoom-woocommerce-cart-wrapper.azoom-woocommerce-box .azoom-woocommerce-box-content ul.cart_list').addClass('large-block-grid-3 medium-block-grid-2 small-block-grid-1');
		jQuery('.azoom-woocommerce-cart-wrapper.azoom-woocommerce-box .azoom-woocommerce-box-content ul.cart_list > li').wrapInner('<div class="ajax-cart-content azoom-transition"></div>');
		jQuery('.azoom-woocommerce-cart-wrapper .azoom-woocommerce-box-content ul.cart_list li .ajax-cart-content').each(function() {
			var img = jQuery(this).find('a img');
			var text = jQuery(this).find('a').not('.remove').text();
			var span_el = jQuery(this).find('.quantity');
			jQuery(this).find('a').not('.remove').html(img).append('<span class="text-overflow">' + text + '</span>');
			jQuery(this).find('a').not('.remove').append(span_el).append(cart_link_html);
		});
		woo_initialized = true;
	}
	if (jQuery(window).width() >= 800 || jQuery(window).height() >= 800) {
		jQuery(document).on('added_to_cart', update_woo_cart_contents);
	}
	if (jQuery('.mobile-cart-holder').length) {
		jQuery(document).on('click', '.mobile-cart-holder', function(e) {
			if (jQuery(this).hasClass('disabled')) {
				e.preventDefault();
				return;
			}
			if (!woo_initialized) {
				init_woo_cart();
			}
			if (jQuery(window).width() > 640) {
				e.preventDefault();
				rockthemes_special_cart_motion();
			}
		});
	}
	jQuery(document).on('click', '.special-cart-container', function(e) {
		if (jQuery(this).hasClass('disabled')) {
			e.preventDefault();
			return;
		}
		if (!woo_initialized) {
			init_woo_cart();
		}
		e.preventDefault();
		rockthemes_special_cart_motion();
	});

	function rockthemes_special_cart_motion() {
		is_box_active = underbox_menu_mask.hasClass('active woocommerce-cart-active') ? true : false;
		var to_all_button_cover = jQuery('.undermenu-box-button-cover');
		if (!is_box_active) {
			if (jQuery('.azoom-woocommerce-box-content li').length) {
				to_all_button_cover.addClass('active');
			} else {
				to_all_button_cover.removeClass('active');
			}
			underbox_menu_mask.removeClass(remove_classes);
			underbox_menu_mask.addClass('active woocommerce-cart-active');
			underbox_menu.addClass('animated slideInDownSmall');
			is_box_active = true;
			underbox_menu_mask.css({
				'height': underbox_menu.height() + to_all_button_height
			});
		} else {
			if (Modernizr.cssanimations) {
				if (underbox_menu.height() + to_all_button_height < 400) {
					underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUpSmall');
				} else {
					underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUp');
				}
				underbox_menu.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', remove_animation_classes);
			} else {
				remove_animation_classes();
			}
		}
	}
	jQuery(document).on('click touchend', '.close-search-icon', function(e) {
		jQuery('.rockthemes-ajax-search-input').blur();
		if (Modernizr.cssanimations) {
			if (underbox_menu.height() + to_all_button_height < 400) {
				underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUpSmall');
			} else {
				underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUp');
			}
			underbox_menu.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', remove_animation_classes);
		} else {
			remove_animation_classes();
		}
	});

	function remove_animation_classes() {
		underbox_menu_mask.removeClass('active woocommerce-cart-active').css('height', '');
		jQuery('.rockthemes-ajax-search-input').val('');
		underbox_menu.removeClass('animated slideOutUpSmall slideOutUp slideInDownSmall');
		underbox_menu.off('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', remove_animation_classes);
		to_all_button_cover.removeClass('active');
		is_box_active = false;
	}
}

function rockthemes_menu_ajax_search() {
	var underbox_menu_mask = jQuery('.azoom-undermenu-mask');
	var underbox_menu = jQuery('.azoom-undermenu-box');
	var is_box_active = false;
	var results_holder = jQuery('.ajax-search-results');
	var to_all_button_cover = jQuery('.undermenu-box-button-cover');
	var to_all_button = jQuery('.search-results-button');
	var to_all_button_height = 63 + 10;
	var remove_classes = '';
	for (var r = 0; r < rockthemes.settings.undermenu_box_classes.length; r++) {
		if (rockthemes.settings.undermenu_box_classes[r] != 'search-box-active') {
			remove_classes += rockthemes.settings.undermenu_box_classes[r] + ' ';
		}
	}
	jQuery(document).on('click', '.special-search-icon', function(e) {
		e.preventDefault();
		is_box_active = underbox_menu_mask.hasClass('active search-box-active') ? true : false;
		if (!is_box_active) {
			if (results_holder.find('li').length) {
				to_all_button_cover.addClass('active');
			} else {
				to_all_button_cover.removeClass('active');
			}
			underbox_menu.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', search_box_animation_ended);
			underbox_menu_mask.removeClass(remove_classes);
			underbox_menu_mask.addClass('active search-box-active');
			underbox_menu.addClass('animated slideInDownSmall');
			underbox_menu_mask.css({
				'height': underbox_menu.height() + to_all_button_height
			});
			is_box_active = true;
		} else {
			jQuery('.rockthemes-ajax-search-input').blur();
			if (Modernizr.cssanimations) {
				if (underbox_menu.height() + to_all_button_height < 400) {
					underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUpSmall');
				} else {
					underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUp');
				}
				underbox_menu.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', remove_animation_classes);
			} else {
				remove_animation_classes();
			}
		}
	})
	jQuery(document).on('click', '.close-search-icon', function(e) {
		jQuery('.rockthemes-ajax-search-input').blur();
		if (Modernizr.cssanimations) {
			if (underbox_menu.height() + to_all_button_height < 400) {
				underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUpSmall');
			} else {
				underbox_menu.removeClass('slideInDownSmall animated').addClass('animated slideOutUp');
			}
			underbox_menu.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', remove_animation_classes);
		} else {
			remove_animation_classes();
		}
	});

	function remove_animation_classes() {
		underbox_menu_mask.removeClass('active search-box-active').css('height', '');
		jQuery('.rockthemes-ajax-search-input').val('');
		results_holder.html('');
		underbox_menu.removeClass('animated slideOutUpSmall slideOutUp slideInDownSmall');
		underbox_menu.off('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', remove_animation_classes);
		to_all_button_cover.removeClass('active');
		is_box_active = false;
	}

	function search_box_animation_ended() {
		underbox_menu.off('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', search_box_animation_ended);
		jQuery('.rockthemes-ajax-search-input').focus();
	}
	var keydown_timer;
	var search_text = '';
	var searching_icon = jQuery('.ajax-loading-icon');
	jQuery(document).on('keydown', '.rockthemes-ajax-search-input', function(e) {
		clearTimeout(keydown_timer);
		keydown_timer = setTimeout(function() {
			search_text = jQuery('.rockthemes-ajax-search-input').val();
			to_all_button.attr('href', rockthemes.home_url + '/?s=' + search_text);
			if (search_text != '' && search_text.length > 1) {
				make_ajax_search(search_text);
			}
		}, 1080);
	});

	function make_ajax_search(text) {
		searching_icon.parents('.azoom-ajax-search-wrapper').addClass('searching');
		jQuery.post(rockthemes.ajaxurl, {
			action: 'rockthemes_ajax_search',
			_ajax_nonce: rockthemes.nonces.asearch,
			search_term: text
		}, function(data) {
			searching_icon.parents('.azoom-ajax-search-wrapper').removeClass('searching');
			results_holder.html(data);
			if (results_holder.find('li').length) {
				to_all_button_cover.addClass('active');
			}
			underbox_menu_mask.stop(true, true).animate({
				'height': underbox_menu.height() + to_all_button_height
			}, 600);
		});
	}
}
jQuery(window).load(function() {
	if (rockthemes.frontend_options.display_inline_nav == 'true' && jQuery('#rockthemes-inline-nav').length) {
		if (Modernizr.touch && (jQuery(window).width() <= 767 || jQuery(window).height() <= 800)) {
			jQuery('#rockthemes-inline-nav').remove();
		} else {
			setTimeout(function() {
				rockthemes_inline_nav();
			}, 1500);
		}
	}
	rockthemes_activate_gototop();
	rockthemes_button_link_inline_navigation();
	if (rockthemes.menu.enable_menu_hash_navigation == 'true') {
		rockthemes_main_nav_inline_links();
	}
	jQuery('.rockthemes-video-bg').each(function() {
		var that = jQuery(this);
		that.find('video[data-autoplay="true"]:in-viewport').do(function() {
			jQuery(this)[0].play();
		});
		jQuery(window).scroll(function() {
			that.find('video[data-autoplay="true"]:in-viewport').do(function() {
				jQuery(this)[0].play();
			});
		});
	});
	rockthemes_activate_portfolio();
	rockthemes_display_not_visible_elements();
	rockthemes_sticky_header_init();
	if (jQuery('.azoom-title-breadcrumbs.rockthemes-parallax').length && Modernizr.ismobile) {}
	rockthemes_activate_lightbox();
	jQuery(document).trigger('rockthemes:mega_menu_resize');
});

function rockthemes_activate_gototop() {
	if (jQuery('#azoom-go-to-top').length < 1) return;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 480) {
			jQuery('#azoom-go-to-top').css({
				'opacity': '1',
				'visibility': 'visible'
			});
		} else {
			jQuery('#azoom-go-to-top').css({
				'opacity': '',
				'visibility': ''
			});
		}
	});
	jQuery('#azoom-go-to-top').click(function() {
		jQuery('body,html').animate({
			scrollTop: 0
		}, 800);
	});
}

function rockthemes_display_not_visible_elements() {
	if (typeof rockthemes.visibility_hidden_elements == 'undefined' || !rockthemes.visibility_hidden_elements) return;
	var els = rockthemes.visibility_hidden_elements;
	for (var i = 0; i < els.length; i++) {
		els[i].css({
			'visibility': 'visible'
		});
		if (els[i].hasClass('not-visible')) {
			els[i].removeClass('not-visible');
		}
	}
}

function rockthemes_button_link_inline_navigation() {
	jQuery('.rockthemes-inline-link').each(function() {
		var that = jQuery(this),
			this_hash = that.attr('href').replace(/.*?\#/, ''),
			wp_nav_height = 0,
			time = 1000;
		if (rockthemes.frontend_options.is_admin_bar_showing) {
			wp_nav_height = jQuery('#wpadminbar').outerHeight();
		}
		that.click(function(e) {
			e.preventDefault();
			if (jQuery('#' + this_hash).length < 1) return;
			var top_val = jQuery('#' + this_hash).offset().top + wp_nav_height;
			top_val = top_val - parseInt(rockthemes.menu.sticky_height);
			jQuery(document).trigger('rockthemes:scroll_events_disable');
			jQuery('html, body').animate({
				'scrollTop': top_val
			}, time, 'easeInOutQuart', function() {
				setTimeout(function() {
					if (history.pushState) {
						history.pushState(null, null, '#' + this_hash);
					} else {
						location.hash = this_hash;
					}
				}, 100);
				jQuery(document).trigger('rockthemes:scroll_events_enable');
			});
		});
	});
}

function rockthemes_main_nav_inline_links() {
	var rtm_nav = jQuery('#rtm-navigation');
	var hash_links = jQuery('#rtm-navigation a, #rnmm li > a').filter(function() {
		return jQuery(this).attr('href').indexOf('#') > -1;
	});
	rockthemes_main_nav_inline_nav_events(hash_links);
	if (hash_links.length < 1) return;
	var init_ended = false;
	var wp_nav_height = 0;
	if (rockthemes.frontend_options.is_admin_bar_showing) {
		wp_nav_height = jQuery('#wpadminbar').outerHeight();
	}
	var moving = false;
	hash_links.click(function(e) {
		moving = true;
		var this_hash = jQuery(this).attr('href').replace(/.*?\#/, '');
		if (jQuery(this).attr('href').charAt(0) == '#' || jQuery(this).attr('href').split('#')[0] == window.location.href.split('#')[0]) {
			e.preventDefault();
		} else {
			return;
		}
		var time = 1000;
		if (rtm_nav.find('li.active').length) {
			time = Math.abs(parseInt(rtm_nav.find('li.active').index()) - jQuery(this).index()) * 1000;
		}
		var top_val = jQuery('#' + this_hash).offset().top - wp_nav_height;
		if (jQuery('.header-sticky-active').length && jQuery('.sticky-header-wrapper').length && jQuery('.sticky-header-wrapper').offset().top < top_val && top_val - rockthemes.menu.sticky_height > 0) {
			top_val = top_val - parseInt(rockthemes.menu.sticky_height);
		}
		if (rtm_nav.find('li.current-menu-item').length) {
			rtm_nav.find('li.current-menu-item').removeClass('current-menu-item');
		}
		if (jQuery('#rnmm li.current-menu-item').length) {
			jQuery('#rnmm li.current-menu-item').removeClass('current-menu-item');
		}
		if (jQuery(this).parents('li').length) {
			jQuery(this).parents('li').addClass('current-menu-item');
		}
		jQuery(document).trigger('rockthemes:scroll_events_disable');
		jQuery('html, body').animate({
			'scrollTop': top_val
		}, time, 'easeInOutQuart', function() {
			setTimeout(function() {
				if (history.pushState) {
					history.pushState(null, null, '#' + this_hash);
				} else {
					location.hash = this_hash;
				}
				moving = false;
			}, 100);
			jQuery(document).trigger('rockthemes:scroll_events_enable');
		});
	});
	var dt;
	jQuery(document).on('rockthemes:in_view_main_nav', function(e, elem, h, li) {
		if (moving) return;
		var _li = rtm_nav.find('#' + li);
		var rd = (_li.index() == 0) ? 0 : 0 + wp_nav_height;
		var top_val = jQuery('#' + h).offset().top;
		var bottom_val = jQuery('#' + h).offset().top + jQuery('#' + h).height();
		if (jQuery('.sticky-header-wrapper').length) {
			top_val = top_val - parseInt(rockthemes.menu.sticky_height);
			bottom_val = bottom_val - parseInt(rockthemes.menu.sticky_height);
		}
		if ((jQuery(window).scrollTop() + wp_nav_height) <= bottom_val && top_val - jQuery(window).scrollTop() <= rd) {
			if (!_li.hasClass('current-menu-item')) {
				rtm_nav.find('li.current-menu-item').removeClass('current-menu-item');
				_li.addClass('current-menu-item');
			}
		}
	});
}

function rockthemes_main_nav_inline_nav_events(elems) {
	elems.each(function() {
		var that = jQuery(this);
		var en = that.attr('href').replace(/.*?\#/, '');
		if (!en.length) return;
		var that_obj = new Object();
		that_obj.data = {
			that: that,
			en: en,
			li: that.parents('li').attr('id')
		}
		rockthemes_main_nav_inline_nav_view_event(that_obj);
		jQuery(window).on('scroll', that_obj.data, rockthemes_main_nav_inline_nav_view_event);
	});
}

function rockthemes_main_nav_inline_nav_view_event(e) {
	jQuery('#' + e.data.en + ':in-viewport').do(function() {
		jQuery(document).trigger('rockthemes:in_view_main_nav', [e.data.that, e.data.en, e.data.li]);
	});
}

function rockthemes_inline_nav() {
	var init_ended = false;
	var wp_nav_height = 0;
	if (rockthemes.frontend_options.is_admin_bar_showing) {
		wp_nav_height = jQuery('#wpadminbar').outerHeight();
	}
	jQuery('#rockthemes-inline-nav li').click(function(e) {
		var this_hash = jQuery(this).attr('id').replace('rin-', '');
		var time = 1000;
		if (jQuery('#rockthemes-inline-nav li.active').length) {
			time = Math.abs(parseInt(jQuery('#rockthemes-inline-nav li.active').index()) - jQuery(this).index()) * 1000;
		}
		var top_val = jQuery('#' + this_hash).offset().top - wp_nav_height;
		if (jQuery('.header-sticky-active').length && jQuery('.sticky-header-wrapper').length && jQuery('.sticky-header-wrapper').offset().top < top_val && top_val - rockthemes.menu.sticky_height > 0) {
			top_val = top_val - parseInt(rockthemes.menu.sticky_height);
		}
		jQuery(document).trigger('rockthemes:scroll_events_disable');
		jQuery('html, body').animate({
			'scrollTop': top_val
		}, time, 'easeInOutQuart', function() {
			setTimeout(function() {
				if (history.pushState) {
					history.pushState(null, null, '#' + this_hash);
				} else {
					location.hash = this_hash;
				}
			}, 100);
			jQuery(document).trigger('rockthemes:scroll_events_enable');
		});
	});
	var dt;
	jQuery(document).on('rockthemes:in_view_nav', function(e, elem, id) {
		if (!init_ended) return;
		var rd = (elem.index() == 0) ? 40 : 10 + wp_nav_height;
		var top_val = jQuery('#' + id).offset().top;
		if (jQuery('.main-header-area').length && jQuery('.main-header-area').offset().top < top_val && top_val - rockthemes.menu.sticky_height > 0) {
			top_val = top_val - parseInt(rockthemes.menu.sticky_height);
		}
		if (top_val - jQuery(window).scrollTop() <= rd) {
			if (!jQuery('#rin-' + id).hasClass('active')) {
				clearTimeout(dt);
				jQuery('#rockthemes-inline-nav li.active').removeClass('active title-active');
				jQuery('#rin-' + id).addClass('active title-active');
				dt = setTimeout(function() {
					jQuery('#rin-' + id).removeClass('title-active');
				}, 1500);
			}
		}
	});
	jQuery('#rockthemes-inline-nav').css('top', parseInt((parseInt(jQuery(window).height() - (jQuery('#rockthemes-inline-nav').height() - 30)) / 2)) + 'px');
	jQuery(window).smartresize(function() {
		jQuery('#rockthemes-inline-nav').css('top', parseInt((parseInt(jQuery(window).height() - (jQuery('#rockthemes-inline-nav').height() - 30)) / 2)) + 'px');
	});
	var inl = jQuery('#rockthemes-inline-nav li').length;
	jQuery(document).on('rockthemes:start_inline_nav', function() {
		jQuery('#rockthemes-inline-nav li.deactive').each(function(i, elem) {
			var that = jQuery(this);
			setTimeout(function() {
				that.removeClass('deactive');
				if ((parseInt(inl) - i) <= 1) {
					init_ended = true;
					dt = setTimeout(function() {
						rockthemes_inline_nav_events(true);
					}, 100);
				}
			}, parseInt(100 * i));
		});
	});
	jQuery(document).on('rockthemes:hide_inline_nav', function() {
		jQuery('#rockthemes-inline-nav li').each(function(i, elem) {
			var that = jQuery(this);
			setTimeout(function() {
				that.addClass('deactive');
				if ((parseInt(inl) - i) <= 1) {
					init_ended = true;
					dt = setTimeout(function() {
						rockthemes_inline_nav_events(false);
					}, 100);
				}
			}, parseInt(100 * i));
		});
	});
	jQuery(document).trigger('rockthemes:start_inline_nav');
}

function rockthemes_inline_nav_events(on_add) {
	on_add = (typeof on_add != 'undefined' && on_add) ? true : false;
	jQuery('#rockthemes-inline-nav li').each(function() {
		var that = jQuery(this);
		var en = that.attr('id').replace('rin-', '');
		if (on_add) {
			var that_obj = new Object();
			that_obj.data = {
				that: that,
				en: en
			}
			rockthemes_inline_nav_view_event(that_obj);
		}
		if (on_add) {
			jQuery(window).on('scroll', {
				that: that,
				en: en
			}, rockthemes_inline_nav_view_event);
		} else {
			jQuery(window).off('scroll', rockthemes_inline_nav_view_event);
		}
	});
	if (on_add) {
		jQuery('#rockthemes-inline-nav').addClass('initialized');
	} else {
		jQuery('#rockthemes-inline-nav.initialized').removeClass('initialized');
	}
}

function rockthemes_inline_nav_view_event(e) {
	jQuery('#' + e.data.en + ':in-viewport').do(function() {
		jQuery(document).trigger('rockthemes:in_view_nav', [e.data.that, e.data.en]);
	});
}

function rockthemes_mobile_menu() {
	if (rockthemes.frontend_options.header_location == 'top_navigation' && (rockthemes.resposivity === 'false' || jQuery('html').hasClass('ie9'))) return;
	var mm = jQuery('#rtm-navigation').clone(true);
	mm.wrapInner('<div id="rockthemes_mobile_menu"></div>');
	mm = mm.find('#rockthemes_mobile_menu').unwrap();
	mm.find('#nav').replaceWith(jQuery('<nav id="rnmm">' + mm.find('#nav').html() + '</nav>'));
	mm.find('.subtitle').remove();
	mm.find('.dismiss-mobile').remove();
	mm.find('.nav-icon').unwrap();
	mm.find('.nav-menu').removeClass('nav-menu');
	mm.find('.rtm-menu').removeClass('rtm-menu');
	mm.find('.columns').removeClass('columns');
	mm.find('.megamenu').removeClass('megamenu');
	mm.find('.regularmenu').removeClass('regularmenu');
	mm.find('.menu-item').removeClass('menu-item');
	mm.find('.dismiss-icon').remove();
	mm.find('.rtm-menu-sticker').remove();
	mm.find('.description').remove();
	mm.find('.rtm-widget').remove();
	mm.find('hr').remove();
	mm.find('*[data-mm-align]').removeAttr('data-mm-align');
	mm.find('*[data-mm-width]').removeAttr('data-mm-width');
	mm.find('.mobile-icon').each(function() {
		if (jQuery(this).parent().parent().hasClass('heading-nav')) {
			jQuery(this).remove();
		} else {
			jQuery(this).parent().prepend('<i class="' + jQuery(this).attr('data-mobile-icon') + '"></i>');
		}
	});
	mm.find('.heading-label.link-disabled').each(function() {
		var tmm = jQuery(this);
		tmm.find('.heading-nav > .azoom-heading-icon').remove();
		tmm.find('.heading-nav > h3').children().unwrap();
		tmm.find('.heading-nav').wrap('<a href="#"></a>');
		tmm.find('.heading-nav').children().unwrap();
	});
	mm.find('.rtm-has-widget h3.widget-title').contents().unwrap();
	for (var i = 1; i < 13; i++) {
		mm.find('.rtm-menu-depth-' + i).removeClass('rtm-menu-depth-' + i);
		mm.find('.large-' + i).removeClass('large-' + i);
		mm.find('.medium-' + i).removeClass('medium-' + i);
		mm.find('.small-' + i).removeClass('small-' + i);
	}
	mm.find('li > ul').each(function() {
		var h2_clone = jQuery(this).parent().find(' > a').clone();
	});
	mm.find('.current-menu-item').addClass('Selected');
	var mm_api;
	var mmenu_settings = {
		offCanvas: {
			position: "left"
		},
		navbar: {
			title: rockthemes.mobile_menu.main_title
		},
		navbars: [],
		slidingSubmenus: true,
	};
	if (rockthemes.frontend_options.header_location === 'side_navigation') {
		mmenu_settings.navbars.push({
			position: 'bottom',
			content: ''
		});
		mmenu_settings.navbars.push({
			position: 'top',
			content: '',
		});
	}
	if (rockthemes.frontend_options.header_location == 'top_navigation') {}
	if (jQuery(window).width() < 1024 || rockthemes.frontend_options.header_location === 'side_navigation') {
		jQuery('body').append(mm);
		jQuery('#rnmm').mmenu(mmenu_settings);
		mm_api = jQuery('#rnmm').data('mmenu');
		jQuery('body').addClass('mobile-menu-added');
		jQuery('#rockthemes_mobile_menu').remove();
	} else {
		jQuery(window).smartresize(function() {
			if (jQuery(window).width() < 1024 && !jQuery('body').hasClass('mobile-menu-added')) {
				jQuery('body').append(mm);
				jQuery('#rnmm').mmenu(mmenu_settings);
				mm_api = jQuery('#rnmm').data('mmenu');
				jQuery('body').addClass('mobile-menu-added');
				jQuery('#rockthemes_mobile_menu').remove();
			}
		});
	}
	if (rockthemes.menu.main_menu_model == 'menu_use_mobile_for_main') {
		jQuery('html').addClass('menu_use_mobile_for_main');
		jQuery('#rtm-navigation').remove();
	}
	if (rockthemes.frontend_options.header_location === 'side_navigation') {
		var h_height = 0;
		var f_height = 0;
		jQuery('html').addClass('side_nav_menu');
		var m_logo = jQuery('.logo-container').clone();
		var m_ht2 = jQuery('.header-top-2').clone();
		m_ht2.removeClass('hide');
		jQuery('.header-all-wrapper').children().each(function() {
			if (jQuery(this).hasClass('azoom-title-breadcrumbs')) return;
			jQuery(this).remove();
		});
		if (jQuery('#rockthemes-inline-nav').length) {
			jQuery('#rockthemes-inline-nav .rockthemes-inline-nav-elem').each(function() {
				if (jQuery('#' + jQuery(this).attr('id').toString().replace('rin-', '')).length < 1) {
					jQuery(this).remove();
				}
			});
		}
		if (m_ht2.hasClass('not-visible')) {
			m_ht2.removeClass('not-visible');
		}
		m_ht2.find('.not-visible').removeClass('not-visible');
		m_ht2.find('.columns').css('width', '100%');
		jQuery('.mm-navbar-top').prepend(m_logo);
		jQuery('.mm-menu .mm-navbar-bottom').append(m_ht2);
		var h_height = jQuery('.mm-navbar-top').height();
		var f_height = jQuery('.mm-navbar-bottom').height();
		var n_height = jQuery('#rnmm').height();
		jQuery('.mm-navbar-top').imagesLoaded(function() {
			rockthemes_mobile_menu_side_resize();
		});
		jQuery('body').append(jQuery('<div id="mobile-menu-list-icon" class="mm-slideout">' + '<span></span>' + '</div>'));
		jQuery(window).resize(function() {
			rockthemes_mobile_menu_side_resize();
			if (typeof mm_api != 'undefined') {
				mm_api.close();
			}
		});
	}
	jQuery(document).on('click touchend', '.mobile-menu-switcher-holder, #mobile-menu-list-icon', function(e) {
		e.preventDefault();
		jQuery(document).trigger('rockthemes:mobile_menu_expand');
		if (typeof mm_api != 'undefined') {
			mm_api.open();
		}
	});
}

function rockthemes_mobile_menu_side_resize() {
	var _h = parseInt(jQuery('.mm-navbar-bottom').height()) + parseInt(jQuery('.mm-navbar-top').height()) + 140;
	if (jQuery('#rnmm').height() < _h) {
		jQuery('.logo-container').css({
			'display': 'none'
		});
	} else if (jQuery('.logo-container').css('display') === 'none') {
		jQuery('.logo-container').css({
			'display': ''
		});
	}
	var h_height = jQuery('.mm-navbar-top').outerHeight(),
		f_height = jQuery('.mm-navbar-bottom').outerHeight(),
		n_height = jQuery('#rnmm').height(),
		list_height = n_height - h_height;
	if (jQuery('.mm-navbar-bottom').length && f_height) {
		list_height = list_height - f_height;
	}
	if (parseInt(jQuery('.mm-navbar-bottom').css('bottom')) !== 0) {
		f_height = f_height + parseInt(jQuery('.mm-navbar-bottom').css('bottom'));
	}
	if (parseInt(jQuery('.mm-navbar-bottom').css('bottom')) !== 0) {
		f_height = f_height + parseInt(jQuery('.mm-navbar-bottom').css('bottom'));
	}
	jQuery('#rnmm > .mm-panel').css({
		'padding': '0px',
		'top': h_height + 'px',
		'height': list_height + 'px'
	});
}

function rockthemes_sticky_header_init() {
	var header = jQuery('.main-header-area');
	if (header.length < 1) return;
	if (!header.hasClass('header-sticky')) return;
	var wp_nav_height = 0;
	if (rockthemes.frontend_options.is_admin_bar_showing) {
		wp_nav_height = jQuery('#wpadminbar').outerHeight();
	}
	header.parents('.sticky-header-wrapper').css('height', header.height() + 'px');
	var starting_point = header.parents('.sticky-header-wrapper').offset();
	if (rockthemes.frontend_options.is_admin_bar_showing) {
		starting_point.top -= wp_nav_height;
	}
	starting_point.bottom = parseInt(starting_point.top + header.parents('.sticky-header-wrapper').height());
	jQuery(document).on('rockthemes:sticky_menu_resize', function() {
		starting_point = header.parents('.sticky-header-wrapper').offset();
		if (rockthemes.frontend_options.is_admin_bar_showing) {
			starting_point.top -= 28;
		}
		starting_point.bottom = parseInt(starting_point.top + header.parents('.sticky-header-wrapper').height());
	});
	jQuery(window).smartresize(function() {
		jQuery(document).trigger('rockthemes:sticky_menu_resize');
	});
	var sticky_active = false;
	var sticky_animated = false;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > starting_point.top) {
			if (!sticky_active) {
				header.addClass('header-sticky-active');
				if (header.parents('.sticky-header-wrapper').length) {
					header.parents('.sticky-header-wrapper').addClass('wrapper-unsticky');
				}
				jQuery('.header-all-wrapper').addClass('sticky-activated');
				sticky_active = true;
			}
			if (jQuery(this).scrollTop() > starting_point.bottom) {
				if (!sticky_animated) {
					sticky_animated = true;
					setTimeout(function() {
						header.addClass('header-sticky-animate');
					}, 30);
				}
			} else if (jQuery(this).scrollTop() <= starting_point.bottom) {
				if (sticky_animated) {
					header.removeClass('header-sticky-animate');
					sticky_animated = false;
				}
			}
		} else if (jQuery(this).scrollTop() <= starting_point.top) {
			if (!sticky_active) return;
			header.removeClass('header-sticky-active');
			if (header.parents('.sticky-header-wrapper').length) {
				header.parents('.sticky-header-wrapper').removeClass('wrapper-unsticky');
			}
			jQuery('.header-all-wrapper').removeClass('sticky-activated');
			sticky_active = false;
			if (!sticky_animated) return;
			if (jQuery(this).scrollTop() <= starting_point.bottom) {
				setTimeout(function() {
					header.removeClass('header-sticky-animate');
					sticky_animated = false;
				}, 20);
			}
		}
	});
}

function rockthemes_multi_bg_colors() {
	if (jQuery('.multi-bg-colors').length < 0) return;
	var spfx = rockthemes.frontend_options.style_prefix,
		value = '',
		is_responsive = jQuery(window).width() >= 800 ? false : true,
		flow = !is_responsive ? 'left' : 'top',
		size_l = '50',
		size_r = '50';
	jQuery('.multi-bg-colors').each(function() {
		var mbg = jQuery(this);
		var mbc = mbg.attr('data-multibg-colors');
		if (typeof mbc == 'undefined') return;
		var mbca = mbc.split(',');
		if (spfx.indexOf('ms') > -1) {
			value = spfx + 'linear-gradient(' + flow + ', ' + mbca[0] + ' ' + size_l + '%, ' + mbca[1] + ' ' + size_r + '%)';
		} else {
			value = spfx + 'linear-gradient(' + flow + ', ' + mbca[0] + ' ' + size_l + '%, ' + mbca[1] + ' ' + size_r + '%)';
		}
		if (is_responsive) {
			mbg.css('background', mbca[0]);
		} else {
			mbg.css('background-image', value);
		}
	});
}
(function($) {
	var $window = $(window);
	var windowHeight = $window.height();
	$window.resize(function() {
		windowHeight = $window.height();
	});
	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		$this.each(function() {
			firstTop = $this.offset().top;
		});
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}

		function update() {
			var pos = $window.scrollTop();
			$this.each(function() {
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}
				var new_pos = Math.round(($this.offset().top - pos) * speedFactor),
					ih_obj = parseInt($this.attr('data-image-main-height'));
				if ((new_pos > 0 && new_pos > ($this.offset().top - pos)) || new_pos + ih_obj < windowHeight) return;
				$this.css('backgroundPosition', xpos + " " + new_pos + "px");
			});
		}
		$window.on('scroll', update).resize(update);
		update();
	};
})(jQuery);
var BrowserDetect = {
	init: function() {
		this.browser = this.searchString(this.dataBrowser) || "Other";
		this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
	},
	searchString: function(data) {
		for (var i = 0; i < data.length; i++) {
			var dataString = data[i].string;
			this.versionSearchString = data[i].subString;
			if (dataString.indexOf(data[i].subString) !== -1) {
				return data[i].identity;
			}
		}
	},
	searchVersion: function(dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index === -1) {
			return;
		}
		var rv = dataString.indexOf("rv:");
		if (this.versionSearchString === "Trident" && rv !== -1) {
			return parseFloat(dataString.substring(rv + 3));
		} else {
			return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
		}
	},
	dataBrowser: [{
		string: navigator.userAgent,
		subString: "Chrome",
		identity: "Chrome"
	}, {
		string: navigator.userAgent,
		subString: "MSIE",
		identity: "Explorer"
	}, {
		string: navigator.userAgent,
		subString: "Trident",
		identity: "Explorer"
	}, {
		string: navigator.userAgent,
		subString: "Firefox",
		identity: "Firefox"
	}, {
		string: navigator.userAgent,
		subString: "Safari",
		identity: "Safari"
	}, {
		string: navigator.userAgent,
		subString: "Opera",
		identity: "Opera"
	}]
};
BrowserDetect.init();
jQuery.fn.rockthemes_svg_control = function() {
	if (!Modernizr) return;
	if (!Modernizr.svg) {
		jQuery('img[src*="svg"].use_svg').attr('src', function() {
			return jQuery(this).attr('src').replace('.svg', '.png');
		});
	}
};
jQuery(document).ready(function() {
	'use strict';

	function rockthemes_mm_init() {
		jQuery('.megamenu').each(function() {
			var padding = 15;
			var position = jQuery(this).offset();
			var container_pos = jQuery('.header-row').offset();
			position.left = position.left - container_pos.left - padding;
			var width = (typeof jQuery(this).attr('data-mm-width') != 'undefined' && jQuery(this).attr('data-mm-width')) ? jQuery(this).attr('data-mm-width') : parseInt(jQuery(this).parents('.header-row').width()) - (2 * padding);
			var align = (typeof jQuery(this).attr('data-mm-align') != 'undefined') ? jQuery(this).attr('data-mm-align') : -position.left;
			var left = 0;
			if (align == 'left') {
				left = 0;
			} else if (align == 'right') {
				left = -parseInt(width) + parseInt(jQuery(this).width());
			} else {
				left = -position.left;
			}
			jQuery(this).find(' > ul').css({
				'width': width,
				'left': left
			});
			var tl = 0;
			jQuery(this).find(' > ul > li').each(function() {
				if (jQuery(this).find('.azoom-swiperslider').length) {
					return;
				}
				tl = Math.max(tl, jQuery(this).height());
			});
			jQuery(this).find(' > ul > li').css({
				'min-height': tl + 'px'
			});
		});
		jQuery('#nav ul.rtm-menu > li, #nav .rtm-menu > ul > li').each(function() {
			var padding = 15;
			var position = jQuery(this).offset();
			var container_pos = jQuery('.header-row').offset();
			position.left = position.left - container_pos.left - padding;
			var this_data_width = jQuery(this).attr('data-mm-width');
			var this_data_align = jQuery(this).attr('data-mm-align');
			if (!this_data_width || !this_data_align) return;
			var width = (typeof jQuery(this).attr('data-mm-width') != 'undefined' && jQuery(this).attr('data-mm-width')) ? jQuery(this).attr('data-mm-width') : parseInt(jQuery(this).parents('.header-row').width()) - (2 * padding);
			var align = (typeof jQuery(this).attr('data-mm-align') != 'undefined') ? jQuery(this).attr('data-mm-align') : -position.left;
			var left = 0;
			if (align == 'left') {
				left = 0;
			} else if (align == 'right') {
				left = -parseInt(width) + parseInt(jQuery(this).width());
			} else {
				left = -position.left;
			}
			jQuery(this).find(' > ul ').css({
				'width': width,
				'left': left
			});
		});
		jQuery('.rtm-menu li').each(function() {
			rockthemes_mm_bg_img_check(jQuery(this));
		});
	}

	function rockthemes_mm_bg_img_check(that) {
		if (that.find('ul').length < 1 || typeof that.attr('data-sub-bg-img') == 'undefined' || that.attr('data-sub-bg-img') == '' || typeof that.attr('data-sub-bg-img-halign') == 'undefined' || that.attr('data-sub-bg-img-halign') == '' || typeof that.attr('data-sub-bg-img-valign') == 'undefined' || that.attr('data-sub-bg-img-valign') == '' || typeof that.attr('data-sub-bg-img-repeat') == 'undefined' || that.attr('data-sub-bg-img-repeat') == '' || typeof that.attr('data-sub-bg-img-width') == 'undefined' || typeof that.attr('data-sub-bg-img-height') == 'undefined') {
			return;
		}
		var img = 'url("' + that.attr('data-sub-bg-img') + '")',
			alignh = that.attr('data-sub-bg-img-halign'),
			alignv = that.attr('data-sub-bg-img-valign'),
			pos = ' ' + alignv + ' ' + alignh + ' ',
			repeat = that.attr('data-sub-bg-img-repeat'),
			width = that.attr('data-sub-bg-img-width'),
			height = that.attr('data-sub-bg-img-height'),
			size = ((width.indexOf('px') > -1 || width.indexOf('%') > -1) ? width : width + 'px') + ' ' + ((height.indexOf('px') > -1 || height.indexOf('%') > -1) ? height : height + 'px');
		that.find(' > ul').css({
			'background-image': img,
			'background-repeat': repeat,
			'background-position': pos,
			'background-size': size
		});
	}
	jQuery(window).on('resize', rockthemes_mm_init);
	jQuery(document).on('rockthemes:mega_menu_resize', rockthemes_mm_init);
	rockthemes_mm_init();
	jQuery(document).trigger('rockthemes:mega_menu_ready');
	if (1 == 1) {
		if (typeof Modernizr != "undefined" && Modernizr.touch) {
			jQuery(document).on('touchend click', '#nav a', function(e) {
				if (jQuery(this).parent().hasClass('menu-item-has-children')) {
					e.preventDefault();
				}
			});
		}
	}
});;
! function(e) {
	function t() {
		e[n].glbl || (r = {
			$wndw: e(window),
			$html: e("html"),
			$body: e("body")
		}, a = {}, i = {}, l = {}, e.each([a, i, l], function(e, t) {
			t.add = function(e) {
				e = e.split(" ");
				for (var n = 0, s = e.length; s > n; n++) t[e[n]] = t.mm(e[n])
			}
		}), a.mm = function(e) {
			return "mm-" + e
		}, a.add("wrapper menu vertical panel nopanel current highest opened subopened navbar hasnavbar title btn prev next first last listview nolistview selected divider spacer hidden fullsubopen"), a.umm = function(e) {
			return "mm-" == e.slice(0, 3) && (e = e.slice(3)), e
		}, i.mm = function(e) {
			return "mm-" + e
		}, i.add("parent sub"), l.mm = function(e) {
			return e + ".mm"
		}, l.add("transitionend webkitTransitionEnd mousedown mouseup touchstart touchmove touchend click keydown"), e[n]._c = a, e[n]._d = i, e[n]._e = l, e[n].glbl = r)
	}
	var n = "mmenu",
		s = "5.2.0";
	if (!e[n]) {
		e[n] = function(e, t, n) {
			this.$menu = e, this._api = ["bind", "init", "update", "setSelected", "getInstance", "openPanel", "closePanel", "closeAllPanels"], this.opts = t, this.conf = n, this.vars = {}, this.cbck = {}, "function" == typeof this.___deprecated && this.___deprecated(), this._initMenu(), this._initAnchors();
			var s = this.$menu.children(this.conf.panelNodetype);
			return this._initAddons(), this.init(s), "function" == typeof this.___debug && this.___debug(), this
		}, e[n].version = s, e[n].addons = {}, e[n].uniqueId = 0, e[n].defaults = {
			extensions: [],
			navbar: {
				title: "Menu",
				titleLink: "panel"
			},
			onClick: {
				setSelected: !0
			},
			slidingSubmenus: !0
		}, e[n].configuration = {
			classNames: {
				panel: "Panel",
				vertical: "Vertical",
				selected: "Selected",
				divider: "Divider",
				spacer: "Spacer"
			},
			clone: !1,
			openingInterval: 25,
			panelNodetype: "ul, ol, div",
			transitionDuration: 400
		}, e[n].prototype = {
			init: function(e) {
				e = e.not("." + a.nopanel), e = this._initPanels(e), this.trigger("init", e), this.trigger("update")
			},
			update: function() {
				this.trigger("update")
			},
			setSelected: function(e) {
				this.$menu.find("." + a.listview).children().removeClass(a.selected), e.addClass(a.selected), this.trigger("setSelected", e)
			},
			openPanel: function(t) {
				var n = t.parent();
				if (n.hasClass(a.vertical)) {
					var s = n.parents("." + a.subopened);
					if (s.length) return this.openPanel(s.first());
					n.addClass(a.opened)
				} else {
					if (t.hasClass(a.current)) return;
					var i = e(this.$menu).children("." + a.panel),
						l = i.filter("." + a.current);
					i.removeClass(a.highest).removeClass(a.current).not(t).not(l).not("." + a.vertical).addClass(a.hidden), t.hasClass(a.opened) ? l.addClass(a.highest).removeClass(a.opened).removeClass(a.subopened) : (t.addClass(a.highest), l.addClass(a.subopened)), t.removeClass(a.hidden).addClass(a.current), setTimeout(function() {
						t.removeClass(a.subopened).addClass(a.opened)
					}, this.conf.openingInterval)
				}
				this.trigger("openPanel", t)
			},
			closePanel: function(e) {
				var t = e.parent();
				t.hasClass(a.vertical) && (t.removeClass(a.opened), this.trigger("closePanel", e))
			},
			closeAllPanels: function() {
				this.$menu.find("." + a.listview).children().removeClass(a.selected).filter("." + a.vertical).removeClass(a.opened);
				var e = this.$menu.children("." + a.panel),
					t = e.first();
				this.$menu.children("." + a.panel).not(t).removeClass(a.subopened).removeClass(a.opened).removeClass(a.current).removeClass(a.highest).addClass(a.hidden), this.openPanel(t)
			},
			togglePanel: function(e) {
				var t = e.parent();
				t.hasClass(a.vertical) && this[t.hasClass(a.opened) ? "closePanel" : "openPanel"](e)
			},
			getInstance: function() {
				return this
			},
			bind: function(e, t) {
				this.cbck[e] = this.cbck[e] || [], this.cbck[e].push(t)
			},
			trigger: function() {
				var e = this,
					t = Array.prototype.slice.call(arguments),
					n = t.shift();
				if (this.cbck[n])
					for (var s = 0, a = this.cbck[n].length; a > s; s++) this.cbck[n][s].apply(e, t)
			},
			_initMenu: function() {
				this.opts.offCanvas && this.conf.clone && (this.$menu = this.$menu.clone(!0), this.$menu.add(this.$menu.find("[id]")).filter("[id]").each(function() {
					e(this).attr("id", a.mm(e(this).attr("id")))
				})), this.$menu.contents().each(function() {
					3 == e(this)[0].nodeType && e(this).remove()
				}), this.$menu.parent().addClass(a.wrapper);
				var t = [a.menu];
				this.opts.slidingSubmenus || t.push(a.vertical), this.opts.extensions = this.opts.extensions.length ? "mm-" + this.opts.extensions.join(" mm-") : "", this.opts.extensions && t.push(this.opts.extensions), this.$menu.addClass(t.join(" "))
			},
			_initPanels: function(t) {
				var n = this;
				this.__findAddBack(t, "ul, ol").not("." + a.nolistview).addClass(a.listview);
				var s = this.__findAddBack(t, "." + a.listview).children();
				this.__refactorClass(s, this.conf.classNames.selected, "selected"), this.__refactorClass(s, this.conf.classNames.divider, "divider"), this.__refactorClass(s, this.conf.classNames.spacer, "spacer"), this.__refactorClass(this.__findAddBack(t, "." + this.conf.classNames.panel), this.conf.classNames.panel, "panel");
				var l = e(),
					r = t.add(t.find("." + a.panel)).add(this.__findAddBack(t, "." + a.listview).children().children(this.conf.panelNodetype)).not("." + a.nopanel);
				this.__refactorClass(r, this.conf.classNames.vertical, "vertical"), this.opts.slidingSubmenus || r.addClass(a.vertical), r.each(function() {
					var t = e(this),
						s = t;
					t.is("ul, ol") ? (t.wrap('<div class="' + a.panel + '" />'), s = t.parent()) : s.addClass(a.panel);
					var i = t.attr("id");
					t.removeAttr("id"), s.attr("id", i || n.__getUniqueId()), t.hasClass(a.vertical) && (t.removeClass(n.conf.classNames.vertical), s.add(s.parent()).addClass(a.vertical)), l = l.add(s);
					var r = s.children().first(),
						d = s.children().last();
					r.is("." + a.listview) && r.addClass(a.first), d.is("." + a.listview) && d.addClass(a.last)
				});
				var d = e("." + a.panel, this.$menu);
				l.each(function() {
					var t = e(this),
						s = t.parent(),
						l = s.children("a, span").first();
					if (s.is("." + a.menu) || (s.data(i.sub, t), t.data(i.parent, s)), !s.children("." + a.next).length && s.parent().is("." + a.listview)) {
						var r = t.attr("id"),
							d = e('<a class="' + a.next + '" href="#' + r + '" data-target="#' + r + '" />').insertBefore(l);
						l.is("span") && d.addClass(a.fullsubopen)
					}
					if (!t.children("." + a.navbar).length && !s.hasClass(a.vertical)) {
						if (s.parent().is("." + a.listview)) var s = s.closest("." + a.panel);
						else var l = s.closest("." + a.panel).find('a[href="#' + t.attr("id") + '"]').first(),
							s = l.closest("." + a.panel);
						var o = e('<div class="' + a.navbar + '" />');
						if (s.length) {
							var r = s.attr("id");
							switch (n.opts.navbar.titleLink) {
								case "anchor":
									_url = l.attr("href");
									break;
								case "panel":
								case "parent":
									_url = "#" + r;
									break;
								case "none":
								default:
									_url = !1
							}
							o.append('<a class="' + a.btn + " " + a.prev + '" href="#' + r + '" data-target="#' + r + '"></a>').append('<a class="' + a.title + '"' + (_url ? ' href="' + _url + '"' : "") + ">" + l.text() + "</a>").prependTo(t), t.addClass(a.hasnavbar)
						} else n.opts.navbar.title && (o.append('<a class="' + a.title + '">' + n.opts.navbar.title + "</a>").prependTo(t), t.addClass(a.hasnavbar))
					}
				});
				var o = this.__findAddBack(t, "." + a.listview).children("." + a.selected).removeClass(a.selected).last().addClass(a.selected);
				o.add(o.parentsUntil("." + a.menu, "li")).filter("." + a.vertical).addClass(a.opened).end().not("." + a.vertical).each(function() {
					e(this).parentsUntil("." + a.menu, "." + a.panel).not("." + a.vertical).first().addClass(a.opened).parentsUntil("." + a.menu, "." + a.panel).not("." + a.vertical).first().addClass(a.opened).addClass(a.subopened)
				}), o.children("." + a.panel).not("." + a.vertical).addClass(a.opened).parentsUntil("." + a.menu, "." + a.panel).not("." + a.vertical).first().addClass(a.opened).addClass(a.subopened);
				var c = d.filter("." + a.opened);
				return c.length || (c = l.first()), c.addClass(a.opened).last().addClass(a.current), l.not("." + a.vertical).not(c.last()).addClass(a.hidden).end().appendTo(this.$menu), l
			},
			_initAnchors: function() {
				var t = this;
				r.$body.on(l.click + "-oncanvas", "a[href]", function(s) {
					var i = e(this),
						l = !1,
						d = t.$menu.find(i).length;
					for (var o in e[n].addons)
						if (l = e[n].addons[o].clickAnchor.call(t, i, d)) break;
					if (!l && d) {
						var c = i.attr("href");
						if (c.length > 1 && "#" == c.slice(0, 1)) {
							var h = e(c, t.$menu);
							h.is("." + a.panel) && (l = !0, t[i.parent().hasClass(a.vertical) ? "togglePanel" : "openPanel"](h))
						}
					}
					if (l && s.preventDefault(), !l && d && i.is("." + a.listview + " > li > a") && !i.is('[rel="external"]') && !i.is('[target="_blank"]')) {
						t.__valueOrFn(t.opts.onClick.setSelected, i) && t.setSelected(e(s.target).parent());
						var u = t.__valueOrFn(t.opts.onClick.preventDefault, i, "#" == c.slice(0, 1));
						u && s.preventDefault(), t.__valueOrFn(t.opts.onClick.blockUI, i, !u) && r.$html.addClass(a.blocking), t.__valueOrFn(t.opts.onClick.close, i, u) && t.close()
					}
				})
			},
			_initAddons: function() {
				for (var t in e[n].addons) e[n].addons[t].add.call(this), e[n].addons[t].add = function() {};
				for (var t in e[n].addons) e[n].addons[t].setup.call(this)
			},
			__api: function() {
				var t = this,
					n = {};
				return e.each(this._api, function() {
					var e = this;
					n[e] = function() {
						var s = t[e].apply(t, arguments);
						return "undefined" == typeof s ? n : s
					}
				}), n
			},
			__valueOrFn: function(e, t, n) {
				return "function" == typeof e ? e.call(t[0]) : "undefined" == typeof e && "undefined" != typeof n ? n : e
			},
			__refactorClass: function(e, t, n) {
				return e.filter("." + t).removeClass(t).addClass(a[n])
			},
			__findAddBack: function(e, t) {
				return e.find(t).add(e.filter(t))
			},
			__filterListItems: function(e) {
				return e.not("." + a.divider).not("." + a.hidden)
			},
			__transitionend: function(e, t, n) {
				var s = !1,
					a = function() {
						s || t.call(e[0]), s = !0
					};
				e.one(l.transitionend, a), e.one(l.webkitTransitionEnd, a), setTimeout(a, 1.1 * n)
			},
			__getUniqueId: function() {
				return a.mm(e[n].uniqueId++)
			}
		}, e.fn[n] = function(s, a) {
			return t(), s = e.extend(!0, {}, e[n].defaults, s), a = e.extend(!0, {}, e[n].configuration, a), this.each(function() {
				var t = e(this);
				if (!t.data(n)) {
					var i = new e[n](t, s, a);
					t.data(n, i.__api())
				}
			})
		}, e[n].support = {
			touch: "ontouchstart" in window || navigator.msMaxTouchPoints
		};
		var a, i, l, r
	}
}(jQuery);
! function(t) {
	var e = "mmenu",
		o = "offCanvas";
	t[e].addons[o] = {
		setup: function() {
			if (this.opts[o]) {
				var n = this.opts[o],
					i = this.conf[o];
				a = t[e].glbl, this._api = t.merge(this._api, ["open", "close", "setPage"]), ("top" == n.position || "bottom" == n.position) && (n.zposition = "front"), "string" != typeof i.pageSelector && (i.pageSelector = "> " + i.pageNodetype), a.$allMenus = (a.$allMenus || t()).add(this.$menu), this.vars.opened = !1;
				var r = [s.offcanvas];
				"left" != n.position && r.push(s.mm(n.position)), "back" != n.zposition && r.push(s.mm(n.zposition)), this.$menu.addClass(r.join(" ")).parent().removeClass(s.wrapper), this.setPage(a.$page), this._initBlocker(), this["_initWindow_" + o](), this.$menu[i.menuInjectMethod + "To"](i.menuWrapperSelector)
			}
		},
		add: function() {
			s = t[e]._c, n = t[e]._d, i = t[e]._e, s.add("offcanvas slideout modal background opening blocker page"), n.add("style"), i.add("resize")
		},
		clickAnchor: function(t) {
			if (!this.opts[o]) return !1;
			var e = this.$menu.attr("id");
			if (e && e.length && (this.conf.clone && (e = s.umm(e)), t.is('[href="#' + e + '"]'))) return this.open(), !0;
			if (a.$page) {
				var e = a.$page.first().attr("id");
				return e && e.length && t.is('[href="#' + e + '"]') ? (this.close(), !0) : !1
			}
		}
	}, t[e].defaults[o] = {
		position: "left",
		zposition: "back",
		modal: !1,
		moveBackground: !0
	}, t[e].configuration[o] = {
		pageNodetype: "div",
		pageSelector: null,
		wrapPageIfNeeded: !0,
		menuWrapperSelector: "body",
		menuInjectMethod: "prepend"
	}, t[e].prototype.open = function() {
		if (!this.vars.opened) {
			var t = this;
			this._openSetup(), setTimeout(function() {
				t._openFinish()
			}, this.conf.openingInterval), this.trigger("open")
		}
	}, t[e].prototype._openSetup = function() {
		var e = this;
		this.closeAllOthers(), a.$page.each(function() {
			t(this).data(n.style, t(this).attr("style") || "")
		}), a.$wndw.trigger(i.resize + "-offcanvas", [!0]);
		var r = [s.opened];
		this.opts[o].modal && r.push(s.modal), this.opts[o].moveBackground && r.push(s.background), "left" != this.opts[o].position && r.push(s.mm(this.opts[o].position)), "back" != this.opts[o].zposition && r.push(s.mm(this.opts[o].zposition)), this.opts.extensions && r.push(this.opts.extensions), a.$html.addClass(r.join(" ")), setTimeout(function() {
			e.vars.opened = !0
		}, this.conf.openingInterval), this.$menu.addClass(s.current + " " + s.opened)
	}, t[e].prototype._openFinish = function() {
		var t = this;
		this.__transitionend(a.$page.first(), function() {
			t.trigger("opened")
		}, this.conf.transitionDuration), a.$html.addClass(s.opening), this.trigger("opening")
	}, t[e].prototype.close = function() {
		if (this.vars.opened) {
			var e = this;
			this.__transitionend(a.$page.first(), function() {
				e.$menu.removeClass(s.current).removeClass(s.opened), a.$html.removeClass(s.opened).removeClass(s.modal).removeClass(s.background).removeClass(s.mm(e.opts[o].position)).removeClass(s.mm(e.opts[o].zposition)), e.opts.extensions && a.$html.removeClass(e.opts.extensions), a.$page.each(function() {
					t(this).attr("style", t(this).data(n.style))
				}), e.vars.opened = !1, e.trigger("closed")
			}, this.conf.transitionDuration), a.$html.removeClass(s.opening), this.trigger("close"), this.trigger("closing")
		}
	}, t[e].prototype.closeAllOthers = function() {
		a.$allMenus.not(this.$menu).each(function() {
			var o = t(this).data(e);
			o && o.close && o.close()
		})
	}, t[e].prototype.setPage = function(e) {
		var n = this,
			i = this.conf[o];
		e && e.length || (e = a.$body.find(i.pageSelector), e.length > 1 && i.wrapPageIfNeeded && (e = e.wrapAll("<" + this.conf[o].pageNodetype + " />").parent())), e.each(function() {
			t(this).attr("id", t(this).attr("id") || n.__getUniqueId())
		}), e.addClass(s.page + " " + s.slideout), a.$page = e, this.trigger("setPage", e)
	}, t[e].prototype["_initWindow_" + o] = function() {
		a.$wndw.off(i.keydown + "-offcanvas").on(i.keydown + "-offcanvas", function(t) {
			return a.$html.hasClass(s.opened) && 9 == t.keyCode ? (t.preventDefault(), !1) : void 0
		});
		var t = 0;
		a.$wndw.off(i.resize + "-offcanvas").on(i.resize + "-offcanvas", function(e, o) {
			if (1 == a.$page.length && (o || a.$html.hasClass(s.opened))) {
				var n = a.$wndw.height();
				(o || n != t) && (t = n, a.$page.css("minHeight", n))
			}
		})
	}, t[e].prototype._initBlocker = function() {
		var e = this;
		a.$blck || (a.$blck = t('<div id="' + s.blocker + '" class="' + s.slideout + '" />')), a.$blck.appendTo(a.$body).off(i.touchstart + "-offcanvas " + i.touchmove + "-offcanvas").on(i.touchstart + "-offcanvas " + i.touchmove + "-offcanvas", function(t) {
			t.preventDefault(), t.stopPropagation(), a.$blck.trigger(i.mousedown + "-offcanvas")
		}).off(i.mousedown + "-offcanvas").on(i.mousedown + "-offcanvas", function(t) {
			t.preventDefault(), a.$html.hasClass(s.modal) || (e.closeAllOthers(), e.close())
		})
	};
	var s, n, i, a
}(jQuery);
! function(t) {
	var e = "mmenu",
		i = "autoHeight";
	t[e].addons[i] = {
		setup: function() {
			if (this.opts.offCanvas) {
				switch (this.opts.offCanvas.position) {
					case "left":
					case "right":
						return
				}
				var n = this,
					o = this.opts[i];
				if (this.conf[i], h = t[e].glbl, "boolean" == typeof o && o && (o = {
						height: "auto"
					}), "object" != typeof o && (o = {}), o = this.opts[i] = t.extend(!0, {}, t[e].defaults[i], o), "auto" == o.height) {
					this.$menu.addClass(s.autoheight);
					var u = function(t) {
						var e = this.$menu.children("." + s.current);
						_top = parseInt(e.css("top"), 10) || 0, _bot = parseInt(e.css("bottom"), 10) || 0, this.$menu.addClass(s.measureheight), t = t || this.$menu.children("." + s.current), t.is("." + s.vertical) && (t = t.parents("." + s.panel).not("." + s.vertical).first()), this.$menu.height(t.outerHeight() + _top + _bot).removeClass(s.measureheight)
					};
					this.bind("update", u), this.bind("openPanel", u), this.bind("closePanel", u), this.bind("open", u), h.$wndw.off(a.resize + "-autoheight").on(a.resize + "-autoheight", function() {
						u.call(n)
					})
				}
			}
		},
		add: function() {
			s = t[e]._c, n = t[e]._d, a = t[e]._e, s.add("autoheight measureheight"), a.add("resize")
		},
		clickAnchor: function() {}
	}, t[e].defaults[i] = {
		height: "default"
	};
	var s, n, a, h
}(jQuery);
! function(o) {
	var t = "mmenu",
		n = "backButton";
	o[t].addons[n] = {
		setup: function() {
			if (this.opts.offCanvas) {
				var i = this,
					e = this.opts[n];
				if (this.conf[n], a = o[t].glbl, "boolean" == typeof e && (e = {
						close: e
					}), "object" != typeof e && (e = {}), e = o.extend(!0, {}, o[t].defaults[n], e), e.close) {
					var c = "#" + i.$menu.attr("id");
					this.bind("opened", function() {
						location.hash != c && history.pushState(null, document.title, c)
					}), o(window).on("popstate", function(o) {
						a.$html.hasClass(s.opened) ? (o.stopPropagation(), i.close()) : location.hash == c && (o.stopPropagation(), i.open())
					})
				}
			}
		},
		add: function() {
			return window.history && window.history.pushState ? (s = o[t]._c, i = o[t]._d, e = o[t]._e, void 0) : (o[t].addons[n].setup = function() {}, void 0)
		},
		clickAnchor: function() {}
	}, o[t].defaults[n] = {
		close: !1
	};
	var s, i, e, a
}(jQuery);
! function(t) {
	var n = "mmenu",
		e = "counters";
	t[n].addons[e] = {
		setup: function() {
			var c = this,
				o = this.opts[e];
			this.conf[e], s = t[n].glbl, "boolean" == typeof o && (o = {
				add: o,
				update: o
			}), "object" != typeof o && (o = {}), o = this.opts[e] = t.extend(!0, {}, t[n].defaults[e], o), this.bind("init", function(n) {
				this.__refactorClass(t("em", n), this.conf.classNames[e].counter, "counter")
			}), o.add && this.bind("init", function(n) {
				n.each(function() {
					var n = t(this).data(a.parent);
					n && (n.children("em." + i.counter).length || n.prepend(t('<em class="' + i.counter + '" />')))
				})
			}), o.update && this.bind("update", function() {
				this.$menu.find("." + i.panel).each(function() {
					var n = t(this),
						e = n.data(a.parent);
					if (e) {
						var s = e.children("em." + i.counter);
						s.length && (n = n.children("." + i.listview), n.length && s.html(c.__filterListItems(n.children()).length))
					}
				})
			})
		},
		add: function() {
			i = t[n]._c, a = t[n]._d, c = t[n]._e, i.add("counter search noresultsmsg")
		},
		clickAnchor: function() {}
	}, t[n].defaults[e] = {
		add: !1,
		update: !1
	}, t[n].configuration.classNames[e] = {
		counter: "Counter"
	};
	var i, a, c, s
}(jQuery);
! function(i) {
	var e = "mmenu",
		s = "dividers";
	i[e].addons[s] = {
		setup: function() {
			var n = this,
				a = this.opts[s];
			if (this.conf[s], l = i[e].glbl, "boolean" == typeof a && (a = {
					add: a,
					fixed: a
				}), "object" != typeof a && (a = {}), a = this.opts[s] = i.extend(!0, {}, i[e].defaults[s], a), this.bind("init", function() {
					this.__refactorClass(i("li", this.$menu), this.conf.classNames[s].collapsed, "collapsed")
				}), a.add && this.bind("init", function(e) {
					switch (a.addTo) {
						case "panels":
							var s = e;
							break;
						default:
							var s = i(a.addTo, this.$menu).filter("." + d.panel)
					}
					i("." + d.divider, s).remove(), s.find("." + d.listview).not("." + d.vertical).each(function() {
						var e = "";
						n.__filterListItems(i(this).children()).each(function() {
							var s = i.trim(i(this).children("a, span").text()).slice(0, 1).toLowerCase();
							s != e && s.length && (e = s, i('<li class="' + d.divider + '">' + s + "</li>").insertBefore(this))
						})
					})
				}), a.collapse && this.bind("init", function(e) {
					i("." + d.divider, e).each(function() {
						var e = i(this),
							s = e.nextUntil("." + d.divider, "." + d.collapsed);
						s.length && (e.children("." + d.subopen).length || (e.wrapInner("<span />"), e.prepend('<a href="#" class="' + d.subopen + " " + d.fullsubopen + '" />')))
					})
				}), a.fixed) {
				var o = function(e) {
					e = e || this.$menu.children("." + d.current);
					var s = e.find("." + d.divider).not("." + d.hidden);
					if (s.length) {
						this.$menu.addClass(d.hasdividers);
						var n = e.scrollTop() || 0,
							t = "";
						e.is(":visible") && e.find("." + d.divider).not("." + d.hidden).each(function() {
							i(this).position().top + n < n + 1 && (t = i(this).text())
						}), this.$fixeddivider.text(t)
					} else this.$menu.removeClass(d.hasdividers)
				};
				this.$fixeddivider = i('<ul class="' + d.listview + " " + d.fixeddivider + '"><li class="' + d.divider + '"></li></ul>').prependTo(this.$menu).children(), this.bind("openPanel", o), this.bind("init", function(e) {
					e.off(t.scroll + "-dividers " + t.touchmove + "-dividers").on(t.scroll + "-dividers " + t.touchmove + "-dividers", function() {
						o.call(n, i(this))
					})
				})
			}
		},
		add: function() {
			d = i[e]._c, n = i[e]._d, t = i[e]._e, d.add("collapsed uncollapsed fixeddivider hasdividers"), t.add("scroll")
		},
		clickAnchor: function(i, e) {
			if (this.opts[s].collapse && e) {
				var n = i.parent();
				if (n.is("." + d.divider)) {
					var t = n.nextUntil("." + d.divider, "." + d.collapsed);
					return n.toggleClass(d.opened), t[n.hasClass(d.opened) ? "addClass" : "removeClass"](d.uncollapsed), !0
				}
			}
			return !1
		}
	}, i[e].defaults[s] = {
		add: !1,
		addTo: "panels",
		fixed: !1,
		collapse: !1
	}, i[e].configuration.classNames[s] = {
		collapsed: "Collapsed"
	};
	var d, n, t, l
}(jQuery);
! function(e) {
	function t(e, t, n) {
		return t > e && (e = t), e > n && (e = n), e
	}
	var n = "mmenu",
		o = "dragOpen";
	e[n].addons[o] = {
		setup: function() {
			if (this.opts.offCanvas) {
				var i = this,
					a = this.opts[o],
					p = this.conf[o];
				if (r = e[n].glbl, "boolean" == typeof a && (a = {
						open: a
					}), "object" != typeof a && (a = {}), a = this.opts[o] = e.extend(!0, {}, e[n].defaults[o], a), a.open) {
					var d, f, c, u, h, l = {},
						m = 0,
						g = !1,
						v = !1,
						w = 0,
						_ = 0;
					switch (this.opts.offCanvas.position) {
						case "left":
						case "right":
							l.events = "panleft panright", l.typeLower = "x", l.typeUpper = "X", v = "width";
							break;
						case "top":
						case "bottom":
							l.events = "panup pandown", l.typeLower = "y", l.typeUpper = "Y", v = "height"
					}
					switch (this.opts.offCanvas.position) {
						case "right":
						case "bottom":
							l.negative = !0, u = function(e) {
								e >= r.$wndw[v]() - a.maxStartPos && (m = 1)
							};
							break;
						default:
							l.negative = !1, u = function(e) {
								e <= a.maxStartPos && (m = 1)
							}
					}
					switch (this.opts.offCanvas.position) {
						case "left":
							l.open_dir = "right", l.close_dir = "left";
							break;
						case "right":
							l.open_dir = "left", l.close_dir = "right";
							break;
						case "top":
							l.open_dir = "down", l.close_dir = "up";
							break;
						case "bottom":
							l.open_dir = "up", l.close_dir = "down"
					}
					switch (this.opts.offCanvas.zposition) {
						case "front":
							h = function() {
								return this.$menu
							};
							break;
						default:
							h = function() {
								return e("." + s.slideout)
							}
					}
					var b = this.__valueOrFn(a.pageNode, this.$menu, r.$page);
					"string" == typeof b && (b = e(b));
					var y = new Hammer(b[0], a.vendors.hammer);
					y.on("panstart", function(e) {
						u(e.center[l.typeLower]), r.$slideOutNodes = h(), g = l.open_dir
					}).on(l.events + " panend", function(e) {
						m > 0 && e.preventDefault()
					}).on(l.events, function(e) {
						if (d = e["delta" + l.typeUpper], l.negative && (d = -d), d != w && (g = d >= w ? l.open_dir : l.close_dir), w = d, w > a.threshold && 1 == m) {
							if (r.$html.hasClass(s.opened)) return;
							m = 2, i._openSetup(), i.trigger("opening"), r.$html.addClass(s.dragging), _ = t(r.$wndw[v]() * p[v].perc, p[v].min, p[v].max)
						}
						2 == m && (f = t(w, 10, _) - ("front" == i.opts.offCanvas.zposition ? _ : 0), l.negative && (f = -f), c = "translate" + l.typeUpper + "(" + f + "px )", r.$slideOutNodes.css({
							"-webkit-transform": "-webkit-" + c,
							transform: c
						}))
					}).on("panend", function() {
						2 == m && (r.$html.removeClass(s.dragging), r.$slideOutNodes.css("transform", ""), i[g == l.open_dir ? "_openFinish" : "close"]()), m = 0
					})
				}
			}
		},
		add: function() {
			return "function" != typeof Hammer || Hammer.VERSION < 2 ? (e[n].addons[o].setup = function() {}, void 0) : (s = e[n]._c, i = e[n]._d, a = e[n]._e, s.add("dragging"), void 0)
		},
		clickAnchor: function() {}
	}, e[n].defaults[o] = {
		open: !1,
		maxStartPos: 100,
		threshold: 50,
		vendors: {
			hammer: {}
		}
	}, e[n].configuration[o] = {
		width: {
			perc: .8,
			min: 140,
			max: 440
		},
		height: {
			perc: .8,
			min: 140,
			max: 880
		}
	};
	var s, i, a, r
}(jQuery);
! function(i) {
	var s = "mmenu",
		n = "fixedElements";
	i[s].addons[n] = {
		setup: function() {
			if (this.opts.offCanvas) {
				this.opts[n], this.conf[n], o = i[s].glbl;
				var a = function(i) {
					var s = this.conf.classNames[n].fixed;
					this.__refactorClass(i.find("." + s), s, "slideout").appendTo(o.$body)
				};
				a.call(this, o.$page), this.bind("setPage", a)
			}
		},
		add: function() {
			a = i[s]._c, t = i[s]._d, e = i[s]._e, a.add("fixed")
		},
		clickAnchor: function() {}
	}, i[s].configuration.classNames[n] = {
		fixed: "Fixed"
	};
	var a, t, e, o
}(jQuery);
! function(n) {
	var a = "mmenu",
		t = "navbars";
	n[a].addons[t] = {
		setup: function() {
			var r = this,
				s = this.opts[t];
			if (this.conf[t], i = n[a].glbl, "undefined" != typeof s) {
				s instanceof Array || (s = [s]);
				var d = {};
				n.each(s, function(i) {
					var c = s[i];
					"boolean" == typeof c && c && (c = {}), "object" != typeof c && (c = {}), "undefined" == typeof c.content && (c.content = ["prev", "title"]), c.content instanceof Array || (c.content = [c.content]), c = n.extend(!0, {}, r.opts.navbar, c);
					var o = c.position;
					"bottom" != o && (o = "top"), d[o] || (d[o] = 0), d[o]++;
					for (var l = n("<div />").addClass(e.navbar).addClass(e.navbar + "-" + o).addClass(e.navbar + "-" + o + "-" + d[o]), h = 0, f = c.content.length; f > h; h++) {
						var v = n[a].addons[t][c.content[h]] || !1;
						v ? v.call(r, l, c) : (v = c.content[h], v instanceof n || (v = n(c.content[h])), v.each(function() {
							l.append(n(this))
						}))
					}
					var u = l.children().not("." + e.btn).length;
					u > 1 && l.addClass(e.navbar + "-" + u), l.children("." + e.btn).length && l.addClass(e.hasbtns), l.prependTo(r.$menu)
				});
				for (var c in d) r.$menu.addClass(e.hasnavbar + "-" + c + "-" + d[c])
			}
		},
		add: function() {
			e = n[a]._c, r = n[a]._d, s = n[a]._e, e.add("close hasbtns")
		},
		clickAnchor: function() {}
	}, n[a].configuration.classNames[t] = {
		panelTitle: "Title",
		panelNext: "Next",
		panelPrev: "Prev"
	};
	var e, r, s, i
}(jQuery),
function(n) {
	var a = "mmenu",
		t = "navbars",
		e = "close";
	n[a].addons[t][e] = function(t) {
		var e = n[a]._c,
			r = n[a].glbl;
		t.append('<a class="' + e.close + " " + e.btn + '" href="#"></a>');
		var s = function(n) {
			t.find("." + e.close).attr("href", "#" + n.attr("id"))
		};
		s.call(this, r.$page), this.bind("setPage", s)
	}
}(jQuery),
function(n) {
	var a = "mmenu",
		t = "navbars",
		e = "next";
	n[a].addons[t][e] = function(e) {
		var r = n[a]._c;
		e.append('<a class="' + r.next + " " + r.btn + '" href="#"></a>');
		var s = function(n) {
			n = n || this.$menu.children("." + r.current);
			var a = e.find("." + r.next),
				s = n.find("." + this.conf.classNames[t].panelNext),
				i = s.attr("href"),
				d = s.html();
			a[i ? "attr" : "removeAttr"]("href", i), a[i || d ? "removeClass" : "addClass"](r.hidden), a.html(d)
		};
		this.bind("openPanel", s), this.bind("init", function() {
			s.call(this)
		})
	}
}(jQuery),
function(n) {
	var a = "mmenu",
		t = "navbars",
		e = "prev";
	n[a].addons[t][e] = function(e) {
		var r = n[a]._c;
		e.append('<a class="' + r.prev + " " + r.btn + '" href="#"></a>'), this.bind("init", function(n) {
			n.removeClass(r.hasnavbar)
		});
		var s = function(n) {
			n = n || this.$menu.children("." + r.current);
			var a = e.find("." + r.prev),
				s = n.find("." + this.conf.classNames[t].panelPrev);
			s.length || (s = n.children("." + r.navbar).children("." + r.prev));
			var i = s.attr("href"),
				d = s.html();
			a[i ? "attr" : "removeAttr"]("href", i), a[i || d ? "removeClass" : "addClass"](r.hidden), a.html(d)
		};
		this.bind("openPanel", s), this.bind("init", function() {
			s.call(this)
		})
	}
}(jQuery),
function(n) {
	var a = "mmenu",
		t = "navbars",
		e = "searchfield";
	n[a].addons[t][e] = function(t) {
		var e = n[a]._c,
			r = n('<div class="' + e.search + '" />').appendTo(t);
		"object" != typeof this.opts.searchfield && (this.opts.searchfield = {}), this.opts.searchfield.add = !0, this.opts.searchfield.addTo = r
	}
}(jQuery),
function(n) {
	var a = "mmenu",
		t = "navbars",
		e = "title";
	n[a].addons[t][e] = function(e, r) {
		var s = n[a]._c;
		e.append('<a class="' + s.title + '"></a>');
		var i = function(n) {
			n = n || this.$menu.children("." + s.current);
			var a = e.find("." + s.title),
				i = n.find("." + this.conf.classNames[t].panelTitle);
			i.length || (i = n.children("." + s.navbar).children("." + s.title));
			var d = i.attr("href"),
				c = i.html() || r.title;
			a[d ? "attr" : "removeAttr"]("href", d), a[d || c ? "removeClass" : "addClass"](s.hidden), a.html(c)
		};
		this.bind("openPanel", i), this.bind("init", function() {
			i.call(this)
		})
	}
}(jQuery);
! function(e) {
	function s(e) {
		switch (e) {
			case 9:
			case 16:
			case 17:
			case 18:
			case 37:
			case 38:
			case 39:
			case 40:
				return !0
		}
		return !1
	}
	var n = "mmenu",
		a = "searchfield";
	e[n].addons[a] = {
		setup: function() {
			var o = this,
				d = this.opts[a],
				c = this.conf[a];
			r = e[n].glbl, "boolean" == typeof d && (d = {
				add: d
			}), "object" != typeof d && (d = {}), d = this.opts[a] = e.extend(!0, {}, e[n].defaults[a], d), this.bind("close", function() {
				this.$menu.find("." + l.search).find("input").blur()
			}), this.bind("init", function(n) {
				if (d.add) {
					switch (d.addTo) {
						case "panels":
							var a = n;
							break;
						default:
							var a = e(d.addTo, this.$menu)
					}
					a.each(function() {
						var s = e(this);
						if (!s.is("." + l.panel) || !s.is("." + l.vertical)) {
							if (!s.children("." + l.search).length) {
								var n = c.form ? "form" : "div",
									a = e("<" + n + ' class="' + l.search + '" />');
								if (c.form && "object" == typeof c.form)
									for (var t in c.form) a.attr(t, c.form[t]);
								a.append('<input placeholder="' + d.placeholder + '" type="text" autocomplete="off" />'), s.hasClass(l.search) ? s.replaceWith(a) : s.prepend(a).addClass(l.hassearch)
							}
							if (d.noResults) {
								var i = s.closest("." + l.panel).length;
								if (i || (s = o.$menu.children("." + l.panel).first()), !s.children("." + l.noresultsmsg).length) {
									var r = s.children("." + l.listview);
									e('<div class="' + l.noresultsmsg + '" />').append(d.noResults)[r.length ? "insertBefore" : "prependTo"](r.length ? r : s)
								}
							}
						}
					}), d.search && e("." + l.search, this.$menu).each(function() {
						var n = e(this),
							a = n.closest("." + l.panel).length;
						if (a) var r = n.closest("." + l.panel),
							c = r;
						else var r = e("." + l.panel, o.$menu),
							c = o.$menu;
						var h = n.children("input"),
							u = o.__findAddBack(r, "." + l.listview).children("li"),
							f = u.filter("." + l.divider),
							p = o.__filterListItems(u),
							v = "> a",
							m = v + ", > span",
							b = function() {
								var s = h.val().toLowerCase();
								r.scrollTop(0), p.add(f).addClass(l.hidden).find("." + l.fullsubopensearch).removeClass(l.fullsubopen).removeClass(l.fullsubopensearch), p.each(function() {
									var n = e(this),
										a = v;
									(d.showTextItems || d.showSubPanels && n.find("." + l.next)) && (a = m), e(a, n).text().toLowerCase().indexOf(s) > -1 && n.add(n.prevAll("." + l.divider).first()).removeClass(l.hidden)
								}), d.showSubPanels && r.each(function() {
									var s = e(this);
									o.__filterListItems(s.find("." + l.listview).children()).each(function() {
										var s = e(this),
											n = s.data(t.sub);
										s.removeClass(l.nosubresults), n && n.find("." + l.listview).children().removeClass(l.hidden)
									})
								}), e(r.get().reverse()).each(function(s) {
									var n = e(this),
										i = n.data(t.parent);
									i && (o.__filterListItems(n.find("." + l.listview).children()).length ? (i.hasClass(l.hidden) && i.children("." + l.next).not("." + l.fullsubopen).addClass(l.fullsubopen).addClass(l.fullsubopensearch), i.removeClass(l.hidden).removeClass(l.nosubresults).prevAll("." + l.divider).first().removeClass(l.hidden)) : a || (n.hasClass(l.opened) && setTimeout(function() {
										o.openPanel(i.closest("." + l.panel))
									}, 1.5 * (s + 1) * o.conf.openingInterval), i.addClass(l.nosubresults)))
								}), c[p.not("." + l.hidden).length ? "removeClass" : "addClass"](l.noresults), this.update()
							};
						h.off(i.keyup + "-searchfield " + i.change + "-searchfield").on(i.keyup + "-searchfield", function(e) {
							s(e.keyCode) || b.call(o)
						}).on(i.change + "-searchfield", function() {
							b.call(o)
						})
					})
				}
			})
		},
		add: function() {
			l = e[n]._c, t = e[n]._d, i = e[n]._e, l.add("search hassearch noresultsmsg noresults nosubresults fullsubopensearch"), i.add("change keyup")
		},
		clickAnchor: function() {}
	}, e[n].defaults[a] = {
		add: !1,
		addTo: "panels",
		search: !0,
		placeholder: "Search",
		noResults: "No results found.",
		showTextItems: !1,
		showSubPanels: !0
	}, e[n].configuration[a] = {
		form: !1
	};
	var l, t, i, r
}(jQuery);
! function(e) {
	var a = "mmenu",
		r = "sectionIndexer";
	e[a].addons[r] = {
		setup: function() {
			var n = this,
				d = this.opts[r];
			this.conf[r], t = e[a].glbl, "boolean" == typeof d && (d = {
				add: d
			}), "object" != typeof d && (d = {}), d = this.opts[r] = e.extend(!0, {}, e[a].defaults[r], d), this.bind("init", function(a) {
				if (d.add) {
					switch (d.addTo) {
						case "panels":
							var r = a;
							break;
						default:
							var r = e(d.addTo, this.$menu).filter("." + i.panel)
					}
					r.find("." + i.divider).closest("." + i.panel).addClass(i.hasindexer)
				}
				if (!this.$indexer && this.$menu.children("." + i.hasindexer).length) {
					this.$indexer = e('<div class="' + i.indexer + '" />').prependTo(this.$menu).append('<a href="#a">a</a><a href="#b">b</a><a href="#c">c</a><a href="#d">d</a><a href="#e">e</a><a href="#f">f</a><a href="#g">g</a><a href="#h">h</a><a href="#i">i</a><a href="#j">j</a><a href="#k">k</a><a href="#l">l</a><a href="#m">m</a><a href="#n">n</a><a href="#o">o</a><a href="#p">p</a><a href="#q">q</a><a href="#r">r</a><a href="#s">s</a><a href="#t">t</a><a href="#u">u</a><a href="#v">v</a><a href="#w">w</a><a href="#x">x</a><a href="#y">y</a><a href="#z">z</a>'), this.$indexer.children().on(s.mouseover + "-searchfield " + i.touchstart + "-searchfield", function() {
						var a = e(this).attr("href").slice(1),
							r = n.$menu.children("." + i.current),
							s = r.find("." + i.listview),
							t = !1,
							d = r.scrollTop(),
							h = s.position().top + parseInt(s.css("margin-top"), 10) + parseInt(s.css("padding-top"), 10) + d;
						r.scrollTop(0), s.children("." + i.divider).not("." + i.hidden).each(function() {
							t === !1 && a == e(this).text().slice(0, 1).toLowerCase() && (t = e(this).position().top + h)
						}), r.scrollTop(t !== !1 ? t : d)
					});
					var t = function(e) {
						n.$menu[(e.hasClass(i.hasindexer) ? "add" : "remove") + "Class"](i.hasindexer)
					};
					this.bind("openPanel", t), t.call(this, this.$menu.children("." + i.current))
				}
			})
		},
		add: function() {
			i = e[a]._c, n = e[a]._d, s = e[a]._e, i.add("indexer hasindexer"), s.add("mouseover touchstart")
		},
		clickAnchor: function(e) {
			return e.parent().is("." + i.indexer) ? !0 : void 0
		}
	}, e[a].defaults[r] = {
		add: !1,
		addTo: "panels"
	};
	var i, n, s, t
}(jQuery);
! function(t) {
	var e = "mmenu",
		c = "toggles";
	t[e].addons[c] = {
		setup: function() {
			var n = this;
			this.opts[c], this.conf[c], l = t[e].glbl, this.bind("init", function(e) {
				this.__refactorClass(t("input", e), this.conf.classNames[c].toggle, "toggle"), this.__refactorClass(t("input", e), this.conf.classNames[c].check, "check"), t("input." + s.toggle + ", input." + s.check, e).each(function() {
					var e = t(this),
						c = e.closest("li"),
						i = e.hasClass(s.toggle) ? "toggle" : "check",
						l = e.attr("id") || n.__getUniqueId();
					c.children('label[for="' + l + '"]').length || (e.attr("id", l), c.prepend(e), t('<label for="' + l + '" class="' + s[i] + '"></label>').insertBefore(c.children("a, span").last()))
				})
			})
		},
		add: function() {
			s = t[e]._c, n = t[e]._d, i = t[e]._e, s.add("toggle check")
		},
		clickAnchor: function() {}
	}, t[e].configuration.classNames[c] = {
		toggle: "Toggle",
		check: "Check"
	};
	var s, n, i, l
}(jQuery);