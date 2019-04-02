<?php
class Zo_Recent_Posts_Widget_With_Thumbnails extends WP_Widget {

	var $plugin_slug;  // identifier of this plugin for WP
	var $plugin_version; // number of current plugin version
	var $number_posts;  // number of posts to show in the widget
	var $default_thumb_width;  // width of the thumbnail
	var $default_thumb_height; // height of the thumbnail
	var $default_thumb_url; // URL of the default thumbnail

	function __construct() {
		$this->plugin_slug  = 'zo-recent-posts-widget-with-thumbnails';
        parent::__construct(
            $this->plugin_slug, // Base ID
            esc_html__('Recent Posts With Thumbnails', 'pasha'), // Name
            array('description' => esc_html__('List of your site&#8217;s most recent posts, with clickable title and thumbnails.', 'pasha'),) // Args
        );
		$this->plugin_version  = '2.3.1';
		$this->number_posts  = 5;
		$this->default_thumb_width  = 55;
		$this->default_thumb_height = 55;
		$this->default_thumb_url = get_template_directory_uri() .'/assets/images/default_thumb.png';
	}

	function widget( $args, $instance ) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( $this->plugin_slug, 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args[ 'widget_id' ] ) ) {
			$args[ 'widget_id' ] = $this->id;
		}

		if ( isset( $cache[ $args[ 'widget_id' ] ] ) ) {
			echo do_shortcode($cache[ $args[ 'widget_id' ] ]);
			return;
		}

		ob_start();
		extract( $args );

		$title = ( ! empty( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : '';

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number_posts		= ( ! empty( $instance[ 'number_posts' ] ) ) ? absint( $instance[ 'number_posts' ] ) : $this->number_posts;
		$thumb_width 		= ( ! empty( $instance[ 'thumb_width' ] ) ) ? absint( $instance[ 'thumb_width' ] ) : $this->default_thumb_width;
		$thumb_height 		= ( ! empty( $instance[ 'thumb_height' ] ) ) ? absint( $instance[ 'thumb_height' ] ) : $this->default_thumb_height;
		$default_url 		= ( ! empty( $instance[ 'default_url' ] ) ) ? $instance[ 'default_url' ] : $this->default_thumb_url;
		$keep_aspect_ratio  = isset( $instance[ 'keep_aspect_ratio' ] ) ? $instance[ 'keep_aspect_ratio' ] : false;
		$hide_title			= isset( $instance[ 'hide_title' ] ) ? $instance[ 'hide_title' ] : false;
		$hide_content		= isset( $instance[ 'hide_content' ] ) ? $instance[ 'hide_content' ] : false;
		$hide_button		= isset( $instance[ 'hide_button' ] ) ? $instance[ 'hide_button' ] : false;
		$show_date 			= isset( $instance[ 'show_date' ] ) ? $instance[ 'show_date' ] : false;
		$show_thumb 		= isset( $instance[ 'show_thumb' ] ) ? $instance[ 'show_thumb' ] : false;
		$use_default 		= isset( $instance[ 'use_default' ] ) ? $instance[ 'use_default' ] : false;
		$try_1st_img 		= isset( $instance[ 'try_1st_img' ] ) ? $instance[ 'try_1st_img' ] : false;
		$only_1st_img 		= isset( $instance[ 'only_1st_img' ] ) ? $instance[ 'only_1st_img' ] : false;

		// sanitizes vars
		if ( ! $number_posts ) 	$number_posts = $this->number_posts;
		if ( ! $thumb_width )	$thumb_width = $this->default_thumb_width;
		if ( ! $thumb_height )	$thumb_height = $this->default_thumb_height;
		if ( ! $default_url )	$default_url = $this->default_thumb_url;

		$size 	= array( $thumb_width, $thumb_height );

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 1.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number_posts,
			'no_found_rows'       => true,
			'post_status'         => 'publish'
		) ) );

		if ( $r->have_posts()) :
		?>
		<?php echo do_shortcode($before_widget); ?>
		<?php if ( $title ) echo do_shortcode($before_title) . do_shortcode($title) . do_shortcode($after_title); ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<div class="tb-recent-thumb">
					<?php 
					if ( $show_thumb ) : 
						$is_thumb = false;
						// if only first image
						if ( $only_1st_img ) :
							// try to find and display the first post's image and return success
							$is_thumb = $this->the_first_posts_image( get_the_content(), $size );
						else :
							// else 
							// look for featured image
							if ( has_post_thumbnail() ) : 
								
								$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
								
								// if there is featured image then show featured image
								$image_resize = matthewruddy_image_resize( $attachment_image[0], $thumb_width, $thumb_height, true, false );
							
								echo '<a href="'. get_the_permalink() .'" data-original-title="'. get_the_title() .'"><img alt="' . get_the_title() . '" class="attachment-featuredImageCropped" src="'. esc_attr($image_resize['url']) .'"></a>';
								$is_thumb = true;
								
							else :
								// else 
								// if user wishes first image trial
								if ( $try_1st_img ) :
									// try to find and display the first post's image and return success
									$is_thumb = $this->the_first_posts_image( get_the_content(), $size );
								endif; // try_1st_img 
							endif; // has_post_thumbnail
						endif; // only_1st_img
						// if there is no image 
						if ( ! $is_thumb ) :
							// if user allows default image then
							if ( $use_default ) :
								// next line inspired by code of wp_get_attachment_image()
								$hwstring = image_hwstring( $thumb_width, $thumb_height );
								$dimensions = join( 'x', $size );
								$default_attr = array(
									'src'	=> $default_url,
									'class'	=> "attachment-$dimensions",
									'alt'	=> '',
								);
								$html = rtrim("<img $hwstring");
								foreach ( $default_attr as $name => $value ) {
									$html .= " $name=" . '"' . do_shortcode($value) . '"';
								}
								$html .= ' />';
								print '<a href="'. get_the_permalink() .'" data-original-title="'. get_the_title() .'">'. $html . '</a>';
							endif; // use_default
						endif; // not is_thumb
						// (else do nothing)
					endif; // show_thumb
					// show title if wished
					?>
					<div class="recent-thumb-overlay"></div>
				</div>
				
				<div class="tb-recent-detail">
					<?php if ( ! $hide_title ) { ?>
						<div class="tb-post-title">
							<h3><a href="<?php the_permalink();?>" title="<?php the_title();?>">		
								<?php 
									$trimtitle = get_the_title();
									$shorttitle = wp_trim_words( $trimtitle, $num_words = 6, $more = '');
									echo do_shortcode($shorttitle);  
								?>
								</a>
							</h3>
						</div>
					<?php }?>
					
					<?php if ( ! $hide_content ) { ?>
						<div class="tb-post-content">
							<?php 
								$trimcontent = get_the_content();
								$shortcontent = wp_trim_words( $trimcontent, $num_words = 9, $more = '');
								echo "<p>" . do_shortcode($shortcontent) . "</p>";  
							?>
						</div>
					<?php }?>
					
					<?php if ( ! $hide_button ) { ?>
						<!-- Btn read mor -->
						<a href="<?php the_permalink(); ?>" class="btn btn-default"><?php esc_html_e('Read More', 'pasha');?></a>
						</li>
					<?php }?>
					
					<?php if ( $show_date ) : ?> 
						<div class="tb-post-date"><span><?php echo get_the_date('M, d, Y'); ?></span></div>
					<?php	endif; ?>
				</div>
				
		<?php endwhile; ?>
		</ul>
		<?php echo do_shortcode($after_widget); ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args[ 'widget_id' ] ] = ob_get_flush();
			wp_cache_set( $this->plugin_slug, $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	function update( $new_widget_settings, $old_widget_settings ) {
		$instance = $old_widget_settings;
		// sanitize user input before update
		$instance[ 'number_posts' ]	= absint( $new_widget_settings[ 'number_posts' ] );
		$instance[ 'thumb_width' ] 	= absint( $new_widget_settings[ 'thumb_width' ] );
		$instance[ 'thumb_height' ] = absint( $new_widget_settings[ 'thumb_height' ] );
		$instance[ 'title' ] 		= strip_tags( $new_widget_settings[ 'title' ]);
		$instance[ 'default_url' ] 	= strip_tags( $new_widget_settings[ 'default_url' ]);
		$instance[ 'keep_aspect_ratio' ] = isset( $new_widget_settings[ 'keep_aspect_ratio' ] ) ? (bool) $new_widget_settings[ 'keep_aspect_ratio' ] : false;
		$instance[ 'hide_title' ] 	= isset( $new_widget_settings[ 'hide_title' ] ) ? (bool) $new_widget_settings[ 'hide_title' ] : false;
		$instance[ 'hide_content' ] 	= isset( $new_widget_settings[ 'hide_content' ] ) ? (bool) $new_widget_settings[ 'hide_content' ] : false;
		$instance[ 'hide_button' ] 	= isset( $new_widget_settings[ 'hide_button' ] ) ? (bool) $new_widget_settings[ 'hide_button' ] : false;
		$instance[ 'show_date' ] 	= isset( $new_widget_settings[ 'show_date' ] ) ? (bool) $new_widget_settings[ 'show_date' ] : false;
		$instance[ 'show_thumb' ] 	= isset( $new_widget_settings[ 'show_thumb' ] ) ? (bool) $new_widget_settings[ 'show_thumb' ] : false;
		$instance[ 'use_default' ] 	= isset( $new_widget_settings[ 'use_default' ] ) ? (bool) $new_widget_settings[ 'use_default' ] : false;
		$instance[ 'try_1st_img' ] 	= isset( $new_widget_settings[ 'try_1st_img' ] ) ? (bool) $new_widget_settings[ 'try_1st_img' ] : false;
		$instance[ 'only_1st_img' ] = isset( $new_widget_settings[ 'only_1st_img' ] ) ? (bool) $new_widget_settings[ 'only_1st_img' ] : false;

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions[ $this->plugin_slug ]) )
			delete_option( $this->plugin_slug );

		// return sanitized current widget settings
		return $instance;
	}

	function form( $instance ) {
		$title        = isset( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : '';
		$default_url  = isset( $instance[ 'default_url' ] ) ? esc_url( $instance[ 'default_url' ] ) : $this->default_thumb_url;
		$thumb_width  = isset( $instance[ 'thumb_width' ] )  ? absint( $instance[ 'thumb_width' ] )  : $this->default_thumb_width;
		$thumb_height = isset( $instance[ 'thumb_height' ] ) ? absint( $instance[ 'thumb_height' ] ) : $this->default_thumb_height;
		$number_posts = isset( $instance[ 'number_posts' ] ) ? absint( $instance[ 'number_posts' ] ) : $this->number_posts;
		$keep_aspect_ratio = isset( $instance[ 'keep_aspect_ratio' ] ) ? (bool) $instance[ 'keep_aspect_ratio' ] : false;
		$hide_title   = isset( $instance[ 'hide_title' ] ) ? (bool) $instance[ 'hide_title' ] : false;
		$hide_content = isset( $instance[ 'hide_content' ] ) ? (bool) $instance[ 'hide_content' ] : false;
		$hide_button  = isset( $instance[ 'hide_button' ] ) ? (bool) $instance[ 'hide_button' ] : false;
		$show_date    = isset( $instance[ 'show_date' ] ) ? (bool) $instance[ 'show_date' ] : false;
		$show_thumb   = isset( $instance[ 'show_thumb' ] ) ? (bool) $instance[ 'show_thumb' ] : true;
		$use_default  = isset( $instance[ 'use_default' ] ) ? (bool) $instance[ 'use_default' ] : false;
		$try_1st_img  = isset( $instance[ 'try_1st_img' ] ) ? (bool) $instance[ 'try_1st_img' ] : false;
		$only_1st_img = isset( $instance[ 'only_1st_img' ] ) ? (bool) $instance[ 'only_1st_img' ] : false;
		
		// sanitize vars
		if ( ! $number_posts )	$number_posts = $this->number_posts;
		if ( ! $thumb_width )	$thumb_width = $this->default_thumb_width;
		if ( ! $thumb_height )	$thumb_height = $this->default_thumb_height;
		if ( ! $default_url )	$default_url = $this->default_thumb_url;
		
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pasha' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number_posts' )); ?>"><?php esc_html_e( 'Number of posts to show:', 'pasha' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number_posts' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_posts' )); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php esc_html_e( 'Display post date?', 'pasha' ); ?></label></p>

		<h4><?php esc_html_e( 'Thumbnail Options', 'pasha' ); ?>:</h4>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_thumb ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_thumb' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_thumb' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_thumb' )); ?>"><?php esc_html_e( 'Display post featured image?', 'pasha' ); ?></label></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'thumb_width' )); ?>"><?php esc_html_e( 'Width of thumbnail', 'pasha' ); ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'thumb_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'thumb_width' )); ?>" type="text" value="<?php echo esc_attr($thumb_width); ?>" size="3" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'thumb_height' )); ?>"><?php esc_html_e( 'Height of thumbnail', 'pasha' ); ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'thumb_height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'thumb_height' )); ?>" type="text" value="<?php echo esc_attr($thumb_height); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $keep_aspect_ratio ); ?> id="<?php echo esc_attr($this->get_field_id( 'keep_aspect_ratio' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'keep_aspect_ratio' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'keep_aspect_ratio' )); ?>"><?php esc_html_e( 'Use aspect ratios of original images?', 'pasha' ); ?> <em><?php esc_html_e( 'If checked the given width is used to determine the height of the thumbnail automatically. This option also supports responsive web design.', 'pasha' ); ?></em></label></p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $hide_title ); ?> id="<?php echo esc_attr($this->get_field_id( 'hide_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_title' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'hide_title' )); ?>"><?php esc_html_e( 'Do not show title?', 'pasha' ); ?> <em><?php esc_html_e( 'Make sure you set a default title for posts without a tille.', 'pasha' ); ?></em></label> </p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $hide_content ); ?> id="<?php echo esc_attr($this->get_field_id( 'hide_content' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_content' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'hide_content' )); ?>"><?php esc_html_e( 'Do not show content?', 'pasha' ); ?> <em><?php esc_html_e( 'Make sure you set a default content for posts without a content.', 'pasha' ); ?></em></label> </p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $hide_button); ?> id="<?php echo esc_attr($this->get_field_id( 'hide_button' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_button' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'hide_button' )); ?>"><?php esc_html_e( 'Do not show button read more?', 'pasha' ); ?> <em><?php esc_html_e( 'Make sure you set a default button for posts without a button.', 'pasha' ); ?></em></label> </p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $try_1st_img ); ?> id="<?php echo esc_attr($this->get_field_id( 'try_1st_img' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'try_1st_img' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'try_1st_img' )); ?>"><?php esc_html_e( "Try to use the post's first image if post has no featured image?", 'pasha' ); ?></label></p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $only_1st_img ); ?> id="<?php echo esc_attr($this->get_field_id( 'only_1st_img' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'only_1st_img' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'only_1st_img' )); ?>"><?php esc_html_e( 'Use first image only, ignore featured image?', 'pasha' ); ?></label></p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $use_default ); ?> id="<?php echo esc_attr($this->get_field_id( 'use_default' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'use_default' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'use_default' )); ?>"><?php esc_html_e( 'Use default thumbnail if no image could be determined?', 'pasha' ); ?></label></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'default_url' )); ?>"><?php esc_html_e( 'URL of default thumbnail (start with http://)', 'pasha' ); ?>:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'default_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'default_url' )); ?>" type="text" value="<?php echo esc_attr($default_url); ?>" /></p>
	<?php
	}

	/**
	 * Returns the id of the first image in the content, else 0
	 *
	 * @access   private
	 * @since     2.0
	 *
	 * @return    integer    the post id of the first content image
	 */
	function get_first_content_image_id ( $content ) {
		// set variables
		global $wpdb;
		// look for images in HTML code
		preg_match_all( '/<img[^>]+>/i', $content, $all_img_tags );
		if ( $all_img_tags ) {
			foreach ( $all_img_tags[ 0 ] as $img_tag ) {
				// find class attribute and catch its value
				preg_match( '/<img.*?class\s*=\s*[\'"]([^\'"]+)[\'"][^>]*>/i', $img_tag, $img_class );
				if ( $img_class ) {
					// Look for the WP image id
					preg_match( '/wp-image-([\d]+)/i', $img_class[ 1 ], $found_id );
					// if first image id found: check whether is image
					if ( $found_id ) {
						$img_id = absint( $found_id[ 1 ] );
						// if is image: return its id
						if ( wp_get_attachment_image_src( $img_id ) ) {
							return $img_id;
						}
					} // if(found_id)
				} // if(img_class)
				
				// else: try to catch image id by its url as stored in the database
				// find src attribute and catch its value
				preg_match( '/<img.*?src\s*=\s*[\'"]([^\'"]+)[\'"][^>]*>/i', $img_tag, $img_src );
				if ( $img_src ) {
					// delete optional query string in img src
					$url = preg_replace( '/([^?]+).*/', '\1', $img_src[ 1 ] );
					// delete image dimensions data in img file name, just take base name and extension
					$guid = preg_replace( '/(.+)-\d+x\d+\.(\w+)/', '\1.\2', $url );
					// look up its ID in the db
					$found_id = $wpdb->get_var( $wpdb->prepare( "SELECT `ID` FROM $wpdb->posts WHERE `guid` = '%s'", $guid ) );
					// if first image id found: return it
					if ( $found_id ) {
						return absint( $found_id );
					} // if(found_id)
				} // if(img_src)
			} // foreach(img_tag)
		} // if(all_img_tags)
		
		// if nothing found: return 0
		return 0;
	}

	/**
	 * Echoes the thumbnail of first post's image and returns success
	 *
	 * @access   private
	 * @since     2.0
	 *
	 * @return    bool    success on finding an image
	 */
	private function the_first_posts_image ( $content, $size ) {
		// look for first image
		$thumb_id = $this->get_first_content_image_id( $content );
		// if there is first image then show first image
		if ( $thumb_id ) :
			echo wp_get_attachment_image( $thumb_id, $size );
			return true;
		else :
			return false;
		endif; // thumb_id
	}

	/**
	 * Generate the css file with stored settings
	 *
	 * @since 2.3
	 */
	private function make_css_file () {

		// get stored settings
		$all_instances = $this->get_settings();

		// generate CSS
		$css_code = sprintf( '.%s ul { list-style: outside none none; }', $this->plugin_slug );
		$css_code .= "\n"; 
		$css_code .= sprintf( '.%s ul li { overflow: hidden; margin: 0 0 1.5em; }', $this->plugin_slug );
		$css_code .= "\n"; 
		$css_code .= sprintf( '.%s ul li img { display: inline; float: left; margin: .3em .75em .75em 0; }', $this->plugin_slug );
		$css_code .= "\n";
		$set_default = true;
		foreach ( $all_instances as $number => $settings ) {
			if ( isset( $settings[ 'thumb_width' ] ) ) {
				$width  = absint( $settings[ 'thumb_width' ]  );
				if ( ! $width ) $width = $this->default_thumb_width;
			}
			if ( isset( $settings[ 'thumb_height' ] ) ) {
				$height = absint( $settings[ 'thumb_height' ] );
				if ( ! $height ) $height = $this->default_thumb_height;
			}
			$keep_aspect_ratio = false;
			if ( isset( $settings[ 'keep_aspect_ratio' ] ) ) {
				$keep_aspect_ratio = (bool) $settings[ 'keep_aspect_ratio' ];
			}
			if ( $keep_aspect_ratio ) {
				$css_code .= sprintf( '#%s-%d img { max-width: %dpx; width: 100%%; height: auto; }', $this->plugin_slug, $number, $width );
				$css_code .= "\n"; 
			} else {
				$css_code .= sprintf( '#%s-%d img { width: %dpx; height: %dpx; }', $this->plugin_slug, $number, $width, $height );
				$css_code .= "\n"; 
			}
			$set_default = false;
		}
		// set at least this statement if no settings are stored
		if ( $set_default ) {
			$css_code .= sprintf( '.%s img { width: %dpx; height: %dpx; }', $this->plugin_slug, $this->default_thumb_width, $this->default_thumb_height );
			$css_code .= "\n"; 
		}
	}

} 

/**
 * Register widget on init
 *
 * @since 1.0
 */
function zo_register_recent_posts_widget_with_thumbnails () {
	register_widget('Zo_Recent_Posts_Widget_With_Thumbnails');
}
add_action('widgets_init', 'zo_register_recent_posts_widget_with_thumbnails');