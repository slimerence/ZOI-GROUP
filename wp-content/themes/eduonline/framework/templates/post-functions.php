<?php
/* Title */
if (!function_exists('jws_theme_title_render')) {
	function jws_theme_title_render(){
		global $jws_theme_options;
		ob_start();
			if(get_the_title()){?>
				<h4 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php }
		return  ob_get_clean();
	}
}
/* Blog date*/
if (!function_exists('jws_theme_date_render')) {
	function jws_theme_date_render() {
		global $jws_theme_options, $post;
		if( is_wp_error( $post ) ) return;
		ob_start();
			?>
				<!-- Date -->
				<!-- Date -->

				<div class="tb-blog-date">

				   <?php 

					$archive_year  = get_the_time('Y'); 

					$archive_month = get_the_time('m'); 

					$archive_day   = get_the_time('d'); 

					$date_format = get_option( 'date_format' );
					$type = $date_format;
					
					if($date_format == 'Y-m-d' || $date_format == 'm/d/Y' ) $type = 'm d';
					else if($date_format == 'F j, Y') $type = 'F j';
					else if( $date_format == 'd/m/Y' ) $type = 'd m';
					
					$formats = explode(' ', $type);
					$date = array();
					foreach ((array) $formats as $format) :
						$date[] = trim($format);
					endforeach;
		
					?>

				   <a href="<?php echo esc_url(get_day_link($archive_year, $archive_month, $archive_day)); ?>"><p><span><?php echo get_the_time($date[0]);?></span><?php echo get_the_time($date[1]);?></p>

				   <p class="comments-number"><i class="fa fa-comment-o"></i><?php comments_number( esc_html__( '0', 'eduonline' ), esc_html__( '1', 'eduonline' ), esc_html__( '%', 'eduonline' ) ); ?></p>

				   </a>

				</div>

			<?php
		return  ob_get_clean();
	}
}


if (!function_exists('jws_theme_date_course')) {
	function jws_theme_date_course() {
		global $jws_theme_options, $post;
		//if( is_wp_error( $post ) ) return;
		ob_start();
			?>
				<!-- Date -->
				<div class="tb-blog-date">
				   <a><?php echo get_the_time('d');?><span><?php echo get_the_time('M');?></span></a>
				</div>
			<?php
		return  ob_get_clean();
	}
}


