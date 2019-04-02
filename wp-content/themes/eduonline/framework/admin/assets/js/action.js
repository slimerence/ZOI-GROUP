(function($) {
	"use strict";
		jQuery(document).ready(function($) {
			var $confirm = false;
		jQuery('#import').click(function(e){
			var $_this = $(this);
			var ajax_url = (redux_ajax_script.ajaxurl) ? redux_ajax_script.ajaxurl : ajaxurl;
			$_this.addClass('importing');
			if( ! $confirm ){
				var $import_true = confirm('Are you sure to import dummy content ? It will overwrite the existing data and make sure you was installed plugins required and recommend of theme!');
				if($import_true == false) return false;
				$confirm = true;
			}
			jQuery('.import-message').html('<span class="loading"></span> Please Waiting');
			
			action_post(ajax_url, $_this);
			var auto_import = setInterval( function(){
				if( ! $_this.hasClass('completed') ){
					action_post(ajax_url, $_this);
				}else{
					clearInterval( auto_import );
				}
			}, 50000);
		});
		function action_post(ajax_url, element){
			jQuery.ajax({
				type: 'POST',
				url: ajax_url,
				data: {
					'action': 'sample'
				},
				success: function(data, textStatus, XMLHttpRequest){
					console.log(data);
					jQuery('.import-message').html('<span class="completed"></span> Import is Completed.<br>Please reload page before change theme options.');
					element.removeClass('importing').addClass('completed');
				}
			});
			
		}
	});
})(jQuery);

