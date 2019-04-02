(function($) {
"use strict";
var o = $("#nav >li.menu-item.current-menu-item,#nav >li.menu-item.current-menu-parent");
	if (o.length > 0) {
		o.before('<span id="magic-line"></span>');
		var s = o.find(">a"),
			r = o.position().left,
			l = parseInt(s.css("padding-left")),
			c = $("#magic-line");
		c.width(s.width()).css("left", Math.round(l + r)).data("magic-width", c.width()).data("magic-left", c.position().left)
	} else {
		var d = $("#nav >li.menu-item:first-child");
		d.after('<span id="magic-line"></span>');
		var c = $("#magic-line");
		c.data("magic-width", 0)
	}
	var u = parseInt($(".tb-header-menu-inner").outerHeight());
	c.css("bottom", 0), $("#nav>li.menu-item").on({
		mouseenter: function() {
			var t = $(this).find(">a"),
				i = t.width(),
				a = t.parent().position().left,
				n = parseInt(t.css("padding-left"));
			c.data("magic-left") || (c.css("left", Math.round(a + n)), c.data("magic-left", "auto")), c.stop().animate({
				left: Math.round(a + n),
				width: i
			})
		},
		mouseleave: function() {
			c.stop().animate({
				left: c.data("magic-left"),
				width: c.data("magic-width")
			})
		}
	}) 
var EduonlineObj = {
	
	tb_featured_video:function(){
		var _product_video = $('.video-featured-popup');
		if( _product_video.length === 0 ) return;
		 $('[data-toggle="tooltip"]').tooltip();
		var _template = '<div class="tb-overlay-bg"><div class="tb-overlay-container"><div class="tb-overlay-content"><div class="tb-iframe-scaler"><iframe class=" mfp-iframe" =""="" src="//www.youtube.com/embed/VIDEOID?autoplay=1" frameborder="0" allowfullscreen=""></iframe></div></div></div></div>';
		_product_video.on('click', function(e){
			e.preventDefault();
			var id = EduonlineObj.get_video_id( $(this).attr('href') );
			if(  id.length > 0 ){
				_template = _template.replace( 'VIDEOID', id );
				$('body').append(_template).find('.tb-overlay-bg').fadeIn(200);
			}
		});
		EduonlineObj.tb_close_overlay();
	},
	tb_close_overlay: function(){
		$('body').on('click','.tb-overlay-content', function(e){
			e.stopPropagation();
		}).on('click','.tb-overlay-container', function(){
			
			var _parent = $($(this).closest('.tb-overlay-bg'));
			console.log(_parent);
			if( _parent.length ){
				_parent.fadeOut();
			}
		})
	},
	get_video_id:function(url){
		var id = url.match( /^.*?(?:player.|www.)?(?:vimeo\.com|youtu(?:be\.com|\.be))\/(?:video\/|embed\/|watch\?v=)?([A-Za-z0-9._%-]*)(?:\&\S+)?/ );
		return id[1];
	},
	
	
	jws_theme_match_height: function(){
		if( $(window).width() < 768 ) return;
		EduonlineObj._same_height = [$('.match-height'),$('.match-height-2')];

		$.each(EduonlineObj._same_height, function(index, _element){
			if( ! _element || _element.length === 0 ){
				EduonlineObj._same_height.splice(index, 1);
				return;
			}
			_element.matchHeight();
			
		});

		$(window).on('resize', function(){
			if( $(window).width() > 768 && EduonlineObj._same_height && EduonlineObj._same_height.length ){
				$.each(EduonlineObj._same_height, function(index, _element){
					_element.matchHeight();
				});
			}
		});
		
	},

	jws_theme_same_height: function(){
		if( $(window).width() < 768 ) return;
		var _same_height = $('.same-height');
		if( _same_height.length === 0 ) return;
		_same_height.children().matchHeight();
	},
	


	jws_theme_cate_height: function(){
		if( $(window).width() < 768 ) return;
		var _cate_height = $('.ro-category-grid');
		if( _cate_height.length === 0 ) return;
		var _c_height = $('.tb-category-detail').height();
		var _p_height = (_cate_height.height())/ 2;
		
		_cate_height.find('.tb-category-item').css("height", (_cate_height.height())/ 2);
		// _cate_height.find('.tb-category-detail').css("padding-top", ( _p_height - _c_height )/ 2);
	},
	

	jws_theme_course_same_height: function(){
		if( $(window).width() < 768 ) return;
		var _same_height = $('.course-same-height');
		if( _same_height.length === 0 ) return;
		_same_height.find('article').matchHeight();
	},
	
	jws_theme_porfolio_masonry: function(){
		var _masonry = $('.tpl1 .grid-portfolio');
		if( _masonry.length === 0 ) return;
		var _gallery_masonry = _masonry.masonry({
		  // options
		  itemSelector: '.grid-item',
		  // columnWidth: 480,
		  gutter: 0,
		  percentPosition: true
		});

	},
	jws_theme_active_course_cate: function(){
		
		var _course_cate = $('.tb-course-categories ul');
	
		var _btn_active = $('.icon-down');
		if( _btn_active.length === 0 ) return;
		_btn_active.on('click', function(e){
			_course_cate.find('li').removeClass('active');
			_course_cate.find('ul').not($(this).children("ul")).hide();
			var _course_item = $(this).closest('li');
			_course_item.addClass('active');
			_course_item.children("ul").toggle();
		});
	},
	jws_theme_portfolio:function(){
		var _gallery = $('#tb-list-portfolio');
		if( _gallery.length === 0 ) return;
		var loaded = false;
		if( _gallery.find('.grid-portfolio').length > 0 ){
			EduonlineObj._grid = _gallery.find('.grid-portfolio').isotope(
				{
					itemSelector: '.grid-item',
					percentPosition: true,
					//gutter: 30,
					masonry: {
						columnWidth: 270,
						gutter: 30,
					}
				}
			);
			$('.controls-filter').on( 'click', '.filter', function() {
				var filterValue = $(this).data('filter');
				EduonlineObj._grid.isotope({ filter: filterValue });
				$(this).addClass('active').siblings('.filter').removeClass('active');
			});
		};
	},
	
	
	jws_theme_set_stick_bar:function( header_offset ){
		EduonlineObj._header_offset = ( header_offset ) ? header_offset : ( ( EduonlineObj._header_offset ) ? EduonlineObj._header_offset : ( $('.tb-header-wrap .tb-header-menu').length > 0 ) ? $('.tb-header-wrap .tb-header-menu').height() : 0 );
		if( EduonlineObj._header_offset ){
			setTimeout(function(){
				if ($(window).scrollTop() > EduonlineObj._header_offset/2 || ($(window).scrollTop() + $(window).height()) > ($(document).height() - 5) ) {
					$('body').addClass('tb-stick-active');
				} else {
					$('body').removeClass('tb-stick-active');
				}
			}, 500)
			
		}
	},
	
	jws_theme_back_to_top:function(){
		// Back to top btn
		var _jws_theme_back_to_top = $('#jws_theme_back_to_top');
		var _wHei = $(window).height();
		$(document).on('scroll',function () {
			/* back to top */
			var scroll_top = $(window).scrollTop();
			if ( scroll_top < _wHei ) {
				_jws_theme_back_to_top.addClass('no-active').removeClass('active');
			} else {
				_jws_theme_back_to_top.removeClass('no-active').addClass('active');
			}
		});
		_jws_theme_back_to_top.click(function () {
			$("html, body").animate({
				scrollTop: 0
			}, 1500);
		});
	},

	jws_theme_load_filter:function(){
		var _cat_filter = $('.tb-cate-course');
		if( _cat_filter.length === 0 ) return;
		_cat_filter.on('click', 'a', function(e){
			e.preventDefault();
			
			_cat_filter.find('a').removeClass('active');
			$(this).addClass('active');
			var _parent_filter = $(this).closest('.tb-blog-carousel');
			if( _parent_filter.length === 0 ) return;
			var data = {},
				_this = $(this),
				_cat = _this.data('cat');
			if( ! _cat ) return;
			data.args = _parent_filter.find('.tb-filter-param').data('args'),
			data.atts = _parent_filter.find('.tb-filter-param').data('atts');
			data.columns = _parent_filter.find('.tb-filter-param').data('columns');
			
			var _columns = data.columns;
			data.cat = _cat;
			
			_parent_filter.find('.tb-reload').addClass('course-loading');
			EduonlineObj.jws_theme_post( 'load_filter_course', data ).done( function(data){
				data = $.parseJSON( data );
				if(data.content){
					_parent_filter.find('.tb-reload').empty().append(data.content);
				}
				_parent_filter.find('.tb-reload').removeClass('course-loading');
				EduonlineObj.jws_theme_carousel( _columns,'.tb-blog-carousel');
			})
		});
	},
	jws_theme_wrap_carousel: function( _element ){
		if( _element.length === 0 ) return;
		_element.parent().addClass('tb-wrap-carousel');
	},
	
	jws_theme_post: function( action, data ){
		data = {
			'action': 'jws_theme_'+action,
			'data': data
		};
		return $.post( the_ajax_script.ajaxurl, data );
	},
	jws_theme_carousel: function( items, element, p_margin = 30 ,assiged ){
		var _element = $(element+items);

		if( _element.length === 0 && assiged ){
			_element = $(element);
			EduonlineObj.assiged = true;
		}
		if( _element.length === 0 ) return;
		var _carousel_ops = {
			loop:true,
			margin: p_margin,
			navText:['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
			dots:true,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
				},
				768:{
					items: ( items > 2 ) ? ( items - 2 ) : ( items > 1 ) ? ( items - 1) : items,
				},
				992:{
					items: ( items > 1 ) ? ( items - 1 ) : items,
				},
				1200:{
					items:items,
					nav:true,
				}
			}
		};

		var owl = _element.find('.owl-carousel').owlCarousel( _carousel_ops );
		owl.on('mouseenter translated.owl.carousel', function(event) {
		   EduonlineObj.jws_theme_add_end_class( $(this) );
		});

		EduonlineObj.jws_theme_set_pos_owlnav( _element );
		EduonlineObj.jws_theme_wrap_carousel( _element );
	},
	jws_theme_add_end_class: function( _element ){
		_element.find('.owl-item.active').last().addClass('end').siblings('.active').removeClass('end');
	},	
	jws_theme_set_pos_owlnav: function( _element ){
		if( _element.length === 0 ) return;
		_element.on('mouseenter', function(){
			if( ! EduonlineObj.set_pos ){
				var top = _element.find('.tb-image,.tb-thumb').first().height()/2;
				
				EduonlineObj.set_pos = true;
			}
		})

	},
	jws_theme_slider: function( _element, options ){
		// var _collection_slider = $('#colection_slider');
		options = $.extend( {
			pagination: '.swiper-pagination',
			paginationClickable: true
		}, options );
		var swiper = new Swiper(_element, options);
	},

	jws_theme_owl_carousel: function(){
		// setTimeout(function(){
			$('.vc_images_carousel').each(function(){
				var _this = $(this),
					items = _this.data('per-view'),
					show_nav = ! _this.data('hide-nav');
					_this.find('.vc_carousel-slideline-inner').owlCarousel({
					items:items,
					loop:true,
					margin:30,
					navText:['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					dots:false,
					responsiveClass:true,
					responsive:{
						0:{
							items:(2 < items) ? 2 : items,
						},
						768:{
							items:(3 < items) ? 3 : items,
						},
						992:{
							items:( 4 < items) ? 4 : items,
							nav:show_nav
						},
						1200:{
							items:items,
							nav:show_nav,
						}
					}
				});
			});
		// }, 1000);
	},
	jws_theme_incremental: function(){
		var _increment = $('.tb-counter');
		if( _increment.length === 0 ) return;
			_increment.each( function(){
				$(this).find('.counter').counterUp({
					delay: 10,
					time: 1000
				});
		})
	},
	jws_theme_disabled_on_mobile: function(){
		if( ! window.jws_theme_is_mobile_tablet ) return;
		$('.product').on('click', '.tb-image', function(e){
			e.preventDefault();
		})
	},

	jws_theme_search_active: function(){
	
		var _search = $('.icon_search_wrap');
		if( _search.length === 0 ) return;
		_search.on('click', function(){
			$(this).next('.box-overlay').addClass('active');
			$(this).next('.box-overlay').find('input:text').focus();
			$(this).next('form').toggleClass('active');
			$(this).next('form').find('input:text').focus();
		});
		$('.box-overlay form').on('click',function(e){
			e.stopPropagation();
		});
		$('.box-overlay').on('click',function(e){
			$(this).removeClass('active');
		});
		
		$('body').on('click','.widget_searchform_content', function(e){
				e.stopPropagation();
			}).on('click',function(e){
			$('.widget_searchform_content form').removeClass('active');
		});
		
	},
	

	jws_theme_close_overlay: function(){
		$('body').on('click','.tb-overlay-content', function(e){
			e.stopPropagation();
		}).on('click','.tb-overlay-container', function(){
			$(this).parent().fadeOut( function(){
				$(this).remove();
			});
		})
	},
	get_video_id:function(url){
		var id = url.match( /^.*?(?:player.|www.)?(?:vimeo\.com|youtu(?:be\.com|\.be))\/(?:video\/|embed\/|watch\?v=)?([A-Za-z0-9._%-]*)(?:\&\S+)?/ );
		return id[1];
	},

	jws_theme_detect_ie: function(){
		var ua = window.navigator.userAgent;

		var msie = ua.indexOf('MSIE ');
		if (msie > 0) {
			// IE 10 or older => return version number
			return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		}

		var trident = ua.indexOf('Trident/');
		if (trident > 0) {
			// IE 11 => return version number
			var rv = ua.indexOf('rv:');
			return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
		}

		var edge = ua.indexOf('Edge/');
		if (edge > 0) {
		   // Edge (IE 12+) => return version number
		   return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
		}

		// other browser
		return false;
	},
	
	jws_theme_sloved_testimonial:function(){
		var _testimonial_top = $('.tb-testimonial-1.tpl');
		if( _testimonial_top.length === 0 ) return;
		_testimonial_top.parent().parent().addClass('ct-testimonial');
	},

	jws_theme_run_ready:function(){
		// lightbox
		EduonlineObj.tb_featured_video();
		EduonlineObj.jws_theme_portfolio();
		EduonlineObj.jws_theme_active_course_cate();
		EduonlineObj.jws_theme_porfolio_masonry();
		EduonlineObj.jws_theme_load_filter();
		EduonlineObj.jws_theme_carousel( 4, '.tb-category-carousel', 0);
		EduonlineObj.jws_theme_carousel( 4, '.tb-blog-carousel');
		EduonlineObj.jws_theme_carousel( 2, '.tb-blog-carousel' );
		EduonlineObj.jws_theme_carousel( 3, '.tb-blog-carousel' );
		EduonlineObj.jws_theme_carousel( 1, '.tb-blog-carousel' );
		EduonlineObj.jws_theme_incremental();
		EduonlineObj.jws_theme_back_to_top();
		EduonlineObj.jws_theme_disabled_on_mobile();
		EduonlineObj.jws_theme_search_active();
		EduonlineObj.jws_theme_sloved_testimonial();
		EduonlineObj.jws_theme_match_height();
		EduonlineObj.jws_theme_same_height();
		EduonlineObj.jws_theme_cate_height();
		EduonlineObj.jws_theme_course_same_height();
		EduonlineObj.jws_theme_owl_carousel();
		EduonlineObj.tb_close_overlay();
		if( EduonlineObj.jws_theme_detect_ie() ){
			$('html').addClass('ie');
		}
	}
};

$(document).ready(function() {
	// tooltip
	EduonlineObj.jws_theme_run_ready();

	function ROtesttimonialSlider($elem) {
		if ($elem.length) {
			$elem.each( function() {
				$(this).flexslider({
					animation: "slide",
					animationLoop: false,
					controlNav: false,
					slideshow: true,
					directionNav: true,
					prevText:'<i class="fa fa-angle-left"></i>',
					nextText:'<i class="fa fa-angle-right"></i>'
				});
			});
		}
	}
	ROtesttimonialSlider($('.tb-testimonial-1'));
	ROtesttimonialSlider($('#colection_slider'));
	$('.tb-portfolio-flexslider').flexslider({
		animation: "slide",
		animationLoop: true,
		controlNav: false,
		slideshow: true,
		directionNav: true,
		prevText:'<i class="fa fa-angle-left"></i>',
		nextText:'<i class="fa fa-angle-right"></i>'
	});

	
	//countdown
	var $tb_countdown_js = $('.jws-countdown-js');
	if($tb_countdown_js.length > 0){
		$tb_countdown_js.each(function(){
			var $this = $(this),
				dateEnd = $this.data('countdown');
			console.log(dateEnd);
			$this.countdown(dateEnd, function(event){
				var $this = $(this).html(event.strftime(''
				+ '<span class="jws-box-countdown"><span>%D</span> <p>days</p></span> '
				+ '<span class="jws-box-countdown"><span>%H</span> <p>hours</p></span> '
				+ '<span class="jws-box-countdown"><span>%M</span> <p>min.</p></span> '
				+ '<span class="jws-box-countdown"><span>%S</span> <p>sec.</p></span>'));
			});
		})
	}
	
	var _jws_theme_course_item = $('.jws_courses');
	if($('.jws_courses_item').length > 0){
		$('.jws_courses_item').hover(function (e) {
				e.preventDefault();
				_jws_theme_course_item.find(".jws_courses_item_active").removeClass('jws_courses_item_active');
				$(this.closest('.jws_courses_item_inner')).addClass('jws_courses_item_active');
		});
	}
	/* Btn menu click */
	$('.tb-menu-control-mobi a').click(function(){
		$('.tb-menu-mobi-list').toggleClass('active');
		$('body').toggleClass('menu-mobi-open');		
	});
	$('body').on('click', function(){
		if( $(this).hasClass('menu-mobi-open')){
			$('.tb-menu-mobi-list').toggleClass('active');
			$(this).toggleClass('menu-mobi-open');
		}
	});

	$('.jws_theme_menu_mobi,.tb-menu-control-mobi').on('click', function(e){
		e.stopPropagation();
	});

	
	

	$('#box-style-inline-css').each(function(){
		var $this = $(this);
		var t = $this.text();
		$this.html(t.replace('&lt','<').replace('&gt', '>'));
	});
	/*Header stick*/
	function ROHeaderStick() {
		if( $('.tb-header-menu').length > 0 ){
			if($( '.tb-header-wrap' ).hasClass( 'tb-header-stick' )) {

				EduonlineObj.jws_theme_set_stick_bar();

				$(window).on('scroll load resize', function() {
					EduonlineObj.jws_theme_set_stick_bar();
				});
			}
		}
		
	}
	ROHeaderStick();
	var jwsAnimation = {};
	jwsAnimation.slideUp = function(elem, timer) {
		dynamics.css(
			elem, {
				translateX: 20,
				opacity: 0,
				//scale: .3
			})
		dynamics.animate(
			elem, {
				translateX: 0,
				opacity: 1,
				//scale: 1
			}, {
				type: dynamics.spring,
				duration: 656,
				frequency: 166,
				friction: 155,
				delay: timer,
				complete: function() {
					$(elem).css('transform', 'none')
				}
			});
	}
	jwsAnimation.slideDown = function(elem, timer) {
		dynamics.css(
			elem, {
				translateX: 0,
				opacity: 1
			})
		dynamics.animate(
			elem, {
				translateX: 20,
				opacity: 0
			}, {
				type: dynamics.spring,
				duration: 656,
				frequency: 166,
				friction: 155,
				delay: timer,
				complete: function() {
					$(elem).css('transform', 'none')
				}
			});
	}
	
	function OpenTheHideMenu() {
		var _canval_menu = $('.tb-canval-menu');
		if (_canval_menu.length) {
			_canval_menu.on('click', function() {
				var $menu = $(this).prev();
				$(this).toggleClass('active');
				$menu.toggleClass('active');
				$menu.closest('.mre-sty-header').toggleClass('active');
				$menu.on({
					'menu.open': function(e) {
						var $li_items = $(this).find('> ul > li');
						$li_items.each(function() {
							var index = $(this).index();
							jwsAnimation.slideUp(this, index * 80);
						})
					},
					'menu.hidden': function(e) {
						var $li_items = $(this).find('> ul > li');
						$li_items.each(function() {
							var index = $(this).index();
							jwsAnimation.slideDown(this, index * 80);
						})
					}
				})
				if ($menu.hasClass('active'))
					$menu.trigger('menu.open')
				else
					$menu.trigger('menu.hidden')
			});
		}
	}
	OpenTheHideMenu(); 

});

window.addEventListener ? 
window.addEventListener("load",jws_theme_onload_func,false) : 
window.attachEvent && window.attachEvent("onload",jws_theme_onload_func);

function jws_theme_onload_func(){

	$('.wpb_tabs').each(function(){
		var wpb_tabs_nav = $(this).find('.wpb_tabs_nav'),
			active_num = wpb_tabs_nav.data('active-tab');
		wpb_tabs_nav.find('li').eq(parseInt(active_num) - 1).trigger('click');
	})
	
	//setTimeout(function(){
		var $wpb_accordion = $('.wpb_accordion');
		if($wpb_accordion.length > 0 && $.fn.niceScroll !== undefined){
			$wpb_accordion.each(function(){
				$(this).find('.wpb_accordion_section').each(function(){
					$(this).css({display: 'block'});
					var nice = $(this).find('.wpb_accordion_content').niceScroll();
				})
			})
		}
	//}, 10)
	
	var $nice_scroll_class_js = $('.nice-scroll-class-js');
	if($nice_scroll_class_js.length > 0 && $.fn.niceScroll !== undefined){
		$nice_scroll_class_js.each(function(){
			$(this).niceScroll();
		})
	}
}
})(window.jQuery)