/* Info Bar */
if (!function_exists('jws_theme_info_bar_render')) {
	function jws_theme_info_bar_render() {
		global $jws_theme_options, $post;
		if( is_wp_error( $post ) ) return;
		$jws_theme_show_post_comment = (int) isset($jws_theme_options['jws_theme_'. $post->post_type .'_show_post_comment']) ?  $jws_theme_options['jws_theme_'. $post->post_type .'_show_post_comment']: 1;
		$jws_theme_show_post_tag = (int) isset( $jws_theme_options['jws_theme_post_show_post_tags'] ) ? $jws_theme_options['jws_theme_post_show_post_tags'] : 1;
		$jws_theme_show_author= (int) isset( $jws_theme_options['jws_theme_post_show_post_author'] ) ? $jws_theme_options['jws_theme_post_show_post_author'] : 1;
		ob_start();
			?>
			<div class="blog-info">
				<?php if( $jws_theme_show_author ){ ?><span class="author-name"><i class="fa fa-user"></i><?php esc_html_e('By ', 'eduonline'); the_author_posts_link(); ?></span><?php } ?>
				
				<?php $on_draught = jws_theme_post_cate();
				if( $on_draught ) echo '<span class="tb-cate">'.$on_draught.'</span>'; 
			
				 if( $jws_theme_show_post_comment ): ?><span class="comments-number"><i class="fa fa-comments"></i><?php comments_number( esc_html__( '0 Comment', 'eduonline' ), esc_html__( '1 Comment', 'eduonline' ), esc_html__( '% Comments ', 'eduonline' ) ); ?></span><?php endif; ?>
				
			</div>
			<?php
		return  ob_get_clean();
	}
}
/* Info class Bar */
if (!function_exists('jws_theme_single_info_render')) {
	function jws_theme_single_info_render() {
		global $jws_theme_options, $post;
		if( is_wp_error( $post ) ) return;
		$jws_theme_show_post_comment = (int) isset($jws_theme_options['jws_theme_'. $post->post_type .'_show_post_comment']) ?  $jws_theme_options['jws_theme_'. $post->post_type .'_show_post_comment']: 1;
		$jws_theme_show_post_tag = (int) isset( $jws_theme_options['jws_theme_post_show_post_tags'] ) ? $jws_theme_options['jws_theme_post_show_post_tags'] : 1;
		$jws_theme_show_author= (int) isset( $jws_theme_options['jws_theme_post_show_post_author'] ) ? $jws_theme_options['jws_theme_post_show_post_author'] : 1;
		ob_start();
			?>
			<div class="blog-info">
				<div class="tb-avatar">
					<div class="tb-avatar-inner">
						<?php echo get_avatar(get_the_author_meta( 'ID' ), 75); ?>
					</div>
					<div class="tb-avatar-info">
						<?php if( $jws_theme_show_author ){ ?><span class="author-name"><?php esc_html_e('By ', 'eduonline'); the_author_posts_link(); ?></span><?php } 
					
						$archive_year  = get_the_time('Y'); 
						$archive_month = get_the_time('m'); 
						$archive_day   = get_the_time('d'); 
						?>
					   <a href="<?php echo esc_url(get_day_link($archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html_e('Posted: ','eduonline');?><span><?php echo get_the_time('d / m / Y');?></span></a>
						
					</div>
				</div>
				<!-- Date -->
				
				<div class="tb-comments">
				   <?php 
				    if( $jws_theme_show_post_comment ): ?><span class="comments-number"><i class="fa fa-comments-o"></i><?php comments_number( esc_html__( '0 Comment', 'eduonline' ), esc_html__( '1 Comment', 'eduonline' ), esc_html__( '% Comments ', 'eduonline' ) ); ?></span><?php endif; ?>
					
				</div>
			</div>
			
			<?php
		return  ob_get_clean();
	}
}
/* Post gallery */
if (!function_exists('jws_theme_theme_grab_ids_from_gallery')) {

    function jws_theme_theme_grab_ids_from_gallery() {
        global $post;
        $gallery = jws_theme_theme_get_shortcode_from_content('gallery');
        $object = new stdClass();
        $object->columns = '3';
        $object->link = 'post';
        $object->ids = array();
        if ($gallery) {
            $object = jws_theme_theme_extra_shortcode('gallery', $gallery, $object);
        }
        return $object;
    }

}
/* Extra shortcode */
if (!function_exists('jws_theme_theme_extra_shortcode')) {
    function jws_theme_theme_extra_shortcode($name, $shortcode, $object) {
        if ($shortcode && is_object($object)) {
            $attrs = str_replace(array('[', ']', '"', $name), null, $shortcode);
            $attrs = explode(' ', $attrs);
            if (is_array($attrs)) {
                foreach ($attrs as $attr) {
                    $_attr = explode('=', $attr);
                    if (count($_attr) == 2) {
                        if ($_attr[0] == 'ids') {
                            $object->$_attr[0] = explode(',', $_attr[1]);
                        } else {
                            $object->$_attr[0] = $_attr[1];
                        }
                    }
                }
            }
        }
        return $object;
    }
}
/* Get Shortcode Content */
if (!function_exists('jws_theme_theme_get_shortcode_from_content')) {

    function jws_theme_theme_get_shortcode_from_content($param) {
        global $post;
        $pattern = get_shortcode_regex();
        $content = $post->post_content;
        if (preg_match_all('/' . $pattern . '/s', $content, $matches) && array_key_exists(2, $matches) && in_array($param, $matches[2])) {
            $key = array_search($param, $matches[2]);
            return $matches[0][$key];
        }
    }

}
/* Remove Shortcode */
if (!function_exists('jws_theme_theme_remove_shortcode_from_content')) {
	function jws_theme_theme_remove_shortcode_from_content( $content ) {
		global $post;
		$format = get_post_format();
		if ( is_single() && 'gallery' == $format ) {
			$content = strip_shortcodes( $content );
		}
		return $content;
	}
}
/* add_filter( 'the_content', 'jws_theme_theme_remove_shortcode_from_content' ); */
/* Content */
if (!function_exists('jws_theme_content_render')) {
	function jws_theme_content_render(){
		global $jws_theme_options;
		$jws_theme_blog_post_excerpt_leng = (int) isset($jws_theme_options['jws_theme_blog_post_excerpt_leng']) ? $jws_theme_options['jws_theme_blog_post_excerpt_leng'] : 0;
		$jws_theme_post_excerpt_more = isset($jws_theme_options['jws_theme_blog_post_excerpt_more']) ? $jws_theme_options['jws_theme_blog_post_excerpt_more'] : '';
		$jws_theme_post_read_more = isset($jws_theme_options['jws_theme_blog_post_readmore']) ? esc_attr( $jws_theme_options['jws_theme_blog_post_readmore'] ) : '';
		
		ob_start();
		?>
		<?php if (is_single() || is_home()) { ?>
				<div class="tb-excerpt">
					<?php
					if(has_excerpt()):
						the_excerpt();	
					else:
						the_content();
					endif;
					wp_link_pages(array(
						'before' => '<div class="page-links">' . esc_html__('Pages:', 'eduonline'),
						'after' => '</div>',
					));
					?>
				</div>
			<?php } else { ?>
				<div class="tb-excerpt">
					<?php echo jws_theme_custom_excerpt( intval( $jws_theme_blog_post_excerpt_leng ), $jws_theme_post_excerpt_more); ?>
				</div>
			<?php } ?>
		<?php
		return  ob_get_clean();
	}
}
/*Tags*/
if (!function_exists('jws_theme_theme_tags_render')) {
	function jws_theme_tags_render(){
		ob_start();
		?>
		<?php if (is_single()) { ?>
				<div class="tag-links">
					<?php the_tags(); ?>
				</div>
			<?php }?>
		<?php
		return  ob_get_clean();
	}
}
/*Author*/
if ( ! function_exists( 'jws_theme_theme_author_render' ) ) {
	function jws_theme_author_render() {
		ob_start();
		?>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
			<span class="featured-post"> <?php esc_html_e( 'Sticky', 'eduonline' ); ?></span>
		<?php } ?>
		<div class="about-author"> 
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 170 ); ?>
			</div>
			<div class="author-info">
				<span class="subtitle"><?php esc_html_e( 'AUTHOR', 'eduonline' ); ?></span>
				<h4 class="name"><?php the_author_meta('display_name'); ?></h4>
				<p class="desc"><?php the_author_meta('description'); ?></p>
				<a class="read-more" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php esc_html_e('All stories by: ', 'eduonline'); the_author_meta('display_name'); ?></a>
			</div>
		</div>
		<?php
		return  ob_get_clean();
	} 
}
/* Social share */
if ( ! function_exists('jws_theme_theme_social_share_post_render') ) {
	function jws_theme_social_share_post_render() {
		global $post;
		$post_title = $post->post_title;
		$permalink = get_permalink($post->ID);
		$title = get_the_title();
		$output = '';
		$output .= '<div class="tb-social-buttons">
			'.__('Social Share: ', 'eduonline').'
			<a class="icon-twitter" href="http://twitter.com/share?text='.$title.'&url='.$permalink.'"
				onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;">
				<span>Twitter</span>
			</a> 
			<a class="icon-pinterest" href="http://pinterest.com/pin/create/button/?url='. $permalink .'"  onclick="window.open(this.href, \'pinterest-share\', \'width=490,height=530\');return false;"><span>Pinterest</span></a>            
			<a class="icon-fb" href="https://www.facebook.com/sharer/sharer.php?u='.$permalink.'"
				 onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;">
				<span>Facebook</span>
			</a>         
			<a class="icon-gplus" href="https://plus.google.com/share?url='.$permalink.'"
			   onclick="window.open(this.href, \'google-plus-share\', \'width=490,height=530\');return false;">
				<span>Google+</span>
			</a>
			
		</div>';
		return $output;
	}
}
/**
 * Get taxonomies terms links.
 *
 * @see get_object_taxonomies()
 */
