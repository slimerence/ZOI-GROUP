(function($){
    $(function(){
        if($('.jws_theme_upload_button').length >= 1) {
            // Uploading files
            var file_frame;

            jQuery('.jws_theme_upload_button').live('click', function( e ){
            e.preventDefault();
            var _el_up = $(this).prev('input');

            if ( file_frame ) {
              file_frame.open();
              return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery( this ).data( 'Upload image' ),
                button: {
                text: jQuery( this ).data( 'Insert' ),
                },
                multiple: false 
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame.state().get('selection').first().toJSON();
                _el_up.prop('value', attachment.sizes.full.url);

            });

            // Finally, open the modal
            file_frame.open();
            });
        }
    });
})(window.jQuery);