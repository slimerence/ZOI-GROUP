!(function($){
	$(function(){
		var $pagination_blog_ajax = $('.pagination.ajax');
		$pagination_blog_ajax.each(function(){
			
			var $pagination = $(this);
			
			$pagination.on('click', 'a', function(e){
				e.preventDefault();
				var next_page = $(this).data('next-page'),
					max_page = $(this).data('max-page'),
					params = $(this).data('params');
				
				$pagination.addClass('blog-more-ajax-loading');
				$.ajax({
					type: "POST",
					url: variable_js.ajax_url,
					data: {action: 'render_blog_list', paged: next_page, params: params},
					success: function(data){
						$pagination.removeClass('blog-more-ajax-loading');
						$pagination.before(data);

						if(next_page >= max_page){
							$pagination.find('a').fadeOut('slow');
						}else{
							$pagination.find('a').data('next-page',next_page+1);
						}
						var _template = '<div class="tb-overlay-bg"><div class="tb-overlay-container"><div class="tb-overlay-content content-lightbox"><div class="portfolio-lightbox"><img class="img-responsive" src="IMGURL"><button title="Close (Esc)" type="button" class="tb-close"><i class="fa fa-times"></i></button></div></div></div></div>';
						$('body .cb-popup').on('click', function(e){
							e.preventDefault();
							var img = $(this).attr('href');
							if(  img.length > 0 ){
								$('body').append(_template.replace( 'IMGURL', img )).find('.tb-overlay-bg').fadeIn(200);
							}
						})
					}
				})
			})
			
			
		})
	})
})(jQuery) 