function wpdocs_custom_taxonomies_terms_links($tax) {
	global $post;
    // Get post by post ID.
    $post = get_post( $post->ID );
 
    // Get post type by post.
    $post_type = $post->post_type;
 
    // Get post type taxonomies.
    $taxonomies = get_object_taxonomies( $post_type, $tax );
 
    $out = array();
 
    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
 
        // Get the terms related to post.
        $terms = get_the_terms( $post->ID, $taxonomy_slug );
 
        if ( ! empty( $terms ) ) {
            $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<li><a href="%1$s">%2$s</a></li>',
                    esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
                    esc_html( $term->name )
                );
            }
            $out[] = "\n</ul>\n";
        }
    }
    return implode( '', $out );
}
/* Post gallery */
if (!function_exists('tb_theme_grab_ids_from_gallery')) {

    function tb_theme_grab_ids_from_gallery() {
        global $post;
        $gallery = tb_theme_get_shortcode_from_content('gallery');
        $object = new stdClass();
        $object->columns = '3';
        $object->link = 'post';
        $object->ids = array();
        if ($gallery) {
            $object = tb_theme_extra_shortcode('gallery', $gallery, $object);
        }
        return $object;
    }

}
/* Extra shortcode */
if (!function_exists('tb_theme_extra_shortcode')) {
    function tb_theme_extra_shortcode($name, $shortcode, $object) {
        if ($shortcode && is_object($object)) {
            $attrs = str_replace(array('[', ']', '"', $name), null, $shortcode);
            $attrs = explode(' ', $attrs);
            if (is_array($attrs)) {
                foreach ($attrs as $attr) {
                    $_attr = explode('=', $attr);
                    if (count($_attr) == 2) {
                        if ($_attr[0] == 'ids') {
                            $object->$_attr[0] = explode(',', $_attr[1]);
                        } else {
                            $object->$_attr[0] = $_attr[1];
                        }
                    }
                }
            }
        }
        return $object;
    }
}
/* Get Shortcode Content */
if (!function_exists('tb_theme_get_shortcode_from_content')) {

    function tb_theme_get_shortcode_from_content($param) {
        global $post;
        $pattern = get_shortcode_regex();
        $content = $post->post_content;
        if (preg_match_all('/' . $pattern . '/s', $content, $matches) && array_key_exists(2, $matches) && in_array($param, $matches[2])) {
            $key = array_search($param, $matches[2]);
            return $matches[0][$key];
        }
    }

}
/* Remove Shortcode */
if (!function_exists('tb_theme_remove_shortcode_from_content')) {
	function tb_theme_remove_shortcode_from_content( $content ) {
		global $post;
		$format = get_post_format();
		if ( is_single() && 'gallery' == $format ) {
			$content = strip_shortcodes( $content );
		}
		return $content;
	}
}