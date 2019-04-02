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
					data: {action: 'render_portfolio_grid', paged: next_page, params: params},
					success: function(data){
						$pagination.removeClass('blog-more-ajax-loading');
						$pagination.before(data);

						if(next_page >= max_page){
							$pagination.find('a').fadeOut('slow');
						}else{
							$pagination.find('a').data('next-page',next_page+1);
						}
					}
				})
			})
		})
	})
})(jQuery) 